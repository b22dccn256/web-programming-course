<?php
/**
 * models/Order.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3 khi có bảng `orders` trong MySQL.
 * Khai báo trước cấu trúc dự kiến để OrderController có thể gọi mà không lỗi.
 *
 * Dự kiến bảng orders: id, ma_don, khach_hang_id, tong_tien, trang_thai, ngay_tao.
 */

class Order
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Lấy danh sách đơn hàng (có thể lọc theo trạng thái). */
    public function layDanhSach(?string $trangThai = null): array
    {
        // TODO (bài tập 3): SELECT * FROM orders [WHERE trang_thai = ?] ORDER BY ngay_tao DESC
        return [];
    }

    /** Lấy chi tiết 1 đơn hàng theo id. */
    public function layTheoId(int $id): ?array
    {
        // TODO (bài tập 3): SELECT * FROM orders WHERE id = ?
        return null;
    }

    /** Tạo đơn hàng mới. */
    public function taoMoi(array $data): bool
    {
        // TODO (bài tập 3): INSERT INTO orders (...) VALUES (...)
        return false;
    }

    /** Cập nhật trạng thái đơn hàng. */
    public function capNhatTrangThai(int $id, string $trangThaiMoi): bool
    {
        // TODO (bài tập 3): UPDATE orders SET trang_thai = ? WHERE id = ?
        return false;
    }
}
