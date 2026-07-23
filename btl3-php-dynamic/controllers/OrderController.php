<?php
/**
 * controllers/OrderController.php
 * ---------------------------------------------------------
 * Mỗi method ứng với 1 action, được index.php gọi tới dựa
 * theo ?controller=order&action=...
 *
 * Quy ước trong Controller này:
 *   - index(), view()  -> render ra HTML (nạp file View)
 *   - create(), search(), updateStatus(), delete() -> trả JSON
 *     (được gọi bằng Fetch API từ public/js/ajax_orders.js)
 * ---------------------------------------------------------
 */
class OrderController
{
    /** GET index.php?controller=order&action=index -> trang danh sách đơn hàng */
    public function index(): void
    {
        // Lấy dữ liệu ban đầu (chưa lọc) để hiển thị lần đầu tải trang.
        // Sau đó việc lọc/tìm kiếm sẽ do JS gọi action=search bằng AJAX.
        $orders = Order::getAll();
        $customers = Customer::getAll(); // để đổ vào dropdown trong modal tạo đơn
        $products = Product::getAll();   // để đổ vào danh sách chọn sản phẩm

        require __DIR__ . '/../views/orders/index.php';
    }

    /** GET index.php?controller=order&action=view&id=5 -> trang chi tiết đơn hàng */
    public function view(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $order = Order::getById($id);

        if (!$order) {
            http_response_code(404);
            echo 'Không tìm thấy đơn hàng.';
            return;
        }

        require __DIR__ . '/../views/orders/view.php';
    }

    /**
     * POST index.php?controller=order&action=create (AJAX, JSON body)
     * Body mẫu: { "customer_id": 1, "items": [{"product_id":2,"quantity":3}] }
     */
    public function create(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $customerId = (int) ($input['customer_id'] ?? 0);
        $items = $input['items'] ?? [];

        // Validate cơ bản đầu vào trước khi chạm tới Model
        if ($customerId <= 0) {
            jsonResponse(false, null, 'Vui lòng chọn khách hàng.', 422);
        }
        if (!is_array($items) || count($items) === 0) {
            jsonResponse(false, null, 'Đơn hàng cần ít nhất 1 sản phẩm.', 422);
        }

        try {
            $orderId = Order::create($customerId, $items);
            jsonResponse(true, ['order_id' => $orderId], 'Tạo đơn hàng thành công.');
        } catch (Exception $e) {
            // Lỗi nghiệp vụ (VD: hết hàng) -> trả về thông báo rõ ràng cho JS hiển thị
            jsonResponse(false, null, $e->getMessage(), 422);
        }
    }

    /**
     * GET index.php?controller=order&action=search&status=&customer=
     * Dùng cho ô lọc/tìm kiếm bằng AJAX ở trang danh sách - trả về
     * JSON, JS sẽ dùng để vẽ lại các dòng trong bảng, không reload trang.
     */
    public function search(): void
    {
        $status = trim($_GET['status'] ?? '');
        $customerName = trim($_GET['customer'] ?? '');

        $orders = Order::getAll($status, $customerName);
        jsonResponse(true, $orders);
    }

    /**
     * POST index.php?controller=order&action=updateStatus (AJAX, JSON body)
     * Body mẫu: { "id": 5, "status": "shipped" }
     */
    public function updateStatus(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int) ($input['id'] ?? 0);
        $status = $input['status'] ?? '';

        try {
            Order::updateStatus($id, $status);
            jsonResponse(true, null, 'Cập nhật trạng thái thành công.');
        } catch (Exception $e) {
            jsonResponse(false, null, $e->getMessage(), 422);
        }
    }

    /**
     * POST index.php?controller=order&action=delete (AJAX, JSON body)
     * Body mẫu: { "id": 5 }
     */
    public function delete(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int) ($input['id'] ?? 0);

        try {
            Order::delete($id);
            jsonResponse(true, null, 'Xóa đơn hàng thành công.');
        } catch (Exception $e) {
            jsonResponse(false, null, $e->getMessage(), 422);
        }
    }
}
