<?php
/**
 * models/Order.php
 * ---------------------------------------------------------
 * Model chính của bài tập - toàn bộ nghiệp vụ Đơn hàng:
 *   - getAll(): danh sách đơn hàng, có lọc theo trạng thái
 *     và tìm theo tên khách hàng (đúng theo phạm vi đơn giản
 *     đã chốt: chỉ 2 tiêu chí lọc này).
 *   - getById(): chi tiết 1 đơn hàng (JOIN customers).
 *   - create(): tạo đơn hàng mới - đây là phần quan trọng
 *     nhất, dùng TRANSACTION để đảm bảo dữ liệu không bị
 *     "nửa vời" nếu có lỗi giữa chừng.
 *   - updateStatus(), delete().
 * ---------------------------------------------------------
 */
class Order
{
    /**
     * Lấy danh sách đơn hàng, JOIN sang customers để hiển thị
     * tên khách hàng luôn (đúng yêu cầu gốc: "Danh sách đơn
     * hàng phải load đầy đủ thông tin khách hàng - JOIN bảng").
     *
     * $status: lọc theo trạng thái, để rỗng '' = lấy tất cả.
     * $customerName: tìm gần đúng theo tên khách hàng bằng LIKE
     * (MySQL với collation mặc định utf8mb4_general_ci/unicode_ci
     * đã tự động không phân biệt hoa/thường, không cần ILIKE
     * như PostgreSQL).
     */
    public static function getAll(string $status = '', string $customerName = ''): array
    {
        $pdo = getDB();

        $sql = 'SELECT o.id, o.order_date, o.total_amount, o.status,
                       c.id AS customer_id, c.name AS customer_name
                FROM orders o
                JOIN customers c ON c.id = o.customer_id
                WHERE 1 = 1';
        $params = [];

        if ($status !== '') {
            $sql .= ' AND o.status = ?';
            $params[] = $status;
        }
        if ($customerName !== '') {
            $sql .= ' AND c.name LIKE ?';
            $params[] = '%' . $customerName . '%';
        }

        $sql .= ' ORDER BY o.order_date DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Lấy chi tiết 1 đơn hàng (kèm thông tin khách hàng) để hiển thị trang view.php */
    public static function getById(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare(
            'SELECT o.id, o.order_date, o.total_amount, o.status,
                    c.id AS customer_id, c.name AS customer_name,
                    c.email AS customer_email, c.phone AS customer_phone
             FROM orders o
             JOIN customers c ON c.id = o.customer_id
             WHERE o.id = ?'
        );
        $stmt->execute([$id]);
        $order = $stmt->fetch();

        if (!$order) {
            return null;
        }

        // Lấy kèm danh sách sản phẩm trong đơn hàng
        $order['items'] = OrderItem::getByOrderId($pdo, $id);

        return $order;
    }

    /**
     * Tạo đơn hàng mới.
     *
     * $customerId: id khách hàng
     * $items: mảng dạng [['product_id' => 1, 'quantity' => 2], ...]
     *
     * Toàn bộ các bước dưới đây nằm trong 1 TRANSACTION:
     *   1) Insert vào `orders` (total_amount tạm để 0)
     *   2) Với mỗi sản phẩm: trừ tồn kho + insert vào `order_items`
     *      (giá được lấy snapshot tại thời điểm này)
     *   3) Cập nhật lại total_amount = tổng các dòng chi tiết
     *   4) COMMIT nếu mọi thứ ổn, ROLLBACK nếu có bất kỳ lỗi nào
     *      (ví dụ: sản phẩm không đủ tồn kho) - nhờ vậy sẽ không
     *      bao giờ có tình trạng "đơn hàng tạo rồi nhưng thiếu
     *      sản phẩm" hoặc "kho bị trừ nhưng đơn hàng không có".
     */
    public static function create(int $customerId, array $items): int
    {
        if (empty($items)) {
            throw new Exception('Đơn hàng phải có ít nhất 1 sản phẩm.');
        }

        $pdo = getDB();
        $pdo->beginTransaction();

        try {
            // 1) Tạo đơn hàng khung với tổng tiền = 0
            // Lưu ý: MySQL không hỗ trợ "RETURNING id" như PostgreSQL,
            // nên phải insert xong rồi gọi lastInsertId() ở dòng dưới.
            $stmt = $pdo->prepare(
                "INSERT INTO orders (customer_id, total_amount, status)
                 VALUES (?, 0, 'pending')"
            );
            $stmt->execute([$customerId]);
            $orderId = (int) $pdo->lastInsertId();

            $totalAmount = 0;

            // 2) Xử lý từng sản phẩm trong đơn
            foreach ($items as $item) {
                $productId = (int) $item['product_id'];
                $quantity = (int) $item['quantity'];

                if ($quantity <= 0) {
                    throw new Exception("Số lượng sản phẩm #$productId không hợp lệ.");
                }

                $product = Product::getById($productId);
                if (!$product) {
                    throw new Exception("Sản phẩm #$productId không tồn tại.");
                }

                // Trừ tồn kho (có kiểm tra đủ hàng bên trong hàm này)
                Product::decreaseStock($pdo, $productId, $quantity);

                // Giá snapshot = giá sản phẩm NGAY TẠI thời điểm đặt hàng
                $priceSnapshot = (float) $product['price'];
                OrderItem::insert($pdo, $orderId, $productId, $quantity, $priceSnapshot);

                $totalAmount += $priceSnapshot * $quantity;
            }

            // 3) Cập nhật lại tổng tiền thật của đơn hàng
            $update = $pdo->prepare('UPDATE orders SET total_amount = ? WHERE id = ?');
            $update->execute([$totalAmount, $orderId]);

            // 4) Mọi thứ ổn -> chốt transaction
            $pdo->commit();

            return $orderId;
        } catch (Exception $e) {
            // Có lỗi ở bất kỳ bước nào -> hủy toàn bộ thay đổi
            $pdo->rollBack();
            throw $e;
        }
    }

    /** Cập nhật trạng thái đơn hàng (VD: pending -> processing -> shipped -> delivered) */
    public static function updateStatus(int $id, string $status): bool
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses, true)) {
            throw new Exception('Trạng thái không hợp lệ.');
        }

        $pdo = getDB();
        $stmt = $pdo->prepare('UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    /**
     * Xóa đơn hàng. `order_items` sẽ tự động bị xóa theo nhờ
     * ON DELETE CASCADE đã khai báo trong schema.sql, nhưng
     * trước khi xóa mình cần HOÀN LẠI tồn kho cho từng sản
     * phẩm trong đơn - việc này cũng nằm trong transaction.
     */
    public static function delete(int $id): bool
    {
        $pdo = getDB();
        $pdo->beginTransaction();

        try {
            $items = OrderItem::getByOrderId($pdo, $id);
            foreach ($items as $item) {
                Product::increaseStock($pdo, $item['product_id'], $item['quantity']);
            }

            $stmt = $pdo->prepare('DELETE FROM orders WHERE id = ?');
            $stmt->execute([$id]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
