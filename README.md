# Web Programming Course (Monorepo)

Đây là repository lưu trữ các bài tập lớn (BTL) của học phần Lập trình Web.

## Cấu trúc Repository

```text
web-programming-course/
│
├── README.md                 # Tổng quan môn học, hướng dẫn cài đặt từng BTL
├── .gitignore                # Bỏ qua thư mục vendor, node_modules, .env, database dumps
│
├── btl1-wordpress/           # Bài tập lớn 1
│   ├── README.md             # Hướng dẫn cài đặt WP, tài khoản admin demo
│   ├── theme-custom/         # (Nếu có custom theme)
│   └── database.sql          # File export database WP (nếu cần)
│
├── btl2-bootstrap-static/    # Bài tập lớn 2
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   ├── images/
│   └── README.md             # Giới thiệu các component Bootstrap đã sử dụng
│
└── btl3-php-dynamic/         # Bài tập lớn 3 (Quan trọng nhất)
    ├── README.md             # Sơ đồ CSDL, tài khoản demo, hướng dẫn chạy
    ├── database/
    │   └── schema.sql        # File tạo bảng và dữ liệu mẫu
    ├── config/
    │   └── db.php            # Kết nối CSDL (dùng PDO)
    ├── public/               # Thư mục gốc chạy web (chứa index.php, css, js, images)
    ├── src/                  # Chứa code PHP (Controllers, Models) nếu làm theo MVC
    ├── includes/             # Chứa header.php, footer.php, functions.php (nếu làm procedural)
    └── .env                  # Thông tin kết nối CSDL (không commit file này lên Git)
```

## Lộ trình thực hiện

1.  **Giai đoạn 1: BTL 1 - WordPress / Blogpost (Tuần 1-2)**
    *   Mục tiêu: Làm quen với CMS, quản trị nội dung, cơ bản về HTML/CSS trong WP.
2.  **Giai đoạn 2: BTL 2 - Website Bootstrap Tĩnh (Tuần 3-4)**
    *   Mục tiêu: Thành thạo Frontend, Responsive Design, UI/UX cơ bản. Sử dụng Bootstrap 5.
3.  **Giai đoạn 3: BTL 3 - Website PHP + Vấn đáp (Tuần 5-8)**
    *   Mục tiêu: Full-stack cơ bản, bảo mật, kiến trúc rõ ràng. Sử dụng PHP (MVC/Procedural) với PDO (Prepared Statements).

## Quy trình làm việc với Git
*   **Tạo nhánh (Branch)** cho từng BTL: `feature/btl1-wordpress`, v.v.
*   **Commit message rõ ràng**: `feat: ...`, `fix: ...`
*   Chỉ merge vào main khi tính năng đã chạy ổn định.
