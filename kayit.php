<?php
session_start();
include 'baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kayit_ol'])) {
    $ad_soyad = $_POST['ad_soyad'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];

    $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE eposta = ?");
    $kontrol->execute([$eposta]);

    if ($kontrol->rowCount() > 0) {
        $hata = "Bu e-posta adresi zaten kayıtlı! Lütfen giriş yapın.";
    } else {
        $ekle = $db->prepare("INSERT INTO kullanicilar (ad_soyad, telefon, eposta, sifre) VALUES (?, ?, ?, ?)");
        if ($ekle->execute([$ad_soyad, $telefon, $eposta, $sifre])) {
            header("Location: giris.php?durum=yeni_kayit");
            exit;
        } else {
            $hata = "Kayıt sırasında bir hata oluştu!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol | Star Nail Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-box { max-width: 400px; margin: 80px auto; background: rgba(255,255,255,0.03); padding: 40px; border: 1px solid rgba(197,160,89,0.2); border-radius: 15px; text-align: center; position: relative; }
        .auth-box input { width: 100%; padding: 12px; margin-bottom: 15px; background: #050a0f; border: 1px solid #222; color: white; border-radius: 5px; }
        .auth-box input:focus { border-color: #c5a059; outline: none; }
        .error-alert { background: #ff4d4d; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        
        /* Ana Sayfaya Dön Butonu CSS'i */
        .back-link { position: absolute; top: 20px; left: 20px; color: #aaa; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px; transition: 0.3s; }
        .back-link:hover { color: #c5a059; }
    </style>
</head>
<body>
    <div class="wide-container">
        <div class="auth-box">
            <a href="index.php" class="back-link">← Ana Sayfa</a>
            
            <h2 style="font-family: 'Playfair Display', serif; color: white; margin-bottom: 20px; margin-top: 15px;">
                Aramıza <span style="color: #c5a059; font-style: italic;">Katıl</span>
            </h2>
            <?php if(isset($hata)): ?> <div class="error-alert"><?= $hata ?></div> <?php endif; ?>
            <form method="POST">
                <input type="text" name="ad_soyad" placeholder="Adınız ve Soyadınız" required>
                <input type="tel" name="telefon" placeholder="Telefon Numaranız" required>
                <input type="email" name="eposta" placeholder="E-Posta Adresiniz" required>
                <input type="password" name="sifre" placeholder="Şifreniz" required>
                <button type="submit" name="kayit_ol" class="shimmer-btn" style="width: 100%; padding: 12px; background: #c5a059; border: none; color: black; font-weight: bold; border-radius: 5px; cursor: pointer;">KAYIT OL</button>
            </form>
            <p style="margin-top: 20px; font-size: 14px;">Zaten üye misiniz? <a href="giris.php" style="color: #c5a059;">Giriş Yapın</a></p>
        </div>
    </div>
</body>
</html>