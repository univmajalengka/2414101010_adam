<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun Baru - YOTS TRAVEL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body style="display:flex; justify-content:center; align-items:center; min-height:100vh;">

    <div style="position:absolute; width:300px; height:300px; background:var(--primary-blue); border-radius:50%; top:-50px; left:-50px; opacity:0.4; filter:blur(80px); z-index:-1;"></div>
    <div style="position:absolute; width:300px; height:300px; background:#ff00ea; border-radius:50%; bottom:-50px; right:-50px; opacity:0.3; filter:blur(80px); z-index:-1;"></div>

    <div class="glass" style="padding: 40px; width: 100%; max-width: 450px; text-align: center;">
        
        <h2 style="margin-bottom: 5px; color: var(--primary-blue);">Buat Akun Baru</h2>
        <p style="margin-bottom: 30px; color: var(--text-secondary);">Gabung dan mulai petualanganmu sekarang!</p>

        <form action="proses-register.php" method="POST">
            
            <div class="input-group">
                <i class="ri-user-smile-line input-icon"></i>
                <input type="text" name="nama" placeholder="Nama Lengkap" required class="custom-input">
            </div>

            <div class="input-group">
                <i class="ri-user-line input-icon"></i>
                <input type="text" name="username" placeholder="Buat Username" required class="custom-input">
            </div>

            <div class="input-group">
                <i class="ri-lock-password-line input-icon"></i>
                <input type="password" name="password" placeholder="Buat Password" required class="custom-input">
            </div>

            <button type="submit" class="btn-pesan" style="width:100%; border:none; padding:12px; cursor:pointer; font-size:1rem; margin-top:10px;">Daftar Sekarang</button>
        </form>

        <div style="margin-top: 25px;">
            Sudah punya akun? <a href="login.php" style="color: var(--primary-blue); font-weight:bold; text-decoration:none;">Login di sini</a>
        </div>
    </div>

    <style>
        .input-group { position: relative; margin-bottom: 15px; }
        .input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
        .custom-input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); background: rgba(255,255,255,0.8); outline: none; transition: 0.3s; }
        .custom-input:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(0,122,255,0.1); }
    </style>
    
    <script src="script.js"></script>
</body>
</html>