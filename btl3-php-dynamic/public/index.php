<?php
/**
 * public/index.php — Trang landing page chính của OrderFlow.
 * Cấu trúc: Hero, Giới thiệu, Dịch vụ, Khách hàng, Liên hệ.
 * Dữ liệu (dịch vụ, khách hàng, thống kê) là mock data khai báo bằng mảng
 * PHP ngay trong file này — ở bài tập 3 sẽ thay bằng ProductController/...
 * lấy dữ liệu thật từ CSDL.
 */

session_start();
require_once __DIR__ . '/../config/config.php';

// Lấy trạng thái gửi form liên hệ (nếu có) rồi xoá khỏi session để không hiện lại khi F5
$contactStatus = $_SESSION['contact_status'] ?? null;
$contactErrors = $_SESSION['contact_errors'] ?? [];
$oldInput      = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_status'], $_SESSION['contact_errors'], $_SESSION['contact_old']);

// ----- Mock data: các bước hành trình đơn hàng (dùng cho dải theo dõi ở Hero) -----
$hanhTrinh = [
    ['nhan' => 'Đặt hàng',    'icon' => 'bi-bag-check',    'trang_thai' => 'done'],
    ['nhan' => 'Xử lý',       'icon' => 'bi-box-seam',     'trang_thai' => 'done'],
    ['nhan' => 'Vận chuyển',  'icon' => 'bi-truck',        'trang_thai' => 'active'],
    ['nhan' => 'Giao hàng',   'icon' => 'bi-house-check',  'trang_thai' => 'pending'],
];

// ----- Mock data: số liệu giới thiệu -----
$thongKe = [
    ['so' => '12.400+', 'nhan' => 'đơn hàng xử lý mỗi ngày'],
    ['so' => '860',     'nhan' => 'doanh nghiệp đang sử dụng'],
    ['so' => '99.2%',   'nhan' => 'đơn hàng giao đúng hẹn'],
    ['so' => '3.5 phút','nhan' => 'thời gian xử lý trung bình'],
];

// ----- Mock data: dịch vụ -----
$dichVu = [
    [
        'icon' => 'bi-broadcast',
        'tieu_de' => 'Theo dõi đơn hàng real-time',
        'mo_ta' => 'Cập nhật trạng thái từng đơn hàng theo thời gian thực, từ lúc tiếp nhận đến khi giao thành công.',
    ],
    [
        'icon' => 'bi-boxes',
        'tieu_de' => 'Quản lý kho & tồn kho',
        'mo_ta' => 'Đồng bộ tồn kho theo từng chi nhánh, cảnh báo sớm khi sản phẩm sắp hết hàng.',
    ],
    [
        'icon' => 'bi-diagram-3',
        'tieu_de' => 'Tự động hoá quy trình',
        'mo_ta' => 'Tự động phân loại, gán đơn vị vận chuyển và nhắc việc cho nhân viên xử lý đơn.',
    ],
    [
        'icon' => 'bi-bar-chart-line',
        'tieu_de' => 'Báo cáo & thống kê',
        'mo_ta' => 'Biểu đồ doanh thu, tỉ lệ huỷ đơn, thời gian giao hàng trung bình theo tuần/tháng.',
    ],
];

// ----- Mock data: khách hàng / đánh giá -----
$khachHang = [
    [
        'ten' => 'Nguyễn Thu Hà',
        'vai_tro' => 'Chủ shop thời trang, Hà Nội',
        'noi_dung' => 'Từ khi dùng OrderFlow, mình không còn phải mở 3-4 group Zalo để hỏi tình trạng đơn hàng nữa. Mọi thứ nằm gọn trên một màn hình.',
    ],
    [
        'ten' => 'Trần Minh Khôi',
        'vai_tro' => 'Quản lý vận hành, chuỗi bán lẻ',
        'noi_dung' => 'Báo cáo tồn kho theo thời gian thực giúp team mình giảm gần một nửa số lần giao thiếu hàng.',
    ],
    [
        'ten' => 'Phạm Bảo Ngọc',
        'vai_tro' => 'Founder, xưởng sản xuất thủ công',
        'noi_dung' => 'Giao diện đơn giản, nhân viên mới chỉ mất nửa buổi để làm quen và tự xử lý đơn hàng.',
    ],
];

require BASE_PATH . '/includes/header.php';
?>

<main>

    <!-- ================= HERO ================= -->
    <section id="hero" class="hero">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <div class="eyebrow">
                        <span class="tracking-code">MÃ ĐƠN #OF-2026-00142</span>
                    </div>
                    <h1 class="hero-title">
                        Mọi đơn hàng đều có<br>
                        một hành trình<br>
                        <span class="text-accent">đáng để theo dõi.</span>
                    </h1>
                    <p class="hero-desc">
                        OrderFlow giúp doanh nghiệp vừa và nhỏ tiếp nhận, xử lý và giao đơn hàng
                        nhanh hơn — với dữ liệu minh bạch cho cả đội ngũ vận hành lẫn khách hàng.
                    </p>
                    <div class="hero-actions">
                        <a href="#lien-he" class="btn btn-cta btn-lg">Liên hệ tư vấn</a>
                        <a href="#dich-vu" class="btn btn-outline-ghost btn-lg">Xem dịch vụ</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Signature element: phiếu vận chuyển với dải theo dõi hành trình -->
                    <div class="shipping-slip">
                        <div class="slip-header">
                            <span>PHIẾU VẬN CHUYỂN</span>
                            <span class="tracking-code">#OF-2026-00142</span>
                        </div>
                        <div class="journey-track">
                            <?php foreach ($hanhTrinh as $i => $buoc): ?>
                                <div class="journey-step journey-<?php echo $buoc['trang_thai']; ?>">
                                    <div class="journey-dot"><i class="bi <?php echo $buoc['icon']; ?>"></i></div>
                                    <span class="journey-label"><?php echo $buoc['nhan']; ?></span>
                                </div>
                                <?php if ($i < count($hanhTrinh) - 1): ?>
                                    <div class="journey-line journey-line-<?php echo $buoc['trang_thai']; ?>"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="slip-footer">
                            <span>Dự kiến giao: <strong>Hôm nay, 18:30</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= GIỚI THIỆU ================= -->
    <section id="gioi-thieu" class="section-gioithieu">
        <div class="container">
            <div class="row gy-5 align-items-center">
                <div class="col-lg-5">
                    <p class="section-eyebrow">Giới thiệu</p>
                    <h2 class="section-title">Xây dựng cho đội vận hành thật,<br>không phải cho slide thuyết trình.</h2>
                    <p class="section-desc">
                        OrderFlow ra đời từ chính nỗi đau của những chủ shop phải quản lý đơn hàng
                        qua sổ tay, Excel và hàng chục cuộc gọi mỗi ngày. Chúng tôi thu gọn toàn bộ
                        quy trình ấy vào một nền tảng duy nhất — dễ dùng ngay từ ngày đầu.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <?php foreach ($thongKe as $tk): ?>
                            <div class="col-6">
                                <div class="stat-card">
                                    <div class="stat-number"><?php echo $tk['so']; ?></div>
                                    <div class="stat-label"><?php echo $tk['nhan']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= DỊCH VỤ ================= -->
    <section id="dich-vu" class="section-dichvu">
        <div class="container">
            <p class="section-eyebrow text-center">Dịch vụ</p>
            <h2 class="section-title text-center">Mọi công cụ cần thiết để vận hành đơn hàng</h2>
            <div class="row g-4 mt-3">
                <?php foreach ($dichVu as $dv): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card h-100">
                            <div class="service-icon"><i class="bi <?php echo $dv['icon']; ?>"></i></div>
                            <h3 class="service-title"><?php echo $dv['tieu_de']; ?></h3>
                            <p class="service-desc"><?php echo $dv['mo_ta']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= KHÁCH HÀNG / TESTIMONIALS ================= -->
    <section id="khach-hang" class="section-khachhang">
        <div class="container">
            <p class="section-eyebrow text-center">Khách hàng nói gì</p>
            <h2 class="section-title text-center">Được tin dùng bởi các đội vận hành bận rộn</h2>
            <div class="row g-4 mt-3">
                <?php foreach ($khachHang as $kh): ?>
                    <div class="col-lg-4">
                        <div class="testimonial-card h-100">
                            <i class="bi bi-quote quote-icon"></i>
                            <p class="testimonial-text">"<?php echo $kh['noi_dung']; ?>"</p>
                            <div class="testimonial-author">
                                <span class="author-name"><?php echo $kh['ten']; ?></span>
                                <span class="author-role"><?php echo $kh['vai_tro']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ================= LIÊN HỆ ================= -->
    <section id="lien-he" class="section-lienhe">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-5">
                    <p class="section-eyebrow">Liên hệ</p>
                    <h2 class="section-title">Sẵn sàng dùng thử OrderFlow?</h2>
                    <p class="section-desc">
                        Để lại thông tin, đội ngũ tư vấn sẽ liên hệ trong vòng 24 giờ làm việc.
                    </p>
                    <ul class="contact-info-list">
                        <li><i class="bi bi-geo-alt"></i> 12 Nguyễn Trãi, Thanh Xuân, Hà Nội</li>
                        <li><i class="bi bi-envelope"></i> hi@orderflow.vn</li>
                        <li><i class="bi bi-telephone"></i> 024 3456 7890</li>
                    </ul>
                </div>

                <div class="col-lg-7">
                    <div class="contact-form-card">

                        <?php if ($contactStatus === 'success'): ?>
                            <div class="alert alert-success-custom" role="alert">
                                <i class="bi bi-check-circle"></i>
                                Cảm ơn bạn! Yêu cầu tư vấn đã được ghi nhận, chúng tôi sẽ liên hệ sớm.
                            </div>
                        <?php elseif ($contactStatus === 'error'): ?>
                            <div class="alert alert-error-custom" role="alert">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Vui lòng kiểm tra lại:</strong>
                                <ul class="mb-0 mt-1">
                                    <?php foreach ($contactErrors as $loi): ?>
                                        <li><?php echo htmlspecialchars($loi, ENT_QUOTES, 'UTF-8'); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="contact.php" method="POST" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="ho_ten" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                                           value="<?php echo htmlspecialchars($oldInput['ho_ten'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                           placeholder="Nguyễn Văn A">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?php echo htmlspecialchars($oldInput['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                           placeholder="ban@congty.vn">
                                </div>
                                <div class="col-md-6">
                                    <label for="sdt" class="form-label">Số điện thoại (không bắt buộc)</label>
                                    <input type="text" class="form-control" id="sdt" name="sdt"
                                           value="<?php echo htmlspecialchars($oldInput['sdt'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                           placeholder="09xx xxx xxx">
                                </div>
                                <div class="col-12">
                                    <label for="noi_dung" class="form-label">Nội dung cần tư vấn</label>
                                    <textarea class="form-control" id="noi_dung" name="noi_dung" rows="4"
                                              placeholder="Shop của bạn hiện đang xử lý khoảng bao nhiêu đơn/ngày?"><?php echo htmlspecialchars($oldInput['noi_dung'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-cta btn-lg w-100 w-md-auto">
                                        Gửi yêu cầu tư vấn
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require BASE_PATH . '/includes/footer.php'; ?>
