<?php 
// 1. MULAI SESSION (WAJIB PALING ATAS)
session_start(); 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOTS TRAVEL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>

    <nav class="glass">
        <a href="index.php" class="logo"><i class="ri-plane-fill"></i> YOTS TRAVEL</a>
        
        <div class="nav-links">
            <a href="index.php" class="nav-btn">Beranda</a>
            
            <?php 
            // Cek Status Login
            if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
                
                // Jika Login sebagai ADMIN
                if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
                    echo '<a href="modifikasi_pesanan.php" class="nav-btn">Kelola Pesanan</a>';
                    echo '<a href="logout.php" class="nav-btn" style="background:rgba(255,0,0,0.1); color:red;">Logout Admin</a>';
                } 
                // Jika Login sebagai CUSTOMER
                else {
                    // Ambil nama (Gunakan 'User' jika nama kosong untuk mencegah error)
                    $namaUser = $_SESSION['nama_lengkap'] ?? 'User';
                    
                    // Tampilkan Nama (Pakai htmlspecialchars agar aman dari hack XSS)
                    echo '<span class="nav-btn" style="cursor:default; border:none;">Halo, '. htmlspecialchars($namaUser) .'</span>';
                    echo '<a href="logout.php" class="nav-btn" style="background:rgba(255,0,0,0.1); color:red;">Logout</a>';
                }

            } else { 
                // Jika Belum Login (GUEST)
            ?>
                <a href="login.php" class="nav-btn" style="background:var(--primary-blue); color:white; padding: 8px 20px;">
                    <i class="ri-login-box-line"></i> Masuk
                </a>
            <?php } ?>
        </div>
        
        <button id="theme-toggle"><i class="ri-moon-line" id="theme-icon"></i></button>
    </nav>

    <section class="hero-slider">
        <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80');"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=1600&q=80');"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=1600&q=80');"></div>

        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Jelajahi Surga Tersembunyi</h1>
            <p>Temukan destinasi impian dengan pengalaman tak terlupakan.</p>
            <a href="#list-paket" class="btn-pesan">Mulai Petualangan</a>
        </div>
    </section>

    <div id="list-paket" class="container"> 
        <div class="grid-paket">
            <?php
            // Query Database
            $query = mysqli_query($koneksi, "SELECT * FROM paket_wisata");
            while($data = mysqli_fetch_array($query)) {
            ?>
            <div class="glass card-paket">
                <img src="<?php echo $data['gambar_url']; ?>" alt="Wisata" class="card-image">
                
                <div class="card-content">
                    <h3 class="card-title"><?php echo $data['nama_paket']; ?></h3>
                    <p class="card-desc"><?php echo $data['deskripsi']; ?></p>
                    
                    <?php if(!empty($data['video_url']) && $data['video_url'] != '#') { ?>
                    <div style="margin-bottom:15px;">
                        <a href="<?php echo $data['video_url']; ?>" target="_blank" style="color:var(--primary-blue); text-decoration:none; font-size:0.9rem;">
                            <i class="ri-play-circle-line"></i> Tonton Video
                        </a>
                    </div>
                    <?php } ?>

                    <div class="card-footer">
                        <span class="price">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
                        <a href="form-pesan.php?id_paket=<?php echo $data['id']; ?>" class="btn-pesan">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>