# OrderFlow — Website đơn hàng (Bài tập 2 → chuẩn bị bài tập 3)

Landing page cho công ty giả định **OrderFlow**, xây bằng **Bootstrap 5 + PHP thuần**
(không dùng framework PHP), tổ chức theo mô hình **MVC** để dễ mở rộng sang bài tập 3
(PHP + CSDL MySQL, cùng chủ đề đơn hàng).

## Cấu trúc thư mục

```
btl3-php-dynamic/
├── public/                     # Document root — nơi trình duyệt truy cập trực tiếp
│   ├── index.php               # Landing page (Hero, Giới thiệu, Dịch vụ, Khách hàng, Liên hệ)
│   ├── contact.php             # Entry point xử lý POST từ form liên hệ → gọi ContactController
│   ├── login.php               # Placeholder — hoàn thiện ở bài tập 3
│   ├── register.php            # Placeholder — hoàn thiện ở bài tập 3
│   └── assets/{css,js,img}, uploads/
│
├── includes/
│   ├── header.php               # <head> + gọi navbar.php
│   ├── navbar.php                # Thanh điều hướng
│   ├── footer.php               # Chân trang + script
│   └── sidebar.php               # Sidebar khu vực admin (placeholder)
│
├── config/
│   ├── config.php               # Hằng số dùng chung (SITE_NAME, BASE_PATH...) — ĐANG DÙNG
│   └── database.php             # Hàm ketNoiCSDL() bằng PDO — CHƯA dùng, chuẩn bị cho bài 3
│
├── controllers/
│   ├── ContactController.php    # HOẠT ĐỘNG THẬT — xử lý form liên hệ
│   ├── OrderController.php      # Placeholder — bài tập 3
│   ├── ProductController.php    # Placeholder — bài tập 3
│   └── UserController.php       # Placeholder — bài tập 3
│
├── models/
│   ├── Contact.php               # HOẠT ĐỘNG THẬT — đọc/ghi data/contacts.json
│   ├── Order.php                 # Placeholder — bài tập 3 (nhận PDO qua constructor)
│   ├── Product.php               # Placeholder — bài tập 3
│   └── User.php                  # Placeholder — bài tập 3
│
├── views/
│   ├── orders/{list.php, detail.php}
│   ├── products/{list.php, form.php}
│   └── users/{profile.php, login.php}
│   (tất cả là placeholder, sẽ được include từ admin/ hoặc public/ ở bài 3)
│
├── admin/                        # Khu vực quản trị (placeholder bố cục)
│   ├── index.php                 # Dashboard
│   ├── orders.php
│   ├── products.php
│   └── users.php
│
├── data/
│   └── contacts.json             # "CSDL tạm" bằng file JSON cho form liên hệ
│
└── README.md
```

## Cách chạy thử

```bash
cd orderflow/public
php -S localhost:8000
```

Mở `http://localhost:8000`. **Lưu ý:** vì `public/` là document root, các trang
trong `admin/` (nằm ngoài `public/`) sẽ **không** truy cập được qua lệnh trên.
Đây là điều cần xử lý ở bài tập 3 — xem mục "Cần quyết định ở bài tập 3" bên dưới.

## Luồng xử lý (đã hoạt động thật): form liên hệ

```
public/index.php (form, action="contact.php")
        │  POST
        ▼
public/contact.php            → chỉ nạp config + gọi controller, không có logic
        │
        ▼
controllers/ContactController.php   → validate dữ liệu
        │
        ▼
models/Contact.php                  → lưu vào data/contacts.json
        │
        ▼
header('Location: index.php#lien-he')   → PRG pattern, hiện thông báo qua $_SESSION
```

Đây chính là "khuôn" MVC bạn sẽ lặp lại ở bài tập 3 cho đơn hàng/sản phẩm/người dùng:
`public/*.php` (entry, mỏng) → `controllers/*Controller.php` (xử lý, gọi model) →
`models/*.php` (truy vấn CSDL qua PDO) → `views/*.php` hoặc trực tiếp render HTML.

## Cần quyết định ở bài tập 3

1. **Document root cho `admin/`**: hiện `admin/` là thư mục ngang hàng với `public/`
   nên không nằm trong document root. Hai lựa chọn:
   - Trỏ document root (Apache/XAMPP) vào `orderflow/` thay vì `orderflow/public/`
     — đơn giản, nhưng lộ luôn `config/`, `models/`... ra web nếu không chặn bằng `.htaccess`.
   - Hoặc chuyển `admin/` vào trong `public/admin/` — an toàn hơn, khuyến nghị dùng cách này.
2. Thay `config/database.php` (đã viết sẵn hàm `ketNoiCSDL()`) — chỉ cần tạo CSDL
   `orderflow_db` trong MySQL rồi bỏ comment các dòng gọi hàm này trong `admin/*.php`.
3. Hiện thực từng model theo TODO đã ghi sẵn trong `models/Order.php`,
   `models/Product.php`, `models/User.php`.
4. Model `Contact.php` có thể giữ nguyên (dùng file JSON) hoặc chuyển sang bảng
   `lien_he` trong MySQL — cấu trúc controller gọi model không cần đổi.

## Vì sao tổ chức theo MVC như vậy

- **`public/*.php` mỏng**: chỉ nạp cấu hình và gọi đúng 1 controller, không chứa
  logic validate/truy vấn — dễ đọc, dễ trace lỗi.
- **`controllers/` dùng class OOP**: mỗi controller gói gọn nghiệp vụ của 1 nhóm
  chức năng (liên hệ / đơn hàng / sản phẩm / người dùng), constructor nhận sẵn
  phụ thuộc cần thiết (model, hoặc PDO cho các controller bài 3).
- **`models/` chỉ biết về dữ liệu**: không in HTML, không đọc `$_POST` trực tiếp —
  chỉ nhận mảng dữ liệu đã validate và biết cách lưu/đọc nó (file JSON hiện tại,
  MySQL ở bài 3).

cd C:\web-programming-course\btl2-bootstrap-static\public
C:\php\php.exe -S localhost:8000