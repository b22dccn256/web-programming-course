<?php
/**
 * includes/footer.php
 * Phần chân trang: thông tin công ty, liên kết nhanh, nạp JS.
 */
$currentYear = date("Y");
?>
<footer class="site-footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <span class="brand-mark">OF</span>
                    <span class="brand-name"><?php echo SITE_NAME; ?></span>
                </div>
                <p class="footer-desc">
                    <?php echo SITE_TAGLINE; ?>. Theo dõi từng đơn hàng, từng chặng đường,
                    từ lúc đặt đến lúc giao tận tay khách hàng.
                </p>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Điều hướng</h6>
                <ul class="footer-links">
                    <li><a href="#hero">Trang chủ</a></li>
                    <li><a href="#gioi-thieu">Giới thiệu</a></li>
                    <li><a href="#dich-vu">Dịch vụ</a></li>
                    <li><a href="#lien-he">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h6 class="footer-heading">Dịch vụ</h6>
                <ul class="footer-links">
                    <li><a href="#dich-vu">Theo dõi đơn hàng</a></li>
                    <li><a href="#dich-vu">Quản lý kho</a></li>
                    <li><a href="#dich-vu">Báo cáo &amp; thống kê</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="footer-heading">Liên hệ</h6>
                <ul class="footer-links">
                    <li><i class="bi bi-geo-alt"></i> 12 Nguyễn Trãi, Thanh Xuân, Hà Nội</li>
                    <li><i class="bi bi-envelope"></i> hi@orderflow.vn</li>
                    <li><i class="bi bi-telephone"></i> 024 3456 7890</li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <span>© <?php echo $currentYear; ?> <?php echo SITE_NAME; ?>. Bài tập môn Lập trình Web — không dùng cho mục đích thương mại.</span>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle (CDN) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
