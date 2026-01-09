<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelajaran PHP - Syntax Basic</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .section {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #4a5568;
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        h2 {
            color: #667eea;
            margin-top: 0;
        }
        pre {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .output {
            background-color: #edf2f7;
            padding: 10px;
            border-left: 4px solid #667eea;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Materi Pembelajaran PHP - Syntax Basic</h1>

<?php
// ============================================
// 1. PENGENALAN PHP
// ============================================
echo '<div class="section">';
echo '<h2>1. Pengenalan PHP</h2>';
echo '<pre>';
echo '// PHP (Hypertext Preprocessor) adalah bahasa scripting server-side
// Kode PHP dieksekusi di server dan hasilnya dikirim ke browser
// PHP selalu dimulai dengan tag <?php dan diakhiri dengan ?>

// Cara menampilkan output:
echo "Ini menggunakan echo";
print "Ini menggunakan print";
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';
echo "Hello World dari PHP!<br>";
echo "Tanggal hari ini: " . date("d-m-Y");
echo '</div>';
echo '</div>';

// ============================================
// 2. VARIABEL DAN TIPE DATA
// ============================================
echo '<div class="section">';
echo '<h2>2. Variabel dan Tipe Data</h2>';
echo '<pre>';
echo '// Variabel di PHP dimulai dengan tanda $
// PHP adalah loosely typed (tidak perlu deklarasi tipe data)

// String (teks)
$nama = "Budi Santoso";
$alamat = \'Jakarta Selatan\';  // Bisa pakai single quote atau double quote

// Integer (bilangan bulat)
$umur = 25;
$jumlahSiswa = 30;

// Float/Double (bilangan desimal)
$tinggi = 175.5;
$berat = 68.3;

// Boolean (true/false)
$lulus = true;
$aktif = false;

// Array (kumpulan data)
$buah = array("Apel", "Jeruk", "Mangga");

// NULL (tidak ada nilai)
$kosong = null;
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

$nama = "Budi Santoso";
$umur = 25;
$tinggi = 175.5;
$lulus = true;

echo "Nama: $nama<br>";
echo "Umur: $umur tahun<br>";
echo "Tinggi: $tinggi cm<br>";
echo "Status Lulus: " . ($lulus ? "Ya" : "Tidak") . "<br>";
echo "Tipe data nama: " . gettype($nama) . "<br>";
echo "Tipe data umur: " . gettype($umur);
echo '</div>';
echo '</div>';

// ============================================
// 3. OPERATOR
// ============================================
echo '<div class="section">';
echo '<h2>3. Operator</h2>';
echo '<pre>';
echo '// OPERATOR ARITMATIKA
$a = 10;
$b = 3;

$tambah = $a + $b;      // Penjumlahan: 13
$kurang = $a - $b;      // Pengurangan: 7
$kali = $a * $b;        // Perkalian: 30
$bagi = $a / $b;        // Pembagian: 3.333...
$modulus = $a % $b;     // Sisa bagi: 1
$pangkat = $a ** $b;    // Perpangkatan: 1000

// OPERATOR PERBANDINGAN
$sama = ($a == $b);           // Sama dengan (false)
$identik = ($a === $b);       // Identik (nilai dan tipe sama)
$tidakSama = ($a != $b);      // Tidak sama dengan (true)
$lebihBesar = ($a > $b);      // Lebih besar (true)
$lebihKecil = ($a < $b);      // Lebih kecil (false)

// OPERATOR LOGIKA
$dan = (true && false);       // AND: false
$atau = (true || false);      // OR: true
$tidak = !true;               // NOT: false

// OPERATOR INCREMENT/DECREMENT
$x = 5;
$x++;  // $x menjadi 6 (increment)
$x--;  // $x menjadi 5 (decrement)
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

$a = 10;
$b = 3;
echo "a = $a, b = $b<br>";
echo "a + b = " . ($a + $b) . "<br>";
echo "a - b = " . ($a - $b) . "<br>";
echo "a * b = " . ($a * $b) . "<br>";
echo "a / b = " . ($a / $b) . "<br>";
echo "a % b = " . ($a % $b) . "<br>";
echo "a ** b = " . ($a ** $b) . "<br>";
echo "a > b = " . (($a > $b) ? 'true' : 'false');
echo '</div>';
echo '</div>';

// ============================================
// 4. CONDITIONAL STATEMENTS (IF-ELSE)
// ============================================
echo '<div class="section">';
echo '<h2>4. Conditional Statements (If-Else)</h2>';
echo '<pre>';
echo '// IF - ELSE IF - ELSE
$nilai = 85;

if ($nilai >= 90) {
    $grade = "A";
} elseif ($nilai >= 80) {
    $grade = "B";
} elseif ($nilai >= 70) {
    $grade = "C";
} elseif ($nilai >= 60) {
    $grade = "D";
} else {
    $grade = "E";
}

// SWITCH CASE
$hari = "Senin";

switch ($hari) {
    case "Senin":
        $kegiatan = "Meeting pagi";
        break;
    case "Selasa":
        $kegiatan = "Presentasi";
        break;
    case "Rabu":
        $kegiatan = "Workshop";
        break;
    default:
        $kegiatan = "Kerja normal";
}

// TERNARY OPERATOR (shorthand if-else)
$umur = 20;
$status = ($umur >= 18) ? "Dewasa" : "Anak-anak";
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

$nilai = 85;
if ($nilai >= 90) {
    $grade = "A";
} elseif ($nilai >= 80) {
    $grade = "B";
} elseif ($nilai >= 70) {
    $grade = "C";
} else {
    $grade = "D";
}

echo "Nilai: $nilai → Grade: $grade<br>";

$hari = "Senin";
switch ($hari) {
    case "Senin":
        $kegiatan = "Meeting pagi";
        break;
    case "Selasa":
        $kegiatan = "Presentasi";
        break;
    default:
        $kegiatan = "Kerja normal";
}
echo "Hari $hari → Kegiatan: $kegiatan<br>";

$umur = 20;
$status = ($umur >= 18) ? "Dewasa" : "Anak-anak";
echo "Umur $umur tahun → Status: $status";
echo '</div>';
echo '</div>';

// ============================================
// 5. LOOPS (PERULANGAN)
// ============================================
echo '<div class="section">';
echo '<h2>5. Loops (Perulangan)</h2>';
echo '<pre>';
echo '// FOR LOOP - untuk perulangan dengan jumlah iterasi tertentu
for ($i = 1; $i <= 5; $i++) {
    echo "Perulangan ke-$i<br>";
}

// WHILE LOOP - perulangan selama kondisi true
$j = 1;
while ($j <= 3) {
    echo "While loop: $j<br>";
    $j++;
}

// DO-WHILE LOOP - minimal dijalankan 1 kali
$k = 1;
do {
    echo "Do-while: $k<br>";
    $k++;
} while ($k <= 2);

// FOREACH - untuk iterasi array
$buah = ["Apel", "Jeruk", "Mangga"];
foreach ($buah as $item) {
    echo "Buah: $item<br>";
}

// FOREACH dengan key dan value
$siswa = ["nama" => "Andi", "umur" => 17];
foreach ($siswa as $key => $value) {
    echo "$key: $value<br>";
}
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

echo "<strong>For Loop:</strong><br>";
for ($i = 1; $i <= 5; $i++) {
    echo "Perulangan ke-$i<br>";
}

echo "<br><strong>While Loop:</strong><br>";
$j = 1;
while ($j <= 3) {
    echo "While loop: $j<br>";
    $j++;
}

echo "<br><strong>Foreach Array:</strong><br>";
$buah = ["Apel", "Jeruk", "Mangga", "Pisang"];
foreach ($buah as $index => $item) {
    echo ($index + 1) . ". $item<br>";
}
echo '</div>';
echo '</div>';

// ============================================
// 6. ARRAY
// ============================================
echo '<div class="section">';
echo '<h2>6. Array</h2>';
echo '<pre>';
echo '// INDEXED ARRAY (array dengan index numerik)
$warna = array("Merah", "Hijau", "Biru");
// atau
$warna = ["Merah", "Hijau", "Biru"];

// Akses elemen array
$warna[0];  // Merah
$warna[1];  // Hijau

// ASSOCIATIVE ARRAY (array dengan key custom)
$siswa = array(
    "nama" => "Dewi",
    "umur" => 18,
    "kelas" => "12 IPA"
);

// MULTIDIMENSIONAL ARRAY
$sekolah = array(
    array("Andi", 17, "11 IPA"),
    array("Budi", 18, "12 IPS"),
    array("Citra", 16, "10 IPA")
);

// FUNGSI-FUNGSI ARRAY
count($warna);              // Menghitung jumlah elemen
array_push($warna, "Kuning"); // Menambah elemen di akhir
array_pop($warna);          // Menghapus elemen terakhir
in_array("Merah", $warna);  // Cek apakah nilai ada
sort($warna);               // Mengurutkan array
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

$warna = ["Merah", "Hijau", "Biru", "Kuning"];
echo "<strong>Indexed Array:</strong><br>";
foreach ($warna as $index => $w) {
    echo "Index $index: $w<br>";
}

$siswa = array(
    "nama" => "Dewi Lestari",
    "umur" => 18,
    "kelas" => "12 IPA",
    "nilai" => 88
);
echo "<br><strong>Associative Array:</strong><br>";
foreach ($siswa as $key => $value) {
    echo ucfirst($key) . ": $value<br>";
}

$mahasiswa = array(
    array("nama" => "Andi", "umur" => 20),
    array("nama" => "Budi", "umur" => 21),
    array("nama" => "Citra", "umur" => 19)
);
echo "<br><strong>Multidimensional Array:</strong><br>";
foreach ($mahasiswa as $index => $mhs) {
    echo ($index + 1) . ". {$mhs['nama']} - {$mhs['umur']} tahun<br>";
}
echo '</div>';
echo '</div>';

// ============================================
// 7. FUNCTION (FUNGSI)
// ============================================
echo '<div class="section">';
echo '<h2>7. Function (Fungsi)</h2>';
echo '<pre>';
echo '// Fungsi tanpa parameter
function salam() {
    return "Halo, Selamat datang!";
}

// Fungsi dengan parameter
function tambah($a, $b) {
    return $a + $b;
}

// Fungsi dengan parameter default
function perkenalan($nama, $umur = 18) {
    return "Nama: $nama, Umur: $umur tahun";
}

// Fungsi dengan type hinting dan return type (PHP 7+)
function kali(int $a, int $b): int {
    return $a * $b;
}

// Memanggil fungsi
$hasil = tambah(5, 3);  // 8
$info = perkenalan("Andi");  // Nama: Andi, Umur: 18 tahun
$info2 = perkenalan("Budi", 20);  // Nama: Budi, Umur: 20 tahun
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

function salam() {
    return "Halo, Selamat datang! 👋";
}

function tambah($a, $b) {
    return $a + $b;
}

function perkenalan($nama, $umur = 18) {
    return "Nama: $nama, Umur: $umur tahun";
}

function luasSegitiga($alas, $tinggi) {
    $luas = 0.5 * $alas * $tinggi;
    return $luas;
}

echo salam() . "<br>";
echo "5 + 3 = " . tambah(5, 3) . "<br>";
echo perkenalan("Andi") . "<br>";
echo perkenalan("Budi", 20) . "<br>";
echo "Luas segitiga (alas=10, tinggi=8): " . luasSegitiga(10, 8) . " cm²";
echo '</div>';
echo '</div>';

// ============================================
// 8. STRING MANIPULATION
// ============================================
echo '<div class="section">';
echo '<h2>8. String Manipulation</h2>';
echo '<pre>';
echo '// Menggabungkan string (concatenation)
$namaDepan = "John";
$namaBelakang = "Doe";
$namaLengkap = $namaDepan . " " . $namaBelakang;

// String functions
strlen($teks);              // Panjang string
strtoupper($teks);          // Uppercase
strtolower($teks);          // Lowercase
ucwords($teks);             // Capitalize setiap kata
str_replace("a", "b", $txt); // Replace karakter
substr($teks, 0, 5);        // Ambil substring
strpos($teks, "cari");      // Cari posisi substring
trim($teks);                // Hapus spasi di awal/akhir
explode(" ", $teks);        // Pecah string menjadi array
implode(", ", $array);      // Gabungkan array menjadi string
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

$teks = "Belajar PHP itu Menyenangkan";
echo "Teks asli: $teks<br>";
echo "Panjang: " . strlen($teks) . " karakter<br>";
echo "Uppercase: " . strtoupper($teks) . "<br>";
echo "Lowercase: " . strtolower($teks) . "<br>";
echo "Replace 'PHP' dengan 'JavaScript': " . str_replace("PHP", "JavaScript", $teks) . "<br>";
echo "5 karakter pertama: " . substr($teks, 0, 5) . "<br>";

$kalimat = "Apel,Jeruk,Mangga,Pisang";
$arrayBuah = explode(",", $kalimat);
echo "Explode: ";
print_r($arrayBuah);
echo "<br>";
echo "Implode: " . implode(" - ", $arrayBuah);
echo '</div>';
echo '</div>';

// ============================================
// 9. SUPERGLOBALS
// ============================================
echo '<div class="section">';
echo '<h2>9. Superglobals (Variabel Global PHP)</h2>';
echo '<pre>';
echo '// $_SERVER - Informasi server dan environment
$_SERVER["SERVER_NAME"];     // Nama server
$_SERVER["HTTP_HOST"];       // Host name
$_SERVER["REQUEST_METHOD"];  // GET/POST
$_SERVER["SCRIPT_NAME"];     // Path file yang dijalankan

// $_GET - Data dari URL (query string)
// Contoh: page.php?nama=John&umur=25
$_GET["nama"];    // John
$_GET["umur"];    // 25

// $_POST - Data dari form method POST
// $_POST["username"];
// $_POST["password"];

// $_SESSION - Menyimpan data antar halaman
// session_start();
// $_SESSION["user"] = "John";

// $_COOKIE - Menyimpan data di browser
// setcookie("user", "John", time() + 3600);
// $_COOKIE["user"];
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

echo "Informasi Server:<br>";
echo "Server Name: " . $_SERVER["SERVER_NAME"] . "<br>";
echo "Script Name: " . $_SERVER["SCRIPT_NAME"] . "<br>";
echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
echo "User Agent: " . substr($_SERVER["HTTP_USER_AGENT"], 0, 50) . "...";
echo '</div>';
echo '</div>';

// ============================================
// 10. DATE & TIME
// ============================================
echo '<div class="section">';
echo '<h2>10. Date & Time</h2>';
echo '<pre>';
echo '// Fungsi date() untuk format tanggal dan waktu
date("d-m-Y");           // 02-01-2026
date("Y-m-d");           // 2026-01-02
date("l, d F Y");        // Thursday, 02 January 2026
date("H:i:s");           // 14:30:45 (jam:menit:detik)
date("d/m/Y H:i");       // 02/01/2026 14:30

// Fungsi time() - Unix timestamp
time();                  // 1735826400 (detik sejak 1 Jan 1970)

// strtotime() - Convert string ke timestamp
strtotime("next Monday");
strtotime("+1 week");
strtotime("2026-12-31");
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

echo "Tanggal sekarang (d-m-Y): " . date("d-m-Y") . "<br>";
echo "Tanggal sekarang (Y-m-d): " . date("Y-m-d") . "<br>";
echo "Tanggal lengkap: " . date("l, d F Y") . "<br>";
echo "Waktu sekarang: " . date("H:i:s") . "<br>";
echo "Tanggal & Waktu: " . date("d/m/Y H:i:s") . "<br>";
echo "Unix Timestamp: " . time() . "<br>";
echo "Besok: " . date("d-m-Y", strtotime("+1 day")) . "<br>";
echo "Minggu depan: " . date("d-m-Y", strtotime("+1 week"));
echo '</div>';
echo '</div>';

// ============================================
// 11. FILE HANDLING
// ============================================
echo '<div class="section">';
echo '<h2>11. File Handling (Dasar)</h2>';
echo '<pre>';
echo '// Membaca file
$isi = file_get_contents("file.txt");    // Baca seluruh isi file

// Menulis file (overwrite)
file_put_contents("file.txt", "Hello World");

// Menulis file (append/tambah)
file_put_contents("file.txt", "\\nBaris baru", FILE_APPEND);

// Cek apakah file ada
if (file_exists("file.txt")) {
    // File exists
}

// Membuka file dengan fopen()
$file = fopen("file.txt", "r");  // r=read, w=write, a=append
$content = fread($file, filesize("file.txt"));
fclose($file);

// Menulis file dengan fwrite()
$file = fopen("file.txt", "w");
fwrite($file, "Hello PHP");
fclose($file);
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';
echo "Contoh operasi file:<br>";
echo "✓ file_get_contents() - Membaca seluruh isi file<br>";
echo "✓ file_put_contents() - Menulis ke file<br>";
echo "✓ file_exists() - Cek keberadaan file<br>";
echo "✓ fopen(), fread(), fwrite(), fclose() - Operasi file detail<br>";
echo "<br><em>Catatan: Pastikan folder memiliki permission untuk write</em>";
echo '</div>';
echo '</div>';

// ============================================
// 12. INCLUDE & REQUIRE
// ============================================
echo '<div class="section">';
echo '<h2>12. Include & Require</h2>';
echo '<pre>';
echo '// INCLUDE - memasukkan file, jika error akan warning & lanjut
include "header.php";
include_once "header.php";  // Hanya include 1x

// REQUIRE - memasukkan file, jika error akan fatal error & stop
require "config.php";
require_once "config.php";  // Hanya require 1x

// Perbedaan:
// - include: jika file tidak ada, tampilkan warning dan lanjut
// - require: jika file tidak ada, fatal error dan stop eksekusi
// - include_once/require_once: mencegah file di-include berulang kali
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';
echo "<strong>Kapan menggunakan:</strong><br>";
echo "• <strong>include</strong>: Untuk file yang optional (tidak wajib)<br>";
echo "• <strong>require</strong>: Untuk file yang wajib ada (config, database)<br>";
echo "• <strong>_once</strong>: Untuk mencegah deklarasi duplikat<br>";
echo "<br><em>Contoh: require_once 'config.php' untuk file konfigurasi database</em>";
echo '</div>';
echo '</div>';

// ============================================
// 13. ERROR HANDLING
// ============================================
echo '<div class="section">';
echo '<h2>13. Error Handling (Dasar)</h2>';
echo '<pre>';
echo '// TRY-CATCH (untuk exception handling)
try {
    // Kode yang mungkin error
    $hasil = 10 / 0;  // Division by zero
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Die() dan exit() - menghentikan eksekusi
if (!file_exists("file.txt")) {
    die("File tidak ditemukan!");
}

// Error reporting
error_reporting(E_ALL);        // Tampilkan semua error
ini_set("display_errors", 1);  // Tampilkan error di browser

// Custom error handler
function errorHandler($errno, $errstr) {
    echo "Error [$errno]: $errstr";
}
set_error_handler("errorHandler");
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

echo "<strong>Contoh Try-Catch:</strong><br>";
try {
    $angka = 100;
    $pembagi = 5;
    if ($pembagi == 0) {
        throw new Exception("Pembagi tidak boleh nol!");
    }
    $hasil = $angka / $pembagi;
    echo "Hasil: $angka / $pembagi = $hasil<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><strong>Error Levels:</strong><br>";
echo "• E_ERROR - Fatal error<br>";
echo "• E_WARNING - Warning<br>";
echo "• E_NOTICE - Notice<br>";
echo "• E_ALL - Semua error";
echo '</div>';
echo '</div>';

// ============================================
// 14. FORM HANDLING
// ============================================
echo '<div class="section">';
echo '<h2>14. Form Handling</h2>';
echo '<pre>';
echo '// HTML Form dengan method POST
&lt;form method="POST" action="proses.php"&gt;
    &lt;input type="text" name="nama"&gt;
    &lt;input type="email" name="email"&gt;
    &lt;button type="submit"&gt;Kirim&lt;/button&gt;
&lt;/form&gt;

// Mengambil data form di PHP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    
    // Validasi
    if (empty($nama)) {
        $error = "Nama wajib diisi";
    }
    
    // Sanitasi (membersihkan input)
    $nama = htmlspecialchars($nama);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid";
    }
}
';
echo '</pre>';

// Contoh form sederhana
echo '<div class="output">';
echo '<strong>Contoh Form Sederhana:</strong><br><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nama_siswa"])) {
    $nama = htmlspecialchars($_POST["nama_siswa"]);
    $kelas = htmlspecialchars($_POST["kelas"]);
    echo '<div style="background:#d4edda; padding:10px; border-radius:5px; color:#155724;">';
    echo "✓ Data berhasil diterima!<br>";
    echo "Nama: $nama<br>";
    echo "Kelas: $kelas";
    echo '</div><br>';
}

echo '<form method="POST" action="" style="background:#f8f9fa; padding:15px; border-radius:5px;">';
echo '<label>Nama Siswa:</label><br>';
echo '<input type="text" name="nama_siswa" required style="width:100%; padding:8px; margin:5px 0;"><br>';
echo '<label>Kelas:</label><br>';
echo '<input type="text" name="kelas" required style="width:100%; padding:8px; margin:5px 0;"><br>';
echo '<button type="submit" style="background:#667eea; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; margin-top:10px;">Kirim Data</button>';
echo '</form>';
echo '</div>';
echo '</div>';

// ============================================
// 15. OOP DASAR (Object-Oriented Programming)
// ============================================
echo '<div class="section">';
echo '<h2>15. OOP Dasar (Object-Oriented Programming)</h2>';
echo '<pre>';
echo '// Membuat Class
class Mobil {
    // Properties (variabel dalam class)
    public $merk;
    public $warna;
    private $kecepatan = 0;
    
    // Constructor - dijalankan saat object dibuat
    public function __construct($merk, $warna) {
        $this->merk = $merk;
        $this->warna = $warna;
    }
    
    // Method (fungsi dalam class)
    public function jalan() {
        $this->kecepatan = 60;
        return "Mobil berjalan dengan kecepatan " . $this->kecepatan . " km/jam";
    }
    
    public function info() {
        return "Mobil $this->merk warna $this->warna";
    }
}

// Membuat object dari class
$mobil1 = new Mobil("Toyota", "Merah");
$mobil2 = new Mobil("Honda", "Hitam");

// Mengakses method
echo $mobil1->info();
echo $mobil1->jalan();
';
echo '</pre>';
echo '<div class="output"><strong>Output:</strong><br>';

class Mahasiswa {
    public $nama;
    public $nim;
    public $jurusan;
    
    public function __construct($nama, $nim, $jurusan) {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->jurusan = $jurusan;
    }
    
    public function perkenalan() {
        return "Nama: {$this->nama}, NIM: {$this->nim}, Jurusan: {$this->jurusan}";
    }
    
    public function belajar() {
        return "{$this->nama} sedang belajar {$this->jurusan}";
    }
}

$mhs1 = new Mahasiswa("Andi Wijaya", "12345", "Teknik Informatika");
$mhs2 = new Mahasiswa("Siti Nurhaliza", "12346", "Sistem Informasi");

echo $mhs1->perkenalan() . "<br>";
echo $mhs1->belajar() . "<br><br>";
echo $mhs2->perkenalan() . "<br>";
echo $mhs2->belajar();
echo '</div>';
echo '</div>';

// ============================================
// PENUTUP & TIPS
// ============================================
echo '<div class="section">';
echo '<h2>Tips & Best Practices</h2>';
echo '<ol style="line-height: 2;">';
echo '<li><strong>Gunakan komentar</strong> untuk menjelaskan kode yang kompleks</li>';
echo '<li><strong>Nama variabel yang deskriptif</strong>: gunakan <code>$namaSiswa</code> bukan <code>$ns</code></li>';
echo '<li><strong>Indentasi konsisten</strong> untuk readability kode</li>';
echo '<li><strong>Validasi input user</strong> untuk keamanan aplikasi</li>';
echo '<li><strong>Gunakan prepared statements</strong> untuk query database (cegah SQL injection)</li>';
echo '<li><strong>Error handling</strong> dengan try-catch untuk kode yang rawan error</li>';
echo '<li><strong>DRY Principle</strong> (Don\'t Repeat Yourself) - buat fungsi untuk kode berulang</li>';
echo '<li><strong>Pisahkan logic, view, dan data</strong> (konsep MVC)</li>';
echo '</ol>';
echo '</div>';

echo '<div class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center;">';
echo '<h2 style="color: white; border: none;">🎓 Selamat Belajar PHP!</h2>';
echo '<p>Praktik adalah kunci untuk menguasai programming.<br>Terus berlatih dan jangan takut mencoba!</p>';
echo '<p style="margin-top: 20px;"><strong>Happy Coding! 🚀</strong></p>';
echo '</div>';
?>

</body>
</html>
