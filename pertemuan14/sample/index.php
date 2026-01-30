<?php
  session_start();
  
  // Cek apakah user sudah login
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
  
  include 'koneksi.php';

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
    <title>Inventaris Barang - Sistem Inventaris</title>
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>
    <div class="container">
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
        
        <!-- Form Input / Edit -->
        <div class="form-section">
            <h3><?php echo $id ? "Edit Data Barang" : "Tambah Data Barang"; ?></h3>
            <form action="proses.php" method="POST">
                <input type="hidden" name="id" value="<?= $id; ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang:</label>
                        <input type="text" id="kode_barang" name="kode_barang" value="<?= $kode_barang; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang:</label>
                        <input type="text" id="nama_barang" name="nama_barang" value="<?= $nama_barang; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <input type="text" id="kategori" name="kategori" value="<?= $kategori; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lokasi">Lokasi:</label>
                        <input type="text" id="lokasi" name="lokasi" value="<?= $lokasi; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" value="<?= $jumlah; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kondisi">Kondisi:</label>
                        <select id="kondisi" name="kondisi" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik" <?= ($kondisi == "Baik") ? "selected" : ""; ?>>Baik</option>
                            <option value="Rusak" <?= ($kondisi == "Rusak") ? "selected" : ""; ?>>Rusak</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk:</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?= $tanggal_masuk; ?>" required>
                </div>
                
                <button type="submit" name="<?= $id ? 'update' : 'simpan'; ?>" class="btn btn-primary">
                    <?= $id ? 'Update Data' : 'Simpan Data'; ?>
                </button>
                
                <?php if ($id): ?>
                    <a href="index.php" class="btn btn-danger">Batal</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="table-section">
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
                    $query = "SELECT * FROM items ORDER BY id DESC";
                    $result = mysqli_query($koneksi, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $kondisi_class = $row['kondisi'] == 'Baik' ? 'badge-success' : 'badge-danger';
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['kode_barang'] . "</td>";
                            echo "<td>" . $row['nama_barang'] . "</td>";
                            echo "<td>" . $row['kategori'] . "</td>";
                            echo "<td>" . $row['lokasi'] . "</td>";
                            echo "<td>" . $row['jumlah'] . "</td>";
                            echo "<td><span class='badge " . $kondisi_class . "'>" . $row['kondisi'] . "</span></td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['tanggal_masuk'])) . "</td>";
                            echo "<td>
                                    <a href='index.php?edit=" . $row['id'] . "' class='btn btn-edit'>Edit</a>
                                    <a href='proses.php?hapus=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus?\");'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
  </body>
</html>