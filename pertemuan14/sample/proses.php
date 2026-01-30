<?php
include 'koneksi.php';

// OPERASI CREATE/POST
if(isset($_POST['simpan'])) {
  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $kategori = $_POST['kategori'];
  $lokasi = $_POST['lokasi'];
  $jumlah = $_POST['jumlah'];
  $kondisi = $_POST['kondisi'];
  $tanggal_masuk = $_POST['tanggal_masuk'];

  $query = "INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) VALUES ('$kode_barang', '$nama_barang', '$kategori', '$lokasi', '$jumlah', '$kondisi', '$tanggal_masuk')";

  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil ditambahkan!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}

// OPERASI UPDATE
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $kategori = $_POST['kategori'];
  $lokasi = $_POST['lokasi'];
  $jumlah = $_POST['jumlah'];
  $kondisi = $_POST['kondisi'];
  $tanggal_masuk = $_POST['tanggal_masuk'];

  $query = "UPDATE items SET kode_barang='$kode_barang', nama_barang='$nama_barang', kategori='$kategori', lokasi='$lokasi', jumlah='$jumlah', kondisi='$kondisi', tanggal_masuk='$tanggal_masuk' WHERE id=$id";
  
  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil diperbarui!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}

// OPERASI DELETE
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  $query = "DELETE FROM items WHERE id=$id";

  if (mysqli_query($koneksi, $query)) {
    header("Location: index.php?success=Data berhasil dihapus!");
  } else {
    header("Location: index.php?success=Error: " . mysqli_error($koneksi));
  }
}

?>