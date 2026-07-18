<?php
/**
 * public/login.php
 * PLACEHOLDER — giao diện đăng nhập thật (gọi UserController + models/User.php
 * + CSDL bảng users) sẽ được nối vào ở bài tập 3. Hiện tại chỉ hiển thị
 * thông báo để không bị lỗi 404 khi bấm "Đăng nhập" từ navbar.
 */

session_start();
require_once __DIR__ . '/../config/config.php';
require BASE_PATH . '/includes/header.php';
?>

<main>
    <section class="section-placeholder">
        <div class="container text-center">
            <p class="section-eyebrow">Đăng nhập</p>
            <h1 class="section-title">Tính năng đang được xây dựng</h1>
            <p class="section-desc mx-auto">
                Trang đăng nhập sẽ hoạt động đầy đủ ở bài tập 3, khi kết nối với
                bảng <code>users</code> trong CSDL MySQL (qua <code>UserController</code>
                và <code>models/User.php</code>).
            </p>
            <a href="index.php" class="btn btn-cta btn-lg mt-3">Về trang chủ</a>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/includes/footer.php'; ?>
