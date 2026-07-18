// main.js — Toàn bộ tương tác chạy ở trình duyệt (client-side), không gọi server.

document.addEventListener("DOMContentLoaded", function () {

    // ---- 1. Tự đóng menu mobile sau khi bấm vào 1 mục điều hướng ----
    var navLinks = document.querySelectorAll("#mainNav .nav-link, #mainNav .btn-cta");
    var navCollapseEl = document.getElementById("mainNav");

    navLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            if (navCollapseEl.classList.contains("show")) {
                var collapse = bootstrap.Collapse.getOrCreateInstance(navCollapseEl);
                collapse.hide();
            }
        });
    });

    // ---- 2. Đổi bóng header khi cuộn trang ----
    var header = document.querySelector(".site-header");
    window.addEventListener("scroll", function () {
        header.style.boxShadow = window.scrollY > 12
            ? "0 1px 0 rgba(20, 33, 61, 0.08)"
            : "none";
    });

    // ---- 3. Xử lý form liên hệ hoàn toàn phía client ----
    // Vì đây là bản HTML/CSS/JS tĩnh thuần (không có PHP/server xử lý),
    // form chỉ validate dữ liệu và hiển thị thông báo giả lập, KHÔNG lưu
    // hay gửi dữ liệu đi đâu cả. Khi ghép vào bài tập 2/3 (có PHP + CSDL),
    // đoạn validate ở đây sẽ được thay bằng việc submit thật tới server.
    var contactForm = document.getElementById("contactForm");
    var contactAlert = document.getElementById("contactAlert");

    if (contactForm) {
        contactForm.addEventListener("submit", function (event) {
            event.preventDefault();
            event.stopPropagation();

            var sdtInput = document.getElementById("sdt");
            // Số điện thoại không bắt buộc, nhưng nếu có nhập thì phải đúng định dạng
            if (sdtInput.value.trim() === "") {
                sdtInput.setCustomValidity("");
            }

            if (!contactForm.checkValidity()) {
                contactForm.classList.add("was-validated");
                showAlert("error", "Vui lòng kiểm tra lại các trường được đánh dấu đỏ bên dưới.");
                return;
            }

            contactForm.classList.remove("was-validated");
            showAlert("success", "Cảm ơn bạn! Đây là bản demo tĩnh nên yêu cầu chưa thực sự được gửi đi — chức năng gửi thật sẽ có ở bản PHP.");
            contactForm.reset();
        });
    }

    function showAlert(type, message) {
        var isSuccess = type === "success";
        contactAlert.className = isSuccess ? "alert-success-custom" : "alert-error-custom";
        contactAlert.innerHTML =
            '<i class="bi ' + (isSuccess ? "bi-check-circle" : "bi-exclamation-triangle") + '"></i> ' +
            message;
        contactAlert.classList.remove("d-none");
        contactAlert.scrollIntoView({ behavior: "smooth", block: "center" });
    }
});
