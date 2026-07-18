<?php
/**
 * models/Product.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3 khi có bảng `products` trong MySQL.
 * Dự kiến bảng products: id, ten_san_pham, gia, ton_kho, hinh_anh, mo_ta.
 */

class Product
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Lấy danh sách sản phẩm. */
    public function layDanhSach(): array
    {
        // TODO (bài tập 3): SELECT * FROM products ORDER BY ten_san_pham ASC
        return [];
    }

    /** Lấy chi tiết 1 sản phẩm theo id. */
    public function layTheoId(int $id): ?array
    {
        // TODO (bài tập 3): SELECT * FROM products WHERE id = ?
        return null;
    }

    /** Thêm sản phẩm mới. */
    public function themMoi(array $data): bool
    {
        // TODO (bài tập 3): INSERT INTO products (...) VALUES (...)
        return false;
    }

    /** Cập nhật thông tin sản phẩm. */
    public function capNhat(int $id, array $data): bool
    {
        // TODO (bài tập 3): UPDATE products SET ... WHERE id = ?
        return false;
    }

    /** Xoá sản phẩm. */
    public function xoa(int $id): bool
    {
        // TODO (bài tập 3): DELETE FROM products WHERE id = ?
        return false;
    }
}
