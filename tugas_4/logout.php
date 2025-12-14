<?php 
session_start();
// Hapus semua session
session_destroy();
// Alihkan ke halaman awal
header("location:index.php");
?>