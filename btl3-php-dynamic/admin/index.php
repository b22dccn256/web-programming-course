<?php
/**
 * admin/index.php — Dashboard quản trị.
 * PLACEHOLDER: bố cục (sidebar + content) đã sẵn sàng, số liệu thật
 * (tổng đơn hàng, doanh thu...) sẽ được nối vào ở bài tập 3 thông qua
 * OrderController/ProductController.
 *
 * LƯU Ý TRIỂN KHAI: thư mục admin/ hiện nằm ngoài public/ theo đúng cấu
 * trúc đã thống nhất. Để truy cập được qua trình duyệt, khi cấu hình
 * virtual host/document root cho bài tập 3, cần trỏ document root vào
 * thư mục gốc orderflow/ (không phải orderflow/public/), hoặc chuyển
 * admin/ vào trong public/admin/ nếu muốn giữ public/ làm document root.
 */

session_start();
require_once __DIR__ . '/../config/config.php';
// require_once BASE_PATH . '/config/database.php'; // sẽ bật lại ở bài tập 3
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Quản trị <?php echo SITE_NAME; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="../public/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="admin-layout">
        <?php require BASE_PATH . '/includes/sidebar.php'; ?>
        <main class="admin-content">
            <h1 class="section-title">Dashboard</h1>
            <p class="section-desc">
                Khu vực này sẽ hiển thị tổng số đơn hàng, doanh thu theo ngày,
                sản phẩm sắp hết hàng... khi CSDL được kết nối ở bài tập 3.
            </p>
            <div class="alert alert-error-custom mt-3" style="max-width: 60ch;">
                <i class="bi bi-cone-striped"></i>
                Đang xây dựng — số liệu bên dưới chỉ là bố cục minh hoạ.
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <div class="stat-card"><div class="stat-number">--</div><div class="stat-label">Tổng đơn hàng</div></div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card"><div class="stat-number">--</div><div class="stat-label">Doanh thu hôm nay</div></div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card"><div class="stat-number">--</div><div class="stat-label">Sản phẩm sắp hết</div></div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
