<?php
/**
 * views/orders/create.php
 * ---------------------------------------------------------
 * Chỉ chứa phần FORM (được include vào trong modal của
 * index.php). Không tự submit theo kiểu HTML thông thường -
 * ajax_orders.js sẽ bắt sự kiện submit, gom dữ liệu thành
 * JSON rồi gửi qua Fetch API tới action=create.
 *
 * Biến có sẵn: $customers (từ OrderController::index()).
 * Biến $products cũng có sẵn (đã đưa qua JS bằng biến PRODUCTS
 * ở index.php, dùng để JS tự render dòng chọn sản phẩm).
 * ---------------------------------------------------------
 */
?>
<form id="createOrderForm">
    <div class="mb-3">
        <label class="form-label">Khách hàng</label>
        <select id="orderCustomerId" class="form-select" required>
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= (int) $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <label class="form-label">Sản phẩm</label>
    <!-- Các dòng sản phẩm được ajax_orders.js thêm/xóa động vào đây -->
    <div id="orderItemsWrapper"></div>

    <button type="button" id="btnAddItemRow" class="btn btn-sm btn-outline-secondary mt-1">
        + Thêm sản phẩm
    </button>

    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <strong>Tạm tính: <span id="orderTotalPreview">0 đ</span></strong>
        <button type="submit" class="btn btn-success">Lưu đơn hàng</button>
    </div>
</form>
