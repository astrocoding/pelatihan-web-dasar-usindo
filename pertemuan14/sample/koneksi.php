<?php
  $host = "localhost"; // atau 127.0.0.1
  $user = "root";
  $password = "";
  $database = "inventaris_db";

  $koneksi = mysqli_connect($host, $user, $password, $database);

  if ($koneksi) {
    // echo "Koneksi berhasil";
  } else {
    die("Koneksi gagal: " . mysqli_connect_error());
  }
?>