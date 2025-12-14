<?php
include 'koneksi.php';

// Validasi
if (empty($_POST['nama']) || empty($_POST['total_bayar'])) {
    echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
    exit;
}

$nama       = $_POST['nama'];
$hp         = $_POST['no_hp'];
$tgl        = $_POST['tgl_wisata'];
$durasi     = $_POST['durasi'];
$jumlah     = $_POST['jumlah'];
$harga_final= $_POST['harga_paket_final'];
$total      = $_POST['total_bayar'];

// Tangkap ID Paket (Ini perbaikannya, ambil dari form, jangan di-nol-kan)
$id_paket   = $_POST['id_paket_form']; 

// Checkbox
$inap  = isset($_POST['layanan_penginapan']) ? 1 : 0;
$trans = isset($_POST['layanan_transport']) ? 1 : 0;
$makan = isset($_POST['layanan_makan']) ? 1 : 0;

// Query Insert
$query = "INSERT INTO pemesanan 
    (nama_pemesan, no_hp, tanggal_wisata, durasi_wisata, layanan_penginapan, layanan_transport, layanan_makan, jumlah_peserta, harga_paket, total_bayar, id_paket) 
    VALUES 
    ('$nama', '$hp', '$tgl', '$durasi', '$inap', '$trans', '$makan', '$jumlah', '$harga_final', '$total', '$id_paket')";

if(mysqli_query($koneksi, $query)) {
    // MODIFIKASI: Balik ke form-pesan.php dengan status=sukses
    header("Location: form-pesan.php?status=sukses&nama=" . urlencode($nama));
} else {
    die("Gagal menyimpan pesanan: " . mysqli_error($koneksi));
}
?>