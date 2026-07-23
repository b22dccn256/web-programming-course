<?php
/**
 * models/Customer.php
 * ---------------------------------------------------------
 * Model đơn giản cho bảng `customers`. Bài tập 3 chỉ cần ĐỌC
 * danh sách khách hàng để hiển thị dropdown trong form tạo
 * đơn hàng, nên mình chỉ viết 2 hàm cần thiết, không làm
 * thêm CRUD thừa cho phần này (đúng tinh thần "đơn giản").
 * ---------------------------------------------------------
 */
class Customer
{
    /** Lấy toàn bộ khách hàng, sắp xếp theo tên */
    public static function getAll(): array
    {
        $pdo = getDB();
        $stmt = $pdo->query('SELECT id, name, email, phone FROM customers ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    /** Lấy 1 khách hàng theo id (dùng khi xem chi tiết đơn hàng) */
    public static function getById(int $id): ?array
    {
        $pdo = getDB();
        // Dùng Prepared Statement (dấu ?) để chống SQL Injection
        $stmt = $pdo->prepare('SELECT id, name, email, phone FROM customers WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
