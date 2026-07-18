<?php
/**
 * config/database.php
 * Kết nối CSDL bằng PDO (MySQL).
 *
 * LƯU Ý: Ở bài tập 2 (landing page tĩnh) file này CHƯA được gọi ở đâu cả,
 * vì chưa có bảng dữ liệu nào. Nó được chuẩn bị sẵn để models/*.php dùng
 * từ bài tập 3 trở đi, khi orders/products/users được chuyển từ mock data
 * sang bảng thật trong MySQL.
 *
 * Cách dùng dự kiến (bài tập 3):
 *   require_once BASE_PATH . '/config/database.php';
 *   $pdo = ketNoiCSDL();
 *   $stmt = $pdo->query('SELECT * FROM orders');
 */

function ketNoiCSDL(): PDO
{
    $host    = 'localhost';
    $dbName  = 'orderflow_db';
    $user    = 'root';
    $pass    = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$host};dbname={$dbName};charset={$charset}";

    $tuyChon = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ném lỗi thay vì âm thầm fail
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // trả về mảng kết hợp
        PDO::ATTR_EMULATE_PREPARES   => false,                  // dùng prepared statement thật, an toàn hơn
    ];

    try {
        return new PDO($dsn, $user, $pass, $tuyChon);
    } catch (PDOException $e) {
        // Ở môi trường học tập, hiện lỗi trực tiếp để dễ debug.
        // Khi triển khai thật, nên ghi log thay vì echo ra màn hình.
        die('Lỗi kết nối CSDL: ' . $e->getMessage());
    }
}
