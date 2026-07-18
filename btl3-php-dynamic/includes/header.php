<?php
/**
 * includes/header.php
 * Phần đầu trang: khai báo HTML, nạp CSS/font, rồi include navbar.php.
 * Yêu cầu: config/config.php phải được require TRƯỚC khi include file này
 * (để có sẵn hằng số SITE_NAME, SITE_TAGLINE).
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> — <?php echo SITE_TAGLINE; ?></title>
    <meta name="description" content="OrderFlow giúp doanh nghiệp vừa và nhỏ theo dõi, xử lý và giao đơn hàng nhanh hơn, minh bạch hơn.">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Space Grotesk (tiêu đề) + Inter (nội dung) + IBM Plex Mono (mã đơn hàng) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

    <!-- CSS riêng của site -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <?php require BASE_PATH . '/includes/navbar.php'; ?>
</header>
