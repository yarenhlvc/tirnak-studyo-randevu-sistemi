<?php
session_start();
include 'baglan.php';

if (!isset($_SESSION['admin_giris']) || $_SESSION['admin_giris'] !== true) {
    die("Yetkisiz erişim!");
}

// BÜTÜN İŞLEMLERİ TRY-CATCH İÇİNE ALDIK (Hata olursa ekrana yazsın diye)
try {
    // 1. RANDEVU DURUM GÜNCELLEME (Onayla / İptal)
    if (isset($_GET['islem']) && isset($_GET['id']) && ($_GET['islem'] == 'onay' || $_GET['islem'] == 'iptal')) {
        $id = intval($_GET['id']);
        $durum = ($_GET['islem'] == 'onay') ? 'Onaylandı' : 'İptal Edildi';
        
        $db->prepare("UPDATE randevular SET durum = ? WHERE id = ?")->execute([$durum, $id]);
        
        header("Location: admin.php#randevular");
        exit;
    }

    // 2. HİZMET EKLEME VEYA GÜNCELLEME
    if (isset($_POST['hizmet_ekle'])) {
        $ad = $_POST['hizmet_adi']; 
        $fiyat = $_POST['fiyat']; 
        $sure = $_POST['sure'];
        $hizmet_id = $_POST['hizmet_id'] ?? ''; 
        
        if (empty($hizmet_id)) {
            $db->prepare("INSERT INTO hizmetler (hizmet_adi, fiyat, sure) VALUES (?, ?, ?)")->execute([$ad, $fiyat, $sure]);
        } else {
            $db->prepare("UPDATE hizmetler SET hizmet_adi = ?, fiyat = ?, sure = ? WHERE id = ?")->execute([$ad, $fiyat, $sure, $hizmet_id]);
        }
        header("Location: admin.php#hizmetler");
        exit;
    }

    // 3. HİZMET SİLME (YENİ ÇÖZÜM BURASI!)
    if (isset($_GET['islem']) && $_GET['islem'] == 'hizmet_sil' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // ADIM 1: Veritabanı çökmesin diye önce bu hizmete ait olan tüm randevuları siliyoruz
        $db->prepare("DELETE FROM randevular WHERE hizmet_id = ?")->execute([$id]);
        
        // ADIM 2: Bağlantılar temizlendiğine göre artık hizmeti güvenle silebiliriz
        $db->prepare("DELETE FROM hizmetler WHERE id = ?")->execute([$id]);
        
        header("Location: admin.php#hizmetler");
        exit;
    }

    // 4. FOTOĞRAF YÜKLEME
    if (isset($_POST['foto_ekle'])) {
        $dizin = 'uploads/';
        if (!file_exists($dizin)) { mkdir($dizin, 0777, true); }
        $isim = time() . "_" . $_FILES['foto']['name'];
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $dizin . $isim)) {
            $db->prepare("INSERT INTO galeri (foto_yol) VALUES (?)")->execute([$isim]);
        }
        header("Location: admin.php#galeri");
        exit;
    }

    // 5. FOTOĞRAF SİLME
    if (isset($_GET['islem']) && $_GET['islem'] == 'foto_sil' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $foto = $db->prepare("SELECT foto_yol FROM galeri WHERE id = ?");
        $foto->execute([$id]);
        $f = $foto->fetch();
        if ($f) {
            if (file_exists("uploads/" . $f['foto_yol'])) { unlink("uploads/" . $f['foto_yol']); }
            $db->prepare("DELETE FROM galeri WHERE id = ?")->execute([$id]);
        }
        header("Location: admin.php#galeri");
        exit;
    }

} catch (PDOException $e) {
    // EĞER ARKA PLANDA BİR ŞEY TERS GİDERSE ARTIK SESSİZ KALMAYACAK
    die("<div style='background: #e74c3c; color: white; padding: 20px; font-size: 18px; text-align: center; font-weight: bold;'>VERİTABANI HATASI: " . $e->getMessage() . "</div>");
}
?>