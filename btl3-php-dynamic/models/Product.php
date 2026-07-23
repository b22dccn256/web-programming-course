<?php
/**
 * models/Product.php
 * ---------------------------------------------------------
 * Tương tự Customer: chỉ cần đọc dữ liệu để đổ vào form tạo
 * đơn hàng, cộng thêm 2 hàm trừ/hoàn tồn kho được Order.php
 * gọi bên trong transaction khi tạo/xóa đơn hàng.
 * ---------------------------------------------------------
 */
class Product
{
    /** Lấy toàn bộ sản phẩm còn hiển thị được (kể cả hết hàng, để biết mà tránh chọn) */
    public static function getAll(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT id, name, price, stock_quantity FROM products ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public static function getById(int $id): ?array
    {
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT id, name, price, stock_quantity FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Trừ tồn kho khi tạo đơn hàng mới.
     * $pdo được truyền từ ngoài vào (từ Order::create) để dùng
     * CHUNG 1 transaction với việc insert order/order_items -
     * nếu 1 bước lỗi thì toàn bộ rollback, không bị trừ kho
     * "mồ côi" mà đơn hàng lại tạo thất bại.
     *
     * SELECT ... FOR UPDATE: khóa dòng sản phẩm lại trong lúc
     * transaction đang chạy, tránh trường hợp 2 người cùng đặt
     * hàng 1 lúc làm tồn kho bị trừ sai (race condition).
     */
    public static function decreaseStock(PDO $pdo, int $productId, int $quantity): void
    {
        $stmt = $pdo->prepare('SELECT stock_quantity FROM products WHERE id = ? FOR UPDATE');
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if (!$product) {
            throw new Exception("Sản phẩm #$productId không tồn tại.");
        }
        if ($product['stock_quantity'] < $quantity) {
            throw new Exception("Sản phẩm #$productId không đủ tồn kho (còn {$product['stock_quantity']}).");
        }

        $update = $pdo->prepare('UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?');
        $update->execute([$quantity, $productId]);
    }

    /** Hoàn lại tồn kho khi xóa đơn hàng */
    public static function increaseStock(PDO $pdo, int $productId, int $quantity): void
    {
        $update = $pdo->prepare('UPDATE products SET stock_quantity = stock_quantity + ? WHERE id = ?');
        $update->execute([$quantity, $productId]);
    }
}
