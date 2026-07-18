<?php
/**
 * public/register.php
 * PLACEHOLDER — giao diện đăng ký thật sẽ được nối vào ở bài tập 3
 * (cùng lúc với login.php), khi có bảng users trong CSDL.
 */

session_start();
require_once __DIR__ . '/../config/config.php';
require BASE_PATH . '/includes/header.php';
?>

<main>
    <section class="section-placeholder">
        <div class="container text-center">
            <p class="section-eyebrow">Đăng ký</p>
            <h1 class="section-title">Tính năng đang được xây dựng</h1>
            <p class="section-desc mx-auto">
                Trang đăng ký tài khoản sẽ hoạt động đầy đủ ở bài tập 3, khi kết nối
                với bảng <code>users</code> trong CSDL MySQL.
            </p>
            <a href="index.php" class="btn btn-cta btn-lg mt-3">Về trang chủ</a>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/includes/footer.php'; ?>
