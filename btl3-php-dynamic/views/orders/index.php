<?php
/**
 * views/orders/index.php
 * ---------------------------------------------------------
 * Biến có sẵn khi file này được require từ OrderController::index():
 *   $orders    -> danh sách đơn hàng (lần tải trang đầu tiên)
 *   $customers -> danh sách khách hàng (đổ vào dropdown modal)
 *   $products  -> danh sách sản phẩm (đổ vào modal chọn sản phẩm)
 * ---------------------------------------------------------
 */
require __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Danh sách Đơn hàng</h3>
    <!-- data-bs-toggle mở modal tạo đơn hàng (Bootstrap tự xử lý, không cần JS thêm) -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
        + Tạo đơn hàng
    </button>
</div>

<!-- KHU VỰC LỌC / TÌM KIẾM: xử lý bằng AJAX (ajax_orders.js), không reload trang -->
<div class="row g-2 mb-3">
    <div class="col-md-4">
        <select id="filterStatus" class="form-select">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="pending">Chờ xử lý</option>
            <option value="processing">Đang xử lý</option>
            <option value="shipped">Đã gửi hàng</option>
            <option value="delivered">Đã giao</option>
            <option value="cancelled">Đã hủy</option>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" id="filterCustomer" class="form-control" placeholder="Tìm theo tên khách hàng...">
    </div>
    <div class="col-md-2">
        <button id="btnSearch" class="btn btn-outline-secondary w-100">Tìm kiếm</button>
    </div>
</div>

<!-- Toast thông báo dùng chung cho mọi thao tác AJAX (thành công/thất bại) -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="mainToast" class="toast" role="alert">
        <div class="toast-body" id="mainToastBody"></div>
    </div>
</div>

<table class="table table-hover align-middle bg-white">
    <thead class="table-light">
        <tr>
            <th>Mã ĐH</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th></th>
        </tr>
    </thead>
    <!-- id="orderTableBody" -> ajax_orders.js sẽ render lại nội dung bảng này mỗi khi tìm kiếm -->
    <tbody id="orderTableBody">
        <?php if (empty($orders)): ?>
            <tr><td colspan="6" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
        <?php else: foreach ($orders as $o): ?>
            <tr>
                <td>#<?= (int) $o['id'] ?></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($o['order_date'])) ?></td>
                <td><?= number_format((float) $o['total_amount'], 0, ',', '.') ?> đ</td>
                <td><span class="badge bg-<?= statusBadgeColor($o['status']) ?>"><?= statusLabel($o['status']) ?></span></td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="index.php?controller=order&action=view&id=<?= (int) $o['id'] ?>">Xem</a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>

<!-- MODAL TẠO ĐƠN HÀNG MỚI -->
<div class="modal fade" id="createOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tạo đơn hàng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php require __DIR__ . '/create.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Truyền dữ liệu sản phẩm từ PHP sang JS để JS dùng khi thêm dòng sản phẩm động
    const PRODUCTS = <?= json_encode($products) ?>;
</script>
<script src="public/js/ajax_orders.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
