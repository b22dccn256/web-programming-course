<?php
/**
 * config/config.php
 * Các hằng số / cấu hình dùng chung cho toàn bộ site.
 * File này KHÔNG chứa thông tin kết nối CSDL (xem config/database.php).
 */

// Đường dẫn gốc của dự án (thư mục orderflow/), dùng để require file bằng đường dẫn tuyệt đối
define('BASE_PATH', dirname(__DIR__));

// Thông tin hiển thị chung
define('SITE_NAME', 'OrderFlow');
define('SITE_TAGLINE', 'Nền tảng quản lý đơn hàng cho doanh nghiệp');

// Bật hiển thị lỗi khi phát triển (nên tắt khi đưa lên production thật)
error_reporting(E_ALL);
ini_set('display_errors', '1');
