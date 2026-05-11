<?php
session_start();

if (isset($_SESSION['admin_giris']) && $_SESSION['admin_giris'] === true) {
    header("Location: admin.php");
    exit;
}

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit;
}

include 'baglan.php';
date_default_timezone_set('Europe/Istanbul');
include 'header.php';

$kullanici_id = $_SESSION['kullanici_id'];

$kullanici_sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE id = ?");
$kullanici_sorgu->execute([$kullanici_id]);
$kullanici = $kullanici_sorgu->fetch();

$randevu_sorgu = $db->prepare("
    SELECT r.*, h.hizmet_adi, h.fiyat, h.sure 
    FROM randevular r 
    JOIN hizmetler h ON r.hizmet_id = h.id 
    WHERE r.kullanici_id = ? 
    ORDER BY r.randevu_tarihi DESC, r.randevu_saati DESC
");
$randevu_sorgu->execute([$kullanici_id]);
$randevular = $randevu_sorgu->fetchAll(PDO::FETCH_ASSOC);

$su_an = time();
$bekleyenler = [];
$gecmisler = [];

foreach ($randevular as $randevu) {
    $randevu_zamani = strtotime($randevu['randevu_tarihi'] . ' ' . $randevu['randevu_saati']);
    if ($randevu_zamani >= $su_an) {
        $bekleyenler[] = $randevu; 
    } else {
        $gecmisler[] = $randevu; 
    }
}
?>

<style>
    .profile-container { max-width: 1000px; margin: 50px auto; display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }
    .profile-card { background: rgba(255, 255, 255, 0.03); padding: 30px; border: 1px solid rgba(197, 160, 89, 0.2); border-radius: 15px; text-align: center; height: fit-content; }
    .profile-avatar { width: 80px; height: 80px; background: #c5a059; color: black; font-size: 32px; font-weight: bold; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
    .profile-info { text-align: left; margin-top: 30px; }
    .profile-info p { margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px; font-size: 14px; opacity: 0.8; }
    .profile-info span { color: #c5a059; display: block; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
    
    .appointments-section { background: transparent; }
    .section-title { font-family: 'Playfair Display', serif; color: white; margin-bottom: 20px; font-size: 24px; border-bottom: 1px solid #c5a059; padding-bottom: 10px; display: inline-block; }
    
    .appointment-card { background: #050a0f; border: 1px solid rgba(197, 160, 89, 0.2); padding: 20px; border-radius: 10px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; transition: transform 0.3s; }
    .appointment-card:hover { transform: translateX(5px); border-color: #c5a059; }
    
    .apt-date { background: #c5a059; color: black; padding: 10px 15px; border-radius: 8px; text-align: center; font-weight: bold; min-width: 80px; }
    .apt-date span { display: block; font-size: 12px; font-weight: normal; margin-top: 3px; }
    
    .apt-details { flex-grow: 1; padding: 0 20px; }
    .apt-details h4 { margin: 0 0 5px 0; color: white; font-size: 18px; }
    .apt-details p { margin: 0; color: #aaa; font-size: 14px; }
    
    .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; margin-top: 8px; text-transform: capitalize; }
    .status-bekliyor { background: rgba(241, 196, 15, 0.1); color: #f1c40f; border: 1px solid #f1c40f; }
    .status-onaylandi { background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid #2ecc71; }
    .status-iptal { background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #e74c3c; }
    
    .apt-price { font-size: 20px; color: #c5a059; font-weight: bold; text-align: right; }
    .past-apt { opacity: 0.6; filter: grayscale(100%); }
    .past-apt:hover { filter: grayscale(0%); opacity: 1; }
.empty-msg { color: #aaa; font-style: italic; background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; text-align: center; }

/* PROFIL SAYFASI MOBİL UYUMU - KESİN ÇÖZÜM */
    @media screen and (max-width: 768px) {
        .profile-container {
            display: flex !important;
            flex-direction: column !important; /* Kutuları KESİNLİKLE alt alta dizer */
            gap: 20px;
        }
        .appointment-card {
            flex-direction: column !important;
            align-items: center !important;
            text-align: center;
            gap: 15px;
        }
        .apt-details {
            padding: 0;
            width: 100%;
        }
        .apt-price {
            text-align: center;
            width: 100%;
        }
    }
</style>


<div class="wide-container">
    <div class="profile-container">
        
        <div class="profile-card">
            <div class="profile-avatar"><?= mb_substr($kullanici['ad_soyad'], 0, 1) ?></div>
            <h3 style="color: white; margin-bottom: 5px; font-family: 'Playfair Display', serif; font-size: 22px;"><?= $kullanici['ad_soyad'] ?></h3>
            <p style="color: #aaa; font-size: 14px; margin-bottom: 20px;">Işıltılı Müşteri</p>
            
            <div class="profile-info">
                <p><span>Telefon</span> <?= $kullanici['telefon'] ?></p>
                <p><span>E-Posta</span> <?= $kullanici['eposta'] ?></p>
            </div>
        </div>
        
        <div class="appointments-section">
            
            <h3 class="section-title">Bekleyen <span style="color: #c5a059; font-style: italic;">Randevularım</span></h3>
            <?php if(count($bekleyenler) > 0): ?>
                <?php foreach($bekleyenler as $apt): ?>
                    
                    <?php 
                        $orijinal_durum = $apt['durum'] ?? 'Bekliyor';
                        $durum_kucuk = mb_strtolower($orijinal_durum, 'UTF-8');
                        
                        $durum_class = "status-bekliyor";
                        $durum_ikon = "⏳";
                        
                        if(strpos($durum_kucuk, 'onay') !== false) { 
                            $durum_class = "status-onaylandi"; 
                            $durum_ikon = "✓"; 
                        }
                        if(strpos($durum_kucuk, 'iptal') !== false || strpos($durum_kucuk, 'i̇ptal') !== false) { 
                            $durum_class = "status-iptal"; 
                            $durum_ikon = "✗"; 
                        }
                    ?>

                    <div class="appointment-card" style="<?= $durum_class == 'status-iptal' ? 'opacity: 0.5;' : '' ?>">
                        <div class="apt-date">
                            <?= date('d M', strtotime($apt['randevu_tarihi'])) ?>
                            <span><?= date('H:i', strtotime($apt['randevu_saati'])) ?></span>
                        </div>
                        <div class="apt-details">
                            <h4><?= $apt['hizmet_adi'] ?></h4>
                            <p>Süre: Yaklaşık <?= $apt['sure'] ?> dakika</p>
                            
                            <div class="status-badge <?= $durum_class ?>">
                                <?= $durum_ikon . " " . $orijinal_durum ?>
                            </div>
                            
                        </div>
                        <div class="apt-price"><?= $apt['fiyat'] ?> ₺</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-msg">Şu an için bekleyen ışıltılı bir randevunuz bulunmuyor.</div>
            <?php endif; ?>
            
            <div style="margin-top: 50px;"></div>
            
            <h3 class="section-title">Geçmiş <span style="color: #c5a059; font-style: italic;">İşlemlerim</span></h3>
            <?php if(count($gecmisler) > 0): ?>
                <?php foreach($gecmisler as $apt): ?>
                    <div class="appointment-card past-apt">
                        <div class="apt-date" style="background: #333; color: #aaa;">
                            <?= date('d M', strtotime($apt['randevu_tarihi'])) ?>
                            <span><?= date('H:i', strtotime($apt['randevu_saati'])) ?></span>
                        </div>
                        <div class="apt-details">
                            <h4 style="color: #ccc;"><?= $apt['hizmet_adi'] ?></h4>
                            <p>Tamamlandı</p>
                        </div>
                        <div class="apt-price" style="color: #888;"><?= $apt['fiyat'] ?> ₺</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-msg">Henüz tamamlanmış bir işleminiz bulunmuyor.</div>
            <?php endif; ?>
            
        </div>
        
    </div>
</div>

<?php include 'footer.php'; ?>