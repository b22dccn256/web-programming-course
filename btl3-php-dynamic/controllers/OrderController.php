<?php
/**
 * controllers/OrderController.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3, dùng ở admin/orders.php
 * để liệt kê/thêm/sửa/xoá đơn hàng thông qua models/Order.php.
 */

require_once BASE_PATH . '/models/Order.php';

class OrderController
{
    private Order $orderModel;

    public function __construct(PDO $pdo)
    {
        $this->orderModel = new Order($pdo);
    }

    /** Hiển thị danh sách đơn hàng (admin/orders.php sẽ gọi hàm này). */
    public function danhSach(): array
    {
        // TODO (bài tập 3)
        return $this->orderModel->layDanhSach();
    }

    /** Xem chi tiết 1 đơn hàng (views/orders/detail.php sẽ gọi hàm này). */
    public function chiTiet(int $id): ?array
    {
        // TODO (bài tập 3)
        return $this->orderModel->layTheoId($id);
    }

    /** Cập nhật trạng thái đơn hàng (ví dụ: đã xử lý -> đang giao). */
    public function capNhatTrangThai(int $id, string $trangThaiMoi): bool
    {
        // TODO (bài tập 3)
        return $this->orderModel->capNhatTrangThai($id, $trangThaiMoi);
    }
}
