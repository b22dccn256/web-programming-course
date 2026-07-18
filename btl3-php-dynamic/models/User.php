<?php
/**
 * models/User.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3 khi có bảng `users` trong MySQL
 * và trang login.php/register.php trong public/ được nối vào thật.
 * Dự kiến bảng users: id, ho_ten, email, mat_khau (hash), vai_tro, ngay_tao.
 */

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Tìm user theo email — dùng khi đăng nhập. */
    public function timTheoEmail(string $email): ?array
    {
        // TODO (bài tập 3): SELECT * FROM users WHERE email = ?
        return null;
    }

    /** Đăng ký user mới, mật khẩu cần hash bằng password_hash() trước khi lưu. */
    public function dangKy(array $data): bool
    {
        // TODO (bài tập 3): INSERT INTO users (...) VALUES (...)
        // Nhớ dùng password_hash($data['mat_khau'], PASSWORD_DEFAULT)
        return false;
    }

    /** Kiểm tra mật khẩu đăng nhập có đúng không. */
    public function kiemTraDangNhap(string $email, string $matKhau): ?array
    {
        // TODO (bài tập 3): lấy user theo email, rồi password_verify($matKhau, $user['mat_khau'])
        return null;
    }
}
