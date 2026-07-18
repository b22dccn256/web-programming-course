<?php
/**
 * controllers/ContactController.php
 *
 * Controller xử lý form liên hệ ở trang chủ.
 * Đây là controller DUY NHẤT hoạt động thật ở bài tập 2 (các controller
 * còn lại là placeholder cho bài tập 3), vì đây là tính năng duy nhất
 * hiện có xử lý dữ liệu người dùng gửi lên.
 */

require_once BASE_PATH . '/models/Contact.php';

class ContactController
{
    private Contact $contactModel;

    public function __construct()
    {
        $this->contactModel = new Contact();
    }

    /**
     * Xử lý request POST từ form liên hệ.
     * Validate dữ liệu, lưu qua model Contact, rồi redirect về trang chủ
     * (Post/Redirect/Get) kèm trạng thái thành công/lỗi qua session.
     */
    public function xuLy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        $hoTen   = trim($_POST['ho_ten'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $sdt     = trim($_POST['sdt'] ?? '');
        $noiDung = trim($_POST['noi_dung'] ?? '');

        $errors = $this->validate($hoTen, $email, $sdt, $noiDung);

        if (empty($errors)) {
            $daLuu = $this->contactModel->luuLienHe([
                'ho_ten'   => htmlspecialchars($hoTen, ENT_QUOTES, 'UTF-8'),
                'email'    => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
                'sdt'      => htmlspecialchars($sdt, ENT_QUOTES, 'UTF-8'),
                'noi_dung' => htmlspecialchars($noiDung, ENT_QUOTES, 'UTF-8'),
            ]);

            $_SESSION['contact_status'] = $daLuu ? 'success' : 'error';
            if (!$daLuu) {
                $_SESSION['contact_errors'] = ['Không thể lưu dữ liệu, vui lòng thử lại.'];
            }
        } else {
            $_SESSION['contact_status'] = 'error';
            $_SESSION['contact_errors'] = $errors;
            $_SESSION['contact_old'] = [
                'ho_ten' => $hoTen, 'email' => $email, 'sdt' => $sdt, 'noi_dung' => $noiDung,
            ];
        }

        header('Location: index.php#lien-he');
        exit;
    }

    /** Validate dữ liệu form, trả về mảng lỗi (rỗng nếu hợp lệ). */
    private function validate(string $hoTen, string $email, string $sdt, string $noiDung): array
    {
        $errors = [];

        if ($hoTen === '') {
            $errors[] = 'Vui lòng nhập họ tên.';
        }

        if ($email === '') {
            $errors[] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không đúng định dạng.';
        }

        if ($sdt !== '' && !preg_match('/^[0-9+\s]{9,15}$/', $sdt)) {
            $errors[] = 'Số điện thoại không hợp lệ.';
        }

        if ($noiDung === '') {
            $errors[] = 'Vui lòng nhập nội dung cần tư vấn.';
        } elseif (mb_strlen($noiDung) > 1000) {
            $errors[] = 'Nội dung không vượt quá 1000 ký tự.';
        }

        return $errors;
    }
}
