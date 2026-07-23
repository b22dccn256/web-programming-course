-- ============================================================
-- SCHEMA: Hệ thống Quản lý Đơn hàng (Bài tập 3)
-- Database: MySQL (>= 8.0, cần bản >= 8.0.16 để CHECK constraint có hiệu lực)
-- Chạy file này bằng: mysql -u <user> -p <ten_database> < schema.sql
-- ============================================================

-- Xóa bảng cũ nếu tồn tại (theo đúng thứ tự phụ thuộc) để có thể
-- chạy lại file này nhiều lần khi cần làm mới CSDL lúc code/test.
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS customers;

-- ------------------------------------------------------------
-- Bảng KHÁCH HÀNG
-- AUTO_INCREMENT thay cho SERIAL của PostgreSQL.
-- ------------------------------------------------------------
CREATE TABLE customers (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(150) NOT NULL,
    email      VARCHAR(150) UNIQUE,
    phone      VARCHAR(20),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Bảng SẢN PHẨM
-- stock_quantity: số lượng tồn kho, sẽ bị trừ mỗi khi có đơn hàng mới
-- ------------------------------------------------------------
CREATE TABLE products (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(200) NOT NULL,
    price          DECIMAL(12,2) NOT NULL CHECK (price >= 0),
    stock_quantity INT NOT NULL DEFAULT 0 CHECK (stock_quantity >= 0),
    created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Bảng ĐƠN HÀNG
-- Quan hệ 1-N với customers: 1 khách hàng có nhiều đơn hàng.
-- ON DELETE RESTRICT: không cho xóa khách hàng nếu còn đơn hàng,
-- để không làm mất lịch sử mua hàng.
-- Lưu ý: FOREIGN KEY (thay vì REFERENCES ngắn gọn như Postgres)
-- là cú pháp bắt buộc phải khai báo tường minh trong MySQL.
-- ------------------------------------------------------------
CREATE TABLE orders (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    customer_id  INT NOT NULL,
    order_date   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    -- CHECK đảm bảo status luôn nằm trong 5 trạng thái hợp lệ
    status       VARCHAR(20) NOT NULL DEFAULT 'pending'
                 CHECK (status IN ('pending','processing','shipped','delivered','cancelled')),
    created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id)
        REFERENCES customers(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Bảng CHI TIẾT ĐƠN HÀNG (bảng trung gian order <-> product)
-- Quan hệ 1-N với orders, N-1 với products.
-- ON DELETE CASCADE trên order_id: xóa đơn hàng thì tự xóa luôn
-- các dòng chi tiết liên quan (không cần code PHP xóa tay).
-- price ở đây là giá SNAPSHOT tại thời điểm đặt hàng, KHÔNG lấy
-- trực tiếp từ products.price, để lịch sử đơn hàng cũ không bị
-- sai lệch nếu sau này giá sản phẩm thay đổi.
-- ------------------------------------------------------------
CREATE TABLE order_items (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL CHECK (quantity > 0),
    price      DECIMAL(12,2) NOT NULL,
    CONSTRAINT fk_items_order FOREIGN KEY (order_id)
        REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_items_product FOREIGN KEY (product_id)
        REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Index phụ trợ cho tìm kiếm/lọc nhanh hơn khi dữ liệu lớn dần
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_customer ON orders(customer_id);
CREATE INDEX idx_order_items_order ON order_items(order_id);
