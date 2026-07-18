<?php
/**
 * controllers/ProductController.php
 *
 * PLACEHOLDER — sẽ hiện thực ở bài tập 3, dùng ở admin/products.php
 * để quản lý sản phẩm thông qua models/Product.php.
 */

require_once BASE_PATH . '/models/Product.php';

class ProductController
{
    private Product $productModel;

    public function __construct(PDO $pdo)
    {
        $this->productModel = new Product($pdo);
    }

    public function danhSach(): array
    {
        // TODO (bài tập 3)
        return $this->productModel->layDanhSach();
    }

    public function chiTiet(int $id): ?array
    {
        // TODO (bài tập 3)
        return $this->productModel->layTheoId($id);
    }

    public function themMoi(array $data): bool
    {
        // TODO (bài tập 3)
        return $this->productModel->themMoi($data);
    }

    public function capNhat(int $id, array $data): bool
    {
        // TODO (bài tập 3)
        return $this->productModel->capNhat($id, $data);
    }

    public function xoa(int $id): bool
    {
        // TODO (bài tập 3)
        return $this->productModel->xoa($id);
    }
}
