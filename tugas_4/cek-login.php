<?php 
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

// Cek di tabel USERS (bukan admin lagi)
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    
    // Simpan data penting ke session
    $_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['role'] = $data['role']; // PENTING: Simpan role (admin/customer)
    $_SESSION['status'] = "login";

    // LOGIKA PENGALIHAN HALAMAN (REDIRECT)
    if($data['role'] == "admin"){
        // Jika Admin -> Masuk ke Dapur
        header("location:modifikasi_pesanan.php");
    } else {
        // Jika Customer -> Kembali ke Beranda
        header("location:index.php");
    }

} else {
    header("location:login.php?pesan=gagal");
}
?>