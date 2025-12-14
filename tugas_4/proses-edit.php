<?php
include 'koneksi.php';

$id     = $_POST['id'];
$nama   = $_POST['nama'];
$durasi = $_POST['durasi'];
$jumlah = $_POST['jumlah'];
$total  = $_POST['total_bayar'];
$harga  = $_POST['harga_paket'];

$inap  = isset($_POST['layanan_penginapan']) ? 1 : 0;
$trans = isset($_POST['layanan_transport']) ? 1 : 0;
$makan = isset($_POST['layanan_makan']) ? 1 : 0;

$query = "UPDATE pemesanan SET 
            nama_pemesan='$nama', 
            durasi_wisata='$durasi', 
            jumlah_peserta='$jumlah', 
            layanan_penginapan='$inap',
            layanan_transport='$trans',
            layanan_makan='$makan',
            harga_paket='$harga',
            total_bayar='$total' 
          WHERE id='$id'";

mysqli_query($koneksi, $query);
header("Location: modifikasi_pesanan.php");
?>