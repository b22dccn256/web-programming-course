<?php
/**
 * index.php - FRONT CONTROLLER
 * ---------------------------------------------------------
 * MỌI request đều đi qua đúng 1 file này. Chạy dự án bằng:
 *     php -S localhost:8000
 * rồi mở trình duyệt: http://localhost:8000/
 *
 * Cách hoạt động (routing đơn giản, không dùng thư viện):
 *   1) Đọc ?controller=xxx&action=yyy từ URL
 *   2) Đối chiếu với $allowedControllers bên dưới (whitelist)
 *      -> KHÔNG include file trực tiếp theo tên do người dùng
 *      gõ trên URL, tránh lỗi bảo mật Local File Inclusion.
 *   3) Tạo đối tượng Controller tương ứng và gọi đúng action.
 * ---------------------------------------------------------
 */

// Hiển thị lỗi PHP khi code (nên tắt error display khi deploy thật)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ---- 1) Nạp toàn bộ file cần thiết ----
// Vì bài tập giữ đơn giản, không dùng Composer/autoload,
// nên liệt kê require_once thẳng ở đây, thấy ngay toàn bộ
// các file phụ thuộc của ứng dụng chỉ trong vài dòng.
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Customer.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/OrderItem.php';
require_once __DIR__ . '/models/Order.php';
require_once __DIR__ . '/controllers/OrderController.php';

/**
 * Hàm dùng chung để trả JSON response theo 1 format thống
 * nhất cho MỌI action gọi bằng AJAX, để JS phía client chỉ
 * cần xử lý theo đúng 1 kiểu: { success, data, message }
 */
function jsonResponse(bool $success, $data = null, string $message = '', int $httpCode = 200): void
{
    http_response_code($httpCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'message' => $message,
    ]);
    exit;
}

/**
 * 2 hàm helper nhỏ dùng trong các View để hiển thị trạng thái
 * đơn hàng ra tiếng Việt kèm màu badge Bootstrap tương ứng.
 */
function statusLabel(string $status): string
{
    $labels = [
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'shipped' => 'Đã gửi hàng',
        'delivered' => 'Đã giao',
        'cancelled' => 'Đã hủy',
    ];
    return $labels[$status] ?? $status;
}

function statusBadgeColor(string $status): string
{
    $colors = [
        'pending' => 'secondary',
        'processing' => 'warning',
        'shipped' => 'info',
        'delivered' => 'success',
        'cancelled' => 'danger',
    ];
    return $colors[$status] ?? 'light';
}

// ---- 2) Routing ----
// Whitelist: chỉ những controller/action trong danh sách này
// mới được phép gọi. Muốn thêm chức năng mới thì thêm vào đây.
$allowedControllers = [
    'order' => ['index', 'view', 'create', 'search', 'updateStatus', 'delete'],
];

$controllerName = $_GET['controller'] ?? 'order';
$actionName = $_GET['action'] ?? 'index';

if (!isset($allowedControllers[$controllerName])
    || !in_array($actionName, $allowedControllers[$controllerName], true)
) {
    http_response_code(404);
    echo 'Không tìm thấy trang (controller/action không hợp lệ).';
    exit;
}

// ---- 3) Gọi Controller ----
// "order" -> "OrderController" (viết hoa chữ cái đầu + hậu tố Controller)
$controllerClass = ucfirst($controllerName) . 'Controller';
$controller = new $controllerClass();
$controller->$actionName();
