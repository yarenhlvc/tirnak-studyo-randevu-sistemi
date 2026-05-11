<?php 
// OTURUM SİSTEMİNİ BAŞLATIYORUZ
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Nail Studio | Shining Like a Star</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <style>
        .nav-links { display: flex; align-items: center; gap: 25px; }
        .nav-links a { text-decoration: none; color: white; transition: 0.3s; }
        .nav-links a:hover:not(.login-btn) { color: #c5a059; }
        
        /* Kullanıcı Açılır Menüsü */
        .user-dropdown { position: relative; display: inline-block; margin-left: 10px; }
        .dropdown-trigger { color: #c5a059; cursor: pointer; font-size: 15px; font-style: italic; display: flex; align-items: center; gap: 5px; }
        .dropdown-menu { 
            position: absolute; top: 150%; right: 0; background: #0a141d; 
            border: 1px solid rgba(197, 160, 89, 0.2); border-radius: 8px; 
            min-width: 200px; box-shadow: 0 8px 25px rgba(0,0,0,0.6); 
            opacity: 0; visibility: hidden; transition: all 0.3s ease; transform: translateY(10px); z-index: 999;
        }
        .user-dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu a { display: block; padding: 12px 20px; color: white; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .dropdown-menu a:hover { background: rgba(197, 160, 89, 0.1); color: #c5a059; }
        .dropdown-menu .cikis-btn { color: #ff4d4d !important; border-bottom: none; }
        .dropdown-menu .cikis-btn:hover { background: rgba(255, 77, 77, 0.1); }
        
        /* Giriş Yap Butonu */
        .login-btn { color: #c5a059 !important; border: 1px solid #c5a059; padding: 8px 15px; border-radius: 5px; margin-left: 10px; }
        .login-btn:hover { background: #c5a059; color: black !important; }
    </style>
</head>
<body>

<header>
    <div class="wide-container nav-flex">
        
        <a href="index.php" class="premium-logo" style="text-decoration: none;">
            <span class="logo-sparkle">✨</span>
            <div class="logo-text">
                <span class="brand-star">STAR</span>
                <span class="brand-studio">NAIL STUDIO</span>
            </div>
        </a>
        
       <nav class="nav-links">
    <a href="index.php">Ana Sayfa</a>
    <a href="hizmetler.php">Hizmetler</a> <a href="galeri.php">Galeri</a>
    <a href="konum.php">Konum</a>
    
    </nav>
            
            <?php if(isset($_SESSION['kullanici_id'])): ?>
                <div class="user-dropdown">
                    <span class="dropdown-trigger">✨ <?= $_SESSION['ad_soyad'] ?> ▾</span>
                    <div class="dropdown-menu">
                        <a href="profil.php">Profilim ve Randevular</a>
                        <a href="cikis.php" class="cikis-btn">Güvenli Çıkış</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="giris.php" class="login-btn">Giriş Yap</a>
            <?php endif; ?>
        </nav>
    </div>
</header>