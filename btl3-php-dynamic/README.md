# Quản lý Đơn hàng (Bài tập 3) — PHP thuần + MySQL

Ứng dụng CRUD Đơn hàng đơn giản, dùng PHP thuần (mô hình MVC tự viết, không
framework, không Composer), MySQL, Bootstrap 5.3 và Fetch API cho AJAX.

## 1. Yêu cầu môi trường
- PHP >= 8.0 (có sẵn extension `pdo_mysql`)
- MySQL >= 8.0.16 (bản này trở lên mới thực thi đúng ràng buộc `CHECK` trong schema)

## 2. Cài đặt CSDL
```bash
# Đăng nhập MySQL và tạo database
mysql -u root -p -e "CREATE DATABASE btl3_order_management CHARACTER SET utf8mb4;"

# Tạo bảng
mysql -u root -p btl3_order_management < database/schema.sql

# (Tùy chọn) Đổ dữ liệu mẫu để test ngay
mysql -u root -p btl3_order_management < database/seed.sql
```

Sau đó mở `config/database.php` và chỉnh lại `DB_HOST`, `DB_USER`, `DB_PASS`
cho khớp với máy bạn (mặc định đang để `root` / mật khẩu rỗng, giống XAMPP/Laragon).

## 3. Chạy ứng dụng
Không cần cài Apache/XAMPP — dùng server tích hợp sẵn của PHP:
```bash
php -S localhost:8000
```
Mở trình duyệt: **http://localhost:8000/**

## 4. Cấu trúc thư mục
```text
btl3-php-dynamic/
├── config/database.php       # Kết nối PDO PostgreSQL
├── models/                   # Order, OrderItem, Product, Customer
├── controllers/OrderController.php
├── views/
│   ├── layout/                # header.php, footer.php
│   └── orders/                # index.php, create.php, view.php
├── public/
│   ├── css/style.css
│   └── js/ajax_orders.js      # Toàn bộ logic AJAX (Fetch API)
├── database/
│   ├── schema.sql
│   └── seed.sql
└── index.php                  # Front Controller (routing)
```

## 5. Các file/thư mục CŨ của Bài tập 2 — nên xóa
Những file này thuộc phạm vi Bài tập 2 (landing page + form liên hệ lưu JSON),
không còn dùng trong Bài tập 3, bạn có thể xóa hẳn khỏi thư mục dự án:
- `public/index.php`, `public/contact.php` và các file HTML/PHP cũ khác nằm
  trực tiếp trong `public/` (chỉ giữ lại `public/css/` và `public/js/` mới)
- `admin/` (toàn bộ thư mục)
- `controllers/ContactController.php`
- `models/Contact.php`
- `data/contacts.json` (và thư mục `data/` nếu không còn dùng gì khác)

## 6. Nghiệp vụ chính
- **Tạo đơn hàng**: chọn khách hàng + nhiều sản phẩm → trừ tồn kho và tính
  tổng tiền trong 1 transaction (xem comment trong `models/Order.php::create()`).
- **Lọc/tìm kiếm**: theo trạng thái và tên khách hàng, xử lý bằng AJAX,
  không reload trang.
- **Cập nhật trạng thái** & **Xóa đơn hàng** (xóa sẽ hoàn lại tồn kho).

Pass: 1111