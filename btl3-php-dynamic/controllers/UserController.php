<?php
/**
 * controllers/UserController.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3, dùng ở public/login.php
 * và public/register.php để xử lý đăng nhập/đăng ký qua models/User.php.
 */

require_once BASE_PATH . '/models/User.php';

class UserController
{
    private User $userModel;

    public function __construct(PDO $pdo)
    {
        $this->userModel = new User($pdo);
    }

    /** Xử lý đăng nhập (public/login.php sẽ gọi hàm này khi submit form). */
    public function dangNhap(string $email, string $matKhau): ?array
    {
        // TODO (bài tập 3)
        return $this->userModel->kiemTraDangNhap($email, $matKhau);
    }

    /** Xử lý đăng ký tài khoản mới (public/register.php sẽ gọi hàm này). */
    public function dangKy(array $data): bool
    {
        // TODO (bài tập 3)
        return $this->userModel->dangKy($data);
    }
}
