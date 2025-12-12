// ============================================
// BELAJAR JAVASCRIPT DASAR
// USINDO Web Development Training
// ============================================


console.log("=== SELAMAT DATANG DI JAVASCRIPT DASAR ===");
console.log("Buka Developer Console (F12) untuk melihat semua output!\n");

// ============================================
// 1. VARIABLE DAN TIPE DATA
// ============================================

console.log("--- 1. VARIABLE DAN TIPE DATA ---");

// Cara mendeklarasikan variable:
// var - cara lama (function scope)
// let - cara baru (block scope)
// const - konstanta (tidak bisa diubah)

// String (Teks)
let nama = "Zaenal";
let kota = "Jakarta";
const negara = "Indonesia";
console.log("String:", nama, kota, negara);

// Number (Angka)
let umur = 25;
let tinggi = 175.5;
const phi = 3.14;
console.log("Number:", umur, tinggi, phi);

// Boolean (True/False)
let isActive = true;
let isLogin = false;
console.log("Boolean:", isActive, isLogin);

// Undefined (belum diberi nilai)
let kosong;
console.log("Undefined:", kosong);

// Null (sengaja dikosongkan)
let data = null;
console.log("Null:", data);

// Array (Kumpulan data)
let angka = [1, 2, 3, 4, 5];
console.log("Array:", angka);

// Object (Data kompleks)
let orang = {
    nama: "Zen",
    umur: 30,
    kota: "Bandung"
};
console.log("Object:", orang);

// Mengecek tipe data
console.log("Tipe dari 'nama':", typeof nama);
console.log("Tipe dari 'umur':", typeof umur);
console.log("Tipe dari 'isActive':", typeof isActive);
console.log("");


// ============================================
// 2. ATURAN PENAMAAN VARIABLE
// ============================================

console.log("--- 2. ATURAN PENAMAAN VARIABLE ---");

//  BENAR - Penamaan yang valid
let firstName = "Zen";           // camelCase (recommended)
let first_name = "Zen";           // snake_case
let firstName2 = "Zen";           // boleh ada angka
let _privatelet = "Private";      // boleh mulai dengan underscore
let $jquery = "jQuery";            // boleh mulai dengan dollar

// SALAH - Penamaan yang tidak valid (akan error)
// let 2name = "Zen";             // tidak boleh mulai dengan angka
// let first-name = "Zen";        // tidak boleh pakai dash
// let first name = "Zen";        // tidak boleh pakai spasi
// let class = "Zen";             // tidak boleh pakai reserved keyword

console.log("Penamaan variable yang benar:");
console.log("camelCase:", firstName);
console.log("snake_case:", first_name);
console.log("dengan angka:", firstName2);
console.log("");

// Best Practice:
// - Gunakan nama yang deskriptif
// - Gunakan camelCase untuk variable dan function
// - Gunakan PascalCase untuk class
// - Gunakan UPPERCASE untuk constant


// ============================================
// 3. OPERATOR
// ============================================

console.log("--- 3. OPERATOR ---");

// A. OPERATOR ARITMATIKA
console.log("A. Operator Aritmatika:");
let a = 10;
let b = 3;

console.log(a + " + " + b + " =", a + b);  // Penjumlahan
console.log(a + " - " + b + " =", a - b);  // Pengurangan
console.log(a + " * " + b + " =", a * b);  // Perkalian
console.log(a + " / " + b + " =", a / b);  // Pembagian
console.log(a + " % " + b + " =", a % b);  // Modulus (sisa bagi)
console.log(a + " ** " + b + " =", a ** b); // Pangkat
console.log("");

// B. OPERATOR ASSIGNMENT (Penugasan)
console.log("B. Operator Assignment:");
var x = 5;
console.log("x = 5:", x);

x += 3;  // sama dengan x = x + 3
console.log("x += 3:", x);

x -= 2;  // sama dengan x = x - 2
console.log("x -= 2:", x);

x *= 2;  // sama dengan x = x * 2
console.log("x *= 2:", x);

x /= 3;  // sama dengan x = x / 3
console.log("x /= 3:", x);
console.log("");

// C. OPERATOR PERBANDINGAN
console.log("C. Operator Perbandingan:");
let num1 = 10;
let num2 = "10";

console.log("10 == '10':", num1 == num2);   // Sama dengan (hanya nilai)
console.log("10 === '10':", num1 === num2); // Identik (nilai dan tipe)
console.log("10 != '10':", num1 != num2);   // Tidak sama dengan
console.log("10 !== '10':", num1 !== num2); // Tidak identik
console.log("10 > 5:", num1 > 5);           // Lebih besar
console.log("10 < 5:", num1 < 5);           // Lebih kecil
console.log("10 >= 10:", num1 >= 10);       // Lebih besar atau sama
console.log("10 <= 10:", num1 <= 10);       // Lebih kecil atau sama
console.log("");

// D. OPERATOR LOGIKA
console.log("D. Operator Logika:");
let benar = true;
let salah = false;

console.log("true && false:", benar && salah);  // AND (DAN)
console.log("true || false:", benar || salah);  // OR (ATAU)
console.log("!true:", !benar);                  // NOT (TIDAK)
console.log("");

// E. INCREMENT & DECREMENT
console.log("E. Increment & Decrement:");
var counter = 0;
console.log("Awal:", counter);

counter++;  // Increment (tambah 1)
console.log("Setelah counter++:", counter);

counter--;  // Decrement (kurang 1)
console.log("Setelah counter--:", counter);
console.log("");


// ============================================
// 4. CONTROL FLOW - IF ELSE
// ============================================

console.log("--- 4. CONTROL FLOW: IF ELSE ---");

// IF sederhana
let nilai = 85;
console.log("Nilai:", nilai);

if (nilai >= 70) {
    console.log("Hasil: LULUS");
}

// IF-ELSE
let umurPengguna = 17;
console.log("\nUmur:", umurPengguna);

if (umurPengguna >= 18) {
    console.log("Anda sudah dewasa");
} else {
    console.log("Anda masih di bawah umur");
}

// IF-ELSE IF-ELSE
let score = 75;
console.log("\nScore:", score);

if (score >= 90) {
    console.log("Grade: A - Excellent!");
} else if (score >= 80) {
    console.log("Grade: B - Good!");
} else if (score >= 70) {
    console.log("Grade: C - Cukup");
} else if (score >= 60) {
    console.log("Grade: D - Kurang");
} else {
    console.log("Grade: E - Gagal");
}

// Nested IF (IF bersarang)
let isRaining = true;
let hasUmbrella = false;
console.log("\nApakah hujan?", isRaining);
console.log("Punya payung?", hasUmbrella);

if (isRaining) {
    if (hasUmbrella) {
        console.log("Aman, bisa jalan");
    } else {
        console.log("Tunggu dulu, hujan!");
    }
} else {
    console.log("Tidak hujan, ayo jalan!");
}
console.log("");


// ============================================
// 5. CONTROL FLOW - SWITCH CASE
// ============================================

console.log("--- 5. CONTROL FLOW: SWITCH CASE ---");

let hari = 3;
let namaHari;

switch (hari) {
    case 1:
        namaHari = "Senin";
        break;
    case 2:
        namaHari = "Selasa";
        break;
    case 3:
        namaHari = "Rabu";
        break;
    case 4:
        namaHari = "Kamis";
        break;
    case 5:
        namaHari = "Jumat";
        break;
    case 6:
        namaHari = "Sabtu";
        break;
    case 7:
        namaHari = "Minggu";
        break;
    default:
        namaHari = "Hari tidak valid";
}

console.log("Hari ke-" + hari + " adalah:", namaHari);

// Contoh switch dengan string
let buah = "apel";
console.log("\nBuah:", buah);

switch (buah) {
    case "apel":
        console.log("Harga: Rp 10.000/kg");
        break;
    case "jeruk":
        console.log("Harga: Rp 15.000/kg");
        break;
    case "mangga":
        console.log("Harga: Rp 20.000/kg");
        break;
    default:
        console.log("Buah tidak tersedia");
}
console.log("");

// ============================================
// 6. LOOP - FOR
// ============================================

console.log("--- 6. LOOP: FOR ---");

// FOR loop dasar
console.log("Hitung 1-5:");
for (let i = 1; i <= 5; i++) {
    console.log("Angka:", i);
}

// FOR loop dengan array
console.log("\nLoop array buah:");
let buahBuahan = ["Apel", "Jeruk", "Mangga", "Pisang"];
for (let i = 0; i < buahBuahan.length; i++) {
    console.log("Buah ke-" + (i + 1) + ":", buahBuahan[i]);
}

// FOR loop genap
console.log("\nAngka genap 2-10:");
for (let i = 2; i <= 10; i += 2) {
    console.log(i);
}
console.log("");


// ============================================
// 7. LOOP - WHILE
// ============================================

console.log("--- 7. LOOP: WHILE ---");

// WHILE loop dasar
console.log("Hitung mundur dari 5:");
let countdown = 5;
while (countdown > 0) {
    console.log(countdown);
    countdown--;
}
console.log("SELESAI!");

// WHILE dengan kondisi
console.log("\nLoop sampai jumlah >= 100:");
var jumlah = 0;
var counter = 1;
while (jumlah < 100) {
    jumlah += counter;
    console.log("Counter:", counter, "- Jumlah:", jumlah);
    counter++;
}
console.log("");


// ============================================
// 8. LOOP - DO WHILE
// ============================================

console.log("--- 8. LOOP: DO WHILE ---");

// DO-WHILE (minimal 1x pasti jalan)
console.log("Loop dengan do-while:");
var angka1 = 1;
do {
    console.log("Angka:", angka1);
    angka1++;
} while (angka1 <= 3);
// Perbedaan while vs do-while
console.log("\nPerbedaan WHILE vs DO-WHILE:");
console.log("WHILE (kondisi false di awal):");
var x = 10;
while (x < 5) {
    console.log("Ini tidak akan muncul");
}

console.log("DO-WHILE (kondisi false di awal):");
var y = 10;
do {
    console.log("Ini tetap muncul 1x:", y);
} while (y < 5);
console.log("");


// ============================================
// 9. FUNGSI (FUNCTION)
// ============================================

console.log("--- 9. FUNGSI (FUNCTION) ---");

// Fungsi tanpa parameter dan return
function sapaPengguna() {
    console.log("Halo! Selamat datang!");
}
sapaPengguna();

// Fungsi dengan parameter
function sapa(nama) {
    console.log("Halo, " + nama + "!");
}
sapa("Zen");
sapa("Zaenal");

// Fungsi dengan parameter dan return
function tambah(a, b) {
    return a + b;
}
let hasil = tambah(5, 3);
console.log("5 + 3 =", hasil);

// Fungsi dengan multiple parameter
function perkenalan(nama, umur, kota) {
    return "Nama saya " + nama + ", umur " + umur + " tahun, tinggal di " + kota;
}
console.log(perkenalan("Budi", 25, "Jakarta"));

// Fungsi dengan default parameter
function ucapanSelamat(nama, waktu = "pagi") {
    return "Selamat " + waktu + ", " + nama + "!";
}
console.log(ucapanSelamat("Ani"));           // default waktu
console.log(ucapanSelamat("Budi", "siang")); // custom waktu

// Arrow Function (cara modern)
const kali = (a, b) => a * b;
console.log("3 x 4 =", kali(3, 4));

const luasPersegi = (sisi) => sisi * sisi;
console.log("Luas persegi sisi 5 =", luasPersegi(5));
console.log("");


// ============================================
// 10. ARRAY
// ============================================

console.log("--- 10. ARRAY ---");

// Membuat array
let buahArray = ["Apel", "Jeruk", "Mangga", "Pisang"];
console.log("Array buah:", buahArray);

// Mengakses element array
console.log("Buah pertama:", buahArray[0]);
console.log("Buah ketiga:", buahArray[2]);

// Panjang array
console.log("Jumlah buah:", buahArray.length);

// Menambah element
buahArray.push("Anggur");  // tambah di akhir
console.log("Setelah push:", buahArray);

buahArray.unshift("Semangka");  // tambah di awal
console.log("Setelah unshift:", buahArray);

// Menghapus element
let buahTerakhir = buahArray.pop();  // hapus dari akhir
console.log("Dihapus dari akhir:", buahTerakhir);
console.log("Array sekarang:", buahArray);

let buahPertama = buahArray.shift();  // hapus dari awal
console.log("Dihapus dari awal:", buahPertama);
console.log("Array sekarang:", buahArray);

// Method array lainnya
let angkaArray = [3, 1, 4, 1, 5, 9, 2, 6];
console.log("\nArray angka:", angkaArray);

// Join - gabung jadi string
console.log("Join dengan '-':", angkaArray.join("-"));

// Sort - urutkan
console.log("Diurutkan:", angkaArray.sort());

// Reverse - balik
console.log("Dibalik:", angkaArray.reverse());

// Slice - ambil sebagian (tidak mengubah original)
let sebagian = angkaArray.slice(2, 5);
console.log("Slice index 2-5:", sebagian);

// Splice - hapus/tambah element (mengubah original)
let numbers = [1, 2, 3, 4, 5];
numbers.splice(2, 1);  // hapus 1 element mulai index 2
console.log("Setelah splice:", numbers);

// Loop array dengan forEach
console.log("\nLoop dengan forEach:");
let mahasiswa = ["Ali", "Budi", "Citra"];
mahasiswa.forEach(function(nama, index) {
    console.log("Mahasiswa ke-" + (index + 1) + ":", nama);
});

// Map - transform array
let angkaDikali2 = [1, 2, 3, 4, 5].map(function(num) {
    return num * 2;
});
console.log("\nAngka dikali 2:", angkaDikali2);

// Filter - filter array
let angkaBesar = [1, 5, 3, 8, 2, 9, 4].filter(function(num) {
    return num > 5;
});
console.log("Angka > 5:", angkaBesar);
console.log("");


// ============================================
// 11. OBJECT
// ============================================

console.log("--- 11. OBJECT ---");

// Membuat object
let mahasiswaObj = {
    nama: "Zen Doe",
    npm: "12345678",
    umur: 20,
    jurusan: "Teknik Informatika",
    aktif: true
};

console.log("Object mahasiswa:", mahasiswaObj);

// Mengakses property object
console.log("Nama:", mahasiswaObj.nama);
console.log("NPM:", mahasiswaObj["npm"]);
console.log("Umur:", mahasiswaObj.umur);

// Menambah property
mahasiswaObj.email = "Zen@example.com";
console.log("Setelah tambah email:", mahasiswaObj);

// Mengubah property
mahasiswaObj.umur = 21;
console.log("Umur diubah:", mahasiswaObj.umur);

// Menghapus property
delete mahasiswaObj.aktif;
console.log("Setelah hapus aktif:", mahasiswaObj);

// Object dengan method (function)
let mobil = {
    merk: "Toyota",
    model: "Avanza",
    tahun: 2023,
    warna: "Hitam",
    
    // Method
    info: function() {
        return this.merk + " " + this.model + " " + this.tahun;
    },
    
    ubahWarna: function(warnaBaru) {
        this.warna = warnaBaru;
        return "Warna diubah menjadi " + this.warna;
    }
};

console.log("\nObject mobil:", mobil);
console.log("Info mobil:", mobil.info());
console.log(mobil.ubahWarna("Merah"));

// Array of Objects
let daftarSiswa = [
    { nama: "Ali", nilai: 85 },
    { nama: "Budi", nilai: 90 },
    { nama: "Citra", nilai: 78 }
];

console.log("\nArray of Objects:");
daftarSiswa.forEach(function(siswa, index) {
    console.log((index + 1) + ". " + siswa.nama + " - Nilai: " + siswa.nilai);
});

// Loop object properties
console.log("\nLoop object properties:");
for (let key in mahasiswaObj) {
    console.log(key + ":", mahasiswaObj[key]);
}
console.log("");


// ============================================
// FUNGSI UNTUK DEMO DI HTML
// ============================================

function externalJSDemo() {
    alert("Ini pesan dari External JavaScript (file index.js)!");
    console.log("External JS berhasil dijalankan");
}

function runAllExamples() {
    console.log("\n\n=== MENJALANKAN SEMUA CONTOH ===\n");
    
    // Contoh sederhana dari semua topik
    console.log("1. Variable: nama = 'JavaScript'");
    var nama = "JavaScript";
    
    console.log("2. Operator: 10 + 5 =", 10 + 5);
    
    console.log("3. IF-ELSE:");
    if (10 > 5) {
        console.log("   10 lebih besar dari 5");
    }
    
    console.log("4. FOR Loop:");
    for (let i = 1; i <= 3; i++) {
        console.log("   Loop ke-" + i);
    }
    
    console.log("5. Function:");
    function salam() {
        return "Halo dari function!";
    }
    console.log("  ", salam());
    
    console.log("6. Array:", [1, 2, 3, 4, 5]);
    
    console.log("7. Object:", { nama: "JS", tipe: "Programming Language" });
    
    console.log("\n Semua contoh selesai!");
    console.log("📝 Lihat kode lengkap di file index.js");
    
    alert("Semua contoh berhasil dijalankan!\nLihat Developer Console untuk detailnya.");
}


// ============================================
// PENUTUP
// ============================================

console.log("\n=== SELESAI ===");
console.log("Anda telah mempelajari dasar-dasar JavaScript!");
console.log("Topik yang sudah dipelajari:");
console.log("✅ Variable dan Tipe Data");
console.log("✅ Aturan Penamaan Variable");
console.log("✅ Operator");
console.log("✅ IF-ELSE");
console.log("✅ Switch Case");
console.log("✅ FOR Loop");
console.log("✅ WHILE Loop");
console.log("✅ DO-WHILE Loop");
console.log("✅ Function");
console.log("✅ Array");
console.log("✅ Object");
console.log("\n🎉 Selamat belajar JavaScript!");
