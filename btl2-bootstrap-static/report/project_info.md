# Thông tin Dự án OrderFlow (Bản Tĩnh)

Tài liệu này trình bày các thành phần chi tiết của Trang chủ và danh sách các class Bootstrap đã được sử dụng trong giao diện.

## 1. Các thành phần của Trang Chủ (`index.html`)

Trang chủ được cấu trúc thành các phần (section) rõ ràng, đi từ trên xuống dưới nhằm dẫn dắt người dùng:

1. **Header / Thanh Điều Hướng (`<header>`)**
   - Logo thương hiệu (OrderFlow).
   - Menu điều hướng dạng neo (anchor links) trỏ đến các section trên trang: Trang chủ, Giới thiệu, Dịch vụ, Khách hàng.
   - Nút "Liên hệ tư vấn" nổi bật (Call-To-Action).
   - Nút hamburger menu mở rộng khi xem trên thiết bị di động.

2. **Hero Section (`<section id="hero">`)**
   - Tiêu đề chính gây ấn tượng, mô tả ngắn gọn về giải pháp.
   - Các nút hành động chính (Liên hệ tư vấn, Xem dịch vụ).
   - Minh họa trực quan: Mô phỏng một "Phiếu vận chuyển" với dải theo dõi hành trình (tracking) sinh động.

3. **Giới thiệu (`<section id="gioi-thieu">`)**
   - Mô tả ngắn gọn về nguồn gốc/lý do ra đời của OrderFlow.
   - Các thẻ hiển thị số liệu thống kê nổi bật (12.400+ đơn hàng, 860 doanh nghiệp, 99.2% giao đúng hẹn, 3.5 phút xử lý).

4. **Dịch vụ (`<section id="dich-vu">`)**
   - Danh sách các tính năng cốt lõi của nền tảng dưới dạng các thẻ dịch vụ (Cards).
   - Bao gồm: Theo dõi đơn hàng real-time, Quản lý kho & tồn kho, Tự động hoá quy trình, Báo cáo & thống kê.

5. **Khách hàng (`<section id="khach-hang">`)**
   - Phần Testimonials (Ý kiến khách hàng).
   - Trích dẫn đánh giá thực tế từ các chủ shop, quản lý vận hành đang sử dụng nền tảng.

6. **Liên hệ (`<section id="lien-he">`)**
   - Khu vực để người dùng liên hệ.
   - Bên trái: Lời kêu gọi, Thông tin liên hệ (Địa chỉ, Email, Điện thoại).
   - Bên phải: Form nhập thông tin liên hệ (Họ tên, Email, Số điện thoại, Nội dung cần tư vấn). Form có tích hợp validate (kiểm tra hợp lệ) phía client.

7. **Footer / Chân trang (`<footer>`)**
   - Tóm tắt lại thông tin thương hiệu.
   - Các cột điều hướng phụ (Sitemap, Links dịch vụ).
   - Lặp lại thông tin liên hệ và dòng Copyright.

---

## 2. Các Class Bootstrap đã sử dụng

Trang chủ sử dụng **Bootstrap 5** qua CDN. Dưới đây là các nhóm class Bootstrap chính đã được áp dụng để dựng Layout và UI:

### Layout & Grid System (Hệ thống lưới và Bố cục)
- `container`: Giới hạn chiều rộng nội dung, căn giữa và tạo khoảng lề 2 bên an toàn.
- `row`: Bọc các cột, kích hoạt Flexbox để dàn hàng ngang.
- **Cột (Columns)**: `col-lg-6`, `col-lg-5`, `col-lg-7`, `col-md-6`, `col-lg-3`, `col-lg-4`, `col-6`, `col-12`: Định dạng độ rộng linh hoạt dựa trên các kích thước màn hình (Breakpoints như lg, md).
- **Gutter (Khoảng cách giữa các cột)**: `g-3`, `g-4`, `gy-4`, `gy-5`: Tạo khoảng trống ngang/dọc giữa các cột trong `row`.

### Navbar (Thanh điều hướng)
- `navbar`, `navbar-expand-lg`: Khởi tạo thanh điều hướng cơ bản và quy định menu sẽ bung ra (không bị cuộn/giấu) ở màn hình lớn (`lg`).
- `navbar-brand`: Định dạng khu vực Logo/Tên thương hiệu.
- `navbar-toggler`, `navbar-toggler-icon`: Nút bấm hamburger menu hiển thị trên thiết bị di động.
- `collapse`, `navbar-collapse`: Bọc nội dung menu để xử lý hiệu ứng thu vào / mở ra.
- `navbar-nav`, `nav-item`, `nav-link`: Định dạng cấu trúc danh sách menu chuẩn của Bootstrap.

### Forms (Biểu mẫu)
- `form-label`: Định dạng nhãn text của các input.
- `form-control`: Định dạng chuẩn cho ô nhập liệu (input, textarea), tự động chiếm 100% chiều rộng và có viền/focus đẹp mắt.
- `invalid-feedback`: Hiển thị dòng text báo lỗi (màu đỏ) khi người dùng nhập sai/thiếu thông tin trong Form Validate.

### Buttons (Nút bấm)
- `btn`: Lớp cơ sở cho nút bấm (reset mặc định của trình duyệt).
- `btn-lg`: Tăng kích thước nút bấm (Large button).

### Utilities (Tiện ích căn chỉnh & Khoảng cách)
- **Margin / Padding**: `mt-2`, `mt-3`, `mb-0`, `ms-auto` (đẩy phần tử sát lề phải).
- **Flexbox Alignment**: 
  - `align-items-center`: Căn giữa nội dung theo chiều dọc.
  - `align-items-lg-center`: Căn giữa dọc nhưng chỉ áp dụng trên màn hình lớn.
- **Text Alignment**: `text-center` (căn giữa chữ).
- **Gap**: `gap-lg-2` (tạo khoảng cách giữa các phần tử flex).
- **Sizing**: `w-100` (rộng 100%), `w-md-auto` (chiều rộng tự động trên tablet/PC), `h-100` (chiều cao 100% để các thẻ Card bằng nhau).
- **Display**: `d-none` (ẩn phần tử).

*(Lưu ý: Dự án có viết thêm một số class CSS tùy chỉnh trong file `style.css` để mở rộng UI như màu sắc, bóng đổ, và thiết kế cấu trúc chi tiết dựa trên nền tảng của Bootstrap).*
