/**
 * public/js/ajax_orders.js
 * ---------------------------------------------------------
 * File JS duy nhất của dự án, dùng chung cho cả trang danh
 * sách (index.php) và trang chi tiết (view.php). Vì 2 trang
 * có phần tử khác nhau, mọi thao tác đều kiểm tra element có
 * tồn tại hay không trước khi gắn sự kiện (tránh lỗi console).
 * ---------------------------------------------------------
 */

// ---------- Hàm tiện ích dùng chung ----------

/** Hiện thông báo dạng Toast của Bootstrap (thành công màu xanh, lỗi màu đỏ) */
function showToast(message, isSuccess = true) {
    const toastEl = document.getElementById('mainToast');
    const toastBody = document.getElementById('mainToastBody');
    if (!toastEl || !toastBody) return;

    toastBody.textContent = message;
    toastEl.classList.remove('text-bg-success', 'text-bg-danger');
    toastEl.classList.add(isSuccess ? 'text-bg-success' : 'text-bg-danger');

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

/** Format số thành tiền VNĐ, ví dụ 1250000 -> "1.250.000 đ" */
function formatCurrency(amount) {
    return Number(amount).toLocaleString('vi-VN') + ' đ';
}

/**
 * Gọi API chung: tự thêm header JSON, tự parse JSON trả về.
 * Ném lỗi (throw) nếu server báo success = false, để chỗ gọi
 * dùng try/catch bắt và hiển thị message cho người dùng.
 */
async function callApi(url, options = {}) {
    const res = await fetch(url, {
        headers: { 'Content-Type': 'application/json' },
        ...options,
    });
    const json = await res.json();
    if (!json.success) {
        throw new Error(json.message || 'Có lỗi xảy ra.');
    }
    return json.data;
}

// ===========================================================
// PHẦN 1: TRANG DANH SÁCH (index.php)
// ===========================================================

const orderTableBody = document.getElementById('orderTableBody');

if (orderTableBody) {
    const filterStatus = document.getElementById('filterStatus');
    const filterCustomer = document.getElementById('filterCustomer');
    const btnSearch = document.getElementById('btnSearch');

    /** Vẽ lại toàn bộ nội dung bảng đơn hàng từ mảng JSON trả về */
    function renderOrderRows(orders) {
        if (!orders || orders.length === 0) {
            orderTableBody.innerHTML =
                '<tr><td colspan="6" class="text-center text-muted">Không tìm thấy đơn hàng nào.</td></tr>';
            return;
        }

        const badgeColor = {
            pending: 'secondary', processing: 'warning', shipped: 'info',
            delivered: 'success', cancelled: 'danger',
        };
        const statusText = {
            pending: 'Chờ xử lý', processing: 'Đang xử lý', shipped: 'Đã gửi hàng',
            delivered: 'Đã giao', cancelled: 'Đã hủy',
        };

        orderTableBody.innerHTML = orders.map(o => `
            <tr>
                <td>#${o.id}</td>
                <td>${o.customer_name}</td>
                <td>${new Date(o.order_date.replace(' ', 'T')).toLocaleString('vi-VN')}</td>
                <td>${formatCurrency(o.total_amount)}</td>
                <td><span class="badge bg-${badgeColor[o.status] || 'light'}">${statusText[o.status] || o.status}</span></td>
                <td><a class="btn btn-sm btn-outline-primary" href="index.php?controller=order&action=view&id=${o.id}">Xem</a></td>
            </tr>
        `).join('');
    }

    /** Gọi action=search với 2 tiêu chí lọc: trạng thái + tên khách hàng */
    async function searchOrders() {
        const params = new URLSearchParams({
            controller: 'order',
            action: 'search',
            status: filterStatus.value,
            customer: filterCustomer.value,
        });
        try {
            const orders = await callApi(`index.php?${params.toString()}`);
            renderOrderRows(orders);
        } catch (err) {
            showToast(err.message, false);
        }
    }

    btnSearch.addEventListener('click', searchOrders);
    // Cho phép nhấn Enter trong ô tìm tên khách hàng để tìm luôn
    filterCustomer.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') searchOrders();
    });
    filterStatus.addEventListener('change', searchOrders);

    // ---------- Form tạo đơn hàng (trong modal) ----------
    const orderItemsWrapper = document.getElementById('orderItemsWrapper');
    const btnAddItemRow = document.getElementById('btnAddItemRow');
    const orderTotalPreview = document.getElementById('orderTotalPreview');
    const createOrderForm = document.getElementById('createOrderForm');
    let itemRowCount = 0;

    /** Thêm 1 dòng chọn sản phẩm + số lượng vào form */
    function addItemRow() {
        itemRowCount++;
        const rowId = `item-row-${itemRowCount}`;

        const productOptions = PRODUCTS.map(p =>
            `<option value="${p.id}" data-price="${p.price}" data-stock="${p.stock_quantity}">
                ${p.name} (còn ${p.stock_quantity}, ${formatCurrency(p.price)})
            </option>`
        ).join('');

        const rowHtml = `
            <div class="row g-2 align-items-center mb-2 item-row" id="${rowId}">
                <div class="col-6">
                    <select class="form-select form-select-sm product-select">${productOptions}</select>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control form-control-sm qty-input" value="1" min="1">
                </div>
                <div class="col-2 subtotal-cell text-end">0 đ</div>
                <div class="col-1">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row">×</button>
                </div>
            </div>`;
        orderItemsWrapper.insertAdjacentHTML('beforeend', rowHtml);

        const rowEl = document.getElementById(rowId);
        rowEl.querySelector('.product-select').addEventListener('change', updateTotalPreview);
        rowEl.querySelector('.qty-input').addEventListener('input', updateTotalPreview);
        rowEl.querySelector('.btn-remove-row').addEventListener('click', () => {
            rowEl.remove();
            updateTotalPreview();
        });

        updateTotalPreview();
    }

    /** Tính lại tổng tiền tạm tính mỗi khi đổi sản phẩm/số lượng, đồng thời cập nhật thành tiền từng dòng */
    function updateTotalPreview() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
            const subtotal = price * qty;
            row.querySelector('.subtotal-cell').textContent = formatCurrency(subtotal);
            total += subtotal;
        });
        orderTotalPreview.textContent = formatCurrency(total);
    }

    btnAddItemRow.addEventListener('click', addItemRow);
    addItemRow(); // sẵn 1 dòng đầu tiên khi mở modal

    createOrderForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const customerId = document.getElementById('orderCustomerId').value;
        const items = Array.from(document.querySelectorAll('.item-row')).map(row => ({
            product_id: parseInt(row.querySelector('.product-select').value),
            quantity: parseInt(row.querySelector('.qty-input').value) || 0,
        }));

        try {
            await callApi('index.php?controller=order&action=create', {
                method: 'POST',
                body: JSON.stringify({ customer_id: parseInt(customerId), items }),
            });
            showToast('Tạo đơn hàng thành công!', true);
            // Tải lại danh sách (không reload cả trang) rồi đóng modal
            await searchOrders();
            bootstrap.Modal.getInstance(document.getElementById('createOrderModal')).hide();
            createOrderForm.reset();
            orderItemsWrapper.innerHTML = '';
            itemRowCount = 0;
            addItemRow();
        } catch (err) {
            showToast(err.message, false);
        }
    });
}

// ===========================================================
// PHẦN 2: TRANG CHI TIẾT ĐƠN HÀNG (view.php)
// ===========================================================

const statusSelect = document.getElementById('statusSelect');

if (statusSelect) {
    statusSelect.addEventListener('change', async () => {
        const orderId = statusSelect.dataset.orderId;
        const newStatus = statusSelect.value;

        try {
            await callApi('index.php?controller=order&action=updateStatus', {
                method: 'POST',
                body: JSON.stringify({ id: parseInt(orderId), status: newStatus }),
            });
            showToast('Cập nhật trạng thái thành công!', true);
        } catch (err) {
            showToast(err.message, false);
        }
    });
}

const btnDeleteOrder = document.getElementById('btnDeleteOrder');

if (btnDeleteOrder) {
    btnDeleteOrder.addEventListener('click', async () => {
        if (!confirm('Bạn chắc chắn muốn xóa đơn hàng này? Tồn kho sẽ được hoàn lại.')) return;

        const orderId = btnDeleteOrder.dataset.orderId;
        try {
            await callApi('index.php?controller=order&action=delete', {
                method: 'POST',
                body: JSON.stringify({ id: parseInt(orderId) }),
            });
            showToast('Đã xóa đơn hàng, đang quay về danh sách...', true);
            setTimeout(() => {
                window.location.href = 'index.php?controller=order&action=index';
            }, 800);
        } catch (err) {
            showToast(err.message, false);
        }
    });
}
