<!DOCTYPE html>
<html lang="id">
<head>
    <title>Masuk - YOTS TRAVEL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body style="display:flex; justify-content:center; align-items:center; min-height:100vh;">

    <div style="position:absolute; width:300px; height:300px; background:var(--primary-blue); border-radius:50%; top:-50px; left:-50px; opacity:0.4; filter:blur(80px); z-index:-1;"></div>
    <div style="position:absolute; width:300px; height:300px; background:#ff00ea; border-radius:50%; bottom:-50px; right:-50px; opacity:0.3; filter:blur(80px); z-index:-1;"></div>

    <div class="glass" style="padding: 40px; width: 100%; max-width: 420px; text-align: center;">
        
        <h2 style="margin-bottom: 5px; color: var(--primary-blue); font-size: 2rem;">Selamat Datang!</h2>
        <p style="margin-bottom: 30px; color: var(--text-secondary);">Masuk untuk melanjutkan petualangan.</p>

        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div class='alert alert-error'>Username atau Password salah!</div>";
            } else if($_GET['pesan'] == "logout"){
                echo "<div class='alert alert-success'>Anda telah berhasil logout.</div>";
            } else if($_GET['pesan'] == "belum_login"){
                echo "<div class='alert alert-warning'>Silakan login terlebih dahulu.</div>";
            } else if($_GET['pesan'] == "daftar_sukses"){
                echo "<div class='alert alert-success'>Pendaftaran berhasil! Silakan login.</div>";
            }
        }
        ?>

        <form action="cek-login.php" method="POST">
            <div class="input-group">
                <i class="ri-user-line input-icon"></i>
                <input type="text" name="username" placeholder="Username" required class="custom-input">
            </div>

            <div class="input-group">
                <i class="ri-lock-password-line input-icon"></i>
                <input type="password" name="password" placeholder="Password" required class="custom-input">
            </div>

            <div style="text-align:right; margin-bottom:20px;">
                <a href="https://wa.me/6281312345678?text=Halo%20Admin,%20saya%20lupa%20password%20akun%20YOTSTravel." target="_blank" style="font-size:0.85rem; color:var(--primary-blue); text-decoration:none;">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-pesan" style="width:100%; border:none; padding:12px; cursor:pointer; font-size:1rem;">Masuk Sekarang</button>
        </form>

        <div style="display:flex; align-items:center; margin: 25px 0; color:var(--text-secondary);">
            <div style="flex:1; height:1px; background:#ccc; opacity:0.5;"></div>
            <span style="padding: 0 10px; font-size:0.8rem;">ATAU MASUK DENGAN</span>
            <div style="flex:1; height:1px; background:#ccc; opacity:0.5;"></div>
        </div>

        <div class="social-login">
            <button class="btn-social google" onclick="alert('Fitur Login Google sedang dalam pengembangan (Butuh API Key). Silakan login manual.')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="G"> Google
            </button>
            <button class="btn-social facebook" onclick="alert('Fitur Login Facebook sedang dalam pengembangan.')">
                <i class="ri-facebook-fill"></i> Facebook
            </button>
        </div>
        
        <a href="https://wa.me/6281313264863?text=Halo%20Admin,%20saya%20ingin%20login%20via%20WhatsApp." target="_blank" style="text-decoration:none;">
            <button class="btn-social whatsapp" style="margin-top:10px; width:100%;">
                <i class="ri-whatsapp-line"></i> Masuk dengan WhatsApp
            </button>
        </a>

        <div style="margin-top: 30px; font-size: 0.9rem;">
            Belum punya akun? <a href="register.php" style="color: var(--primary-blue); font-weight:bold; text-decoration:none;">Daftar Sekarang</a>
        </div>
        
        <div style="margin-top: 15px;">
            <a href="index.php" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem;">&larr; Kembali ke Beranda</a>
        </div>
    </div>

    <style>
        .input-group { position: relative; margin-bottom: 15px; }
        .input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
        .custom-input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); background: rgba(255,255,255,0.8); outline: none; transition: 0.3s; }
        .custom-input:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(0,122,255,0.1); }
        
        .alert { padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-error { background: rgba(255,0,0,0.1); color: red; }
        .alert-success { background: rgba(0,255,0,0.1); color: green; }
        .alert-warning { background: rgba(255,165,0,0.1); color: orange; }

        .social-login { display: flex; gap: 10px; }
        .btn-social { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); background: white; cursor: pointer; font-weight: 500; transition: 0.2s; color: #333; }
        .btn-social:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .btn-social img { width: 18px; }
        
        .facebook { color: #1877F2; background: rgba(24, 119, 242, 0.05); border: 1px solid rgba(24, 119, 242, 0.1); }
        .whatsapp { color: #25D366; background: rgba(37, 211, 102, 0.05); border: 1px solid rgba(37, 211, 102, 0.1); }
    </style>
    
    <script src="script.js"></script>
</body>
</html>