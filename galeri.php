<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'baglan.php'; 
include 'header.php'; 

// Veritabanından fotoğrafları çekiyoruz (Eğer tablo boşsa veya hata verirse çökmeyi önleyen sistem)
$sorgu = $db->query("SELECT * FROM galeri ORDER BY id DESC");
$galeri = $sorgu ? $sorgu->fetchAll(PDO::FETCH_ASSOC) : [];
?>

<main class="wide-container" style="padding: 100px 0; min-height: 60vh;">
    <h2 style="color: #c5a059; text-align: center; font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 50px;">
        Işıltılı <span style="font-style: italic; color: white;">Çalışmalarımız</span>
    </h2>
    
    <?php if(count($galeri) > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <?php foreach($galeri as $f): ?>
            <div style="border-radius: 10px; overflow: hidden; border: 1px solid rgba(197,160,89,0.2); position: relative;">
                <img src="uploads/<?php echo $f['foto_yol']; ?>" style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; color: #aaa; padding: 50px; background: rgba(255,255,255,0.02); border-radius: 10px;">
            Şu an galerimizde fotoğraf bulunmuyor. Işıltılı tırnaklar çok yakında burada!
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>