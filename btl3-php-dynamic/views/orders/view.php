<?php
/**
 * views/orders/view.php
 * ---------------------------------------------------------
 * Biến có sẵn: $order (mảng, có key 'items' chứa danh sách
 * sản phẩm trong đơn - xem Order::getById()).
 * ---------------------------------------------------------
 */
require __DIR__ . '/../layout/header.php';
?>

<a href="index.php?controller=order&action=index" class="btn btn-link ps-0">&larr; Quay lại danh sách</a>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4>Đơn hàng #<?= (int) $order['id'] ?></h4>
                <p class="mb-1"><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p class="mb-1 text-muted"><?= htmlspecialchars($order['customer_email'] ?? '') ?> · <?= htmlspecialchars($order['customer_phone'] ?? '') ?></p>
                <p class="mb-0"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
            </div>
            <span class="badge bg-<?= statusBadgeColor($order['status']) ?> fs-6" id="currentStatusBadge">
                <?= statusLabel($order['status']) ?>
            </span>
        </div>

        <hr>

        <!-- Đổi trạng thái bằng AJAX - không reload trang -->
        <div class="row g-2 align-items-center mb-3" style="max-width: 420px;">
            <div class="col-auto">Cập nhật trạng thái:</div>
            <div class="col">
                <select id="statusSelect" class="form-select form-select-sm" data-order-id="<?= (int) $order['id'] ?>">
                    <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?>
                        <option value="<?= $s ?>" <?= $s === $order['status'] ? 'selected' : '' ?>>
                            <?= statusLabel($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-end">Đơn giá</th>
                    <th class="text-end">Số lượng</th>
                    <th class="text-end">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td class="text-end"><?= number_format((float) $item['price'], 0, ',', '.') ?> đ</td>
                        <td class="text-end"><?= (int) $item['quantity'] ?></td>
                        <td class="text-end"><?= number_format((float) $item['subtotal'], 0, ',', '.') ?> đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Tổng cộng</th>
                    <th class="text-end"><?= number_format((float) $order['total_amount'], 0, ',', '.') ?> đ</th>
                </tr>
            </tfoot>
        </table>

        <button id="btnDeleteOrder" class="btn btn-outline-danger" data-order-id="<?= (int) $order['id'] ?>">
            Xóa đơn hàng
        </button>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="mainToast" class="toast" role="alert">
        <div class="toast-body" id="mainToastBody"></div>
    </div>
</div>

<script src="public/js/ajax_orders.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
