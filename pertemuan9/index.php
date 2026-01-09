<?php
  echo "<h1>Hello, World!</h1>"; // ini adalah string
  $nama = "Zaenal Alfian"; // penulisan variabel
  echo "Nama $nama <br>";
  echo 'Nama $nama';
  $angka = 10;
  $angka = "string aja"; // PHP bersifat loosely typed/dynamically typed

  echo "<br>Angka sekarang adalah $angka";
  // integer, string, float, boolean, array, object, null

  // operator aritmatika
  $a = 10;
  $b = 3;
  $c = $a + $b;
  echo "<br> $c = $a + $b";
  $c = $a % $b;
  echo "<br> $c = $a % $b"; // cara kerja modulus/sisa bagi
  $nilai = 11;

  if($nilai % 2 == 0) { // 11 dibagi 2 sisanya 1, jadi ganjil
    echo "<br> $nilai adalah bilangan genap";
  } else {
    echo "<br> $nilai adalah bilangan ganjil";
  }

  // operator penugasan
  $x = 5; // penugasan biasa
  $x += 10; // $x = $x + 10

  // Operator logika

  $hasil = ($x > 10) && ($nilai % 2 == 1); // true && true -> true
  echo "<br> Hasil: $hasil"; // 1 = true, nol = false

  // variable, operator, pengkondisian, perulangan, fungsi, tipe data, array, oop (object oriented programming)

  // LOOPING di PHP: for, while, do..while, foreach (untuk array)
  for($i = 0; $i <= 5; $i++) {
    echo "<br>Perulangan ke-$i";
  }

  $x = 5;
  while($x >= 0) {
    echo "<br>While loop: $x";
    $x--;
  }

  echo "<hr>";

  $data = array("apel", "jeruk", "mangga");
  var_dump($data); // Bisa kita gunakan untuk logging/debugging
  echo "<br>";
  // echo $data;
  foreach($data as $buah) {
    echo "<br> Buah: $buah"; // menampilkan isi array, looping sesuai jumlah elemen array
  }

  // MATERI FUNCTION
  function sapa($nama) {
    return "<br>Halo, $nama!"; // hanya mengembalikan nilai
  }
  echo sapa("Zaenal");
  function tampil() {
    echo "<br>Ini adalah fungsi tampil";
  }

  tampil(); // memanggil fungsi

  function ganjilgenap($angka) {
    if($angka % 2 == 0) {
      while($angka > 0) {
        $angka -= 2; // pengurangan terus menerus sampai habis
      }
      $hasil = "$angka adalah bilangan genap";
      return $hasil;
    } else {
      return "$angka adalah bilangan ganjil";
    }
  }

  echo "<br>" . ganjilgenap(20);

  // TERNARY
  $usia = 15;
  $status = ($usia >= 18) ? "Dewasa" : "Anak-anak";
  echo "<br> Usia: $usia<br>";
  var_dump($status);
  echo "<br>Status: $status";

  $siswa = array(
    "nama" => "Alfian",
    "usia" => 17,
    "kelas" => "12 RPL 1"
  );

  echo "<br>ini adalah array 1: $data[0]";

  $siswa["nama"] = "Zaenal Alfian"; // mengubah nilai array associative
  echo "<br>Nama siswa: " . $siswa["nama"];

?>