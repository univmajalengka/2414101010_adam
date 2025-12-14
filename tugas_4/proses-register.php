<?php
include 'koneksi.php';

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']); // Enkripsi password
$role     = 'customer'; // Default role user baru adalah Customer

// Cek apakah username sudah ada?
$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Username sudah terpakai, silakan pilih yang lain!'); window.location='register.php';</script>";
} else {
    // Simpan ke database
    $query = "INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    
    if(mysqli_query($koneksi, $query)){
        // Jika sukses, arahkan ke login dengan pesan sukses
        header("location:login.php?pesan=daftar_sukses");
    } else {
        echo "Gagal daftar: " . mysqli_error($koneksi);
    }
}
?>