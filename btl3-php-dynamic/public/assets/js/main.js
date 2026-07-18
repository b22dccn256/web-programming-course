// main.js — Chỉ xử lý tương tác giao diện đơn giản, không liên quan tới dữ liệu.

document.addEventListener("DOMContentLoaded", function () {
    // Tự đóng menu mobile sau khi bấm vào 1 mục điều hướng
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

    // Đổi nền header khi cuộn trang (hiệu ứng nhỏ, không lạm dụng animation)
    var header = document.querySelector(".site-header");
    window.addEventListener("scroll", function () {
        if (window.scrollY > 12) {
            header.style.boxShadow = "0 1px 0 rgba(20, 33, 61, 0.08)";
        } else {
            header.style.boxShadow = "none";
        }
    });
});
