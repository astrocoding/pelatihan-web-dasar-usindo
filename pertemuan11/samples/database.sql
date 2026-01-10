-- ========================================
-- REFERENSI BELAJAR SQL (MySQL/MariaDB)
-- Database: inventaris_db
-- ========================================

-- ========================================
-- BAGIAN 1: DDL (Data Definition Language)
-- ========================================
-- DDL digunakan untuk mendefinisikan struktur database, tabel, dan objek database lainnya

-- 1.1 CREATE DATABASE
-- Membuat database baru
CREATE DATABASE IF NOT EXISTS inventaris_db;

-- Menggunakan database yang telah dibuat
USE inventaris_db;

-- 1.2 CREATE TABLE
-- Membuat tabel items (tabel utama untuk menyimpan data barang)
CREATE TABLE IF NOT EXISTS items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    lokasi VARCHAR(100) NOT NULL,
    jumlah INT(11) NOT NULL,
    kondisi VARCHAR(20) NOT NULL,
    tanggal_masuk DATE NOT NULL
);

-- Membuat tabel transactions (tabel untuk mencatat transaksi keluar/masuk barang)
-- Tabel ini berelasi dengan tabel items melalui foreign key
CREATE TABLE IF NOT EXISTS transactions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_id INT(11) NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT(11) NOT NULL,
    tanggal_transaksi DATE NOT NULL,
    keterangan TEXT,
    penanggung_jawab VARCHAR(100) NOT NULL,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- 1.3 ALTER TABLE
-- Menambahkan kolom baru ke tabel items
ALTER TABLE items ADD COLUMN harga_satuan DECIMAL(10,2) DEFAULT 0;

-- Menambahkan index untuk meningkatkan performa pencarian
ALTER TABLE items ADD INDEX idx_kode_barang (kode_barang);
ALTER TABLE items ADD INDEX idx_kategori (kategori);

-- Mengubah tipe data kolom
-- ALTER TABLE items MODIFY COLUMN kondisi VARCHAR(30);

-- Menghapus kolom (contoh, jangan jalankan jika tidak perlu)
-- ALTER TABLE items DROP COLUMN harga_satuan;

-- 1.4 DROP TABLE
-- Menghapus tabel (HATI-HATI: Data akan hilang permanen)
-- DROP TABLE IF EXISTS transactions;
-- DROP TABLE IF EXISTS items;

-- 1.5 TRUNCATE TABLE
-- Mengosongkan isi tabel tanpa menghapus strukturnya
-- TRUNCATE TABLE transactions;


-- ========================================
-- BAGIAN 2: DML (Data Manipulation Language)
-- ========================================
-- DML digunakan untuk memanipulasi data dalam tabel

-- 2.1 INSERT - Menambahkan data baru
-- Insert single row (1 baris data)
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk, harga_satuan)
VALUES ('BRG001', 'Laptop Dell Latitude', 'Elektronik', 'Ruang IT', 5, 'Baik', '2026-01-01', 8500000);

-- Insert multiple rows (beberapa baris sekaligus)
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk, harga_satuan)
VALUES 
    ('BRG002', 'Meja Kantor', 'Furniture', 'Ruang Staff', 10, 'Baik', '2026-01-02', 1500000),
    ('BRG003', 'Kursi Ergonomis', 'Furniture', 'Ruang Staff', 15, 'Baik', '2026-01-02', 850000),
    ('BRG004', 'Proyektor Epson', 'Elektronik', 'Ruang Meeting', 3, 'Baik', '2026-01-03', 6500000),
    ('BRG005', 'Printer HP LaserJet', 'Elektronik', 'Ruang Admin', 4, 'Baik', '2026-01-04', 3200000),
    ('BRG006', 'AC 1.5 PK', 'Elektronik', 'Ruang Meeting', 6, 'Baik', '2026-01-05', 4500000),
    ('BRG007', 'Lemari Arsip', 'Furniture', 'Ruang Admin', 8, 'Baik', '2026-01-06', 2100000),
    ('BRG008', 'Whiteboard', 'Perlengkapan', 'Ruang Meeting', 4, 'Baik', '2026-01-07', 750000);

-- Insert data transactions
INSERT INTO transactions (item_id, jenis_transaksi, jumlah, tanggal_transaksi, keterangan, penanggung_jawab)
VALUES 
    (1, 'masuk', 5, '2026-01-01', 'Pembelian laptop baru untuk tim IT', 'Budi Santoso'),
    (1, 'keluar', 2, '2026-01-08', 'Distribusi laptop ke cabang Jakarta', 'Siti Aminah'),
    (4, 'keluar', 1, '2026-01-09', 'Peminjaman proyektor untuk seminar', 'Ahmad Fauzi'),
    (5, 'masuk', 2, '2026-01-10', 'Penambahan printer untuk staff baru', 'Dewi Lestari');

-- 2.2 SELECT - Mengambil/membaca data
-- Select semua data
SELECT * FROM items;

-- Select kolom tertentu
SELECT kode_barang, nama_barang, jumlah FROM items;

-- Select dengan WHERE (kondisi)
SELECT * FROM items WHERE kategori = 'Elektronik';

-- Select dengan operator perbandingan
SELECT * FROM items WHERE jumlah > 5;
SELECT * FROM items WHERE jumlah >= 5 AND jumlah <= 10;
SELECT * FROM items WHERE kategori IN ('Elektronik', 'Furniture');

-- Select dengan LIKE (pencarian pattern)
SELECT * FROM items WHERE nama_barang LIKE '%Laptop%';
SELECT * FROM items WHERE kode_barang LIKE 'BRG00%';

-- Select dengan ORDER BY (pengurutan)
SELECT * FROM items ORDER BY nama_barang ASC;  -- Ascending (A-Z)
SELECT * FROM items ORDER BY jumlah DESC;       -- Descending (besar ke kecil)

-- Select dengan LIMIT (membatasi hasil)
SELECT * FROM items LIMIT 5;                    -- 5 data pertama
SELECT * FROM items LIMIT 3, 5;                 -- Skip 3 data, ambil 5 data berikutnya

-- Select dengan fungsi agregat
SELECT COUNT(*) AS total_items FROM items;                           -- Menghitung jumlah baris
SELECT SUM(jumlah) AS total_barang FROM items;                      -- Menjumlahkan
SELECT AVG(harga_satuan) AS rata_rata_harga FROM items;             -- Rata-rata
SELECT MAX(harga_satuan) AS harga_tertinggi FROM items;             -- Nilai maksimum
SELECT MIN(harga_satuan) AS harga_terendah FROM items;              -- Nilai minimum

-- Select dengan GROUP BY
SELECT kategori, COUNT(*) AS jumlah_jenis 
FROM items 
GROUP BY kategori;

SELECT lokasi, SUM(jumlah) AS total_barang 
FROM items 
GROUP BY lokasi;

-- Select dengan HAVING (filter setelah GROUP BY)
SELECT kategori, COUNT(*) AS jumlah_jenis 
FROM items 
GROUP BY kategori 
HAVING COUNT(*) > 2;

-- 2.3 UPDATE - Mengubah data yang sudah ada
-- Update single row
UPDATE items 
SET jumlah = 3 
WHERE id = 1;

-- Update dengan kondisi
UPDATE items 
SET kondisi = 'Perlu Perbaikan' 
WHERE kode_barang = 'BRG004';

-- Update multiple columns
UPDATE items 
SET jumlah = 12, lokasi = 'Ruang Manager' 
WHERE id = 7;

-- Update dengan kalkulasi
UPDATE items 
SET jumlah = jumlah + 5 
WHERE kategori = 'Furniture';

-- PERINGATAN: Update tanpa WHERE akan mengubah SEMUA data
-- UPDATE items SET kondisi = 'Baik';  -- Hati-hati!

-- 2.4 DELETE - Menghapus data
-- Delete single row
DELETE FROM items WHERE id = 8;

-- Delete dengan kondisi
DELETE FROM items WHERE jumlah = 0;

-- PERINGATAN: Delete tanpa WHERE akan menghapus SEMUA data
-- DELETE FROM items;  -- Hati-hati!


-- ========================================
-- BAGIAN 3: JOIN OPERATIONS
-- ========================================
-- JOIN digunakan untuk menggabungkan data dari dua atau lebih tabel

-- 3.1 INNER JOIN
-- Menampilkan data yang ada di KEDUA tabel (irisan)
SELECT 
    t.id AS transaksi_id,
    t.jenis_transaksi,
    t.jumlah AS jumlah_transaksi,
    t.tanggal_transaksi,
    t.penanggung_jawab,
    i.kode_barang,
    i.nama_barang,
    i.kategori
FROM transactions t
INNER JOIN items i ON t.item_id = i.id;

-- 3.2 LEFT JOIN (LEFT OUTER JOIN)
-- Menampilkan SEMUA data dari tabel kiri, dan data yang match dari tabel kanan
SELECT 
    i.id,
    i.kode_barang,
    i.nama_barang,
    i.jumlah AS stok_sekarang,
    t.jenis_transaksi,
    t.jumlah AS jumlah_transaksi,
    t.tanggal_transaksi
FROM items i
LEFT JOIN transactions t ON i.id = t.item_id;

-- 3.3 RIGHT JOIN (RIGHT OUTER JOIN)
-- Menampilkan SEMUA data dari tabel kanan, dan data yang match dari tabel kiri
SELECT 
    i.kode_barang,
    i.nama_barang,
    t.jenis_transaksi,
    t.jumlah,
    t.tanggal_transaksi,
    t.penanggung_jawab
FROM items i
RIGHT JOIN transactions t ON i.id = t.item_id;

-- 3.4 CROSS JOIN
-- Menghasilkan kombinasi semua baris dari kedua tabel (Cartesian Product)
-- HATI-HATI: Menghasilkan banyak data jika tabel besar
-- SELECT i.nama_barang, t.jenis_transaksi 
-- FROM items i 
-- CROSS JOIN transactions t;

-- 3.5 SELF JOIN
-- Join tabel dengan dirinya sendiri (berguna untuk perbandingan dalam satu tabel)
-- Contoh: Mencari barang dengan kategori yang sama
SELECT 
    i1.nama_barang AS barang_1,
    i2.nama_barang AS barang_2,
    i1.kategori
FROM items i1
INNER JOIN items i2 ON i1.kategori = i2.kategori AND i1.id < i2.id
ORDER BY i1.kategori;


-- ========================================
-- BAGIAN 4: QUERY LANJUTAN (SUBQUERY & ADVANCED)
-- ========================================

-- 4.1 SUBQUERY dalam WHERE
-- Mencari barang yang memiliki transaksi
SELECT * FROM items 
WHERE id IN (SELECT DISTINCT item_id FROM transactions);

-- Mencari barang yang belum pernah ada transaksi
SELECT * FROM items 
WHERE id NOT IN (SELECT DISTINCT item_id FROM transactions);

-- 4.2 SUBQUERY dengan EXISTS
SELECT i.* FROM items i
WHERE EXISTS (
    SELECT 1 FROM transactions t 
    WHERE t.item_id = i.id AND t.jenis_transaksi = 'keluar'
);

-- 4.3 SUBQUERY dalam SELECT
SELECT 
    i.*,
    (SELECT COUNT(*) FROM transactions t WHERE t.item_id = i.id) AS total_transaksi,
    (SELECT SUM(CASE WHEN jenis_transaksi = 'masuk' THEN jumlah ELSE 0 END) 
     FROM transactions t WHERE t.item_id = i.id) AS total_masuk,
    (SELECT SUM(CASE WHEN jenis_transaksi = 'keluar' THEN jumlah ELSE 0 END) 
     FROM transactions t WHERE t.item_id = i.id) AS total_keluar
FROM items i;

-- 4.4 CASE Statement
SELECT 
    nama_barang,
    jumlah,
    CASE 
        WHEN jumlah > 10 THEN 'Stok Aman'
        WHEN jumlah BETWEEN 5 AND 10 THEN 'Stok Cukup'
        ELSE 'Stok Menipis'
    END AS status_stok
FROM items;

-- 4.5 UNION
-- Menggabungkan hasil dari dua query
SELECT kode_barang, nama_barang, 'Elektronik' AS sumber FROM items WHERE kategori = 'Elektronik'
UNION
SELECT kode_barang, nama_barang, 'Furniture' AS sumber FROM items WHERE kategori = 'Furniture';


-- ========================================
-- BAGIAN 5: VIEW (Virtual Table)
-- ========================================

-- Membuat VIEW untuk laporan ringkasan
CREATE OR REPLACE VIEW view_laporan_barang AS
SELECT 
    i.id,
    i.kode_barang,
    i.nama_barang,
    i.kategori,
    i.lokasi,
    i.jumlah AS stok_sekarang,
    i.kondisi,
    i.harga_satuan,
    COUNT(t.id) AS total_transaksi,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'masuk' THEN t.jumlah ELSE 0 END), 0) AS total_masuk,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'keluar' THEN t.jumlah ELSE 0 END), 0) AS total_keluar
FROM items i
LEFT JOIN transaksi t ON i.id = t.item_id
GROUP BY i.id;

-- Menggunakan VIEW
SELECT * FROM view_laporan_barang;
SELECT * FROM view_laporan_barang WHERE kategori = 'Elektronik';

-- Menghapus VIEW
-- DROP VIEW IF EXISTS view_laporan_barang;


-- ========================================
-- BAGIAN 6: TRANSACTION (ACID Properties)
-- ========================================

-- Memulai transaksi
START TRANSACTION;

-- Melakukan operasi
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk, harga_satuan)
VALUES ('BRG009', 'Scanner', 'Elektronik', 'Ruang Admin', 2, 'Baik', '2026-01-11', 2500000);

-- Jika semua operasi berhasil, commit untuk menyimpan perubahan
COMMIT;

-- Jika terjadi error, rollback untuk membatalkan semua perubahan
-- ROLLBACK;


-- ========================================
-- BAGIAN 7: CONTOH QUERY CRUD LENGKAP
-- ========================================

-- CREATE: Menambah barang baru
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk, harga_satuan)
VALUES ('BRG010', 'Mouse Wireless', 'Elektronik', 'Ruang IT', 20, 'Baik', CURDATE(), 125000);

-- READ: Membaca data barang
-- Semua barang
SELECT * FROM items;

-- Barang tertentu berdasarkan ID
SELECT * FROM items WHERE id = 1;

-- Barang dengan filter
SELECT * FROM items WHERE kategori = 'Elektronik' AND jumlah > 3;

-- UPDATE: Mengubah data barang
UPDATE items 
SET jumlah = 18, kondisi = 'Baik' 
WHERE kode_barang = 'BRG010';

-- DELETE: Menghapus data barang
-- DELETE FROM items WHERE id = 10;


-- ========================================
-- BAGIAN 8: QUERY REPORTING & ANALYSIS
-- ========================================

-- Laporan barang per kategori
SELECT 
    kategori,
    COUNT(*) AS jumlah_jenis_barang,
    SUM(jumlah) AS total_unit,
    AVG(harga_satuan) AS rata_rata_harga,
    SUM(jumlah * harga_satuan) AS nilai_total
FROM items
GROUP BY kategori
ORDER BY nilai_total DESC;

-- Laporan transaksi bulanan
SELECT 
    DATE_FORMAT(tanggal_transaksi, '%Y-%m') AS bulan,
    jenis_transaksi,
    COUNT(*) AS jumlah_transaksi,
    SUM(jumlah) AS total_unit
FROM transactions
GROUP BY DATE_FORMAT(tanggal_transaksi, '%Y-%m'), jenis_transaksi
ORDER BY bulan DESC, jenis_transaksi;

-- Laporan barang dengan stok menipis
SELECT 
    kode_barang,
    nama_barang,
    kategori,
    jumlah,
    lokasi
FROM items
WHERE jumlah < 5
ORDER BY jumlah ASC;

-- Laporan aktivitas transaksi per barang
SELECT 
    i.kode_barang,
    i.nama_barang,
    i.kategori,
    COUNT(t.id) AS total_transaksi,
    SUM(CASE WHEN t.jenis_transaksi = 'masuk' THEN t.jumlah ELSE 0 END) AS total_masuk,
    SUM(CASE WHEN t.jenis_transaksi = 'keluar' THEN t.jumlah ELSE 0 END) AS total_keluar,
    i.jumlah AS stok_akhir
FROM items i
LEFT JOIN transactions t ON i.id = t.item_id
GROUP BY i.id
ORDER BY total_transaksi DESC;


-- ========================================
-- BAGIAN 9: INDEX & OPTIMIZATION
-- ========================================

-- Melihat index yang ada
SHOW INDEX FROM items;
SHOW INDEX FROM transactions;

-- Membuat index untuk mempercepat query
CREATE INDEX idx_nama_barang ON items(nama_barang);
CREATE INDEX idx_tanggal_transaksi ON transactions(tanggal_transaksi);

-- Composite index (index gabungan)
CREATE INDEX idx_kategori_lokasi ON items(kategori, lokasi);

-- Menghapus index
-- DROP INDEX idx_nama_barang ON items;

-- Menganalisa query execution plan
EXPLAIN SELECT * FROM items WHERE kategori = 'Elektronik';
EXPLAIN SELECT * FROM transactions t INNER JOIN items i ON t.item_id = i.id;


-- ========================================
-- CATATAN PENTING
-- ========================================
-- 1. Selalu backup database sebelum operasi besar
-- 2. Gunakan WHERE pada UPDATE dan DELETE untuk menghindari perubahan massal
-- 3. Gunakan TRANSACTION untuk operasi yang kompleks
-- 4. Buat INDEX pada kolom yang sering digunakan untuk pencarian
-- 5. Normalisasi tabel untuk menghindari redundansi data
-- 6. Gunakan FOREIGN KEY untuk menjaga integritas referensial
-- 7. Gunakan prepared statements untuk keamanan (mencegah SQL Injection)

-- ========================================
-- SELESAI
-- ========================================
