<?php 
session_start();
include 'koneksi.php';

// CEK KEAMANAN
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login" || $_SESSION['role'] != "admin"){
    header("location:login.php?pesan=belum_login");
    exit; 
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - YOTS TRAVEL Admin</title>
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
        <a href="index.php" class="logo"><i class="ri-plane-fill"></i> YOTS TRAVEL Admin</a>
        
        <div class="nav-links">
            <a href="index.php" class="nav-btn">Beranda</a>
            <a href="form-pesan.php" class="btn-pesan" style="padding: 8px 20px; font-size: 0.9rem;">+ Tambah Pesanan</a>
            <a href="logout.php" class="nav-btn" style="background:rgba(255,0,0,0.1); color:red;">Logout</a>
        </div>
        
        <button id="theme-toggle"><i class="ri-moon-line" id="theme-icon"></i></button>
    </nav>

    <div class="container" style="max-width: 1200px; margin-top: 40px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h2 style="color: var(--text-main);">Daftar Pesanan Masuk</h2>
        </div>
        
        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%" style="text-align:center;">No</th>
                        <th width="20%">Pelanggan</th>
                        <th width="20%">Jadwal & Durasi</th>
                        <th width="25%">Layanan Tambahan</th>
                        <th width="15%">Tagihan</th>
                        <th width="15%" style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM pemesanan ORDER BY id DESC");
                    
                    if(mysqli_num_rows($query) == 0){
                        echo "<tr><td colspan='6' style='text-align:center; padding:30px; font-style:italic;'>Belum ada data pesanan.</td></tr>";
                    }

                    while($row = mysqli_fetch_array($query)){
                        $layanan = [];
                        if($row['layanan_penginapan']) $layanan[] = "Inap";
                        if($row['layanan_transport']) $layanan[] = "Trans";
                        if($row['layanan_makan']) $layanan[] = "Makan";
                        $txt_layanan = empty($layanan) ? "-" : implode(", ", $layanan);
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no++; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['nama_pemesan']); ?></strong><br>
                            <small style="opacity: 0.7;"><?php echo htmlspecialchars($row['no_hp']); ?></small>
                        </td>
                        <td>
                            <?php echo date('d M Y', strtotime($row['tanggal_wisata'])); ?><br>
                            <span class="badge"><?php echo $row['durasi_wisata']; ?> Hari</span>
                        </td>
                        <td>
                            <?php 
                                foreach($layanan as $l) {
                                    echo "<span class='badge'>$l</span> ";
                                }
                                if(empty($layanan)) echo "<small style='opacity:0.5;'>-</small>";
                            ?>
                        </td>
                        <td style="font-weight: bold; color: var(--primary-blue);">
                            Rp <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?>
                        </td>
                        
                        <td style="text-align:center;">
                            <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                                <a href="form-edit.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <a href="hapus-pesanan.php?id=<?php echo $row['id']; ?>" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin hapus data ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>