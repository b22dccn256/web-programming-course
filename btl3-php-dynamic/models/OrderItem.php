<?php
/**
 * models/OrderItem.php
 * ---------------------------------------------------------
 * Thao tác bảng trung gian `order_items` (chi tiết đơn hàng).
 * Các hàm ở đây đều nhận $pdo từ ngoài truyền vào để dùng
 * chung transaction với Order.php.
 * ---------------------------------------------------------
 */
class OrderItem
{
    /** Thêm 1 dòng chi tiết đơn hàng (1 sản phẩm trong 1 đơn) */
    public static function insert(PDO $pdo, int $orderId, int $productId, int $quantity, float $price): void
    {
        $stmt = $pdo->prepare(
            'INSERT INTO order_items (order_id, product_id, quantity, price)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$orderId, $productId, $quantity, $price]);
    }

    /**
     * Lấy toàn bộ chi tiết của 1 đơn hàng, kèm JOIN sang bảng
     * products để lấy tên sản phẩm hiển thị (products.price
     * KHÔNG dùng ở đây vì order_items.price mới là giá snapshot
     * đúng tại thời điểm đặt hàng).
     */
    public static function getByOrderId(PDO $pdo, int $orderId): array
    {
        $stmt = $pdo->prepare(
            'SELECT oi.id, oi.product_id, p.name AS product_name,
                    oi.quantity, oi.price, (oi.quantity * oi.price) AS subtotal
             FROM order_items oi
             JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = ?
             ORDER BY oi.id ASC'
        );
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
