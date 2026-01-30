# 📚 DOKUMENTASI SISTEM INVENTARIS BARANG

## 📋 Daftar Isi
- [Pengenalan Projek](#pengenalan-projek)
- [Struktur Projek](#struktur-projek)
- [Database](#database)
- [File Koneksi](#file-koneksi)
- [Sistem Authentication](#sistem-authentication)
- [Halaman Utama](#halaman-utama)
- [Halaman Transaksi](#halaman-transaksi)
- [Styling](#styling)

---

## 🎯 Pengenalan Projek

Sistem Inventaris Barang adalah aplikasi web sederhana untuk mengelola data barang dan transaksi keluar-masuk barang. Dibuat menggunakan PHP native dan MySQL.

**Fitur Utama:**
- Login & Register dengan password terenkripsi
- CRUD Data Barang (Create, Read, Update, Delete)
- CRUD Transaksi (Barang Masuk/Keluar)
- Update stok otomatis saat transaksi
- Desain responsif untuk mobile & desktop

---

## 📁 Struktur Projek

```
pertemuan13/
├── sample/
│   ├── index.php              # Halaman data barang
│   ├── transaksi.php          # Halaman transaksi
│   ├── login.php              # Halaman login
│   ├── register.php           # Halaman registrasi
│   ├── logout.php             # Proses logout
│   ├── koneksi.php            # Koneksi database
│   ├── proses.php             # Proses CRUD barang
│   ├── proses_transaksi.php   # Proses CRUD transaksi
│   └── styles/
│       ├── style.css          # CSS halaman utama
│       └── login.css          # CSS login & register
└── inventaris_db.sql          # File database
```

---

## 🗄️ Database

### Struktur Database `inventaris_db`

#### Tabel `users` - Data Pengguna
```sql
id              INT         # ID user (auto increment)
username        VARCHAR(50) # Username unik untuk login
password        VARCHAR(255)# Password terenkripsi
email           VARCHAR(100)# Email user
nama_lengkap    VARCHAR(100)# Nama lengkap user
created_at      TIMESTAMP   # Waktu registrasi
updated_at      TIMESTAMP   # Waktu update terakhir
```

**Penjelasan:**
- `id`: Nomor unik untuk setiap user, dibuat otomatis
- `password`: Disimpan dalam bentuk hash (bukan teks biasa) untuk keamanan
- `created_at`: Dicatat otomatis saat user mendaftar
- `updated_at`: Diperbarui otomatis saat data user berubah

#### Tabel `items` - Data Barang
```sql
id              INT         # ID barang (auto increment)
kode_barang     VARCHAR(50) # Kode unik barang (contoh: BRG001)
nama_barang     VARCHAR(100)# Nama barang
kategori        VARCHAR(100)# Kategori barang
lokasi          VARCHAR(100)# Lokasi penyimpanan
jumlah          INT         # Stok barang saat ini
kondisi         VARCHAR(20) # Kondisi: Baik/Rusak
tanggal_masuk   DATE        # Tanggal barang pertama masuk
harga_satuan    DECIMAL(10,2)# Harga per unit (optional)
```

**Penjelasan:**
- `jumlah`: Stok yang akan otomatis berubah saat ada transaksi
- `kondisi`: Hanya menerima nilai "Baik" atau "Rusak"
- `harga_satuan`: Bisa kosong (default 0.00)

#### Tabel `transactions` - Data Transaksi
```sql
id                  INT         # ID transaksi (auto increment)
item_id             INT         # ID barang (foreign key ke items)
jenis_transaksi     ENUM        # Jenis: 'masuk' atau 'keluar'
jumlah              INT         # Jumlah barang yang ditransaksikan
tanggal_transaksi   DATE        # Tanggal transaksi terjadi
keterangan          TEXT        # Catatan tambahan
penanggung_jawab    VARCHAR(100)# Nama penanggung jawab
```

**Penjelasan:**
- `item_id`: Menghubungkan transaksi dengan barang tertentu
- `jenis_transaksi`: Hanya bisa "masuk" (stok +) atau "keluar" (stok -)
- Foreign key memastikan transaksi hanya bisa dibuat untuk barang yang ada

---

## 🔌 File Koneksi

### `koneksi.php` - Koneksi ke Database

```php
<?php
  $host = "localhost";      // Alamat server database
  $user = "root";           // Username database
  $password = "";           // Password database (kosong untuk XAMPP default)
  $database = "inventaris_db"; // Nama database yang digunakan

  // Membuat koneksi ke database
  $koneksi = mysqli_connect($host, $user, $password, $database);

  // Cek apakah koneksi berhasil
  if ($koneksi) {
    // Koneksi berhasil (kode sukses)
  } else {
    // Jika gagal, tampilkan error dan hentikan program
    die("Koneksi gagal: " . mysqli_connect_error());
  }
?>
```

**Penjelasan Step by Step:**

1. **Variabel Koneksi**
   - `$host`: Lokasi server database (localhost = komputer sendiri)
   - `$user`: Username untuk masuk ke database
   - `$password`: Password database (kosong di XAMPP)
   - `$database`: Nama database yang akan digunakan

2. **mysqli_connect()**
   - Fungsi untuk membuat koneksi ke MySQL
   - Menerima 4 parameter: host, user, password, database
   - Mengembalikan objek koneksi jika berhasil

3. **Pengecekan Koneksi**
   - `if ($koneksi)`: Jika koneksi berhasil
   - `die()`: Hentikan program dan tampilkan pesan error jika gagal

---

## 🔐 Sistem Authentication

### `register.php` - Halaman Registrasi

#### Bagian PHP (Backend)

```php
<?php
session_start(); // Memulai session untuk menyimpan data login

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Jika sudah login, langsung ke halaman utama
    exit();
}

include 'koneksi.php'; // Memanggil file koneksi database

$error = "";    // Variabel untuk menyimpan pesan error
$success = "";  // Variabel untuk menyimpan pesan sukses
```

**Penjelasan:**
- `session_start()`: Wajib dipanggil di awal untuk menggunakan session
- `isset($_SESSION['user_id'])`: Mengecek apakah user sudah login
- `header("Location: ...")`: Mengarahkan user ke halaman lain
- `exit()`: Menghentikan eksekusi kode setelah redirect

#### Proses Registrasi

```php
if (isset($_POST['register'])) {
    // Ambil data dari form dan amankan dari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
```

**Penjelasan:**
- `isset($_POST['register'])`: Cek apakah form sudah disubmit
- `mysqli_real_escape_string()`: Mengamankan input dari SQL Injection
- `$_POST['nama_field']`: Mengambil data dari form HTML

#### Validasi Input

```php
    // Validasi password
    if ($password !== $confirm_password) {
        $error = "Password tidak sama!";
    } else if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    }
```

**Penjelasan:**
- `!==`: Operator untuk membandingkan (tidak sama dengan)
- `strlen()`: Menghitung panjang string
- Validasi memastikan password aman dan sesuai

#### Cek Username/Email yang Sudah Ada

```php
    else {
        // Cek apakah username atau email sudah terdaftar
        $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $check_result = mysqli_query($koneksi, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username atau email sudah terdaftar!";
        }
```

**Penjelasan:**
- `SELECT * FROM users WHERE ...`: Query untuk mencari data user
- `OR`: Operator untuk kondisi "atau"
- `mysqli_num_rows()`: Menghitung jumlah baris hasil query
- Jika > 0 berarti username/email sudah ada

#### Enkripsi Password & Insert Data

```php
        else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert data user baru ke database
            $query = "INSERT INTO users (username, password, email, nama_lengkap) 
                      VALUES ('$username', '$hashed_password', '$email', '$nama_lengkap')";
            
            if (mysqli_query($koneksi, $query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan: " . mysqli_error($koneksi);
            }
        }
    }
}
?>
```

**Penjelasan:**
- `password_hash()`: Mengenkripsi password (tidak bisa dikembalikan ke aslinya)
- `PASSWORD_DEFAULT`: Algoritma enkripsi terbaik saat ini (bcrypt)
- `INSERT INTO ... VALUES`: Query untuk menambah data baru
- `mysqli_query()`: Menjalankan query ke database
- `mysqli_error()`: Menampilkan pesan error dari database

---

### `login.php` - Halaman Login

#### Proses Login

```php
if (isset($_POST['login'])) {
    // Ambil input dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    
    // Cari user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
```

**Penjelasan:**
- Mencari user di database berdasarkan username
- `SELECT *`: Mengambil semua kolom dari tabel

#### Verifikasi Password

```php
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password yang diinput dengan hash di database
        if (password_verify($password, $user['password'])) {
            // Simpan data user ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
```

**Penjelasan:**
- `mysqli_fetch_assoc()`: Mengambil data hasil query sebagai array
- `password_verify()`: Membandingkan password input dengan hash di database
- `$_SESSION['key'] = value`: Menyimpan data ke session
- Session ini akan digunakan untuk mengecek login di halaman lain

---

### `logout.php` - Proses Logout

```php
<?php
session_start();          // Mulai session
session_destroy();        // Hancurkan semua data session
header("Location: login.php"); // Kembali ke halaman login
exit();
?>
```

**Penjelasan:**
- `session_destroy()`: Menghapus semua data session (logout)
- User harus login lagi untuk mengakses halaman yang dilindungi

---

## 🏠 Halaman Utama

### `index.php` - Halaman Data Barang

#### Proteksi Halaman

```php
<?php
  session_start();
  
  // Cek apakah user sudah login
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Jika belum login, paksa ke halaman login
    exit();
  }
  
  include 'koneksi.php';
```

**Penjelasan:**
- `!isset()`: NOT (kebalikan) dari isset - jika tidak ada/set
- Proteksi ini memastikan hanya user yang login bisa akses halaman ini

#### Inisialisasi Variabel

```php
  $id = "";
  $kode_barang = "";
  $nama_barang = "";
  // ... variabel lainnya
```

**Penjelasan:**
- Variabel diinisialisasi kosong untuk form
- Akan diisi jika ada proses edit

#### Mode Edit

```php
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = "SELECT * FROM items WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    // Isi variabel dengan data dari database
    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    // ... data lainnya
  }
```

**Penjelasan:**
- `$_GET['edit']`: Mengambil parameter dari URL (contoh: index.php?edit=5)
- Jika ada parameter edit, ambil data dari database
- Data ini akan ditampilkan di form untuk diedit

#### Notifikasi Sukses/Error

```php
  if (isset($_GET['success'])) {
    $pesan = $_GET['success'];
    echo "<script>alert('$pesan');</script>";
  }
```

**Penjelasan:**
- Menampilkan pesan sukses/error setelah proses CRUD
- Menggunakan JavaScript `alert()` untuk popup notifikasi

#### Header & Navigasi (HTML)

```html
<div class="header">
    <h2>SISTEM INVENTARIS BARANG</h2>
    <div class="user-info">
        <span>Selamat datang, <strong><?= $_SESSION['nama_lengkap']; ?></strong></span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="nav-menu">
    <a href="index.php" class="active">Data Barang</a>
    <a href="transaksi.php">Transaksi</a>
</div>
```

**Penjelasan:**
- `<?= ... ?>`: Shorthand untuk `<?php echo ... ?>`
- Menampilkan nama user dari session
- Class `active` memberikan highlight pada menu yang sedang dibuka

#### Form Input/Edit

```html
<form action="proses.php" method="POST">
    <input type="hidden" name="id" value="<?= $id; ?>">
```

**Penjelasan:**
- `action="proses.php"`: Form akan dikirim ke file proses.php
- `method="POST"`: Data dikirim secara POST (tidak terlihat di URL)
- `type="hidden"`: Input tersembunyi untuk menyimpan ID saat edit

#### Form dengan Grid Layout

```html
<div class="form-row">
    <div class="form-group">
        <label for="kode_barang">Kode Barang:</label>
        <input type="text" id="kode_barang" name="kode_barang" 
               value="<?= $kode_barang; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" 
               value="<?= $nama_barang; ?>" required>
    </div>
</div>
```

**Penjelasan:**
- `form-row`: Container dengan CSS grid untuk 2 kolom
- `for="id"`: Label dikaitkan dengan input (klik label = fokus input)
- `value="<?= $var ?>"`: Menampilkan value saat mode edit
- `required`: Validasi HTML5 - field wajib diisi

#### Select/Dropdown

```html
<select id="kondisi" name="kondisi" required>
    <option value="">-- Pilih Kondisi --</option>
    <option value="Baik" <?= ($kondisi == "Baik") ? "selected" : ""; ?>>Baik</option>
    <option value="Rusak" <?= ($kondisi == "Rusak") ? "selected" : ""; ?>>Rusak</option>
</select>
```

**Penjelasan:**
- `<option value="">`: Option pertama sebagai placeholder
- `($kondisi == "Baik") ? "selected" : ""`: Ternary operator
  - Jika kondisi = "Baik", tambahkan atribut `selected`
  - Jika tidak, kosongkan
- `selected`: Membuat option terpilih secara default

#### Tombol Submit Dinamis

```html
<button type="submit" name="<?= $id ? 'update' : 'simpan'; ?>" class="btn btn-primary">
    <?= $id ? 'Update Data' : 'Simpan Data'; ?>
</button>

<?php if ($id): ?>
    <a href="index.php" class="btn btn-danger">Batal</a>
<?php endif; ?>
```

**Penjelasan:**
- `$id ? 'update' : 'simpan'`: Ternary operator
  - Jika `$id` ada (mode edit) = name "update"
  - Jika tidak (mode tambah) = name "simpan"
- Tombol Batal hanya muncul saat mode edit
- `if ($id):` dan `endif;`: Alternatif syntax untuk if di HTML

#### Tabel Data

```php
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <!-- kolom lainnya -->
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM items ORDER BY id DESC";
        $result = mysqli_query($koneksi, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                // Tentukan class badge berdasarkan kondisi
                $kondisi_class = $row['kondisi'] == 'Baik' ? 'badge-success' : 'badge-danger';
                
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['kode_barang'] . "</td>";
                echo "<td>" . $row['nama_barang'] . "</td>";
                echo "<td><span class='badge " . $kondisi_class . "'>" . $row['kondisi'] . "</span></td>";
                echo "<td>" . date('d/m/Y', strtotime($row['tanggal_masuk'])) . "</td>";
                echo "<td>
                        <a href='index.php?edit=" . $row['id'] . "' class='btn btn-edit'>Edit</a>
                        <a href='proses.php?hapus=" . $row['id'] . "' class='btn btn-delete' 
                           onclick='return confirm(\"Yakin ingin menghapus?\");'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center'>Tidak ada data</td></tr>";
        }
        ?>
    </tbody>
</table>
```

**Penjelasan:**
- `ORDER BY id DESC`: Urutkan dari ID terbesar (data terbaru di atas)
- `while ($row = mysqli_fetch_assoc($result))`: Loop untuk setiap baris data
- `$no++`: Increment nomor urut setelah digunakan
- `date('d/m/Y', strtotime(...))`: Format tanggal menjadi dd/mm/yyyy
- `onclick='return confirm(...)'`: Konfirmasi sebelum hapus
- `colspan='9'`: Cell yang membentang 9 kolom (untuk pesan "tidak ada data")

---

### `proses.php` - Proses CRUD Data Barang

#### CREATE - Tambah Data

```php
if(isset($_POST['simpan'])) {
  // Ambil semua data dari form
  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $kategori = $_POST['kategori'];
  $lokasi = $_POST['lokasi'];
  $jumlah = $_POST['jumlah'];
  $kondisi = $_POST['kondisi'];
  $tanggal_masuk = $_POST['tanggal_masuk'];

  // Query INSERT untuk menambah data baru
  $query = "INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) 
            VALUES ('$kode_barang', '$nama_barang', '$kategori', '$lokasi', '$jumlah', '$kondisi', '$tanggal_masuk')";

  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil ditambahkan!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}
```

**Penjelasan:**
- `INSERT INTO tabel (kolom1, kolom2) VALUES (nilai1, nilai2)`: Syntax SQL untuk insert
- Query berhasil = redirect dengan pesan sukses
- Query gagal = redirect dengan pesan error
- `mysqli_error()`: Menampilkan detail error dari MySQL

#### UPDATE - Edit Data

```php
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $kode_barang = $_POST['kode_barang'];
  // ... ambil data lainnya

  // Query UPDATE untuk mengubah data existing
  $query = "UPDATE items SET 
            kode_barang='$kode_barang', 
            nama_barang='$nama_barang', 
            kategori='$kategori', 
            lokasi='$lokasi', 
            jumlah='$jumlah', 
            kondisi='$kondisi', 
            tanggal_masuk='$tanggal_masuk' 
            WHERE id=$id";
  
  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil diperbarui!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}
```

**Penjelasan:**
- `UPDATE tabel SET kolom='nilai' WHERE kondisi`: Syntax SQL untuk update
- `WHERE id=$id`: Kondisi untuk update data spesifik (berdasarkan ID)
- PENTING: Tanpa WHERE, semua data akan ter-update

#### DELETE - Hapus Data

```php
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  // Query DELETE untuk menghapus data
  $query = "DELETE FROM items WHERE id=$id";

  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil dihapus!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}
```

**Penjelasan:**
- `DELETE FROM tabel WHERE kondisi`: Syntax SQL untuk delete
- Menggunakan `$_GET` karena dipanggil dari link, bukan form
- PENTING: Tanpa WHERE, semua data akan terhapus

---

## 📦 Halaman Transaksi

### `transaksi.php` - Halaman Transaksi

#### Form Select Barang dengan Data dari Database

```php
<select id="item_id" name="item_id" required>
    <option value="">-- Pilih Barang --</option>
    <?php
    $query_items = "SELECT id, kode_barang, nama_barang FROM items ORDER BY nama_barang";
    $result_items = mysqli_query($koneksi, $query_items);
    while ($item = mysqli_fetch_assoc($result_items)) {
        $selected = ($item_id == $item['id']) ? "selected" : "";
        echo "<option value='" . $item['id'] . "' $selected>" 
             . $item['kode_barang'] . " - " . $item['nama_barang'] . "</option>";
    }
    ?>
</select>
```

**Penjelasan:**
- Query mengambil semua barang dari tabel items
- Loop `while` membuat option untuk setiap barang
- `value=id`: Value yang dikirim adalah ID barang
- Teks yang ditampilkan: Kode + Nama barang
- `$selected`: Menandai option yang dipilih saat edit

#### Select Jenis Transaksi

```html
<select id="jenis_transaksi" name="jenis_transaksi" required>
    <option value="">-- Pilih Jenis --</option>
    <option value="masuk" <?= ($jenis_transaksi == "masuk") ? "selected" : ""; ?>>
        Barang Masuk
    </option>
    <option value="keluar" <?= ($jenis_transaksi == "keluar") ? "selected" : ""; ?>>
        Barang Keluar
    </option>
</select>
```

**Penjelasan:**
- `value="masuk"`: Value yang akan disimpan ke database
- Teks "Barang Masuk": Label yang ditampilkan ke user
- Masuk = stok bertambah, Keluar = stok berkurang

#### Textarea untuk Keterangan

```html
<textarea id="keterangan" name="keterangan"><?= $keterangan; ?></textarea>
```

**Penjelasan:**
- `<textarea>`: Input multi-baris untuk teks panjang
- Value ditulis di antara tag pembuka dan penutup (bukan di atribut)
- Field optional (tidak ada atribut `required`)

#### Tabel dengan JOIN

```php
$query = "SELECT t.*, i.nama_barang, i.kode_barang 
          FROM transactions t 
          JOIN items i ON t.item_id = i.id 
          ORDER BY t.id DESC";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Tentukan class & text berdasarkan jenis transaksi
        $jenis_class = $row['jenis_transaksi'] == 'masuk' ? 'badge-success' : 'badge-danger';
        $jenis_text = $row['jenis_transaksi'] == 'masuk' ? 'Masuk' : 'Keluar';
        
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nama_barang'] . "</td>";
        echo "<td><span class='badge " . $jenis_class . "'>" . $jenis_text . "</span></td>";
        // ... kolom lainnya
    }
}
```

**Penjelasan:**
- `JOIN`: Menggabungkan 2 tabel berdasarkan relasi
- `t.*`: Ambil semua kolom dari tabel transactions (alias t)
- `i.nama_barang`: Ambil kolom nama_barang dari tabel items (alias i)
- `ON t.item_id = i.id`: Kondisi JOIN (item_id di transactions = id di items)
- Badge hijau untuk masuk, merah untuk keluar

---

### `proses_transaksi.php` - Proses CRUD Transaksi

#### CREATE - Tambah Transaksi dengan Update Stok

```php
if(isset($_POST['simpan'])) {
    $item_id = $_POST['item_id'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $jumlah = $_POST['jumlah'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);

    // 1. Insert transaksi ke database
    $query = "INSERT INTO transactions (item_id, jenis_transaksi, jumlah, tanggal_transaksi, keterangan, penanggung_jawab) 
              VALUES ('$item_id', '$jenis_transaksi', '$jumlah', '$tanggal_transaksi', '$keterangan', '$penanggung_jawab')";

    if (mysqli_query($koneksi, $query)) {
        // 2. Update stok barang otomatis
        if ($jenis_transaksi == 'masuk') {
            // Jika barang masuk, stok bertambah (+)
            $update_query = "UPDATE items SET jumlah = jumlah + $jumlah WHERE id = $item_id";
        } else {
            // Jika barang keluar, stok berkurang (-)
            $update_query = "UPDATE items SET jumlah = jumlah - $jumlah WHERE id = $item_id";
        }
        mysqli_query($koneksi, $update_query);
        
        header("Location: transaksi.php?success=Transaksi berhasil ditambahkan!");
    }
}
```

**Penjelasan:**
- Proses dilakukan dalam 2 langkah:
  1. Insert data transaksi
  2. Update stok barang sesuai jenis transaksi
- `jumlah = jumlah + $jumlah`: Stok saat ini + jumlah transaksi
- `jumlah = jumlah - $jumlah`: Stok saat ini - jumlah transaksi
- Menggunakan operator matematika langsung di query SQL

#### UPDATE - Edit Transaksi (3 Langkah)

```php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    // ... ambil data lainnya

    // LANGKAH 1: Ambil data transaksi lama
    $old_query = "SELECT * FROM transactions WHERE id = $id";
    $old_result = mysqli_query($koneksi, $old_query);
    $old_data = mysqli_fetch_assoc($old_result);

    // LANGKAH 2: Kembalikan stok sesuai transaksi lama
    if ($old_data['jenis_transaksi'] == 'masuk') {
        // Jika dulu masuk, kembalikan dengan mengurangi stok
        $revert_query = "UPDATE items SET jumlah = jumlah - " . $old_data['jumlah'] 
                        . " WHERE id = " . $old_data['item_id'];
    } else {
        // Jika dulu keluar, kembalikan dengan menambah stok
        $revert_query = "UPDATE items SET jumlah = jumlah + " . $old_data['jumlah'] 
                        . " WHERE id = " . $old_data['item_id'];
    }
    mysqli_query($koneksi, $revert_query);

    // LANGKAH 3: Update data transaksi
    $query = "UPDATE transactions SET 
              item_id='$item_id', 
              jenis_transaksi='$jenis_transaksi', 
              jumlah='$jumlah', 
              tanggal_transaksi='$tanggal_transaksi', 
              keterangan='$keterangan', 
              penanggung_jawab='$penanggung_jawab' 
              WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        // LANGKAH 4: Terapkan stok baru
        if ($jenis_transaksi == 'masuk') {
            $new_query = "UPDATE items SET jumlah = jumlah + $jumlah WHERE id = $item_id";
        } else {
            $new_query = "UPDATE items SET jumlah = jumlah - $jumlah WHERE id = $item_id";
        }
        mysqli_query($koneksi, $new_query);
        
        header("Location: transaksi.php?success=Transaksi berhasil diperbarui!");
    }
}
```

**Penjelasan Kenapa 4 Langkah:**
1. **Ambil data lama**: Untuk tahu transaksi sebelumnya seperti apa
2. **Revert stok**: Kembalikan stok ke kondisi sebelum transaksi lama
   - Contoh: Dulu masuk +10, sekarang stok dikurangi 10
3. **Update transaksi**: Simpan data transaksi yang baru
4. **Terapkan stok baru**: Ubah stok sesuai transaksi baru
   - Contoh: Sekarang keluar -5, maka stok dikurangi 5

**Ilustrasi:**
```
Stok awal: 100
Transaksi lama: Masuk +10 → Stok jadi 110
Edit transaksi: Keluar -5
  - Revert: 110 - 10 = 100 (kembali ke stok awal)
  - Apply new: 100 - 5 = 95 (stok akhir)
```

#### DELETE - Hapus Transaksi dengan Kembalikan Stok

```php
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // 1. Ambil data transaksi yang akan dihapus
    $trans_query = "SELECT * FROM transactions WHERE id = $id";
    $trans_result = mysqli_query($koneksi, $trans_query);
    $trans_data = mysqli_fetch_assoc($trans_result);

    // 2. Kembalikan stok sebelum hapus transaksi
    if ($trans_data['jenis_transaksi'] == 'masuk') {
        // Jika transaksi masuk, kembalikan dengan mengurangi stok
        $update_query = "UPDATE items SET jumlah = jumlah - " . $trans_data['jumlah'] 
                        . " WHERE id = " . $trans_data['item_id'];
    } else {
        // Jika transaksi keluar, kembalikan dengan menambah stok
        $update_query = "UPDATE items SET jumlah = jumlah + " . $trans_data['jumlah'] 
                        . " WHERE id = " . $trans_data['item_id'];
    }
    mysqli_query($koneksi, $update_query);

    // 3. Hapus transaksi dari database
    $query = "DELETE FROM transactions WHERE id=$id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: transaksi.php?success=Transaksi berhasil dihapus!");
    }
}
```

**Penjelasan:**
- Sebelum hapus transaksi, stok harus dikembalikan
- Kebalikan dari saat insert:
  - Transaksi masuk dulu = stok dikurangi saat hapus
  - Transaksi keluar dulu = stok ditambah saat hapus
- Baru setelah stok dikembalikan, transaksi dihapus

---

## 🎨 Styling

### `style.css` - CSS Halaman Utama & Transaksi

#### Reset & Base Styles

```css
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
```

**Penjelasan:**
- `*`: Selector universal (semua elemen)
- `margin: 0; padding: 0;`: Reset default margin & padding browser
- `box-sizing: border-box;`: Padding & border masuk dalam width/height

#### Body Layout

```css
body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    padding: 20px;
}
```

**Penjelasan:**
- `font-family`: Font yang digunakan
- `background`: Warna background abu-abu muda
- `padding`: Jarak di tepi halaman

#### Container

```css
.container {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
```

**Penjelasan:**
- `max-width`: Lebar maksimal 1200px
- `margin: 0 auto;`: Center horizontal (auto = otomatis kiri-kanan)
- `border-radius`: Sudut melengkung
- `box-shadow`: Bayangan (x-offset, y-offset, blur, warna)
- `rgba(0,0,0,0.1)`: Hitam dengan transparansi 10%

#### Flexbox untuk Header

```css
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
```

**Penjelasan:**
- `display: flex`: Aktifkan flexbox
- `justify-content: space-between`: Item di ujung kiri & kanan
- `align-items: center`: Item rata tengah vertikal
- Layout: [Judul] ---------- [Info User + Logout]

#### Navigasi Menu

```css
.nav-menu {
    display: flex;
    gap: 10px;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 10px;
}

.nav-menu a {
    padding: 10px 20px;
    text-decoration: none;
    color: #555;
    border-radius: 4px;
}

.nav-menu a:hover {
    background: #f0f2f5;
    color: #1a73e8;
}

.nav-menu a.active {
    background: #1a73e8;
    color: white;
}
```

**Penjelasan:**
- `gap: 10px`: Jarak antar item flex
- `text-decoration: none`: Hilangkan underline link
- `:hover`: Style saat mouse di atas elemen
- `.active`: Class untuk menu yang sedang dibuka
- Warna biru (#1a73e8) adalah tema utama

#### Button Styles

```css
.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: #1a73e8;
    color: white;
}

.btn-primary:hover {
    background: #1557b0;
}
```

**Penjelasan:**
- `.btn`: Base class untuk semua button
- `.btn-primary`: Button biru utama
- `cursor: pointer`: Kursor berubah jadi tangan saat hover
- `display: inline-block`: Agar `<a>` bisa diberi padding

#### Form Grid Layout

```css
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}
```

**Penjelasan:**
- `display: grid`: Aktifkan CSS Grid
- `grid-template-columns: repeat(2, 1fr)`: 2 kolom dengan lebar sama
- `1fr`: 1 fraction (bagian) dari ruang available
- `gap: 15px`: Jarak antar kolom
- Layout: [Input 1] [Input 2]

#### Input Styles

```css
input[type="text"],
input[type="number"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #1a73e8;
}
```

**Penjelasan:**
- Selector dengan koma = style yang sama untuk banyak elemen
- `width: 100%`: Lebar penuh container
- `:focus`: Style saat input sedang aktif/diklik
- `outline: none`: Hilangkan default outline browser
- Border berubah biru saat fokus

#### Table Styles

```css
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #1a73e8;
    color: white;
    padding: 12px 10px;
    text-align: left;
}

td {
    padding: 10px;
    border: 1px solid #ddd;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

tr:hover {
    background: #f0f2f5;
}
```

**Penjelasan:**
- `border-collapse: collapse`: Border tidak dobel/terpisah
- `:nth-child(even)`: Baris genap (2, 4, 6, ...)
- Menghasilkan zebra striping (baris bergantian warna)
- `tr:hover`: Background berubah saat mouse di atas baris

#### Badge/Label

```css
.badge {
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
}

.badge-success {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-danger {
    background: #ffebee;
    color: #c62828;
}
```

**Penjelasan:**
- Badge: Label kecil dengan background berwarna
- `-success`: Hijau untuk kondisi baik/masuk
- `-danger`: Merah untuk kondisi rusak/keluar
- Background dibuat lebih terang dari teks (kontras)

#### Responsive Design - Tablet

```css
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
```

**Penjelasan:**
- `@media (max-width: 768px)`: Style untuk layar ≤ 768px (tablet)
- `flex-direction: column`: Flex berubah vertikal (atas-bawah)
- `grid-template-columns: 1fr`: Grid jadi 1 kolom (input baris per baris)

#### Responsive Design - Mobile

```css
@media (max-width: 480px) {
    body {
        padding: 10px;
    }
    
    table {
        font-size: 12px;
    }
    
    th, td {
        padding: 6px 4px;
    }
}
```

**Penjelasan:**
- `@media (max-width: 480px)`: Style untuk layar ≤ 480px (mobile)
- Font & padding diperkecil agar muat di layar kecil
- Table tetap readable di mobile

---

### `login.css` - CSS untuk Login & Register

#### Centering Login Box

```css
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
```

**Penjelasan:**
- `min-height: 100vh`: Minimal tinggi 100% viewport height (tinggi layar)
- Flexbox dengan `justify-content` & `align-items` = center sempurna
- Login box akan selalu di tengah layar

#### Container Login/Register

```css
.login-container,
.register-container {
    background: white;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
}
```

**Penjelasan:**
- Style yang sama untuk login & register (DRY principle)
- `max-width: 400px`: Box tidak terlalu lebar
- Box putih dengan bayangan di background abu-abu

---

## 📝 Konsep Penting

### 1. Session Management

**Apa itu Session?**
- Cara menyimpan data user sementara di server
- Data tetap ada selama browser tidak ditutup
- Digunakan untuk sistem login

**Flow Session:**
```
Login → Session dibuat → Session dicek di setiap halaman → Logout → Session dihapus
```

**Fungsi Session:**
- `session_start()`: Mulai/lanjutkan session
- `$_SESSION['key']`: Simpan/ambil data session
- `session_destroy()`: Hapus semua data session

### 2. Password Security

**Hashing vs Encryption:**
- **Hashing**: Satu arah, tidak bisa dikembalikan (untuk password)
- **Encryption**: Dua arah, bisa dikembalikan (untuk data sensitif)

**Fungsi Password:**
- `password_hash($password, PASSWORD_DEFAULT)`: Enkripsi password
- `password_verify($input, $hash)`: Cek apakah password benar
- Hash yang sama dari input berbeda = TIDAK PERNAH SAMA

### 3. SQL Injection Prevention

**Bahaya SQL Injection:**
```php
// BAHAYA! Jangan seperti ini
$query = "SELECT * FROM users WHERE username = '$_POST[username]'";
// Input: admin' OR '1'='1
// Query jadi: SELECT * FROM users WHERE username = 'admin' OR '1'='1'
// Hasilnya: Login berhasil tanpa password!
```

**Solusi:**
```php
// AMAN! Gunakan ini
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$query = "SELECT * FROM users WHERE username = '$username'";
```

### 4. CRUD Operations

**CRUD = Create, Read, Update, Delete**

| Operasi | SQL Query | HTTP Method | Contoh |
|---------|-----------|-------------|--------|
| Create  | INSERT    | POST        | Tambah barang baru |
| Read    | SELECT    | GET         | Tampilkan daftar barang |
| Update  | UPDATE    | POST        | Edit data barang |
| Delete  | DELETE    | GET         | Hapus barang |

### 5. Relational Database

**Foreign Key:**
- `item_id` di tabel transactions adalah Foreign Key
- Menghubungkan transaksi dengan barang tertentu
- Tidak bisa menambah transaksi untuk barang yang tidak ada

**JOIN:**
- Menggabungkan data dari 2 tabel atau lebih
- Menampilkan nama barang di tabel transaksi (padahal tersimpan di tabel items)

### 6. Responsive Design

**Mobile-First Approach:**
1. Design untuk mobile dulu
2. Tambahkan fitur untuk layar lebih besar
3. Gunakan media query untuk breakpoint

**Breakpoint Umum:**
- Mobile: < 480px
- Tablet: 481px - 768px
- Desktop: > 768px

---

## 🚀 Cara Menjalankan Projek

### Persiapan

1. **Install XAMPP**
   - Download dari https://www.apachefriends.org
   - Install dan jalankan Apache + MySQL

2. **Import Database**
   - Buka phpMyAdmin (http://localhost/phpmyadmin)
   - Buat database baru: `inventaris_db`
   - Import file `inventaris_db.sql`

3. **Simpan Projek**
   - Copy folder `sample` ke `C:/xampp/htdocs/pertemuan13/`
   - Atau sesuaikan path di XAMPP Anda

### Menjalankan

1. Buka browser
2. Akses: `http://localhost/pertemuan13/sample/login.php`
3. Register akun baru
4. Login dengan akun yang dibuat
5. Mulai gunakan sistem inventaris

---

## 🔧 Troubleshooting

### Error: "Call to undefined function mysqli_connect()"
**Solusi:** Aktifkan extension mysqli di php.ini
```
;extension=mysqli  → Hapus tanda ; di depan
extension=mysqli
```

### Error: "Access denied for user 'root'@'localhost'"
**Solusi:** Periksa username/password di koneksi.php
```php
$user = "root";      // Sesuaikan dengan user MySQL Anda
$password = "";      // Sesuaikan dengan password MySQL Anda
```

### Error: "Table 'inventaris_db.items' doesn't exist"
**Solusi:** Import database inventaris_db.sql melalui phpMyAdmin

### Stok tidak update saat transaksi
**Solusi:** Periksa Foreign Key di database
```sql
ALTER TABLE transactions
ADD CONSTRAINT transactions_ibfk_1 
FOREIGN KEY (item_id) REFERENCES items (id);
```

### CSS tidak muncul
**Solusi:** Periksa path CSS di HTML
```html
<!-- Pastikan path ini benar -->
<link rel="stylesheet" href="styles/style.css">
```

---

## 📚 Resources Belajar Lebih Lanjut

### PHP
- [PHP Official Documentation](https://www.php.net/manual/en/)
- [W3Schools PHP Tutorial](https://www.w3schools.com/php/)

### MySQL
- [MySQL Tutorial](https://www.mysqltutorial.org/)
- [SQL for Beginners](https://www.w3schools.com/sql/)

### CSS
- [CSS Tricks](https://css-tricks.com/)
- [Flexbox Guide](https://css-tricks.com/snippets/css/a-guide-to-flexbox/)
- [Grid Guide](https://css-tricks.com/snippets/css/complete-guide-grid/)

### Security
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)

---

## ✅ Checklist Pengembangan Selanjutnya

Fitur yang bisa ditambahkan:
- [ ] Pagination untuk tabel (jika data banyak)
- [ ] Search & Filter data
- [ ] Export data ke Excel/PDF
- [ ] Upload foto barang
- [ ] Role management (Admin, User biasa)
- [ ] Log activity (siapa edit apa, kapan)
- [ ] Dashboard dengan chart/grafik
- [ ] Notifikasi stok menipis
- [ ] Barcode scanning
- [ ] API untuk mobile app

---

## 📞 Penutup

Dokumentasi ini dibuat untuk membantu Anda memahami setiap baris kode dalam projek Sistem Inventaris Barang. 

**Tips Belajar:**
1. Baca dokumentasi perlahan
2. Coba jalankan kodenya
3. Ubah sedikit dan lihat hasilnya
4. Jika error, baca pesan errornya dengan teliti
5. Google adalah teman terbaik developer!

**Happy Coding! 🚀**

---

*Dokumentasi ini untuk pembelajaran.*
*Last Updated: 23 Januari 2026*
