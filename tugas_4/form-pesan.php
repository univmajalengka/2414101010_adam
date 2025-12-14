<?php 
// 1. MULAI SESSION (Wajib paling atas)
session_start(); 
include 'koneksi.php'; 

// TANGKAP ID DARI URL
$id_paket_url = isset($_GET['id_paket']) ? $_GET['id_paket'] : 0;
$nama_paket_info = "Custom Trip (Paket Rakitan)";
$harga_paket_info = 0;

if($id_paket_url > 0){
    $cek_paket = mysqli_query($koneksi, "SELECT * FROM paket_wisata WHERE id = '$id_paket_url'");
    if($row = mysqli_fetch_array($cek_paket)){
        $nama_paket_info = $row['nama_paket'];
        $harga_paket_info = $row['harga'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Form Pemesanan - YOTS TRAVEL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

    <nav class="glass">
        <a href="index.php" class="logo"><i class="ri-plane-fill"></i> YOTS TRAVEL</a>
        <div class="nav-links">
            <a href="index.php" class="nav-btn">Beranda</a>
            
            <?php 
            // CEK LOGIN
            if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
                
                // CEK ROLE: ADMIN ATAU CUSTOMER?
                if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
                    // ADMIN: Lihat menu kelola
                    echo '<a href="modifikasi_pesanan.php" class="nav-btn">Kelola Pesanan</a>';
                    echo '<a href="logout.php" class="nav-btn" style="background:rgba(255,0,0,0.1); color:red;">Logout Admin</a>';
                } else {
                    // CUSTOMER: Cuma sapaan & logout (TIDAK ADA TOMBOL KELOLA)
                    echo '<span class="nav-btn" style="cursor:default; border:none;">Halo, '. $_SESSION['nama_lengkap'] .'</span>';
                    echo '<a href="logout.php" class="nav-btn" style="background:rgba(255,0,0,0.1); color:red;">Logout</a>';
                }

            } else { 
                // GUEST: Tombol Masuk
                echo '<a href="login.php" class="nav-btn" style="background:var(--primary-blue); color:white; padding: 8px 20px;"><i class="ri-login-box-line"></i> Masuk</a>';
            } 
            ?>
        </div>
        <button id="theme-toggle"><i class="ri-moon-line" id="theme-icon"></i></button>
    </nav>
    <div class="container" style="margin-top:20px; max-width:700px;">
        <div class="glass" style="padding:40px;">
            <h2 style="margin-bottom:10px; color:var(--primary-blue);">Formulir Pemesanan</h2>
            
            <div style="background: rgba(0,122,255,0.1); padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <small>Anda memesan:</small><br>
                <strong><?php echo $nama_paket_info; ?></strong>
            </div>
            
            <form action="proses-pesan.php" method="POST" id="bookingForm">
                <input type="hidden" name="id_paket_form" value="<?php echo $id_paket_url; ?>">

                <div class="form-group">
                    <label>Nama Pemesan</label>
                    <input type="text" name="nama" required class="form-input" 
                           value="<?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Nomor HP/Telp</label>
                    <input type="number" name="no_hp" required class="form-input">
                </div>

                <div class="row-input">
                    <div class="form-group">
                        <label>Tanggal Mulai Wisata</label>
                        <input type="date" name="tgl_wisata" required class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Waktu Perjalanan (Hari)</label>
                        <input type="number" name="durasi" id="durasi" value="1" min="1" required class="form-input" oninput="hitungTotal()">
                    </div>
                </div>

                <div class="form-group">
                    <label>Pilih Pelayanan Tambahan:</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="layanan_penginapan" id="chk_inap" value="1" onclick="hitungTotal()"> 
                            Penginapan (+Rp 1.000.000)
                        </label>
                        <label>
                            <input type="checkbox" name="layanan_transport" id="chk_trans" value="1" onclick="hitungTotal()"> 
                            Transportasi (+Rp 1.200.000)
                        </label>
                        <label>
                            <input type="checkbox" name="layanan_makan" id="chk_makan" value="1" onclick="hitungTotal()"> 
                            Service/Makan (+Rp 500.000)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jumlah Peserta</label>
                    <input type="number" name="jumlah" id="peserta" value="1" min="1" required class="form-input" oninput="hitungTotal()">
                </div>

                <div class="total-section">
                    <div class="row-total">
                        <span>Base Harga Paket:</span>
                        <span id="txt_base_harga">Rp <?php echo number_format($harga_paket_info,0,',','.'); ?></span>
                    </div>
                    <div class="row-total">
                        <span>Total Layanan Tambahan:</span>
                        <span id="txt_layanan">Rp 0</span>
                    </div>
                    <div class="row-total main-total">
                        <span>Total Tagihan:</span>
                        <span id="txt_total_tagihan">Rp 0</span>
                        <input type="hidden" name="harga_paket_final" id="val_harga_paket">
                        <input type="hidden" name="total_bayar" id="val_total_tagihan">
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-pesan" style="width:100%; border:none;">Simpan Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="paymentModal" class="modal-overlay">
        <div class="modal-content glass">
            <div style="text-align: center;">
                <div class="success-icon"><i class="ri-check-line"></i></div>
                <h2 style="color:var(--text-main); margin-bottom:10px;">Pemesanan Berhasil!</h2>
                <p style="color:var(--text-secondary); margin-bottom:20px;">Silakan selesaikan pembayaran melalui:</p>
                
                <div class="payment-box">
                    <h4 style="color: #008CFF; margin-bottom: 10px;">DANA / QRIS</h4>
                    <img src="img/A.N ADAM NUGROHO.svg" alt="QR Code" style="border-radius:10px; border:2px solid #eee;">
                    <p style="font-size:0.8rem; margin-top:5px; color:var(--text-secondary);">Scan QR di atas</p>
                </div>

                <p style="margin: 10px 0; font-weight:bold; color:var(--text-secondary);">— ATAU —</p>

                <div class="payment-box">
                    <h4 style="color: var(--text-main); margin-bottom: 5px;">Transfer Manual</h4>
                    <div class="copy-text">
                        <span id="rekNumber" style="font-family:monospace; font-size:1.2rem; font-weight:bold;">0813-1326-4863</span>
                        <button onclick="copyToClipboard()" style="background:none; border:none; color:var(--primary-blue); cursor:pointer;"><i class="ri-file-copy-line"></i></button>
                    </div>
                    <p style="font-size:0.9rem; color:var(--text-secondary);">a.n. YOTS Travel Admin</p>
                </div>

                <button onclick="closeModal()" class="btn-pesan" style="width:100%; margin-top:20px; border:none;">Saya Sudah Bayar</button>
            </div>
        </div>
    </div>

    <style>
        .form-group { margin-bottom: 15px; }
        .form-input { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ccc; background: rgba(255,255,255,0.5); color: var(--text-main); }
        .row-input { display: flex; gap: 15px; flex-wrap: wrap; }
        .row-input .form-group { flex: 1; min-width: 150px; }
        .checkbox-group label { display: block; margin-bottom: 8px; cursor: pointer; color: var(--text-main); }
        .total-section { background: rgba(0,122,255,0.1); padding: 20px; border-radius: 15px; margin-top: 20px; border: 1px solid var(--primary-blue); }
        .row-total { display: flex; justify-content: space-between; margin-bottom: 5px; color: var(--text-main); }
        .main-total { font-weight: 800; font-size: 1.2rem; color: var(--primary-blue); border-top: 1px solid rgba(0,0,0,0.1); padding-top: 10px; margin-top: 10px;}

        /* MODAL POPUP */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7); z-index: 9999; backdrop-filter: blur(8px);
            align-items: center; justify-content: center;
        }
        .modal-content {
            background: var(--bg-color); padding: 30px; border-radius: 20px; position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); animation: popUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center; overflow-y: auto; max-height: 90vh; width: 90%; max-width: 380px;
        }
        .payment-box img { width: 100%; max-width: 160px !important; height: auto; display: block; margin: 0 auto; }
        .success-icon {
            width: 70px; height: 70px; background: #25D366; color: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 35px;
            margin: -50px auto 20px auto; border: 5px solid var(--bg-color); box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        }
        .payment-box { background: rgba(128,128,128,0.05); border: 1px solid var(--card-border); padding: 15px; border-radius: 12px; margin-bottom: 15px; }
        @keyframes popUp { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>

    <script src="script.js"></script>
    <script>
        const baseHargaPaket = <?php echo (int)$harga_paket_info; ?>;

        function hitungTotal() {
            let durasi = parseInt(document.getElementById('durasi').value) || 0;
            let peserta = parseInt(document.getElementById('peserta').value) || 0;
            
            let hargaInap = document.getElementById('chk_inap').checked ? 1000000 : 0;
            let hargaTrans = document.getElementById('chk_trans').checked ? 1200000 : 0;
            let hargaMakan = document.getElementById('chk_makan').checked ? 500000 : 0;

            let totalLayanan = hargaInap + hargaTrans + hargaMakan;
            let hargaPerOrg = baseHargaPaket + totalLayanan; 
            let totalTagihan = hargaPerOrg * peserta * durasi;

            document.getElementById('txt_layanan').innerText = "+ Rp " + totalLayanan.toLocaleString('id-ID');
            document.getElementById('txt_total_tagihan').innerText = "Rp " + totalTagihan.toLocaleString('id-ID');

            document.getElementById('val_harga_paket').value = hargaPerOrg; 
            document.getElementById('val_total_tagihan').value = totalTagihan; 
        }

        window.onload = function() {
            hitungTotal();
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('status') === 'sukses') {
                document.getElementById('paymentModal').style.display = 'flex';
            }
        };

        function closeModal() {
            document.getElementById('paymentModal').style.display = 'none';
            window.history.replaceState({}, document.title, window.location.pathname);
            document.getElementById('bookingForm').reset();
            hitungTotal();
        }

        function copyToClipboard() {
            const rek = document.getElementById("rekNumber").innerText;
            navigator.clipboard.writeText(rek);
            alert("Nomor berhasil disalin!");
        }
    </script>
</body>
</html>