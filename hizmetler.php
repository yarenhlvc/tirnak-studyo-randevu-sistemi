<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'baglan.php'; 
include 'header.php'; 

// Veritabanından hizmetleri çekiyoruz
$hizmetler = $db->query("SELECT * FROM hizmetler ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="wide-container" style="padding: 100px 0; min-height: 60vh;">
    <h2 style="color: #c5a059; text-align: center; font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 50px;">
        Premium <span style="font-style: italic; color: white;">Hizmetlerimiz</span>
    </h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        <?php foreach($hizmetler as $h): ?>
        <div style="background: rgba(255,255,255,0.03); padding: 40px 30px; border-radius: 15px; border: 1px solid rgba(197, 160, 89, 0.2); text-align: center; transition: 0.3s;" onmouseover="this.style.borderColor='#c5a059'" onmouseout="this.style.borderColor='rgba(197, 160, 89, 0.2)'">
            <h3 style="color: white; margin-bottom: 10px; font-size: 22px;"><?= $h['hizmet_adi'] ?></h3>
            <p style="color: #aaa; margin-bottom: 20px; font-size: 14px;">İşlem Süresi: Yaklaşık <?= $h['sure'] ?> dk</p>
            <div style="font-size: 28px; color: #c5a059; font-weight: bold; margin-bottom: 25px;"><?= $h['fiyat'] ?> ₺</div>
            <a href="randevu.php" class="shimmer-btn" style="padding: 10px 25px; font-size: 14px; display: inline-block;">Hemen Randevu Al</a>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'footer.php'; ?>