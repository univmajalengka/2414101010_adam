<?php 
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id='$id'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesanan</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function hitungTotal() {
            let durasi = parseInt(document.getElementById('durasi').value) || 0;
            let peserta = parseInt(document.getElementById('peserta').value) || 0;
            
            let hargaInap = document.getElementById('chk_inap').checked ? 1000000 : 0;
            let hargaTrans = document.getElementById('chk_trans').checked ? 1200000 : 0;
            let hargaMakan = document.getElementById('chk_makan').checked ? 500000 : 0;

            let hargaPaket = hargaInap + hargaTrans + hargaMakan;
            let totalTagihan = durasi * peserta * hargaPaket;

            document.getElementById('txt_harga_paket').innerText = "Rp " + hargaPaket.toLocaleString('id-ID');
            document.getElementById('txt_total_tagihan').innerText = "Rp " + totalTagihan.toLocaleString('id-ID');

            document.getElementById('val_harga_paket').value = hargaPaket;
            document.getElementById('val_total_tagihan').value = totalTagihan;
        }
        window.onload = hitungTotal; // Hitung otomatis saat halaman edit dibuka
    </script>
</head>
<body>
    <div class="container" style="margin-top:20px; max-width:700px;">
        <div class="glass" style="padding:40px;">
            <h2>Edit Pesanan</h2>
            <form action="proses-edit.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                
                <div style="margin-bottom:15px;">
                    <label>Nama Pemesan</label>
                    <input type="text" name="nama" value="<?php echo $data['nama_pemesan']; ?>" required style="width:100%; padding:10px;">
                </div>
                
                <div style="margin-bottom:15px;">
                    <label>Durasi (Hari)</label>
                    <input type="number" name="durasi" id="durasi" value="<?php echo $data['durasi_wisata']; ?>" oninput="hitungTotal()" style="width:100%; padding:10px;">
                </div>

                <div style="margin-bottom:15px;">
                    <label>Layanan:</label><br>
                    <input type="checkbox" name="layanan_penginapan" id="chk_inap" value="1" onclick="hitungTotal()" <?php if($data['layanan_penginapan']==1) echo 'checked'; ?>> Penginapan<br>
                    <input type="checkbox" name="layanan_transport" id="chk_trans" value="1" onclick="hitungTotal()" <?php if($data['layanan_transport']==1) echo 'checked'; ?>> Transportasi<br>
                    <input type="checkbox" name="layanan_makan" id="chk_makan" value="1" onclick="hitungTotal()" <?php if($data['layanan_makan']==1) echo 'checked'; ?>> Makan<br>
                </div>

                <div style="margin-bottom:15px;">
                    <label>Jumlah Peserta</label>
                    <input type="number" name="jumlah" id="peserta" value="<?php echo $data['jumlah_peserta']; ?>" oninput="hitungTotal()" style="width:100%; padding:10px;">
                </div>

                <div style="background:#eee; padding:15px; border-radius:10px; margin-bottom:15px;">
                    <b>Harga Paket:</b> <span id="txt_harga_paket">Rp 0</span><br>
                    <b>Total Tagihan:</b> <span id="txt_total_tagihan">Rp 0</span>
                    <input type="hidden" name="harga_paket" id="val_harga_paket">
                    <input type="hidden" name="total_bayar" id="val_total_tagihan">
                </div>

                <button type="submit" class="btn-pesan" style="width:100%;">Update Data</button>
            </form>
        </div>
    </div>
</body>
</html>