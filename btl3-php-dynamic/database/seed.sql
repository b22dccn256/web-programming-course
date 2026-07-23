-- ============================================================
-- SEED DATA: Dữ liệu mẫu để test nhanh sau khi tạo schema
-- Chạy: psql -U <user> -d <ten_database> -f seed.sql
-- ============================================================

INSERT INTO customers (name, email, phone) VALUES
('Nguyễn Văn An', 'an.nguyen@example.com', '0901234567'),
('Trần Thị Bình', 'binh.tran@example.com', '0912345678'),
('Lê Hoàng Cường', 'cuong.le@example.com', '0987654321');

INSERT INTO products (name, price, stock_quantity) VALUES
('Bàn phím cơ AKKO', 890000, 25),
('Chuột không dây Logitech', 450000, 40),
('Tai nghe Bluetooth Sony', 1250000, 15),
('Màn hình LCD 24 inch', 3200000, 10),
('Bàn di chuột Gaming', 150000, 60);
