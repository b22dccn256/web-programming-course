<?php
/**
 * includes/navbar.php
 * Thanh điều hướng, tách riêng khỏi header.php để dễ tái sử dụng
 * (ví dụ sau này admin/ có thể dùng navbar khác mà không đụng vào <head>).
 * Được include từ bên trong includes/header.php.
 */
?>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span class="brand-mark">OF</span>
            <span class="brand-name"><?php echo SITE_NAME; ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Mở menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="#hero">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#gioi-thieu">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="#dich-vu">Dịch vụ</a></li>
                <li class="nav-item"><a class="nav-link" href="#khach-hang">Khách hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
                <li class="nav-item">
                    <a class="btn btn-cta" href="#lien-he">Liên hệ tư vấn</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
