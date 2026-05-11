<?php
session_start();
include 'baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['giris_yap'])) {
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];

    // =======================================================
    // 1. PATRON (ADMIN) GİRİŞ KONTROLÜ
    // =======================================================
    if ($eposta == 'ennur@star.com' && $sifre == 'patron123') {
        // Ennur giriş yaptı! Ona özel 'admin' yetkisi veriyoruz
        $_SESSION['admin_giris'] = true; 
        $_SESSION['kullanici_id'] = 999; // Sistem hata vermesin diye sanal bir ID
        $_SESSION['ad_soyad'] = 'Ennur (Patron)';
        
        // Doğrudan yönetim paneline fırlat!
        header("Location: admin.php");
        exit;
    }

    // =======================================================
    // 2. NORMAL MÜŞTERİ GİRİŞ KONTROLÜ
    // =======================================================
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta = ? AND sifre = ?");
    $sorgu->execute([$eposta, $sifre]);

    if ($sorgu->rowCount() > 0) {
        $kullanici = $sorgu->fetch();
        $_SESSION['kullanici_id'] = $kullanici['id'];
        $_SESSION['ad_soyad'] = $kullanici['ad_soyad'];
        
        // Müşteriyi randevu sayfasına yolla!
        header("Location: randevu.php");
        exit;
    } else {
        $hata = "E-posta veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap | Star Nail Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-box { max-width: 400px; margin: 80px auto; background: rgba(255,255,255,0.03); padding: 40px; border: 1px solid rgba(197,160,89,0.2); border-radius: 15px; text-align: center; position: relative; }
        .auth-box input { width: 100%; padding: 12px; margin-bottom: 15px; background: #050a0f; border: 1px solid #222; color: white; border-radius: 5px; }
        .auth-box input:focus { border-color: #c5a059; outline: none; }
        .error-alert { background: #ff4d4d; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .success-alert { background: #c5a059; color: black; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold;}
        .back-link { position: absolute; top: 20px; left: 20px; color: #aaa; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px; transition: 0.3s; }
        .back-link:hover { color: #c5a059; }
    </style>
</head>
<body>
    <div class="wide-container">
        <div class="auth-box">
            <a href="index.php" class="back-link">← Ana Sayfa</a>
            
            <h2 style="font-family: 'Playfair Display', serif; color: white; margin-bottom: 20px; margin-top: 15px;">
                Tekrar <span style="color: #c5a059; font-style: italic;">Hoş Geldiniz</span>
            </h2>
            <?php if(isset($_GET['durum']) && $_GET['durum'] == 'yeni_kayit'): ?> <div class="success-alert">Kayıt başarılı! Şimdi giriş yapabilirsiniz.</div> <?php endif; ?>
            <?php if(isset($_GET['durum']) && $_GET['durum'] == 'izinsiz'): ?> <div class="error-alert">Bu sayfaya girmek için yetkiniz yok!</div> <?php endif; ?>
            <?php if(isset($hata)): ?> <div class="error-alert"><?= $hata ?></div> <?php endif; ?>
            
            <form method="POST">
                <input type="email" name="eposta" placeholder="E-Posta Adresiniz" required>
                <input type="password" name="sifre" placeholder="Şifreniz" required>
                <button type="submit" name="giris_yap" class="shimmer-btn" style="width: 100%; padding: 12px; background: #c5a059; border: none; color: black; font-weight: bold; border-radius: 5px; cursor: pointer;">GİRİŞ YAP</button>
            </form>
            <p style="margin-top: 20px; font-size: 14px;">Hesabınız yok mu? <a href="kayit.php" style="color: #c5a059;">Hemen Kayıt Olun</a></p>
        </div>
    </div>
</body>
</html>