<?php
// Veritabanı bilgilerini buraya daha net yazdık
$host = "127.0.0.1"; // localhost yerine IP kullandık (daha garantidir)
$port = "3307";      // Senin özel portun
$veritabani_adi = "star_nail_db";
$kullanici_adi = "root";
$sifre = "";   // Senin kullandığın şifre

try {
    // Bağlantı dizesini portu da içerecek şekilde güncelledik
    $dsn = "mysql:host=$host;port=$port;dbname=$veritabani_adi;charset=utf8";
    
    $db = new PDO($dsn, $kullanici_adi, $sifre);
    
    // Hata modunu aç
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "<div style='color:green; font-weight:bold; padding:20px; border:2px solid green;'>
          //✨ BAĞLANTI BAŞARILI! Yıldızlar parlamaya hazır Yaren! 
          //</div>"; 
    
} catch (PDOException $e) {
    echo "<div style='color:red; padding:20px; border:2px solid red;'>";
    echo "<b>Hata Oluştu:</b> " . $e->getMessage();
    echo "<br><br><i>İpucu: Eğer hala şifre hatası veriyorsa, şifre kısmını çift tırnak arasını boş bırakarak denemelisin.</i>";
    echo "</div>";
}
?>