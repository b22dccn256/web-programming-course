<?php
/**
 * config/database.php
 * ---------------------------------------------------------
 * Khai báo thông tin kết nối CSDL và hàm getDB() để lấy về
 * một đối tượng PDO dùng chung cho toàn bộ ứng dụng.
 *
 * Vì đây là bài tập đơn giản, mình khai báo thẳng hằng số ở
 * đây thay vì dùng file .env. LƯU Ý: nếu đưa code lên Git
 * public thật, không nên để mật khẩu thật ở đây.
 * ---------------------------------------------------------
 */

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'btl3_order_management'); // đổi tên DB theo máy bạn nếu cần
define('DB_USER', 'root');                  // đổi user theo máy bạn
define('DB_PASS', '1111');                      // đổi password theo máy bạn

/**
 * Trả về 1 kết nối PDO duy nhất (static) để không phải mở
 * kết nối mới mỗi lần gọi hàm này trong cùng 1 request.
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        // charset=utf8mb4: bắt buộc để lưu/hiển thị tiếng Việt có dấu đúng
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                // Bắt lỗi bằng Exception thay vì lỗi âm thầm -> dễ debug
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Trả kết quả dạng mảng kết hợp (associative array)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            // Không lộ chi tiết lỗi kết nối ra ngoài (bảo mật),
            // chỉ ghi ra để debug lúc code.
            die('Kết nối CSDL thất bại: ' . $e->getMessage());
        }
    }

    return $pdo;
}
