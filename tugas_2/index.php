<?php

function hitungDiskon($totalBelanja) {
    if ($totalBelanja >= 100000) {
        return $totalBelanja * 0.10; 
    } 
    
    if ($totalBelanja >= 50000) {
        return $totalBelanja * 0.05;
    }

    return 0; 
}

$totalBelanja = 120000;

$diskon     = hitungDiskon($totalBelanja);
$totalBayar = $totalBelanja - $diskon;

echo "<h3>Hasil Perhitungan Kasir</h3>";
echo "Total Belanja   : Rp. " . number_format($totalBelanja, 0, ',', '.') . "<br>";
echo "Potongan Diskon : Rp. " . number_format($diskon, 0, ',', '.') . "<br>";
echo "<hr style='width: 300px; text-align: left; margin: 10px 0;'>";
echo "<b>Total Bayar : Rp. " . number_format($totalBayar, 0, ',', '.') . "</b>";

?>