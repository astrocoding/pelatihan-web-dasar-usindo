<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$id = "";
$item_id = "";
$jenis_transaksi = "";
$jumlah = "";
$tanggal_transaksi = "";
$keterangan = "";
$penanggung_jawab = "";

if (isset($_GET['edit'])) { // VARIABLE GLOBAL
    $id = $_GET['edit'];
    $query = "SELECT * FROM transactions WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    $item_id = $data['item_id'];
    $jenis_transaksi = $data['jenis_transaksi'];
    $jumlah = $data['jumlah'];
    $tanggal_transaksi = $data['tanggal_transaksi'];
    $keterangan = $data['keterangan'];
    $penanggung_jawab = $data['penanggung_jawab'];
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
    <title>Transaksi - Sistem Inventaris</title>
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
            <a href="index.php">Data Barang</a>
            <a href="transaksi.php" class="active">Transaksi</a>
        </div>
        
        <!-- Form Input / Edit -->
        <div class="form-section">
            <h3><?php echo $id ? "Edit Transaksi" : "Tambah Transaksi"; ?></h3>
            <form action="proses_transaksi.php" method="POST">
                <input type="hidden" name="id" value="<?= $id; ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="item_id">Barang:</label>
                        <select id="item_id" name="item_id" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            $query_items = "SELECT id, kode_barang, nama_barang FROM items ORDER BY nama_barang";
                            $result_items = mysqli_query($koneksi, $query_items);
                            while ($item = mysqli_fetch_assoc($result_items)) {
                                $selected = ($item_id == $item['id']) ? "selected" : "";
                                echo "<option value='" . $item['id'] . "' $selected>" . $item['kode_barang'] . " - " . $item['nama_barang'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jenis_transaksi">Jenis Transaksi:</label>
                        <select id="jenis_transaksi" name="jenis_transaksi" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="masuk" <?= ($jenis_transaksi == "masuk") ? "selected" : ""; ?>>Barang Masuk</option>
                            <option value="keluar" <?= ($jenis_transaksi == "keluar") ? "selected" : ""; ?>>Barang Keluar</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" value="<?= $jumlah; ?>" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi:</label>
                        <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" value="<?= $tanggal_transaksi; ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="penanggung_jawab">Penanggung Jawab:</label>
                    <input type="text" id="penanggung_jawab" name="penanggung_jawab" value="<?= $penanggung_jawab; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea id="keterangan" name="keterangan"><?= $keterangan; ?></textarea>
                </div>
                
                <button type="submit" name="<?= $id ? 'update' : 'simpan'; ?>" class="btn btn-primary">
                    <?= $id ? 'Update Transaksi' : 'Simpan Transaksi'; ?>
                </button>
                
                <?php if ($id): ?>
                    <a href="transaksi.php" class="btn btn-danger">Batal</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="table-section">
            <h3>Daftar Transaksi</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Nama Barang</th>
                        <th style="width: 12%;">Jenis</th>
                        <th style="width: 8%;">Jumlah</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 15%;">Penanggung Jawab</th>
                        <th style="width: 20%;">Keterangan</th>
                        <th style="width: 13%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT t.*, i.nama_barang, i.kode_barang 
                              FROM transactions t 
                              JOIN items i ON t.item_id = i.id 
                              ORDER BY t.id DESC";
                    $result = mysqli_query($koneksi, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $jenis_class = $row['jenis_transaksi'] == 'masuk' ? 'badge-success' : 'badge-danger';
                            $jenis_text = $row['jenis_transaksi'] == 'masuk' ? 'Masuk' : 'Keluar';
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['nama_barang'] . "</td>";
                            echo "<td><span class='badge " . $jenis_class . "'>" . $jenis_text . "</span></td>";
                            echo "<td>" . $row['jumlah'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['tanggal_transaksi'])) . "</td>";
                            echo "<td>" . $row['penanggung_jawab'] . "</td>";
                            echo "<td>" . ($row['keterangan'] ? $row['keterangan'] : '-') . "</td>";
                            echo "<td>
                                    <a href='transaksi.php?edit=" . $row['id'] . "' class='btn btn-edit'>Edit</a>
                                    <a href='proses_transaksi.php?hapus=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus?\");'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
