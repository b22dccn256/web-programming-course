# Kịch bản Thuyết trình / Trả lời vấn đáp (Bài tập lớn số 2)

Dưới đây là kịch bản gợi ý để bạn trả lời giảng viên, tập trung vào 2 tiêu chí đầu tiên. Các hành động (thao tác) được đặt trong dấu ngoặc vuông `[...]`.

---

## 1. Trả lời Tiêu chí 1: Thể hiện được khả năng trình bày

**[Thao tác]:** Mở trình duyệt, hiển thị giao diện trang web (cuộn từ từ từ trên xuống dưới để giảng viên xem tổng quan).

**[Lời thoại gợi ý]:**
> "Dạ thưa thầy/cô, về tiêu chí khả năng trình bày, giao diện trang web của em/nhóm em được thiết kế tập trung vào 4 điểm chính sau:
> 
> **Thứ nhất**, về cấu trúc HTML, em chia vùng rất rành mạch theo chuẩn Semantic với các thẻ `<header>`, `<main>`, `<section>` và `<footer>`.
> **Thứ hai**, luồng nội dung được sắp xếp logic dẫn dắt người xem: từ Hero section giới thiệu tổng quan, đến các con số thống kê, chi tiết dịch vụ, nhận xét khách hàng và chốt lại bằng form liên hệ ở cuối.
> **Thứ ba**, điểm nhấn sáng tạo của giao diện nằm ở phần 'Phiếu vận chuyển' trên đầu trang. Thay vì dùng ảnh, em đã kết hợp CSS và HTML để tạo ra mép xé giấy và thanh tiến trình có hiệu ứng tỏa sáng, bám sát chủ đề quản lý đơn hàng.
> **Cuối cùng**, bố cục không gian được phân bổ thoáng với khoảng cách padding đồng nhất. Giao diện cũng được Responsive hoàn toàn, menu ngang trên máy tính tự động thu gọn thành menu hamburger trên mobile, và không bị vỡ bố cục."

---

## 2. Trả lời Tiêu chí 2: Hiểu các class áp dụng trong code

**[Thao tác]:** Đóng trình duyệt, mở file `index.html` trong trình soạn thảo code (ví dụ: VS Code). 

**[Lời thoại gợi ý]:**
> "Để minh chứng cho việc hiểu các class Bootstrap đã áp dụng, em xin phép mở trực tiếp file `index.html` và giải thích một số class tiêu biểu em đã dùng."

**[Thao tác]: Cuộn đến phần `<header>`, bôi đen dòng `<nav class="navbar navbar-expand-lg">`**
> "Ở đây em dùng class `navbar` để tạo bộ khung thanh điều hướng. `navbar-expand-lg` có tác dụng là thanh menu này sẽ trải ngang hiển thị đầy đủ trên màn hình kích thước lớn (Desktop), nhưng khi xuống màn hình nhỏ nó sẽ tự động thu gọn lại thành nút bấm ẩn."

**[Thao tác]: Bôi đen `<div class="container">` ngay bên dưới**
> "Hầu hết các section em đều bọc bằng class `container`. Class này giúp thu gom nội dung vào giữa trang, đồng thời tự động tạo khoảng lề (padding) an toàn ở hai bên để nội dung không bị tràn sát ra mép màn hình."

**[Thao tác]: Bôi đen `<ul class="navbar-nav ms-auto align-items-lg-center">`**
> "Ở danh sách menu, em dùng `ms-auto` (tức là margin-start auto) để đẩy toàn bộ các mục menu dạt hết về phía bên phải. Còn `align-items-lg-center` để căn giữa văn bản theo chiều dọc, hiệu lực từ màn hình lớn trở lên."

**[Thao tác]: Cuộn xuống thẻ `<section id="hero">`, bôi đen dòng `<div class="row align-items-center gy-5">`**
> "Ở phần đầu trang này, em khởi tạo một lưới với class `row`. Điểm đáng chú ý là class `gy-5` (Gutter Y mức 5). Nó tạo khoảng cách lớn theo chiều dọc. Khi xem trên điện thoại, 2 cột bị rớt dòng thì `gy-5` sẽ tự động tạo khoảng trống giúp chúng không dính sát vào nhau."

**[Thao tác]: Bôi đen `<div class="col-lg-6">`**
> "Đây là khai báo cột. `col-lg-6` có nghĩa là trên màn hình từ Desktop trở lên, khối nội dung này sẽ chiếm 6/12 phần (tức là 50% chiều rộng). Em dùng hai khối `col-lg-6` để chia màn hình thành 2 nửa bằng nhau."

**[Thao tác]: Cuộn xuống cuối trang chỗ Form Liên Hệ (phần nút bấm), bôi đen `<button class="btn btn-cta btn-lg w-100 w-md-auto">`**
> "Về Utility Class, ở nút bấm này em dùng `w-100` để ép nút bấm dài 100% chiều ngang khi ở trên điện thoại di động giúp người dùng dễ bấm. Tuy nhiên em kết hợp thêm `w-md-auto`, tức là khi lên màn hình máy tính (từ md trở lên), chiều ngang của nút sẽ tự động co lại cho vừa với chữ bên trong."

**[Thao tác]: Bôi đen `<input class="form-control">` và `<div class="invalid-feedback">` (nếu giảng viên hỏi thêm về Form)**
> "Với form nhập liệu, em áp dụng `form-control` để định dạng chuẩn của Bootstrap (có border và hiệu ứng focus). Đi kèm là `invalid-feedback`, class này Bootstrap thiết kế sẵn để ẩn đi, và chỉ hiện ra dòng chữ đỏ cảnh báo khi Form Validation kiểm tra thấy người dùng nhập thiếu hoặc sai."

> "Ngoài ra ở CSS Custom, em tuyệt đối không can thiệp vào các class cấu trúc như `.row` hay `.col` của Bootstrap, mà chỉ tạo các class riêng biệt (như `.shipping-slip`, `.stat-card`) để chỉnh sửa màu sắc, hình dáng đặc thù thôi ạ."
