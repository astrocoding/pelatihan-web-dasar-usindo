# DOKUMENTASI SISTEM LOGIN DAN REGISTER PHP

## 1. Authentication vs Authorization

### Authentication (Autentikasi)
Authentication adalah proses memverifikasi identitas pengguna. Proses ini menjawab pertanyaan "Siapa kamu?". 

**Contoh:**
- Login dengan username dan password
- Login dengan sidik jari
- Login dengan OTP (One Time Password)

Pada sistem kita, authentication dilakukan ketika user memasukkan username dan password di halaman login.php. Sistem akan mengecek apakah kredensial yang dimasukkan benar atau tidak.

### Authorization (Otorisasi)
Authorization adalah proses menentukan apa yang boleh dilakukan oleh pengguna yang sudah terautentikasi. Proses ini menjawab pertanyaan "Apa yang boleh kamu lakukan?".

**Contoh:**
- Admin bisa menghapus data user
- User biasa hanya bisa melihat data
- Moderator bisa edit tapi tidak bisa hapus

Pada sistem kita, authorization diterapkan dengan mengecek session di index.php. Hanya user yang sudah login (terautentikasi) yang bisa mengakses halaman inventaris.

---

## 2. Session di PHP

### Apa itu Session?
Session adalah cara untuk menyimpan informasi pengguna di server untuk digunakan di berbagai halaman. Ketika user mengunjungi website, server akan membuat ID unik untuk user tersebut dan menyimpannya di cookie browser.

### Cara Kerja Session:
1. User membuka website
2. Server membuat Session ID unik (contoh: 5f4dcc3b5aa765d61d8327deb882cf99)
3. Session ID disimpan di cookie browser
4. Data user disimpan di server dengan Session ID sebagai kunci
5. Setiap halaman baru yang dibuka, browser mengirim Session ID ke server
6. Server membaca data berdasarkan Session ID tersebut

### Syntax Session di PHP:
```php
// Memulai session (harus di paling atas sebelum HTML)
session_start();

// Menyimpan data ke session
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';

// Membaca data dari session
echo $_SESSION['username']; // Output: admin

// Menghapus session tertentu
unset($_SESSION['username']);

// Menghapus semua session (logout)
session_destroy();
```

---

## 3. Alur Cara Kerja Login di PHP

### Diagram Alur Login:

```
1. User membuka login.php
   ↓
2. User mengisi username & password
   ↓
3. User klik tombol "Login"
   ↓
4. Data dikirim ke server (method POST)
   ↓
5. Server query database: SELECT * FROM users WHERE username = ?
   ↓
6. Ada data user?
   ├─ TIDAK → Tampilkan error "Username atau password salah"
   │
   └─ YA → Lanjut ke step 7
       ↓
7. Verifikasi password dengan password_verify()
   ↓
8. Password cocok?
   ├─ TIDAK → Tampilkan error "Username atau password salah"
   │
   └─ YA → Lanjut ke step 9
       ↓
9. Simpan data user ke session
   ├─ $_SESSION['user_id']
   ├─ $_SESSION['username']
   └─ $_SESSION['nama_lengkap']
       ↓
10. Redirect ke index.php
    ↓
11. User berhasil login dan bisa akses sistem
```

### Proses di Setiap Halaman:
Setiap halaman yang butuh login akan mengecek:
```php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
```

Jika session user_id tidak ada, user diarahkan kembali ke login.php.

---

## 4. Enkripsi Password

### Mengapa Password Harus Dienkripsi?
- Melindungi password dari pencurian data
- Jika database bocor, password asli tetap aman
- Standar keamanan modern

### Jenis-jenis Enkripsi Password:

#### 1. MD5 (Message Digest 5)
```php
$password = md5('admin123');
// Hasil: 0192023a7bbd73250516f069df18b500
```
**Kelemahan:** Sudah tidak aman, mudah di-crack dengan rainbow table

#### 2. SHA-1 (Secure Hash Algorithm 1)
```php
$password = sha1('admin123');
// Hasil: 240be518fabd2724ddb6f04eeb1da5967448d7e8
```
**Kelemahan:** Sama seperti MD5, sudah tidak aman

#### 3. bcrypt/PASSWORD_DEFAULT (Recommended)
```php
// Enkripsi (saat register)
$password = password_hash('admin123', PASSWORD_DEFAULT);
// Hasil: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

// Verifikasi (saat login)
if (password_verify('admin123', $hashed_password)) {
    echo "Password benar!";
}
```

**Kelebihan:**
- Sangat aman
- Menggunakan salt otomatis
- Sulit di-crack
- Standar industri saat ini

### Perbedaan Hash vs Enkripsi:
- **Hash:** Satu arah, tidak bisa dikembalikan (contoh: password_hash)
- **Enkripsi:** Dua arah, bisa didekripsi kembali (contoh: AES encryption)

Password sebaiknya menggunakan HASH, bukan enkripsi.

---

## 5. Penjelasan Kode login.php

### Bagian 1: Session Start dan Cek Login
```php
<?php
session_start();

// Jika sudah login, redirect ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
```
**Penjelasan:**
- `session_start()`: Memulai session untuk halaman ini
- `isset($_SESSION['user_id'])`: Mengecek apakah user sudah login
- Jika sudah login, langsung diarahkan ke index.php
- `exit()`: Menghentikan eksekusi script setelah redirect

### Bagian 2: Include Koneksi Database
```php
include 'koneksi.php';

$error = "";
```
**Penjelasan:**
- `include 'koneksi.php'`: Menyertakan file koneksi ke database
- `$error = ""`: Variabel untuk menyimpan pesan error

### Bagian 3: Proses Login
```php
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
```
**Penjelasan:**
- `isset($_POST['login'])`: Cek apakah tombol login diklik
- `mysqli_real_escape_string()`: Mencegah SQL injection dengan escape karakter berbahaya
- `$_POST['username']`: Mengambil data username dari form

### Bagian 4: Query Database
```php
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
```
**Penjelasan:**
- `SELECT * FROM users WHERE username = '$username'`: Mencari user berdasarkan username
- `mysqli_query()`: Menjalankan query ke database
- `mysqli_num_rows($result) > 0`: Cek apakah ada data yang ditemukan
- `mysqli_fetch_assoc()`: Mengambil data sebagai array associative

### Bagian 5: Verifikasi Password
```php
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
```
**Penjelasan:**
- `password_verify()`: Membandingkan password yang diinput dengan hash di database
- Jika cocok, simpan data user ke session
- `header("Location: index.php")`: Redirect ke halaman index
- Jika tidak cocok, tampilkan pesan error

### Bagian 6: Form HTML
```php
<form method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit" name="login">Login</button>
</form>
```
**Penjelasan:**
- `method="POST"`: Data dikirim secara POST (tidak terlihat di URL)
- `name="username"`: Nama field yang akan diambil dengan $_POST['username']
- `required`: Validasi HTML5, field wajib diisi
- `name="login"`: Nama tombol untuk pengecekan isset($_POST['login'])

---

## 6. Penjelasan Kode register.php

### Bagian 1: Menerima Data Form
```php
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
```
**Penjelasan:**
- Mengambil semua data dari form register
- Membersihkan input dengan `mysqli_real_escape_string()`
- Password tidak di-escape karena akan di-hash

### Bagian 2: Validasi Input
```php
    if ($password !== $confirm_password) {
        $error = "Password tidak sama!";
    } else if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    }
```
**Penjelasan:**
- `!==`: Operator strict comparison (membandingkan nilai dan tipe data)
- Cek apakah password dan konfirmasi password sama
- `strlen()`: Menghitung panjang string
- Validasi password minimal 6 karakter

### Bagian 3: Cek Username/Email Sudah Ada
```php
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($koneksi, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username atau email sudah terdaftar!";
    }
```
**Penjelasan:**
- Query untuk cek apakah username atau email sudah terdaftar
- `OR`: Operator logika, jika salah satu kondisi true maka true
- Mencegah duplikasi data

### Bagian 4: Hash Password dan Insert Database
```php
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (username, password, email, nama_lengkap) 
              VALUES ('$username', '$hashed_password', '$email', '$nama_lengkap')";
    
    if (mysqli_query($koneksi, $query)) {
        $success = "Registrasi berhasil! Silakan login.";
    }
```
**Penjelasan:**
- `password_hash()`: Mengenkripsi password dengan algoritma bcrypt
- `PASSWORD_DEFAULT`: Menggunakan algoritma terbaik yang tersedia
- `INSERT INTO`: Query untuk menambah data baru
- `VALUES`: Nilai yang akan diinsert ke database

---

## 7. Penjelasan Logout di index.php

### Bagian 1: Proteksi Halaman
```php
<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
```
**Penjelasan:**
- `!isset()`: NOT isset, mengecek apakah session TIDAK ada
- Jika belum login, redirect ke login.php
- Proteksi halaman dari akses tanpa login

### Bagian 2: Tampilan Info User
```php
<span style="color: #555;">
    Selamat datang, <strong><?= $_SESSION['nama_lengkap']; ?></strong>
</span>
<a href="logout.php" style="...">Logout</a>
```
**Penjelasan:**
- `<?= ?>`: Short syntax untuk echo
- Menampilkan nama lengkap dari session
- Link ke logout.php untuk proses logout

### Bagian 3: File logout.php
```php
<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>
```
**Penjelasan:**
- `session_start()`: Harus dipanggil dulu sebelum manipulasi session
- `session_destroy()`: Menghapus semua data session
- User diarahkan kembali ke halaman login
- Setelah logout, user tidak bisa akses halaman yang butuh login

### Alternatif Logout (Selektif):
```php
// Menghapus session tertentu saja
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['nama_lengkap']);
```
Perbedaan:
- `session_destroy()`: Menghapus SEMUA session
- `unset()`: Menghapus session tertentu saja

---

## 8. Penjelasan database.sql

### Bagian 1: Membuat Database
```sql
CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;
```
**Penjelasan:**
- `CREATE DATABASE`: Membuat database baru
- `IF NOT EXISTS`: Hanya buat jika belum ada, mencegah error
- `inventaris_db`: Nama database
- `USE inventaris_db`: Memilih database yang akan digunakan

### Bagian 2: Membuat Tabel Users
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
**Penjelasan:**

#### Kolom id:
- `INT`: Tipe data integer (angka bulat)
- `AUTO_INCREMENT`: Otomatis bertambah 1,2,3,4... setiap insert data baru
- `PRIMARY KEY`: Kunci utama, harus unik dan tidak boleh NULL

#### Kolom username:
- `VARCHAR(50)`: Tipe data string maksimal 50 karakter
- `NOT NULL`: Wajib diisi, tidak boleh kosong
- `UNIQUE`: Harus unik, tidak boleh duplikat

#### Kolom password:
- `VARCHAR(255)`: String 255 karakter untuk menyimpan hash password
- Kenapa 255? Hash bcrypt menghasilkan 60 karakter, 255 untuk antisipasi algoritma baru

#### Kolom email:
- `VARCHAR(100)`: String 100 karakter
- `NOT NULL UNIQUE`: Wajib diisi dan harus unik

#### Kolom created_at:
- `TIMESTAMP`: Tipe data tanggal dan waktu
- `DEFAULT CURRENT_TIMESTAMP`: Otomatis diisi dengan waktu saat data dibuat

#### Kolom updated_at:
- `ON UPDATE CURRENT_TIMESTAMP`: Otomatis update waktu setiap kali data diubah

### Bagian 3: Insert Data Default
```sql
INSERT INTO users (username, password, email, nama_lengkap) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'admin@example.com', 'Administrator'),
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'user1@example.com', 'User Pertama');
```
**Penjelasan:**
- `INSERT INTO users`: Menambah data ke tabel users
- Kolom yang diisi: username, password, email, nama_lengkap
- Kolom id, created_at, updated_at tidak perlu diisi (otomatis)
- Password yang di-insert sudah dalam bentuk hash
- Password asli untuk kedua user: admin123 dan user123

### Penjelasan Hash Password:
```
$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
│ │  │  └─────────────────────────────────────────────────────┘
│ │  │                    Hash Result (31 chars)
│ │  │
│ │  └── Salt (22 chars)
│ │
│ └───── Cost Parameter (10 = 2^10 iterations)
│
└────────── Algorithm ($2y = bcrypt)
```

---

## 9. Flow Chart Sistem Login Lengkap

```
START
  ↓
User Membuka Website
  ↓
Cek Session (index.php)
  ├─ Session Ada? → Tampilkan Halaman Inventaris
  │                 ↓
  │                 User Klik Logout
  │                 ↓
  │                 session_destroy()
  │                 ↓
  │                 Redirect ke login.php
  │
  └─ Session Tidak Ada?
      ↓
      Redirect ke login.php
      ↓
      ┌─────────────────────────┐
      │   Halaman Login         │
      │                         │
      │  - User input username  │
      │  - User input password  │
      │  - Klik tombol Login    │
      └─────────────────────────┘
      ↓
      Query Database
      ↓
      ┌──────────────────────────────────┐
      │ SELECT * FROM users              │
      │ WHERE username = ?               │
      └──────────────────────────────────┘
      ↓
      User Ditemukan?
      ├─ TIDAK → Tampilkan Error → Kembali ke Form Login
      │
      └─ YA
          ↓
          password_verify(input, hash_dari_db)
          ↓
          Password Cocok?
          ├─ TIDAK → Tampilkan Error → Kembali ke Form Login
          │
          └─ YA
              ↓
              Simpan ke Session:
              - $_SESSION['user_id']
              - $_SESSION['username']
              - $_SESSION['nama_lengkap']
              ↓
              Redirect ke index.php
              ↓
              User Berhasil Login
              ↓
              Bisa Akses Sistem Inventaris
              ↓
              Klik Logout → Kembali ke Awal
```

---

## 10. Best Practices Keamanan

### 1. Gunakan Prepared Statements
```php
// Tidak aman (vulnerable to SQL injection)
$query = "SELECT * FROM users WHERE username = '$username'";

// Aman (menggunakan prepared statement)
$stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
```

### 2. Validasi Input
```php
// Validasi di sisi server, jangan hanya di HTML
if (empty($username) || empty($password)) {
    $error = "Semua field harus diisi!";
}

if (strlen($password) < 8) {
    $error = "Password minimal 8 karakter!";
}
```

### 3. HTTPS
- Gunakan HTTPS untuk enkripsi data saat transfer
- Password tidak akan terlihat di network traffic

### 4. Session Security
```php
// Regenerate session ID setelah login
session_regenerate_id(true);

// Set session timeout
ini_set('session.gc_maxlifetime', 3600); // 1 jam
```

### 5. Password Policy
- Minimal 8 karakter
- Kombinasi huruf besar, kecil, angka, dan simbol
- Tidak boleh sama dengan username

---

## 11. Troubleshooting

### Error: Headers already sent
**Penyebab:** Ada output (spasi, HTML) sebelum session_start() atau header()
**Solusi:** Pastikan tidak ada output sebelum <?php

### Error: Cannot modify header information
**Penyebab:** Sama dengan di atas, atau ada echo sebelum redirect
**Solusi:** Gunakan exit() setelah header()

### Password tidak cocok saat login
**Penyebab:** Password di database tidak ter-hash dengan benar
**Solusi:** 
```php
// Generate hash baru
$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo $hash; // Copy ke database
```

### Session tidak tersimpan
**Penyebab:** session_start() tidak dipanggil
**Solusi:** Pastikan session_start() ada di setiap halaman yang menggunakan session

---

## 12. Kesimpulan

### Yang Telah Dipelajari:
1. ✅ Perbedaan Authentication dan Authorization
2. ✅ Cara kerja Session di PHP
3. ✅ Alur lengkap sistem login
4. ✅ Enkripsi password dengan bcrypt
5. ✅ Implementasi register dan login
6. ✅ Proteksi halaman dengan session
7. ✅ Logout dan destroy session
8. ✅ Struktur database untuk sistem login

### Konsep Penting:
- **Session** menyimpan data user di server
- **password_hash()** untuk enkripsi password saat register
- **password_verify()** untuk verifikasi password saat login
- **mysqli_real_escape_string()** untuk mencegah SQL injection
- **session_destroy()** untuk logout

### Next Level:
- Implementasi "Remember Me" dengan cookies
- Two-Factor Authentication (2FA)
- OAuth Login (Google, Facebook)
- Role-based Access Control (RBAC)
- Password Reset via Email

---

**Dibuat untuk keperluan pembelajaran**  
**Sistem Inventaris Barang dengan PHP & MySQL**
