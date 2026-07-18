<?php
/**
 * models/Contact.php
 *
 * Model đại diện cho 1 yêu cầu liên hệ.
 * Hiện tại lưu bằng file JSON (data/contacts.json) vì bài tập 2 chưa có CSDL.
 * Ở bài tập 3, chỉ cần sửa nội dung 2 phương thức luuLienHe()/layTatCa()
 * để dùng PDO (xem config/database.php) thay vì đọc/ghi file — phần
 * gọi model từ ContactController sẽ không cần đổi gì.
 */

class Contact
{
    private string $dataFile;

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/contacts.json';
    }

    /**
     * Lưu 1 yêu cầu liên hệ mới.
     * @param array $data ['ho_ten' => ..., 'email' => ..., 'sdt' => ..., 'noi_dung' => ...]
     */
    public function luuLienHe(array $data): bool
    {
        $danhSach = $this->layTatCa();

        $danhSach[] = [
            'ho_ten'    => $data['ho_ten'],
            'email'     => $data['email'],
            'sdt'       => $data['sdt'],
            'noi_dung'  => $data['noi_dung'],
            'thoi_gian' => date('Y-m-d H:i:s'),
        ];

        if (!is_dir(dirname($this->dataFile))) {
            mkdir(dirname($this->dataFile), 0755, true);
        }

        $ketQua = file_put_contents(
            $this->dataFile,
            json_encode($danhSach, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $ketQua !== false;
    }

    /**
     * Lấy toàn bộ danh sách liên hệ đã lưu (dùng cho trang quản trị sau này).
     */
    public function layTatCa(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }

        $noiDung = file_get_contents($this->dataFile);
        $danhSach = json_decode($noiDung, true);

        return is_array($danhSach) ? $danhSach : [];
    }
}
