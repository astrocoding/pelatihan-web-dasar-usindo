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
    $query = "SELECT * FROM barang WHERE id = $id";
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Inventaris Barang</title>
    <style>
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
    </style>
</head>
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
    </div>
</body>
</html>
