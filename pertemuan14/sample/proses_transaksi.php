<?php
include 'koneksi.php';

// OPERASI CREATE/POST
if(isset($_POST['simpan'])) {
    $item_id = $_POST['item_id'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $jumlah = $_POST['jumlah'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);

    // Insert transaksi
    $query = "INSERT INTO transactions (item_id, jenis_transaksi, jumlah, tanggal_transaksi, keterangan, penanggung_jawab) 
              VALUES ('$item_id', '$jenis_transaksi', '$jumlah', '$tanggal_transaksi', '$keterangan', '$penanggung_jawab')";

    if (mysqli_query($koneksi, $query)) {
        // Update stok barang
        if ($jenis_transaksi == 'masuk') {
            $update_query = "UPDATE items SET jumlah = jumlah + $jumlah WHERE id = $item_id";
        } else {
            $update_query = "UPDATE items SET jumlah = jumlah - $jumlah WHERE id = $item_id";
        }
        mysqli_query($koneksi, $update_query);
        
        header("Location: transaksi.php?success=Transaksi berhasil ditambahkan!");
    } else {
        header("Location: transaksi.php?success=Error: " . mysqli_error($koneksi));
    }
}

// OPERASI UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $item_id = $_POST['item_id'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $jumlah = $_POST['jumlah'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $penanggung_jawab = mysqli_real_escape_string($koneksi, $_POST['penanggung_jawab']);

    // Ambil data transaksi lama
    $old_query = "SELECT * FROM transactions WHERE id = $id";
    $old_result = mysqli_query($koneksi, $old_query);
    $old_data = mysqli_fetch_assoc($old_result);

    // Kembalikan stok sesuai transaksi lama
    if ($old_data['jenis_transaksi'] == 'masuk') {
        $revert_query = "UPDATE items SET jumlah = jumlah - " . $old_data['jumlah'] . " WHERE id = " . $old_data['item_id'];
    } else {
        $revert_query = "UPDATE items SET jumlah = jumlah + " . $old_data['jumlah'] . " WHERE id = " . $old_data['item_id'];
    }
    mysqli_query($koneksi, $revert_query);

    // Update transaksi
    $query = "UPDATE transactions SET 
              item_id='$item_id', 
              jenis_transaksi='$jenis_transaksi', 
              jumlah='$jumlah', 
              tanggal_transaksi='$tanggal_transaksi', 
              keterangan='$keterangan', 
              penanggung_jawab='$penanggung_jawab' 
              WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        // Terapkan stok baru
        if ($jenis_transaksi == 'masuk') {
            $new_query = "UPDATE items SET jumlah = jumlah + $jumlah WHERE id = $item_id";
        } else {
            $new_query = "UPDATE items SET jumlah = jumlah - $jumlah WHERE id = $item_id";
        }
        mysqli_query($koneksi, $new_query);
        
        header("Location: transaksi.php?success=Transaksi berhasil diperbarui!");
    } else {
        header("Location: transaksi.php?success=Error: " . mysqli_error($koneksi));
    }
}

// OPERASI DELETE
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil data transaksi untuk kembalikan stok
    $trans_query = "SELECT * FROM transactions WHERE id = $id";
    $trans_result = mysqli_query($koneksi, $trans_query);
    $trans_data = mysqli_fetch_assoc($trans_result);

    // Kembalikan stok
    if ($trans_data['jenis_transaksi'] == 'masuk') {
        $update_query = "UPDATE items SET jumlah = jumlah - " . $trans_data['jumlah'] . " WHERE id = " . $trans_data['item_id'];
    } else {
        $update_query = "UPDATE items SET jumlah = jumlah + " . $trans_data['jumlah'] . " WHERE id = " . $trans_data['item_id'];
    }
    mysqli_query($koneksi, $update_query);

    // Hapus transaksi
    $query = "DELETE FROM transactions WHERE id=$id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: transaksi.php?success=Transaksi berhasil dihapus!");
    } else {
        header("Location: transaksi.php?success=Error: " . mysqli_error($koneksi));
    }
}
?>
