-- =====================================================================
-- DATABASE SPK CIKA MULIA MULTIMEDIA
-- Sistem Pendukung Keputusan Pengelompokan Wilayah Pengiriman
-- Metode: TOPSIS
-- Versi: 2.0
-- =====================================================================

DROP DATABASE IF EXISTS spk_cika;
CREATE DATABASE spk_cika CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE spk_cika;

-- =====================================================================
-- 1. TABEL USERS (LOGIN)
-- =====================================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    role ENUM('admin','staff') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', MD5('admin123'), 'Administrator', 'admin'),
('staff', MD5('staff123'), 'Staff Operator', 'staff');

-- =====================================================================
-- 2. TABEL PENGATURAN (IDENTITAS APLIKASI)
-- =====================================================================
CREATE TABLE pengaturan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(50) UNIQUE,
    `value` TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO pengaturan (`key`, `value`) VALUES
('nama_perusahaan', 'PT Cika Mulia Multimedia'),
('nama_pendek', 'SPK Cika'),
('deskripsi', 'Sistem Pendukung Keputusan Pengelompokan Wilayah Pengiriman Voucher'),
('versi', 'v2.0');

-- =====================================================================
-- 3. TABEL PELANGGAN
-- =====================================================================
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_pelanggan VARCHAR(20) UNIQUE,
    nama_pelanggan VARCHAR(100) NOT NULL,
    alamat TEXT,
    kota VARCHAR(50),
    provinsi VARCHAR(50),
    no_telp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pelanggan (kode_pelanggan, nama_pelanggan, alamat, kota, provinsi, no_telp) VALUES
('PLG001', 'PT Cika Mulia Multimedia', 'Jl. Merdeka No. 10', 'Jakarta', 'DKI Jakarta', '021-1234567'),
('PLG002', 'Toko Berkah Jaya', 'Jl. Sudirman No. 22', 'Bandung', 'Jawa Barat', '022-7654321'),
('PLG003', 'CV Sinar Abadi', 'Jl. Diponegoro No. 5', 'Surabaya', 'Jawa Timur', '031-9988776'),
('PLG004', 'UD Makmur Sentosa', 'Jl. Gajah Mada No. 8', 'Medan', 'Sumatera Utara', '061-4433221'),
('PLG005', 'PT Nusantara Digital', 'Jl. Ahmad Yani No. 15', 'Semarang', 'Jawa Tengah', '024-5566778');

-- =====================================================================
-- 4. TABEL WILAYAH
-- =====================================================================
CREATE TABLE wilayah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_wilayah VARCHAR(20) UNIQUE,
    nama_wilayah VARCHAR(100) NOT NULL,
    kota VARCHAR(50),
    provinsi VARCHAR(50),
    zona ENUM('Zona A (Prioritas)','Zona B (Menengah)','Zona C (Reguler)') DEFAULT 'Zona C (Reguler)',
    estimasi_hari INT DEFAULT 3,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO wilayah (kode_wilayah, nama_wilayah, kota, provinsi, zona, estimasi_hari, keterangan) VALUES
('WIL001', 'Jakarta Pusat', 'Jakarta', 'DKI Jakarta', 'Zona A (Prioritas)', 1, 'Wilayah pengiriman utama'),
('WIL002', 'Bandung Kota', 'Bandung', 'Jawa Barat', 'Zona B (Menengah)', 3, 'Wilayah sekunder'),
('WIL003', 'Surabaya Timur', 'Surabaya', 'Jawa Timur', 'Zona A (Prioritas)', 1, 'Wilayah padat'),
('WIL004', 'Medan Kota', 'Medan', 'Sumatera Utara', 'Zona C (Reguler)', 5, 'Wilayah jauh'),
('WIL005', 'Semarang Tengah', 'Semarang', 'Jawa Tengah', 'Zona B (Menengah)', 3, 'Wilayah reguler');

-- =====================================================================
-- 5. TABEL KATEGORI JASA KIRIM
-- =====================================================================
CREATE TABLE kategori_kirim (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL,
    estimasi_hari INT,
    biaya_per_kg DECIMAL(10,2),
    keterangan TEXT
);

INSERT INTO kategori_kirim (nama_kategori, estimasi_hari, biaya_per_kg, keterangan) VALUES
('Reguler', 5, 15000, 'Pengiriman standar ekonomi'),
('Express', 2, 30000, 'Pengiriman cepat 1-2 hari'),
('Kargo', 7, 8000, 'Pengiriman barang besar/berat'),
('Same Day', 1, 50000, 'Pengiriman di hari yang sama'),
('Ekonomi', 10, 5000, 'Pengiriman paling murah');

-- =====================================================================
-- 6. TABEL VOUCHER FISIK
-- =====================================================================
CREATE TABLE voucher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_voucher VARCHAR(30) UNIQUE,
    nama_voucher VARCHAR(100) NOT NULL,
    jenis_voucher VARCHAR(50),
    pelanggan_id INT,
    kategori_kirim_id INT,
    jumlah INT DEFAULT 1,
    berat_total DECIMAL(8,2) DEFAULT 1,
    tanggal_pesan DATE,
    status ENUM('pending','dikirim','selesai') DEFAULT 'pending',
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_kirim_id) REFERENCES kategori_kirim(id) ON DELETE SET NULL
);

INSERT INTO voucher (kode_voucher, nama_voucher, jenis_voucher, pelanggan_id, kategori_kirim_id, jumlah, berat_total, tanggal_pesan) VALUES
('VCR001', 'Voucher Fisik 50K', 'Voucher Belanja', 1, 2, 100, 5.0, '2025-01-10'),
('VCR002', 'Voucher Fisik 100K', 'Voucher Belanja', 2, 1, 200, 10.0, '2025-01-11'),
('VCR003', 'Voucher Fisik 25K', 'Voucher Diskon', 3, 3, 150, 8.0, '2025-01-12'),
('VCR004', 'Voucher Fisik 200K', 'Voucher Belanja', 4, 4, 50, 3.0, '2025-01-13'),
('VCR005', 'Voucher Fisik 75K', 'Voucher Diskon', 5, 5, 300, 15.0, '2025-01-14');

-- =====================================================================
-- 7. TABEL KRITERIA (BOBOT TOPSIS)
-- =====================================================================
CREATE TABLE kriteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) UNIQUE,
    nama_kriteria VARCHAR(50) NOT NULL,
    bobot DECIMAL(5,3),
    tipe ENUM('benefit','cost')
);

INSERT INTO kriteria (kode, nama_kriteria, bobot, tipe) VALUES
('C1', 'Jarak Tempuh (km)', 0.25, 'cost'),
('C2', 'Biaya Kirim (Rp)', 0.20, 'cost'),
('C3', 'Estimasi Waktu (hari)', 0.20, 'cost'),
('C4', 'Jumlah Voucher', 0.20, 'benefit'),
('C5', 'Kapasitas Gudang', 0.15, 'benefit');

-- =====================================================================
-- 8. TABEL PENILAIAN (MATRIKS KEPUTUSAN)
-- =====================================================================
CREATE TABLE penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT,
    kriteria_id INT,
    nilai DECIMAL(10,2),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE
);

INSERT INTO penilaian (pelanggan_id, kriteria_id, nilai) VALUES
-- Pelanggan 1 (PT Cika Mulia Multimedia - Jakarta)
(1,1,120),(1,2,450000),(1,3,2),(1,4,100),(1,5,80),
-- Pelanggan 2 (Toko Berkah Jaya - Bandung)
(2,1,200),(2,2,300000),(2,3,5),(2,4,200),(2,5,70),
-- Pelanggan 3 (CV Sinar Abadi - Surabaya)
(3,1,350),(3,2,800000),(3,3,7),(3,4,150),(3,5,90),
-- Pelanggan 4 (UD Makmur Sentosa - Medan)
(4,1,500),(4,2,250000),(4,3,1),(4,4,50),(4,5,60),
-- Pelanggan 5 (PT Nusantara Digital - Semarang)
(5,1,280),(5,2,180000),(5,3,10),(5,4,300),(5,5,75);

-- =====================================================================
-- 9. TABEL HASIL PENGELOMPOKAN (OUTPUT TOPSIS)
-- =====================================================================
CREATE TABLE hasil_pengelompokan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT,
    zona ENUM('Zona A (Prioritas)','Zona B (Menengah)','Zona C (Reguler)'),
    skor_topsis DECIMAL(10,6),
    ranking INT,
    tanggal_proses DATE,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE
);

-- =====================================================================
-- SELESAI! Database siap digunakan.
-- Login default:
--   Username: admin   | Password: admin123
--   Username: staff   | Password: staff123
-- =====================================================================