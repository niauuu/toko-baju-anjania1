-- Tambahkan ke database yang sama (if0_41774282_bintangtiga)

CREATE TABLE IF NOT EXISTS kr_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kr_produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    bahan VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    gambar VARCHAR(255) DEFAULT 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=300&fit=crop',
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kr_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    produk_id INT,
    nama_pembeli VARCHAR(100) NOT NULL,
    nama_produk VARCHAR(150) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    bahan VARCHAR(100),
    harga INT NOT NULL,
    jumlah INT NOT NULL,
    total_harga INT NOT NULL,
    tanggal_transaksi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES kr_users(id) ON DELETE SET NULL,
    FOREIGN KEY (produk_id) REFERENCES kr_produk(id) ON DELETE SET NULL
);

-- Admin default (password: admin123)
INSERT INTO kr_users (nama, email, password, role) VALUES
('Anjania', 'admin@anjania.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Data baju sample
INSERT INTO kr_produk (nama_produk, kategori, bahan, harga, stok, gambar, deskripsi) VALUES
('Kemeja Flanel Premium', 'Kemeja', 'Katun Flanel', 165000, 30, 'https://images.unsplash.com/photo-1588359348347-9bc6cbbb689e?w=400&h=300&fit=crop', 'Kemeja flanel dengan bahan katun tebal dan hangat. Cocok untuk gaya kasual maupun semi formal.'),
('Kaos Oversize Basic', 'Kaos', 'Katun Combed 24s', 95000, 60, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=300&fit=crop', 'Kaos oversize dengan bahan combed lembut dan adem, potongan kekinian untuk gaya sehari-hari.'),
('Celana Chino Slimfit', 'Celana', 'Twill Stretch', 175000, 45, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=400&h=300&fit=crop', 'Celana chino slimfit dengan bahan twill stretch yang nyaman dipakai bergerak seharian.'),
('Jaket Bomber Denim', 'Jaket', 'Denim Premium', 245000, 25, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=300&fit=crop', 'Jaket bomber denim dengan jahitan rapi dan bahan tebal, tampil stylish di segala suasana.'),
('Dress Casual Midi', 'Dress', 'Rayon Premium', 155000, 35, 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&h=300&fit=crop', 'Dress midi casual dengan bahan rayon jatuh sempurna, cocok untuk acara santai maupun jalan-jalan.'),
('Kaos Polo Pique', 'Kaos', 'Cotton Pique', 110000, 50, 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?w=400&h=300&fit=crop', 'Kaos polo dengan bahan pique premium, tampilan rapi cocok untuk kerja maupun santai.'),
('Kemeja Linen Katun', 'Kemeja', 'Linen Katun', 135000, 40, 'https://images.unsplash.com/photo-1620012253295-c15cc3e65df4?w=400&h=300&fit=crop', 'Kemeja linen katun yang ringan dan adem, pilihan tepat untuk cuaca panas.'),
('Celana Jogger Sport', 'Celana', 'Fleece Premium', 115000, 55, 'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=400&h=300&fit=crop', 'Celana jogger fleece yang nyaman dan elastis, ideal untuk aktivitas santai maupun olahraga ringan.');