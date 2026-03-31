<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Nail Studio | Shining Like a Star</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="wide-container nav-flex">
        
        <a href="index.php" class="premium-logo">
            <span class="logo-sparkle">✨</span>
            <div class="logo-text">
                <span class="brand-star">STAR</span>
                <span class="brand-studio">NAIL STUDIO</span>
            </div>
        </a>
        
        <nav>
            <a href="index.php">Ana Sayfa</a>
            <a href="hizmetler.php">Hizmetler</a>
            <a href="galeri.php">Galeri</a>
            <a href="konum.php">Konum</a>
            <a href="randevu.php" class="gold-cta">Randevu Al</a>
        </nav>
    </div>
</header>
    <?php if(isset($_GET['durum']) && $_GET['durum'] == 'basarili'): ?>
    <div class="wide-container">
        <div class="success-alert">
            ✨ <span>Tebrikler!</span> Randevunuz başarıyla oluşturuldu. Işıltılı gününüzü sabırsızlıkla bekliyoruz.
        </div>
    </div>
<?php endif; ?>