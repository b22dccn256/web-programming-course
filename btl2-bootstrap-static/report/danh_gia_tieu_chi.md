# Đánh Giá Chi Tiết Bài Tập Lớn Số 2 (Bootstrap Tĩnh)

Tài liệu này đánh giá chi tiết dự án dựa trên hai tiêu chí trọng tâm: Khả năng trình bày và Hiểu biết về các class Bootstrap được áp dụng.

---

## Tiêu chí 1: Thể hiện được khả năng trình bày

Giao diện website thể hiện sự đầu tư kỹ lưỡng về mặt trình bày, không chỉ ở bố cục mà còn ở tư duy thiết kế trải nghiệm người dùng (UX) và giao diện người dùng (UI).

### 1. Cấu trúc Semantic HTML rõ ràng
* Code tuân thủ chuẩn HTML5 với việc phân chia rành mạch các vùng không gian: `<header>` (chứa điều hướng), `<main>` (chứa nội dung chính), và `<footer>` (thông tin bản quyền, liên kết phụ).
* Sử dụng thẻ `<section>` kèm theo `id` cụ thể (`#hero`, `#gioi-thieu`, `#dich-vu`, `#khach-hang`, `#lien-he`) giúp code dễ đọc, dễ bảo trì và hỗ trợ tốt cho việc điều hướng (anchor links) trên menu.

### 2. Luồng nội dung (Content Flow) logic
Trang Landing Page được tổ chức theo cấu trúc chuẩn của một sản phẩm SaaS (Phần mềm dịch vụ):
* **Hero Section:** Đập vào mắt người dùng đầu tiên là thông điệp chính và 2 nút Call-To-Action (CTA).
* **Giới thiệu & Số liệu:** Xây dựng niềm tin ngay lập tức bằng các con số thống kê (Social Proof).
* **Dịch vụ cốt lõi:** Nêu bật các tính năng giải quyết vấn đề (Theo dõi đơn, Quản lý kho, Tự động hóa).
* **Khách hàng (Testimonials):** Lời chứng thực tăng độ uy tín.
* **Liên hệ (Form):** Đưa người dùng đến hành động cuối cùng là để lại thông tin.

### 3. Sáng tạo UI có tính ứng dụng (Signature Element)
* Thay vì chỉ để một hình ảnh minh họa khô khan ở phần Hero, dự án đã dùng HTML/CSS để vẽ nên một **"Phiếu vận chuyển" (`.shipping-slip`)** sống động.
* Các chi tiết như mép xé giấy răng cưa (tạo bằng CSS `radial-gradient`), mã vạch, và đặc biệt là thanh tiến trình theo dõi đơn hàng (`.journey-track`) có hiệu ứng tỏa sáng (`pulse-ring`) thể hiện khả năng tùy biến trình bày ở mức độ cao, bám sát hoàn toàn vào chủ đề "OrderFlow - Quản lý đơn hàng".

### 4. Bố cục Responsive và Whitespace
* Các vùng không gian được phân bổ thoáng đãng nhờ thuộc tính padding đồng nhất (`padding: 5rem 0` cho các section).
* Giao diện không bị vỡ trên các thiết bị di động. Từ menu dạng hamburger cho đến lưới nội dung chuyển từ hàng ngang (desktop) sang hàng dọc (mobile) đều mượt mà.

---

## Tiêu chí 2: Hiểu các class áp dụng trong code

Dự án thể hiện sự am hiểu sâu sắc và vận dụng chính xác hệ thống Grid, Component và Utility của Bootstrap 5, kết hợp khéo léo với CSS Custom.

Dưới đây là danh sách các class Bootstrap 5 được sử dụng, phân chia theo từng khu vực (section) xuất hiện lần đầu tiên trong file `index.html`. Các class đã được liệt kê ở phần trên sẽ không lặp lại ở phần dưới.

### 1. Phần Thanh điều hướng (Header / Navbar)
* **`navbar`, `navbar-expand-lg`** *(Vị trí: dòng 28)*: Khởi tạo cấu trúc của thanh điều hướng. `expand-lg` có nghĩa là thanh menu sẽ hiển thị đầy đủ trên màn hình Desktop (lg), nhưng khi xuống màn hình nhỏ hơn sẽ tự động thu gọn lại (thành dạng hamburger menu).
* **`container`** *(Vị trí: dòng 29, 57, 120...)*: Tạo một khung chứa bao bọc toàn bộ nội dung bên trong, tự động căn giữa trang và thiết lập max-width an toàn theo từng kích thước màn hình, giúp nội dung không bị tràn sát lề.
* **`navbar-toggler`, `collapse`** *(Vị trí: dòng 34, 38)*: Xử lý logic ẩn/hiện menu trên giao diện di động.
* **`ms-auto`** *(Vị trí: dòng 39)*: (Margin Start Auto) Đẩy phần tử (như menu list) dạt hết về phía bên phải trong flex container (thường dùng ở Navbar).
* **`align-items-lg-center`** *(Vị trí: dòng 39)*: Sử dụng flexbox để căn giữa theo trục dọc (vertical alignment) cho các phần tử, chỉ áp dụng hiệu lực từ kích thước màn hình lg (Desktop) trở lên.

### 2. Phần Hero (Giới thiệu chính)
* **`row`** *(Vị trí: dòng 58, 121, 133...)*: Khởi tạo một hàng (sử dụng flexbox) để chứa các cột (`col-*`), xử lý triệt để các rắc rối về margin âm mặc định của Bootstrap.
* **`align-items-center`** *(Vị trí: dòng 58, 121)*: Sử dụng flexbox để căn giữa theo trục dọc (vertical alignment) cho các phần tử con bên trong.
* **`gy-5`** *(Vị trí: dòng 58, 121, 252...)*: Tạo khoảng cách (gutter) theo trục Y (chiều dọc) giữa các cột/hàng với kích thước mức độ 5 (rất lớn).
* **`col-lg-6`, `col-lg-5`, `col-lg-7`** *(Vị trí: dòng 59, 122, 253...)*: Định nghĩa độ rộng của cột trên màn hình lớn (Large - từ 992px trở lên). Ví dụ `col-lg-6` sẽ chiếm 6/12 phần (tương đương 50% chiều rộng).
* **`btn`, `btn-lg`** *(Vị trí: dòng 73, 74, 301)*: Định nghĩa cấu trúc chuẩn của một nút bấm (nền, viền, khoảng cách, font) và phiên bản phóng to (`btn-lg`).

### 3. Phần Giới thiệu (Về OrderFlow & Số liệu)
* **`g-4`** *(Vị trí: dòng 133, 169, 211...)*: Tạo khoảng cách (gutter) đồng đều cả hai trục X và Y ở mức độ 4 (vừa phải) cho các phần tử bên trong lưới.

### 4. Phần Dịch vụ
* **`text-center`** *(Vị trí: dòng 167, 168, 209...)*: Căn giữa văn bản.
* **`mt-3`** *(Vị trí: dòng 169, 211)*: (Margin Top mức 3) Tạo một khoảng cách đẩy lùi nội dung phía trên xuống một chút.
* **`col-md-6 col-lg-3`** *(Vị trí: dòng 170, 178, 186...)*: Chaining (nối) class để tạo tính tương thích (Responsive). Ý nghĩa: trên màn hình vừa (Tablet - md) chiếm 6 phần (50% = 2 cột/hàng), trên màn hình lớn (Desktop - lg) chiếm 3 phần (25% = 4 cột/hàng). Trên mobile mặc định sẽ rơi xuống 1 cột (100%).
* **`h-100`** *(Vị trí: dòng 171, 213, 224...)*: Ép phần tử có chiều cao 100% so với phần tử cha, đặc biệt hiệu quả để làm các thẻ Card trong lưới cao bằng nhau dù nội dung bên trong có chênh lệch.

### 5. Phần Liên hệ
* **`d-none`** *(Vị trí: dòng 270)*: Ẩn hoàn toàn phần tử khỏi giao diện (display: none).
* **`form-control`** *(Vị trí: dòng 276, 282, 288...)*: Mặc định định dạng cho thẻ `input` và `textarea` trở nên đẹp mắt, đồng bộ và có trạng thái focus (viền sáng lên) theo phong cách Bootstrap.
* **`invalid-feedback`** *(Vị trí: dòng 278, 284, 290...)*: Class đặc thù dùng cho Form Validation. Nó sẽ tự động ẩn đi, và chỉ hiện ra dòng chữ cảnh báo lỗi màu đỏ khi input phía trên bị đánh dấu là lỗi.
* **`w-100`** *(Vị trí: dòng 301)*: Ép phần tử chiếm độ rộng 100% của phần tử cha (rất hữu ích để nút bấm trải dài trên giao diện mobile).
* **`w-md-auto`** *(Vị trí: dòng 301)*: Khi lên màn hình kích thước từ md (Tablet) trở lên, độ rộng trở về tự động (auto), không còn bị giãn 100% nữa.

### Phạm vi CSS Custom thông minh (Scoping)
* File `style.css` không can thiệp vào các class cấu trúc của Bootstrap (không định nghĩa lại `.row` hay `.col`).
* CSS Custom chỉ nhắm vào việc tạo hình (styling) cho các block đặc thù (VD: `.hero-title`, `.stat-card`, `.journey-dot`). Việc này minh chứng cho sự hiểu biết rõ ràng ranh giới giữa việc "dùng thư viện để dựng khung" và "dùng CSS custom để vẽ lớp áo", một tư duy cực kỳ tốt trong phát triển Web Front-end.
