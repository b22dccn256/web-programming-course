<?php
/**
 * admin/orders.php — Quản lý đơn hàng.
 * PLACEHOLDER: ở bài tập 3 sẽ nạp OrderController, gọi $controller->danhSach()
 * lấy dữ liệu từ bảng orders rồi render bằng views/orders/list.php.
 */

session_start();
require_once __DIR__ . '/../config/config.php';

/*
 * Mã dự kiến cho bài tập 3:
 *
 * require_once BASE_PATH . '/config/database.php';
 * require_once BASE_PATH . '/controllers/OrderController.php';
 * $pdo = ketNoiCSDL();
 * $orderController = new OrderController($pdo);
 * $danhSachDonHang = $orderController->danhSach();
 * require BASE_PATH . '/views/orders/list.php'; // render bảng đơn hàng
 */
$danhSachDonHang = []; // rỗng vì chưa có CSDL
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng — Quản trị <?php echo SITE_NAME; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="../public/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="admin-layout">
        <?php require BASE_PATH . '/includes/sidebar.php'; ?>
        <main class="admin-content">
            <h1 class="section-title">Đơn hàng</h1>
            <p class="section-desc">Danh sách đơn hàng sẽ hiển thị ở đây sau khi kết nối CSDL (bài tập 3).</p>
            <?php if (empty($danhSachDonHang)): ?>
                <div class="alert alert-error-custom mt-3" style="max-width: 60ch;">
                    <i class="bi bi-inbox"></i> Chưa có dữ liệu — bảng <code>orders</code> chưa được tạo.
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
