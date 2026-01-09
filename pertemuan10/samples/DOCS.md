# 📚 DOKUMENTASI SISTEM CRUD INVENTARIS BARANG
## Panduan Step by Step untuk Mahasiswa

---

## 📋 DAFTAR ISI
1. [Pengenalan Project](#pengenalan-project)
2. [Struktur File](#struktur-file)
3. [Persiapan Awal](#persiapan-awal)
4. [Step 1: Membuat Database](#step-1-membuat-database)
5. [Step 2: Membuat File Koneksi](#step-2-membuat-file-koneksi)
6. [Step 3: Membuat File Proses](#step-3-membuat-file-proses)
7. [Step 4: Membuat Halaman Utama](#step-4-membuat-halaman-utama)
8. [Penjelasan Kode Detail](#penjelasan-kode-detail)
9. [Testing & Troubleshooting](#testing--troubleshooting)

---

## 🎯 PENGENALAN PROJECT

Project ini adalah sistem **CRUD (Create, Read, Update, Delete)** sederhana untuk mengelola data inventaris barang menggunakan:
- **PHP** untuk backend logic
- **MySQL** untuk database
- **HTML5** untuk struktur halaman
- **CSS** untuk styling sederhana

### Fitur Aplikasi:
✅ Tambah data barang baru  
✅ Lihat daftar semua barang  
✅ Edit data barang  
✅ Hapus data barang (dengan konfirmasi)  
✅ Alert notifikasi success  

---

## 📁 STRUKTUR FILE

```
pertemuan10/samples/
│
├── koneksi.php      → File koneksi ke database
├── index.php        → Halaman utama (form + tabel)
├── proses.php       → Proses CRUD (tambah/edit/hapus)
└── database.sql     → Script SQL untuk membuat database
```

---

## 🛠️ PERSIAPAN AWAL

### Yang Harus Disiapkan:
1. **XAMPP** sudah terinstall
2. **Text Editor** (VS Code, Notepad++, Sublime Text)
3. **Browser** (Chrome, Firefox, Edge)

### Langkah Persiapan:
1. Buka XAMPP Control Panel
2. Start **Apache** (untuk PHP)
3. Start **MySQL** (untuk database)
4. Buat folder `pertemuan10/samples` di `htdocs`

---

## 📊 STEP 1: MEMBUAT DATABASE

### 1.1 Buka phpMyAdmin
- Buka browser, ketik: `http://localhost/phpmyadmin`
- Login jika diminta (default: user `root`, password kosong)

### 1.2 Buat Database Baru
Klik tab **SQL**, lalu copas kode berikut:

```sql
-- Membuat database
CREATE DATABASE IF NOT EXISTS inventaris_db;

-- Menggunakan database
USE inventaris_db;

-- Membuat tabel items
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

-- Contoh data sample (opsional)
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) VALUES
('BRG001', 'Laptop Dell', 'Elektronik', 'Gudang A', 10, 'Baik', '2026-01-05'),
('BRG002', 'Meja Kantor', 'Furniture', 'Gudang B', 25, 'Baik', '2026-01-06'),
('BRG003', 'Kursi Roda', 'Peralatan', 'Gudang A', 5, 'Rusak', '2026-01-07');
```

### 1.3 Klik tombol **Go** untuk menjalankan

### 💡 Penjelasan:
- `CREATE DATABASE` → Membuat database baru bernama `inventaris_db`
- `CREATE TABLE` → Membuat tabel `items` dengan 8 kolom
- `AUTO_INCREMENT` → ID otomatis bertambah
- `PRIMARY KEY` → ID sebagai kunci utama (unik)
- `VARCHAR(50)` → Tipe data text maksimal 50 karakter
- `INT(11)` → Tipe data angka bulat
- `DATE` → Tipe data tanggal

---

## 🔌 STEP 2: MEMBUAT FILE KONEKSI

### 2.1 Buat File `koneksi.php`
Di folder `pertemuan10/samples/`, buat file baru bernama `koneksi.php`

### 2.2 Copas Kode Berikut:

```php
<?php
// File koneksi database
$host = "localhost";
$user = "root";
$password = "";
$database = "inventaris_db";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

### 💡 Penjelasan Baris per Baris:

**Baris 2-5: Konfigurasi Database**
```php
$host = "localhost";        // Server database (localhost = komputer sendiri)
$user = "root";             // Username MySQL (default root)
$password = "";             // Password MySQL (default kosong)
$database = "inventaris_db"; // Nama database yang dibuat tadi
```

**Baris 8: Membuat Koneksi**
```php
$koneksi = mysqli_connect($host, $user, $password, $database);
```
- `mysqli_connect()` → Fungsi PHP untuk connect ke MySQL
- Menyimpan koneksi ke variabel `$koneksi`
- Variabel ini akan dipakai di file lain

**Baris 11-13: Cek Koneksi**
```php
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
```
- Jika koneksi gagal, tampilkan pesan error dan hentikan program
- `die()` → Menghentikan eksekusi PHP
- `mysqli_connect_error()` → Menampilkan pesan error koneksi

---

## ⚙️ STEP 3: MEMBUAT FILE PROSES

### 3.1 Buat File `proses.php`
File ini menangani semua operasi CRUD (tambah, edit, hapus)

### 3.2 Copas Kode Berikut:

```php
<?php
// Memanggil file koneksi
include 'koneksi.php';

// PROSES TAMBAH DATA
if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    
    $query = "INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) 
              VALUES ('$kode_barang', '$nama_barang', '$kategori', '$lokasi', '$jumlah', '$kondisi', '$tanggal_masuk')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?success=Data berhasil ditambahkan!");
    } else {
        header("Location: index.php?success=Error: " . mysqli_error($koneksi));
    }
}

// PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    
    $query = "UPDATE items SET 
              kode_barang = '$kode_barang',
              nama_barang = '$nama_barang',
              kategori = '$kategori',
              lokasi = '$lokasi',
              jumlah = '$jumlah',
              kondisi = '$kondisi',
              tanggal_masuk = '$tanggal_masuk'
              WHERE id = $id";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?success=Data berhasil diupdate!");
    } else {
        header("Location: index.php?success=Error: " . mysqli_error($koneksi));
    }
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $query = "DELETE FROM items WHERE id = $id";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?success=Data berhasil dihapus!");
    } else {
        header("Location: index.php?success=Error: " . mysqli_error($koneksi));
    }
}
?>
```

### 💡 Penjelasan Per Bagian:

#### A. Include File Koneksi
```php
include 'koneksi.php';
```
- Memanggil file `koneksi.php` agar bisa pakai variabel `$koneksi`

#### B. Proses Tambah Data (CREATE)
```php
if (isset($_POST['simpan'])) {
```
- `isset()` → Cek apakah tombol 'simpan' diklik
- `$_POST` → Menerima data dari form dengan method POST

```php
$kode_barang = $_POST['kode_barang'];
```
- Mengambil nilai dari input form dengan name="kode_barang"
- Menyimpan ke variabel PHP

```php
$query = "INSERT INTO items (...) VALUES (...)";
```
- SQL command untuk menambah data ke tabel `items`
- `INSERT INTO` → Perintah tambah data

```php
if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil ditambahkan!");
}
```
- `mysqli_query()` → Menjalankan query SQL
- Jika berhasil, redirect ke index.php dengan parameter success
- `header()` → Redirect halaman

#### C. Proses Update Data (UPDATE)
```php
if (isset($_POST['update'])) {
```
- Cek apakah tombol 'update' diklik

```php
$query = "UPDATE items SET ... WHERE id = $id";
```
- SQL command untuk update data
- `UPDATE` → Perintah ubah data
- `WHERE id = $id` → Hanya update data dengan ID tertentu

#### D. Proses Hapus Data (DELETE)
```php
if (isset($_GET['hapus'])) {
```
- `$_GET` → Menerima data dari URL (misal: ?hapus=5)

```php
$query = "DELETE FROM items WHERE id = $id";
```
- SQL command untuk hapus data
- `DELETE FROM` → Perintah hapus data

---

## 🖥️ STEP 4: MEMBUAT HALAMAN UTAMA

### 4.1 Struktur File `index.php`
File ini terdiri dari 3 bagian utama:
1. **PHP Logic** (bagian atas)
2. **HTML Structure** (bagian tengah)
3. **CSS Styling** (di dalam tag `<style>`)

### 4.2 Bagian 1: PHP Logic (Atas)

Copas kode ini di awal file:

```php
<?php
// Memanggil file koneksi
include 'koneksi.php';

// Untuk Edit - Mengambil data berdasarkan ID
$id = "";
$kode_barang = "";
$nama_barang = "";
$kategori = "";
$lokasi = "";
$jumlah = "";
$kondisi = "";
$tanggal_masuk = "";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = "SELECT * FROM items WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    
    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $kategori = $data['kategori'];
    $lokasi = $data['lokasi'];
    $jumlah = $data['jumlah'];
    $kondisi = $data['kondisi'];
    $tanggal_masuk = $data['tanggal_masuk'];
}

// Menampilkan alert jika ada parameter success
if (isset($_GET['success'])) {
    $pesan = $_GET['success'];
    echo "<script>alert('$pesan');</script>";
}
?>
```

#### 💡 Penjelasan:

**Inisialisasi Variabel (Baris 6-13)**
```php
$id = "";
$kode_barang = "";
// dst...
```
- Membuat variabel kosong untuk menampung data
- Jika tidak diisi, value form akan kosong (untuk tambah data baru)
- Jika diisi (saat edit), value form akan terisi

**Logic untuk Edit Data (Baris 15-27)**
```php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
```
- Cek apakah ada parameter `?edit=5` di URL
- Jika ada, ambil ID nya

```php
$query = "SELECT * FROM items WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
```
- `SELECT * FROM items` → Ambil semua kolom dari tabel items
- `WHERE id = $id` → Yang ID nya sesuai
- `mysqli_fetch_assoc()` → Ubah hasil query jadi array associative

```php
$kode_barang = $data['kode_barang'];
```
- Mengisi variabel dengan data dari database
- Variabel ini akan ditampilkan di form

**Alert Success (Baris 30-33)**
```php
if (isset($_GET['success'])) {
    echo "<script>alert('$pesan');</script>";
}
```
- Jika ada parameter `?success=...` di URL
- Tampilkan alert JavaScript dengan pesan tersebut

---

### 4.3 Bagian 2: HTML Structure

#### A. DOCTYPE dan Head
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Inventaris Barang</title>
    <style>
        /* CSS akan ditaruh di sini */
    </style>
</head>
```

#### 💡 Penjelasan:
- `<!DOCTYPE html>` → Deklarasi HTML5
- `lang="id"` → Bahasa Indonesia
- `<meta charset="UTF-8">` → Support karakter Indonesia
- `<meta name="viewport">` → Responsive untuk mobile

#### B. CSS Styling

Copas CSS berikut di dalam tag `<style>`:

```css
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 5px;
}

h2 {
    color: #333;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
}

button:hover {
    background-color: #45a049;
}

.btn-reset {
    background-color: #f44336;
}

.btn-reset:hover {
    background-color: #da190b;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
    padding: 12px;
    text-align: left;
}

td {
    padding: 10px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.btn-edit {
    background-color: #2196F3;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
    display: inline-block;
}

.btn-edit:hover {
    background-color: #0b7dda;
}

.btn-delete {
    background-color: #f44336;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
    display: inline-block;
}

.btn-delete:hover {
    background-color: #da190b;
}

.form-section {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}
```

#### 💡 Penjelasan CSS:

**Container dan Layout**
```css
.container {
    max-width: 1000px;    /* Lebar maksimal */
    margin: 0 auto;       /* Posisi tengah */
}
```

**Table Styling**
```css
table {
    width: 100%;
    border-collapse: collapse;  /* Gabungkan border */
}
```

**Responsive Table Width**
```css
th {
    width: 10%;  /* Bisa diatur sesuai kebutuhan */
}
```

**Hover Effect**
```css
button:hover {
    background-color: #45a049;  /* Warna berubah saat hover */
}
```

#### C. Form Input/Edit

Copas kode berikut di dalam `<body>`:

```html
<body>
    <div class="container">
        <h2>SISTEM INVENTARIS BARANG</h2>
        
        <!-- Form Input / Edit -->
        <div class="form-section">
            <h3><?php echo $id ? "Edit Data Barang" : "Tambah Data Barang"; ?></h3>
            <form action="proses.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <div class="form-group">
                    <label for="kode_barang">Kode Barang:</label>
                    <input type="text" id="kode_barang" name="kode_barang" value="<?php echo $kode_barang; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="nama_barang">Nama Barang:</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $nama_barang; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <input type="text" id="kategori" name="kategori" value="<?php echo $kategori; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lokasi">Lokasi:</label>
                    <input type="text" id="lokasi" name="lokasi" value="<?php echo $lokasi; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="kondisi">Kondisi:</label>
                    <select id="kondisi" name="kondisi" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" <?php echo ($kondisi == "Baik") ? "selected" : ""; ?>>Baik</option>
                        <option value="Rusak" <?php echo ($kondisi == "Rusak") ? "selected" : ""; ?>>Rusak</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk:</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo $tanggal_masuk; ?>" required>
                </div>
                
                <button type="submit" name="<?php echo $id ? 'update' : 'simpan'; ?>">
                    <?php echo $id ? 'Update Data' : 'Simpan Data'; ?>
                </button>
                
                <?php if ($id): ?>
                    <a href="index.php"><button type="button" class="btn-reset">Batal</button></a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
```

#### 💡 Penjelasan Form:

**Judul Dinamis**
```php
<h3><?php echo $id ? "Edit Data Barang" : "Tambah Data Barang"; ?></h3>
```
- Jika ada `$id`, tampilkan "Edit Data Barang"
- Jika tidak ada, tampilkan "Tambah Data Barang"
- Operator ternary: `kondisi ? true : false`

**Form Action**
```html
<form action="proses.php" method="POST">
```
- `action` → Data dikirim ke file `proses.php`
- `method="POST"` → Metode pengiriman POST (lebih aman)

**Input Hidden**
```html
<input type="hidden" name="id" value="<?php echo $id; ?>">
```
- Input tersembunyi untuk menyimpan ID
- Digunakan saat update data

**Input Text**
```html
<input type="text" name="kode_barang" value="<?php echo $kode_barang; ?>" required>
```
- `name` → Nama variabel yang akan dikirim
- `value` → Nilai default (kosong atau dari database)
- `required` → Wajib diisi

**Dropdown Kondisi**
```html
<select name="kondisi" required>
    <option value="">-- Pilih Kondisi --</option>
    <option value="Baik" <?php echo ($kondisi == "Baik") ? "selected" : ""; ?>>Baik</option>
    <option value="Rusak" <?php echo ($kondisi == "Rusak") ? "selected" : ""; ?>>Rusak</option>
</select>
```
- Dropdown dengan 2 pilihan: Baik atau Rusak
- `selected` akan muncul jika kondisi sesuai (saat edit)

**Tombol Submit Dinamis**
```php
<button type="submit" name="<?php echo $id ? 'update' : 'simpan'; ?>">
    <?php echo $id ? 'Update Data' : 'Simpan Data'; ?>
</button>
```
- Jika ada `$id` → name="update" dan text "Update Data"
- Jika tidak → name="simpan" dan text "Simpan Data"

**Tombol Batal (Conditional)**
```php
<?php if ($id): ?>
    <a href="index.php"><button type="button" class="btn-reset">Batal</button></a>
<?php endif; ?>
```
- Tombol batal hanya muncul saat mode edit
- Link kembali ke `index.php` (reset form)

#### D. Tabel Data

Copas kode berikut setelah form:

```html
<!-- Tabel Data -->
<div>
    <h3>Daftar Barang</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Kode Barang</th>
                <th style="width: 18%;">Nama Barang</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 12%;">Lokasi</th>
                <th style="width: 8%;">Jumlah</th>
                <th style="width: 10%;">Kondisi</th>
                <th style="width: 13%;">Tanggal Masuk</th>
                <th style="width: 10%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk menampilkan semua data
            $query = "SELECT * FROM items ORDER BY id DESC";
            $result = mysqli_query($koneksi, $query);
            
            // Cek apakah ada data
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['kode_barang'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>" . $row['kategori'] . "</td>";
                    echo "<td>" . $row['lokasi'] . "</td>";
                    echo "<td>" . $row['jumlah'] . "</td>";
                    echo "<td>" . $row['kondisi'] . "</td>";
                    echo "<td>" . $row['tanggal_masuk'] . "</td>";
                    echo "<td>
                            <a href='index.php?edit=" . $row['id'] . "' class='btn-edit'>Edit</a>
                            <a href='proses.php?hapus=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' style='text-align: center;'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
```

#### 💡 Penjelasan Tabel:

**Setting Width Kolom**
```html
<th style="width: 12%;">Kode Barang</th>
```
- Mengatur lebar setiap kolom
- Total harus 100% (atau biarkan otomatis)

**Query SELECT**
```php
$query = "SELECT * FROM items ORDER BY id DESC";
```
- Ambil semua data dari tabel items
- `ORDER BY id DESC` → Urutkan dari ID terbesar (data terbaru di atas)

**Execute Query**
```php
$result = mysqli_query($koneksi, $query);
```
- Jalankan query
- Simpan hasilnya ke variabel `$result`

**Cek Jumlah Data**
```php
if (mysqli_num_rows($result) > 0) {
```
- `mysqli_num_rows()` → Hitung jumlah baris hasil query
- Jika > 0 berarti ada data

**Loop Data dengan While**
```php
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['kode_barang'] . "</td>";
}
```
- `while` → Loop selama masih ada data
- `mysqli_fetch_assoc()` → Ambil 1 baris data jadi array
- `$no++` → Nomor urut otomatis bertambah

**Tombol Edit**
```php
<a href='index.php?edit=" . $row['id'] . "' class='btn-edit'>Edit</a>
```
- Link ke `index.php?edit=5` (contoh ID = 5)
- Akan mengisi form dengan data yang ada

**Tombol Hapus dengan Konfirmasi**
```php
<a href='proses.php?hapus=" . $row['id'] . "' 
   onclick='return confirm("Apakah Anda yakin ingin menghapus data ini?");'>
   Hapus
</a>
```
- `onclick` → JavaScript event
- `confirm()` → Popup konfirmasi
- `return` → Jika cancel, link tidak dijalankan

**Jika Tidak Ada Data**
```php
else {
    echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
}
```
- `colspan='9'` → Gabungkan 9 kolom jadi 1
- Tampilkan pesan "Tidak ada data"

---

## 📝 PENJELASAN KODE DETAIL

### Konsep CRUD

#### 1. CREATE (Tambah Data)
**Flow:**
1. User isi form → klik "Simpan Data"
2. Data dikirim ke `proses.php` via POST
3. PHP ambil data dari `$_POST`
4. Buat query INSERT
5. Execute query
6. Redirect ke index.php dengan pesan success

**Contoh Query:**
```sql
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) 
VALUES ('BRG004', 'Monitor LG', 'Elektronik', 'Gudang C', 15, 'Baik', '2026-01-09')
```

#### 2. READ (Tampilkan Data)
**Flow:**
1. Buka `index.php`
2. PHP execute query SELECT
3. Loop semua data dengan while
4. Tampilkan di tabel HTML

**Contoh Query:**
```sql
SELECT * FROM items ORDER BY id DESC
```

#### 3. UPDATE (Edit Data)
**Flow:**
1. User klik tombol "Edit" → pindah ke `index.php?edit=5`
2. PHP ambil data berdasarkan ID
3. Isi form dengan data yang ada
4. User ubah data → klik "Update Data"
5. Data dikirim ke `proses.php`
6. PHP buat query UPDATE
7. Execute query
8. Redirect ke index.php

**Contoh Query:**
```sql
UPDATE items SET 
    kode_barang = 'BRG004', 
    nama_barang = 'Monitor Samsung',
    kategori = 'Elektronik'
WHERE id = 5
```

#### 4. DELETE (Hapus Data)
**Flow:**
1. User klik tombol "Hapus"
2. JavaScript confirm() muncul
3. Jika OK → pindah ke `proses.php?hapus=5`
4. PHP ambil ID dari URL
5. Buat query DELETE
6. Execute query
7. Redirect ke index.php

**Contoh Query:**
```sql
DELETE FROM items WHERE id = 5
```

---

### Konsep PHP-MySQL

#### Variabel PHP
```php
$nama = "John";              // String
$umur = 25;                  // Integer
$nilai = ["A", "B", "C"];    // Array
```

#### Koneksi Database
```php
mysqli_connect($host, $user, $password, $database)
```
- Menghubungkan PHP dengan MySQL
- Return: resource connection

#### Execute Query
```php
mysqli_query($koneksi, $query)
```
- Menjalankan SQL query
- Return: result set (untuk SELECT) atau boolean

#### Ambil Data
```php
mysqli_fetch_assoc($result)
```
- Mengambil 1 baris data
- Return: array associative
- Contoh: `['id' => 1, 'nama' => 'Laptop']`

#### Hitung Baris
```php
mysqli_num_rows($result)
```
- Menghitung jumlah baris
- Return: integer

#### Redirect
```php
header("Location: index.php?success=Berhasil")
```
- Pindah halaman
- Harus sebelum HTML output

---

### Konsep HTML Form

#### Form Method
```html
<form method="POST">    <!-- Data tidak terlihat di URL -->
<form method="GET">     <!-- Data terlihat di URL -->
```

#### Input Types
```html
<input type="text">      <!-- Text biasa -->
<input type="number">    <!-- Hanya angka -->
<input type="date">      <!-- Kalender -->
<input type="hidden">    <!-- Tersembunyi -->
```

#### Select (Dropdown)
```html
<select name="kondisi">
    <option value="Baik">Baik</option>
    <option value="Rusak">Rusak</option>
</select>
```

---

### Konsep CSS

#### Selector
```css
body { }           /* Tag selector */
.container { }     /* Class selector */
#header { }        /* ID selector */
button:hover { }   /* Pseudo-class */
```

#### Box Model
```css
padding: 20px;     /* Jarak dalam */
margin: 20px;      /* Jarak luar */
border: 1px solid; /* Garis tepi */
```

---

## 🧪 TESTING & TROUBLESHOOTING

### Testing Step by Step

#### 1. Test Koneksi Database
Buat file `test_koneksi.php`:
```php
<?php
include 'koneksi.php';
echo "Koneksi berhasil!";
?>
```
Buka: `http://localhost/pertemuan10/samples/test_koneksi.php`

#### 2. Test Tambah Data
1. Buka `index.php`
2. Isi semua form
3. Klik "Simpan Data"
4. Cek apakah alert muncul
5. Cek data di tabel

#### 3. Test Edit Data
1. Klik tombol "Edit" di salah satu data
2. Form harus terisi otomatis
3. Ubah beberapa field
4. Klik "Update Data"
5. Cek apakah data berubah

#### 4. Test Hapus Data
1. Klik tombol "Hapus"
2. Popup konfirmasi harus muncul
3. Klik OK
4. Cek apakah data hilang dari tabel

---

### Common Errors & Solutions

#### Error 1: "Koneksi gagal"
**Penyebab:**
- MySQL belum running
- Database belum dibuat
- Username/password salah

**Solusi:**
1. Start MySQL di XAMPP
2. Buat database di phpMyAdmin
3. Cek konfigurasi di `koneksi.php`

#### Error 2: "Undefined variable"
**Penyebab:**
- Variabel belum di-inisialisasi

**Solusi:**
```php
// Tambahkan ini di awal
$kode_barang = "";
$nama_barang = "";
```

#### Error 3: "Table doesn't exist"
**Penyebab:**
- Nama tabel salah (case sensitive di Linux)
- Tabel belum dibuat

**Solusi:**
1. Pastikan nama tabel: `items` (bukan `barang`)
2. Cek di phpMyAdmin apakah tabel ada

#### Error 4: Alert tidak muncul
**Penyebab:**
- Parameter success tidak terkirim
- JavaScript error

**Solusi:**
Cek di browser console (F12)

#### Error 5: Form tidak terkirim
**Penyebab:**
- Attribute `name` tidak ada
- Method salah

**Solusi:**
```html
<form action="proses.php" method="POST">
<input type="text" name="kode_barang">
```

---

## 🎓 TIPS UNTUK MAHASISWA

### Cara Belajar Efektif

1. **Jangan Langsung Copas Semua**
   - Ketik kode secara manual
   - Pahami setiap baris
   - Modifikasi sedikit-sedikit

2. **Gunakan echo untuk Debug**
```php
echo "ID = " . $id;
echo "<pre>"; print_r($data); echo "</pre>";
```

3. **Cek Error di Browser**
   - Klik kanan → Inspect → Console
   - Lihat error PHP di browser

4. **Belajar Step by Step**
   - Hari 1: Koneksi database + Buat tabel
   - Hari 2: Tambah data (CREATE)
   - Hari 3: Tampilkan data (READ)
   - Hari 4: Edit data (UPDATE)
   - Hari 5: Hapus data (DELETE)

5. **Dokumentasi**
   - Tulis catatan sendiri
   - Buat flowchart
   - Screenshot setiap step

---

## 🔧 MODIFIKASI & PENGEMBANGAN

### Ide Pengembangan

1. **Tambah Fitur Search**
```php
$keyword = $_GET['search'];
$query = "SELECT * FROM items WHERE nama_barang LIKE '%$keyword%'";
```

2. **Pagination**
```php
$limit = 10;
$page = $_GET['page'];
$offset = ($page - 1) * $limit;
$query = "SELECT * FROM items LIMIT $limit OFFSET $offset";
```

3. **Upload Foto Barang**
```html
<input type="file" name="foto">
```

4. **Export ke Excel**
- Gunakan library PHPExcel atau PHPSpreadsheet

5. **Login System**
- Tambah tabel users
- Session management

6. **Validasi Input**
```php
$kode_barang = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
```

7. **Responsive Design**
```css
@media (max-width: 768px) {
    table { font-size: 12px; }
}
```

---

## 📚 REFERENSI

### Dokumentasi Resmi
- PHP: https://www.php.net/manual/en/
- MySQL: https://dev.mysql.com/doc/
- HTML: https://developer.mozilla.org/en-US/docs/Web/HTML
- CSS: https://developer.mozilla.org/en-US/docs/Web/CSS

### Tutorial Online
- W3Schools: https://www.w3schools.com/
- PHP Tutorial: https://www.phptutorial.net/
- MySQL Tutorial: https://www.mysqltutorial.org/

---

## ✅ CHECKLIST PEMBELAJARAN

### Pemahaman Dasar
- [ ] Memahami konsep CRUD
- [ ] Memahami cara kerja PHP-MySQL
- [ ] Memahami HTML Form
- [ ] Memahami CSS Styling

### Skill Praktis
- [ ] Bisa membuat database dan tabel
- [ ] Bisa koneksi PHP ke MySQL
- [ ] Bisa INSERT data
- [ ] Bisa SELECT data
- [ ] Bisa UPDATE data
- [ ] Bisa DELETE data

### Advanced
- [ ] Bisa validasi input
- [ ] Bisa handle error
- [ ] Bisa debug code
- [ ] Bisa modifikasi sendiri

---

## 🎯 TUGAS MANDIRI

### Level 1 (Easy)
1. Ubah warna tema dari hijau ke biru
2. Tambah field "harga" di tabel
3. Ubah urutan kolom di tabel

### Level 2 (Medium)
1. Tambah fitur search berdasarkan nama barang
2. Tambah dropdown untuk filter berdasarkan kategori
3. Buat halaman terpisah untuk form tambah/edit

### Level 3 (Hard)
1. Tambah upload foto untuk setiap barang
2. Buat export data ke PDF
3. Tambah login system dengan session

---

## 💡 KESIMPULAN

Aplikasi CRUD ini adalah dasar dari web development. Dengan memahami:
- **PHP** untuk logic backend
- **MySQL** untuk database
- **HTML** untuk struktur
- **CSS** untuk styling

Kamu bisa membuat berbagai aplikasi web seperti:
- Sistem perpustakaan
- Aplikasi kasir
- Website e-commerce
- Dan masih banyak lagi!

**Kunci sukses:** Praktek, praktek, praktek! 🚀

---

## 📞 BANTUAN

Jika ada error atau tidak paham:
1. Baca error message dengan teliti
2. Cek dokumentasi di bagian Troubleshooting
3. Google error message nya
4. Tanya ke dosen/asisten
5. Diskusi dengan teman

**Selamat Belajar! 📚✨**
