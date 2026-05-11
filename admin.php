<?php
session_start();
include 'baglan.php';

if (!isset($_SESSION['admin_giris']) || $_SESSION['admin_giris'] !== true) {
    header("Location: giris.php?durum=izinsiz");
    exit;
}

$randevu_cek = $db->query("SELECT r.id AS r_id, r.randevu_tarihi, r.randevu_saati, r.durum, k.ad_soyad, k.telefon, h.hizmet_adi FROM randevular r JOIN kullanicilar k ON r.kullanici_id = k.id JOIN hizmetler h ON r.hizmet_id = h.id ORDER BY r.randevu_tarihi DESC");
$randevular = $randevu_cek->fetchAll(PDO::FETCH_ASSOC);

$hizmetler = $db->query("SELECT * FROM hizmetler ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$galeri = $db->query("SELECT * FROM galeri ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli | Star Nail Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #050a0f; color: white; font-family: 'Poppins', sans-serif; margin: 0; }
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #0a141d; border-right: 1px solid rgba(197, 160, 89, 0.2); padding: 30px 20px; position: fixed; height: 100%; }
        .sidebar h2 { color: #c5a059; font-size: 20px; margin-bottom: 40px; text-align: center; }
        .tablink { display: block; width: 100%; text-align: left; background: none; border: none; color: #aaa; padding: 15px; border-radius: 8px; margin-bottom: 10px; cursor: pointer; font-size: 15px; transition: 0.3s; }
        .tablink:hover, .tablink.active { background: rgba(197, 160, 89, 0.1); color: #c5a059; font-weight: 600; }
        .content { flex-grow: 1; margin-left: 260px; padding: 40px; }
        .admin-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; display: none; }
        .admin-card.active { display: block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: rgba(0,0,0,0.2); border-radius: 10px; overflow: hidden; }
        th { text-align: left; color: #c5a059; padding: 18px; background: rgba(197, 160, 89, 0.05); }
        td { padding: 18px; border-bottom: 1px solid #111; font-size: 14px; }
        .btn { padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold; display: inline-block; cursor: pointer; border: none; transition: 0.3s; }
        .btn-onay { background: #2ecc71; color: white; margin-right: 5px; }
        .btn-iptal { background: #e74c3c; color: white; }
        .btn-duzenle { background: #f39c12; color: white; margin-right: 5px; }
        .btn-onay:hover { background: #27ae60; }
        .btn-iptal:hover { background: #c0392b; }
        .form-row { display: flex; gap: 15px; margin-bottom: 30px; align-items: center; }
        input { background: #111; border: 1px solid #333; color: white; padding: 12px; border-radius: 5px; width: 100%; box-sizing: border-box; }
    
        /* ADMIN PANELİ MOBİL UYUMU */
    @media screen and (max-width: 768px) {
        .admin-container {
            flex-direction: column; /* Yan yana duran admin tasarımını alt alta al */
        }
        .sidebar {
            width: 100%;
            height: auto;
            position: relative; /* Sabitliği kaldır */
            border-right: none;
            border-bottom: 1px solid rgba(197, 160, 89, 0.2);
            padding: 20px;
            box-sizing: border-box;
        }
        .content {
            margin-left: 0; /* İçeriğin solundaki menü boşluğunu sıfırla */
            padding: 20px 10px;
        }
        /* Tablolar ekrana sığmazsa yatay scroll (kaydırma) çubuğu çıkar */
        .admin-card table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        .form-row {
            flex-direction: column;
        }
        .form-row input {
            width: 100% !important;
        }
    }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="sidebar">
        <h2>✨ STAR ADMIN</h2>
        <button class="tablink active" onclick="openTab(event, 'randevular')">Randevu Yönetimi</button>
        <button class="tablink" onclick="openTab(event, 'hizmetler')">Hizmet Ayarları</button>
        <button class="tablink" onclick="openTab(event, 'galeri')">Galeri Yönetimi</button>
        <div style="margin-top: 50px; border-top: 1px solid #222; padding-top: 20px;">
            <a href="index.php" style="color: #aaa; text-decoration: none; display: block; margin-bottom: 15px;">← Siteye Dön</a>
            <a href="cikis.php" style="color: #ff4d4d; text-decoration: none;">Güvenli Çıkış</a>
        </div>
    </div>

    <div class="content">
        <div id="randevular" class="admin-card active">
            <h3 style="color: #c5a059;">Randevu Listesi</h3>
            <table>
                <thead>
                    <tr>
                        <th>Müşteri</th>
                        <th>Hizmet</th>
                        <th>Zaman</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($randevular as $r): ?>
                    <?php 
                        // AKILLI DURUM VE BUTON KONTROLÜ
                        $durum_kucuk = mb_strtolower($r['durum'], 'UTF-8');
                        $durum_renk = '#f1c40f'; // Varsayılan Sarı
                        $durum_metin = 'Bekliyor';
                        $is_onayli = false;
                        $is_iptal = false;
                        
                        if (strpos($durum_kucuk, 'onay') !== false) {
                            $durum_renk = '#2ecc71';
                            $durum_metin = 'Onaylandı';
                            $is_onayli = true;
                        } elseif (strpos($durum_kucuk, 'iptal') !== false || strpos($durum_kucuk, 'i̇ptal') !== false) {
                            $durum_renk = '#e74c3c';
                            $durum_metin = 'İptal Edildi';
                            $is_iptal = true;
                        } else {
                            $durum_metin = $r['durum']; 
                        }
                    ?>
                    <tr>
                        <td><b><?= $r['ad_soyad'] ?></b><br><small><?= $r['telefon'] ?></small></td>
                        <td><?= $r['hizmet_adi'] ?></td>
                        <td><?= date('d.m.Y', strtotime($r['randevu_tarihi'])) ?> | <?= $r['randevu_saati'] ?></td>
                        <td><b style="color: <?= $durum_renk ?>"><?= $durum_metin ?></b></td>
                        <td>
                            <?php if($is_onayli): ?>
                                <span style="color: #2ecc71; font-weight: bold; margin-right: 10px;">✓ İşlem Tamam</span>
                                <a href="admin_islem.php?islem=iptal&id=<?= $r['r_id'] ?>" class="btn btn-iptal" style="padding: 4px 8px; font-size: 10px;">Fikrini Değiştir (İptal Et)</a>
                            
                            <?php elseif($is_iptal): ?>
                                <span style="color: #e74c3c; font-weight: bold; margin-right: 10px;">✗ İptal Edilmiş</span>
                                <a href="admin_islem.php?islem=onay&id=<?= $r['r_id'] ?>" class="btn btn-onay" style="padding: 4px 8px; font-size: 10px;">Geri Al (Onayla)</a>
                            
                            <?php else: ?>
                                <a href="admin_islem.php?islem=onay&id=<?= $r['r_id'] ?>" class="btn btn-onay">Onayla</a>
                                <a href="admin_islem.php?islem=iptal&id=<?= $r['r_id'] ?>" class="btn btn-iptal">İptal Et</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="hizmetler" class="admin-card">
            <h3 style="color: #c5a059;" id="form-baslik">Yeni Hizmet Ekle</h3>
            <form action="admin_islem.php" method="POST" class="form-row">
                <input type="hidden" name="hizmet_id" id="hizmet_id" value="">
                <input type="text" name="hizmet_adi" id="hizmet_adi" placeholder="Hizmet Adı" required style="flex: 2;">
                <input type="number" name="fiyat" id="fiyat" placeholder="Fiyat (₺)" required style="flex: 1;">
                <input type="number" name="sure" id="sure" placeholder="Süre (Dk)" required style="flex: 1;">
                
                <div style="display: flex; gap: 5px;">
                    <button type="submit" name="hizmet_ekle" id="submit-btn" class="btn btn-onay" style="padding: 12px 20px;">EKLE</button>
                    <button type="button" id="iptal-btn" class="btn btn-iptal" style="display: none; padding: 12px 20px;" onclick="formSifirla()">İptal</button>
                </div>
            </form>

            <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 40px;">
                <?php foreach($hizmetler as $h): ?>
                <div style="background: rgba(255,255,255,0.03); padding: 15px 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(197, 160, 89, 0.1);">
                    <div>
                        <div style="font-size: 16px;"><b><?= $h['hizmet_adi'] ?></b> <span style="color: #aaa; font-size: 13px;">(<?= $h['sure'] ?> dk)</span></div>
                        <div style="color: #c5a059; font-weight: bold; margin-top: 5px;"><?= $h['fiyat'] ?> ₺</div>
                    </div>
                    <div>
                        <button onclick="hizmetDuzenle(<?= $h['id'] ?>, '<?= addslashes($h['hizmet_adi']) ?>', <?= $h['fiyat'] ?>, <?= $h['sure'] ?>)" class="btn btn-duzenle">Düzenle</button>
                        <a href="admin_islem.php?islem=hizmet_sil&id=<?= $h['id'] ?>" class="btn btn-iptal" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="galeri" class="admin-card">
            <h3 style="color: #c5a059;">Fotoğraf Yükle</h3>
            <form action="admin_islem.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 30px;">
                <input type="file" name="foto" required>
                <button type="submit" name="foto_ekle" class="btn btn-onay" style="margin-top: 10px;">YÜKLE</button>
            </form>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                <?php foreach($galeri as $f): ?>
                <div style="position: relative; border-radius: 10px; overflow: hidden;">
                    <img src="uploads/<?= $f['foto_yol'] ?>" style="width: 100%; height: 180px; object-fit: cover;">
                    <a href="admin_islem.php?islem=foto_sil&id=<?= $f['id'] ?>" class="btn btn-iptal" style="position: absolute; top: 5px; right: 5px;">SİL</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
// SEKMELER ARASI GEÇİŞ VE HAFIZA SİSTEMİ
function openTab(evt, tabName) {
    var i, adminCard, tablinks;
    
    // Tüm kartları gizle ve butonların rengini sıfırla
    adminCard = document.getElementsByClassName("admin-card");
    for (i = 0; i < adminCard.length; i++) { adminCard[i].style.display = "none"; }
    
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) { tablinks[i].classList.remove("active"); }
    
    // İstenen sekmeyi göster
    document.getElementById(tabName).style.display = "block";
    
    // Tıklanma ile geldiyse butonu parlat, otomatik açıldıysa kodu bulup parlat
    if (evt) {
        evt.currentTarget.classList.add("active");
        // Adres çubuğundaki yazıyı güncelle (Örn: admin.php#galeri)
        if(history.pushState) {
            history.pushState(null, null, '#' + tabName);
        } else {
            location.hash = '#' + tabName;
        }
    } else {
        var btn = document.querySelector(".tablink[onclick*='" + tabName + "']");
        if (btn) btn.classList.add("active");
    }
}

// SİHİRLİ KISIM: Sayfa Yüklendiğinde Adres Çubuğunu Kontrol Et
window.onload = function() {
    var hash = window.location.hash.substring(1); // #galeri kısmındaki 'galeri' kelimesini alır
    if (hash && document.getElementById(hash)) {
        openTab(null, hash); // Eğer adres çubuğunda galeri yazıyorsa orayı aç
    }
};

// HİZMET DÜZENLEME (AKILLI FORM DOLDURUCU)
function hizmetDuzenle(id, ad, fiyat, sure) {
    document.getElementById('form-baslik').innerText = "Hizmeti Düzenle";
    document.getElementById('hizmet_id').value = id;
    document.getElementById('hizmet_adi').value = ad;
    document.getElementById('fiyat').value = fiyat;
    document.getElementById('sure').value = sure;
    document.getElementById('submit-btn').innerText = "GÜNCELLE";
    document.getElementById('submit-btn').style.background = "#f39c12"; 
    document.getElementById('iptal-btn').style.display = "inline-block";
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// DÜZENLEMEDEN VAZGEÇİLDİĞİNDE FORMU SIFIRLAMA
function formSifirla() {
    document.getElementById('form-baslik').innerText = "Yeni Hizmet Ekle";
    document.getElementById('hizmet_id').value = "";
    document.getElementById('hizmet_adi').value = "";
    document.getElementById('fiyat').value = "";
    document.getElementById('sure').value = "";
    document.getElementById('submit-btn').innerText = "EKLE";
    document.getElementById('submit-btn').style.background = "#2ecc71"; 
    document.getElementById('iptal-btn').style.display = "none";
}
</script>
</body>
</html>