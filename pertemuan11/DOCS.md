# Dokumentasi Belajar SQL - Database Inventaris

## Daftar Isi
1. [Pengenalan Database](#pengenalan-database)
2. [DDL - Data Definition Language](#ddl---data-definition-language)
3. [DML - Data Manipulation Language](#dml---data-manipulation-language)
4. [JOIN Operations](#join-operations)
5. [Query Lanjutan](#query-lanjutan)
6. [Normalisasi Database](#normalisasi-database)
7. [Best Practices](#best-practices)

---

## Pengenalan Database

### Apa itu Database?
Database adalah kumpulan data yang terorganisir dan dapat diakses dengan mudah. MySQL/MariaDB adalah sistem manajemen database relasional (RDBMS) yang populer.

### Database: inventaris_db
Database contoh ini mengelola inventaris barang dengan dua tabel utama:
- **items**: Menyimpan data barang inventaris
- **transactions**: Mencatat transaksi keluar/masuk barang

### Struktur Tabel

#### Tabel Items
```sql
CREATE TABLE items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    lokasi VARCHAR(100) NOT NULL,
    jumlah INT(11) NOT NULL,
    kondisi VARCHAR(20) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    harga_satuan DECIMAL(10,2) DEFAULT 0
);
```

**Penjelasan Kolom:**
- `id`: Primary key, auto increment (otomatis bertambah)
- `kode_barang`: Kode unik barang (contoh: BRG001)
- `nama_barang`: Nama lengkap barang
- `kategori`: Jenis kategori (Elektronik, Furniture, dll)
- `lokasi`: Lokasi penyimpanan barang
- `jumlah`: Jumlah stok barang
- `kondisi`: Kondisi barang (Baik, Rusak, dll)
- `tanggal_masuk`: Tanggal barang masuk ke inventaris
- `harga_satuan`: Harga per unit barang

#### Tabel Transactions
```sql
CREATE TABLE transactions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_id INT(11) NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT(11) NOT NULL,
    tanggal_transaksi DATE NOT NULL,
    keterangan TEXT,
    penanggung_jawab VARCHAR(100) NOT NULL,
    FOREIGN KEY (item_id) REFERENCES items(id)
);
```

**Penjelasan Kolom:**
- `id`: Primary key transaksi
- `item_id`: Foreign key ke tabel items
- `jenis_transaksi`: Jenis (masuk/keluar)
- `jumlah`: Jumlah barang dalam transaksi
- `tanggal_transaksi`: Tanggal transaksi dilakukan
- `keterangan`: Catatan tambahan
- `penanggung_jawab`: Nama penanggung jawab transaksi

---

## DDL - Data Definition Language

DDL digunakan untuk mendefinisikan struktur database dan objek-objeknya.

### 1. CREATE DATABASE
Membuat database baru.

```sql
CREATE DATABASE IF NOT EXISTS inventaris_db;
```

**Penjelasan:**
- `IF NOT EXISTS`: Mencegah error jika database sudah ada
- `inventaris_db`: Nama database

### 2. USE DATABASE
Memilih database yang akan digunakan.

```sql
USE inventaris_db;
```

### 3. CREATE TABLE
Membuat tabel baru dengan struktur tertentu.

```sql
CREATE TABLE IF NOT EXISTS items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL
);
```

**Penjelasan:**
- `AUTO_INCREMENT`: Nilai otomatis bertambah
- `PRIMARY KEY`: Identitas unik setiap baris
- `NOT NULL`: Kolom harus diisi
- `VARCHAR(n)`: Tipe data string dengan panjang maksimal n
- `INT(n)`: Tipe data integer
- `DECIMAL(m,n)`: Angka desimal (m total digit, n digit desimal)
- `DATE`: Tipe data tanggal
- `ENUM`: Pilihan nilai tertentu

### 4. FOREIGN KEY
Menghubungkan dua tabel untuk menjaga integritas data.

```sql
FOREIGN KEY (item_id) REFERENCES items(id) 
ON DELETE CASCADE ON UPDATE CASCADE
```

**Penjelasan:**
- `ON DELETE CASCADE`: Jika data di items dihapus, data transaksi terkait ikut terhapus
- `ON UPDATE CASCADE`: Jika id di items berubah, item_id di transaksi ikut berubah

### 5. ALTER TABLE
Mengubah struktur tabel yang sudah ada.

**Menambah Kolom:**
```sql
ALTER TABLE items ADD COLUMN harga_satuan DECIMAL(10,2) DEFAULT 0;
```

**Mengubah Tipe Data:**
```sql
ALTER TABLE items MODIFY COLUMN kondisi VARCHAR(30);
```

**Menghapus Kolom:**
```sql
ALTER TABLE items DROP COLUMN harga_satuan;
```

**Menambah Index:**
```sql
ALTER TABLE items ADD INDEX idx_kode_barang (kode_barang);
```

### 6. DROP TABLE
Menghapus tabel beserta seluruh datanya.

```sql
DROP TABLE IF EXISTS transactions;
```

**PERINGATAN:** Operasi ini tidak dapat dibatalkan (irreversible)!

### 7. TRUNCATE TABLE
Mengosongkan isi tabel, struktur tetap ada.

```sql
TRUNCATE TABLE transactions;
```

**Perbedaan dengan DELETE:**
- TRUNCATE: Lebih cepat, reset AUTO_INCREMENT, tidak bisa dikembalikan
- DELETE: Lebih lambat, AUTO_INCREMENT tetap lanjut, bisa dikembalikan dengan ROLLBACK

---

## DML - Data Manipulation Language

DML digunakan untuk memanipulasi data dalam tabel.

### 1. INSERT - Menambah Data

#### Insert Single Row
```sql
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk)
VALUES ('BRG001', 'Laptop Dell', 'Elektronik', 'Ruang IT', 5, 'Baik', '2026-01-01');
```

#### Insert Multiple Rows
```sql
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk)
VALUES 
    ('BRG002', 'Meja Kantor', 'Furniture', 'Ruang Staff', 10, 'Baik', '2026-01-02'),
    ('BRG003', 'Kursi Ergonomis', 'Furniture', 'Ruang Staff', 15, 'Baik', '2026-01-02');
```

**Tips:**
- Insert multiple rows lebih efisien daripada multiple insert single row
- Pastikan urutan kolom dan values sesuai

### 2. SELECT - Membaca Data

#### Select Semua Data
```sql
SELECT * FROM items;
```

#### Select Kolom Tertentu
```sql
SELECT kode_barang, nama_barang, jumlah FROM items;
```

**Best Practice:** Hindari `SELECT *` di production, sebutkan kolom yang diperlukan.

#### SELECT dengan WHERE
```sql
SELECT * FROM items WHERE kategori = 'Elektronik';
SELECT * FROM items WHERE jumlah > 5;
SELECT * FROM items WHERE jumlah BETWEEN 5 AND 10;
```

**Operator WHERE:**
- `=`: Sama dengan
- `!=` atau `<>`: Tidak sama dengan
- `>`: Lebih besar
- `<`: Lebih kecil
- `>=`: Lebih besar sama dengan
- `<=`: Lebih kecil sama dengan
- `BETWEEN`: Antara dua nilai
- `IN`: Ada dalam list
- `LIKE`: Pattern matching
- `IS NULL`: Nilai null
- `IS NOT NULL`: Nilai tidak null

#### LIKE Pattern Matching
```sql
SELECT * FROM items WHERE nama_barang LIKE '%Laptop%';
SELECT * FROM items WHERE kode_barang LIKE 'BRG00%';
```

**Wildcard:**
- `%`: Menggantikan 0 atau lebih karakter
- `_`: Menggantikan 1 karakter

#### ORDER BY - Pengurutan
```sql
SELECT * FROM items ORDER BY nama_barang ASC;   -- A ke Z
SELECT * FROM items ORDER BY jumlah DESC;        -- Besar ke kecil
```

#### LIMIT - Membatasi Hasil
```sql
SELECT * FROM items LIMIT 5;          -- 5 data pertama
SELECT * FROM items LIMIT 3, 5;       -- Skip 3, ambil 5 berikutnya
```

#### Fungsi Agregat
```sql
SELECT COUNT(*) AS total_items FROM items;              -- Hitung jumlah
SELECT SUM(jumlah) AS total_barang FROM items;          -- Jumlahkan
SELECT AVG(harga_satuan) AS rata_rata FROM items;       -- Rata-rata
SELECT MAX(harga_satuan) AS tertinggi FROM items;       -- Nilai max
SELECT MIN(harga_satuan) AS terendah FROM items;        -- Nilai min
```

#### GROUP BY - Pengelompokan
```sql
SELECT kategori, COUNT(*) AS jumlah_jenis 
FROM items 
GROUP BY kategori;
```

**Contoh Output:**
```
kategori    | jumlah_jenis
------------|-------------
Elektronik  | 5
Furniture   | 3
```

#### HAVING - Filter Setelah GROUP BY
```sql
SELECT kategori, COUNT(*) AS jumlah_jenis 
FROM items 
GROUP BY kategori 
HAVING COUNT(*) > 2;
```

**Perbedaan WHERE vs HAVING:**
- `WHERE`: Filter sebelum grouping
- `HAVING`: Filter setelah grouping

### 3. UPDATE - Mengubah Data

#### Update Single Row
```sql
UPDATE items SET jumlah = 3 WHERE id = 1;
```

#### Update Multiple Columns
```sql
UPDATE items 
SET jumlah = 12, lokasi = 'Ruang Manager' 
WHERE id = 7;
```

#### Update dengan Kalkulasi
```sql
UPDATE items SET jumlah = jumlah + 5 WHERE kategori = 'Furniture';
```

**PERINGATAN:** Selalu gunakan WHERE! Tanpa WHERE, semua baris akan berubah.

### 4. DELETE - Menghapus Data

#### Delete dengan Kondisi
```sql
DELETE FROM items WHERE id = 8;
DELETE FROM items WHERE jumlah = 0;
```

**PERINGATAN:** Selalu gunakan WHERE! Tanpa WHERE, semua data akan terhapus.

---

## JOIN Operations

JOIN menggabungkan data dari dua atau lebih tabel berdasarkan kolom yang berelasi.

### Visualisasi JOIN

```
Tabel Items:               Tabel Transactions:
id | nama_barang           item_id | jenis
---|-------------------    --------|--------
1  | Laptop               1       | masuk
2  | Meja                 1       | keluar
3  | Kursi                4       | keluar
4  | Proyektor            
```

### 1. INNER JOIN
Menampilkan data yang ada di KEDUA tabel (irisan/intersection).

```sql
SELECT 
    t.id AS transaksi_id,
    t.jenis_transaksi,
    t.jumlah,
    i.nama_barang,
    i.kategori
FROM transactions t
INNER JOIN items i ON t.item_id = i.id;
```

**Hasil:** Hanya transaksi yang memiliki item terkait (id 1, 1, 4).

**Kapan Digunakan:**
- Ketika hanya ingin data yang lengkap di kedua tabel
- Query paling umum digunakan

### 2. LEFT JOIN (LEFT OUTER JOIN)
Menampilkan SEMUA data dari tabel KIRI, dan data matching dari tabel kanan.

```sql
SELECT 
    i.id,
    i.nama_barang,
    t.jenis_transaksi,
    t.jumlah
FROM items i
LEFT JOIN transactions t ON i.id = t.item_id;
```

**Hasil:** Semua items (1,2,3,4). Item 2 dan 3 akan punya nilai NULL untuk kolom transaksi.

**Kapan Digunakan:**
- Mencari data di tabel kiri yang tidak memiliki relasi di tabel kanan
- Contoh: Barang yang belum pernah ada transaksi

### 3. RIGHT JOIN (RIGHT OUTER JOIN)
Menampilkan SEMUA data dari tabel KANAN, dan data matching dari tabel kiri.

```sql
SELECT 
    i.nama_barang,
    t.jenis_transaksi,
    t.jumlah
FROM items i
RIGHT JOIN transactions t ON i.id = t.item_id;
```

**Hasil:** Semua transaksi. Jika ada transaksi tanpa item (seharusnya tidak terjadi karena foreign key), item akan NULL.

**Kapan Digunakan:**
- Jarang digunakan (bisa diganti dengan LEFT JOIN dengan urutan tabel dibalik)

### 4. CROSS JOIN
Menghasilkan kombinasi semua baris (Cartesian Product).

```sql
SELECT i.nama_barang, t.jenis_transaksi 
FROM items i 
CROSS JOIN transactions t;
```

**Hasil:** Jika items 4 baris dan transaksi 3 baris, hasilnya 12 baris (4x3).

**Kapan Digunakan:**
- Generate kombinasi data
- HATI-HATI: Bisa menghasilkan data sangat besar

### 5. SELF JOIN
Join tabel dengan dirinya sendiri.

```sql
SELECT 
    i1.nama_barang AS barang_1,
    i2.nama_barang AS barang_2,
    i1.kategori
FROM items i1
INNER JOIN items i2 ON i1.kategori = i2.kategori AND i1.id < i2.id;
```

**Kapan Digunakan:**
- Membandingkan baris dalam satu tabel
- Contoh: Mencari barang dengan kategori yang sama

### Ringkasan JOIN

| JOIN Type   | Deskripsi                              | Use Case                        |
|-------------|----------------------------------------|---------------------------------|
| INNER JOIN  | Data ada di kedua tabel                | Default, data lengkap           |
| LEFT JOIN   | Semua data tabel kiri                  | Cari yang tidak punya relasi    |
| RIGHT JOIN  | Semua data tabel kanan                 | Jarang digunakan                |
| CROSS JOIN  | Semua kombinasi                        | Generate data kombinasi         |
| SELF JOIN   | Tabel dengan dirinya sendiri           | Perbandingan dalam satu tabel   |

---

## Query Lanjutan

### 1. SUBQUERY
Query di dalam query.

#### Subquery di WHERE
```sql
SELECT * FROM items 
WHERE id IN (SELECT DISTINCT item_id FROM transactions);
```

**Contoh Use Case:** Mencari barang yang pernah ada transaksi.

#### Subquery dengan NOT IN
```sql
SELECT * FROM items 
WHERE id NOT IN (SELECT DISTINCT item_id FROM transactions);
```

**Contoh Use Case:** Mencari barang yang belum pernah ada transaksi.

#### Subquery dengan EXISTS
```sql
SELECT i.* FROM items i
WHERE EXISTS (
    SELECT 1 FROM transactions t 
    WHERE t.item_id = i.id AND t.jenis_transaksi = 'keluar'
);
```

**Perbedaan IN vs EXISTS:**
- `IN`: Untuk nilai tunggal
- `EXISTS`: Lebih efisien untuk data besar, hanya cek keberadaan

#### Subquery di SELECT
```sql
SELECT 
    i.*,
    (SELECT COUNT(*) FROM transactions t WHERE t.item_id = i.id) AS total_transaksi
FROM items i;
```

### 2. CASE Statement
Conditional logic dalam SQL.

```sql
SELECT 
    nama_barang,
    jumlah,
    CASE 
        WHEN jumlah > 10 THEN 'Stok Aman'
        WHEN jumlah BETWEEN 5 AND 10 THEN 'Stok Cukup'
        ELSE 'Stok Menipis'
    END AS status_stok
FROM items;
```

**Contoh Output:**
```
nama_barang          | jumlah | status_stok
---------------------|--------|-------------
Laptop Dell          | 3      | Stok Menipis
Meja Kantor          | 10     | Stok Cukup
Kursi Ergonomis      | 15     | Stok Aman
```

### 3. UNION
Menggabungkan hasil dua query.

```sql
SELECT kode_barang, nama_barang FROM items WHERE kategori = 'Elektronik'
UNION
SELECT kode_barang, nama_barang FROM items WHERE kategori = 'Furniture';
```

**Perbedaan UNION vs UNION ALL:**
- `UNION`: Menghilangkan duplikat (lebih lambat)
- `UNION ALL`: Menyertakan duplikat (lebih cepat)

### 4. VIEW
Virtual table hasil query yang disimpan.

```sql
CREATE OR REPLACE VIEW view_laporan_barang AS
SELECT 
    i.id,
    i.kode_barang,
    i.nama_barang,
    COUNT(t.id) AS total_transaksi
FROM items i
LEFT JOIN transactions t ON i.id = t.item_id
GROUP BY i.id;
```

**Menggunakan VIEW:**
```sql
SELECT * FROM view_laporan_barang;
SELECT * FROM view_laporan_barang WHERE total_transaksi > 2;
```

**Keuntungan VIEW:**
- Menyederhanakan query kompleks
- Keamanan: Membatasi akses ke kolom tertentu
- Konsistensi: Query yang sama selalu menghasilkan struktur yang sama

### 5. TRANSACTION
Mengelola sekelompok operasi sebagai satu kesatuan.

```sql
START TRANSACTION;

INSERT INTO items (...) VALUES (...);
UPDATE items SET jumlah = jumlah - 1 WHERE id = 5;

COMMIT;  -- Simpan semua perubahan
-- atau
ROLLBACK;  -- Batalkan semua perubahan
```

**ACID Properties:**
- **Atomicity**: Semua operasi sukses atau semua gagal
- **Consistency**: Data tetap konsisten
- **Isolation**: Transaksi tidak saling mengganggu
- **Durability**: Hasil transaksi permanen

**Kapan Menggunakan Transaction:**
- Transfer data antar tabel
- Operasi yang melibatkan multiple tables
- Operasi kritis yang harus sukses semua atau gagal semua

---

## Normalisasi Database

Normalisasi adalah proses mengorganisir data untuk mengurangi redundansi dan meningkatkan integritas.

### Contoh Tabel Tidak Normal

**Tabel: transactions_barang (Tidak Normal)**
```
id | kode_barang | nama_barang  | kategori   | jenis_transaksi | jumlah | penanggung_jawab
---|-------------|--------------|------------|-----------------|--------|------------------
1  | BRG001      | Laptop Dell  | Elektronik | masuk           | 5      | Budi
2  | BRG001      | Laptop Dell  | Elektronik | keluar          | 2      | Siti
```

**Masalah:**
- Data barang (kode, nama, kategori) berulang di setiap transaksi
- Jika nama barang berubah, harus update di semua transaksi
- Waste storage space

### Setelah Normalisasi (1NF, 2NF, 3NF)

**Tabel 1: items**
```
id | kode_barang | nama_barang  | kategori   | lokasi     | jumlah | kondisi
---|-------------|--------------|------------|------------|--------|--------
1  | BRG001      | Laptop Dell  | Elektronik | Ruang IT   | 3      | Baik
```

**Tabel 2: transactions**
```
id | item_id | jenis_transaksi | jumlah | tanggal_transaksi | penanggung_jawab
---|---------|-----------------|--------|-------------------|------------------
1  | 1       | masuk           | 5      | 2026-01-01        | Budi
2  | 1       | keluar          | 2      | 2026-01-08        | Siti
```

**Keuntungan:**
- Data barang hanya disimpan sekali
- Update nama barang hanya di satu tempat
- Menghemat storage
- Data lebih konsisten

### Bentuk Normal

#### 1NF (First Normal Form)
- Setiap kolom berisi nilai atomic (tidak bisa dibagi lagi)
- Tidak ada repeating groups

**Contoh Pelanggaran:**
```
id | nama_barang | lokasi
---|-------------|------------------------
1  | Laptop      | Ruang A, Ruang B, Ruang C
```

**Seharusnya:** Pisahkan menjadi multiple rows atau tabel terpisah.

#### 2NF (Second Normal Form)
- Sudah memenuhi 1NF
- Tidak ada partial dependency (atribut non-key bergantung pada sebagian primary key)

#### 3NF (Third Normal Form)
- Sudah memenuhi 2NF
- Tidak ada transitive dependency (atribut non-key bergantung pada atribut non-key lain)

**Catatan:** Untuk pemula, fokus pada memisahkan entitas yang berbeda ke tabel berbeda dan menghubungkan dengan foreign key.

---

## Best Practices

### 1. Penamaan

**Gunakan Nama yang Deskriptif:**
- Tabel: Plural atau singular konsisten (`items` atau `item`)
- Kolom: Jelas dan ringkas (`tanggal_masuk` bukan `tgl_msk`)
- Index: Prefix dengan `idx_` (`idx_kode_barang`)
- Foreign Key: Prefix dengan `fk_` atau suffix dengan `_id` (`item_id`)

**Hindari:**
- Spasi dalam nama (gunakan underscore)
- Reserved keywords sebagai nama
- Nama terlalu umum (`data`, `info`, `value`)

### 2. Tipe Data

**Pilih Tipe Data yang Tepat:**
- `VARCHAR`: String dengan panjang variabel
- `CHAR`: String dengan panjang tetap (lebih cepat untuk data fixed)
- `INT`: Integer
- `DECIMAL`: Angka desimal presisi tinggi (untuk uang)
- `FLOAT/DOUBLE`: Angka desimal (untuk kalkulasi saintifik)
- `DATE`: Tanggal (YYYY-MM-DD)
- `DATETIME`: Tanggal dan waktu
- `TEXT`: String panjang
- `ENUM`: Pilihan nilai terbatas

**Tips:**
- Gunakan `DECIMAL` untuk nilai uang, bukan `FLOAT`
- Gunakan `DATE` untuk tanggal, bukan `VARCHAR`
- Tentukan panjang `VARCHAR` sesuai kebutuhan

### 3. Indexing

**Kapan Membuat Index:**
- Kolom yang sering digunakan di WHERE
- Kolom yang sering digunakan di JOIN
- Kolom yang sering digunakan di ORDER BY
- Foreign key columns

**Jangan Over-Index:**
- Index memperlambat INSERT, UPDATE, DELETE
- Index memakan storage
- Cukup index kolom yang benar-benar sering digunakan

```sql
CREATE INDEX idx_kode_barang ON items(kode_barang);
CREATE INDEX idx_kategori ON items(kategori);
```

### 4. Query Optimization

**DO:**
- Sebutkan kolom yang diperlukan, hindari `SELECT *`
- Gunakan `LIMIT` jika tidak perlu semua data
- Gunakan `WHERE` untuk filter data
- Gunakan `EXPLAIN` untuk analisa query

**DON'T:**
- Hindari `SELECT *` di production code
- Hindari query dalam loop (N+1 problem)
- Hindari function di WHERE clause pada kolom indexed

**Contoh Buruk:**
```sql
SELECT * FROM items WHERE YEAR(tanggal_masuk) = 2026;
```

**Contoh Baik:**
```sql
SELECT id, nama_barang FROM items 
WHERE tanggal_masuk BETWEEN '2026-01-01' AND '2026-12-31';
```

### 5. Security

**SQL Injection Prevention:**
- Gunakan Prepared Statements
- Validasi input
- Escape special characters

**Contoh (PHP PDO):**
```php
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
```

**Jangan:**
```php
$query = "SELECT * FROM items WHERE id = " . $_GET['id'];  // BAHAYA!
```

### 6. Backup & Recovery

**Lakukan Backup Rutin:**
```bash
# Backup database
mysqldump -u username -p inventaris_db > backup.sql

# Restore database
mysql -u username -p inventaris_db < backup.sql
```

**Best Practice:**
- Backup sebelum perubahan besar
- Backup berkala (harian/mingguan)
- Simpan backup di lokasi terpisah
- Test restore procedure

### 7. Transaction Usage

**Gunakan Transaction untuk:**
- Multiple related operations
- Operations yang harus atomic
- Data critical operations

```sql
START TRANSACTION;

UPDATE items SET jumlah = jumlah - 5 WHERE id = 1;
INSERT INTO transactions (item_id, jenis_transaksi, jumlah, ...) 
VALUES (1, 'keluar', 5, ...);

COMMIT;
```

### 8. Documentation

**Dokumentasikan:**
- Struktur database (ERD - Entity Relationship Diagram)
- Relasi antar tabel
- Business rules
- Index yang dibuat dan alasannya
- Query kompleks dengan komentar

```sql
-- Menghitung total nilai inventaris per kategori
-- Digunakan untuk laporan bulanan finance
SELECT 
    kategori,
    SUM(jumlah * harga_satuan) AS nilai_total
FROM items
GROUP BY kategori;
```

### 9. Naming Conventions

**Konsisten dalam Penamaan:**
- Snake_case untuk table dan column: `nama_barang`, `tanggal_masuk`
- Singular atau plural konsisten
- Prefix untuk tabel tertentu jika multi-aplikasi

### 10. Error Handling

**Always Check:**
- Foreign key constraints
- Data type compatibility
- NOT NULL constraints
- Unique constraints

**Contoh Error:**
```sql
-- Error: Cannot add foreign key constraint
INSERT INTO transactions (item_id, ...) VALUES (999, ...);  
-- item_id 999 tidak ada di tabel items
```

---

## Latihan

### Latihan 1: Basic CRUD
1. Tambahkan 3 barang baru dengan kategori berbeda
2. Tampilkan semua barang dengan kategori 'Elektronik'
3. Update jumlah barang dengan id = 2 menjadi 20
4. Hapus barang dengan jumlah = 0

### Latihan 2: Aggregation
1. Hitung total semua barang di inventaris
2. Hitung rata-rata harga barang per kategori
3. Tampilkan kategori dengan jumlah barang terbanyak

### Latihan 3: JOIN
1. Tampilkan semua transaksi beserta detail barangnya
2. Tampilkan barang yang belum pernah ada transaksi
3. Hitung total transaksi per barang

### Latihan 4: Advanced
1. Buat VIEW untuk laporan stok menipis (jumlah < 5)
2. Buat query untuk menampilkan barang dengan nilai total tertinggi
3. Buat transaction untuk memindahkan barang antar lokasi

---

## Referensi

### Dokumentasi Resmi
- MySQL Documentation: https://dev.mysql.com/doc/
- MariaDB Documentation: https://mariadb.com/kb/en/

### Perintah Dasar MySQL CLI
```bash
# Login ke MySQL
mysql -u root -p

# Menampilkan semua database
SHOW DATABASES;

# Menggunakan database
USE inventaris_db;

# Menampilkan semua tabel
SHOW TABLES;

# Menampilkan struktur tabel
DESCRIBE items;

# Menampilkan create statement
SHOW CREATE TABLE items;
```

### Fungsi-Fungsi Umum

**String Functions:**
- `CONCAT(str1, str2)`: Menggabungkan string
- `UPPER(str)`: Konversi ke uppercase
- `LOWER(str)`: Konversi ke lowercase
- `LENGTH(str)`: Panjang string
- `SUBSTRING(str, start, length)`: Potong string

**Date Functions:**
- `NOW()`: Tanggal dan waktu sekarang
- `CURDATE()`: Tanggal sekarang
- `DATE_FORMAT(date, format)`: Format tanggal
- `DATEDIFF(date1, date2)`: Selisih hari
- `YEAR(date)`: Ekstrak tahun

**Numeric Functions:**
- `ROUND(number, decimals)`: Pembulatan
- `CEIL(number)`: Pembulatan ke atas
- `FLOOR(number)`: Pembulatan ke bawah
- `ABS(number)`: Nilai absolut

---

## Glossary

**ACID**: Atomicity, Consistency, Isolation, Durability - prinsip transaksi database

**Auto Increment**: Kolom yang nilainya otomatis bertambah setiap insert data baru

**Cartesian Product**: Kombinasi semua baris dari dua tabel (CROSS JOIN)

**Constraint**: Aturan yang diterapkan pada kolom (NOT NULL, UNIQUE, PRIMARY KEY, dll)

**DDL**: Data Definition Language - SQL untuk struktur database

**DML**: Data Manipulation Language - SQL untuk manipulasi data

**Foreign Key**: Kolom yang mereferensikan Primary Key di tabel lain

**Index**: Struktur data untuk mempercepat pencarian

**Join**: Operasi menggabungkan data dari multiple tables

**Normalization**: Proses mengorganisir data untuk mengurangi redundansi

**Primary Key**: Kolom unik untuk identifikasi setiap baris

**Query**: Perintah SQL untuk mengambil atau memanipulasi data

**Subquery**: Query di dalam query

**Transaction**: Sekelompok operasi yang dieksekusi sebagai satu unit

**View**: Virtual table hasil dari query

---

## Tips Belajar SQL

1. **Praktik Langsung**: Jalankan setiap contoh query di database
2. **Eksperimen**: Ubah query dan lihat hasilnya
3. **Pahami Error**: Baca error message untuk belajar
4. **Gunakan EXPLAIN**: Untuk memahami bagaimana query dieksekusi
5. **Mulai Sederhana**: Kuasai SELECT, WHERE, JOIN dulu sebelum advanced topics
6. **Backup Data**: Selalu backup sebelum eksperimen dengan UPDATE/DELETE
7. **Baca Dokumentasi**: MySQL/MariaDB documentation sangat lengkap
8. **Latihan Soal**: Kerjakan latihan untuk memperkuat pemahaman

---

**Versi Dokumen**: 1.0  
**Tanggal**: 10 Januari 2026  
**Database**: inventaris_db  
**DBMS**: MySQL/MariaDB
