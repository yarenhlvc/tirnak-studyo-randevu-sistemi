<?php
session_start(); // OTURUMU BAŞLATTIK (En önemli kısım!)
include 'baglan.php';

date_default_timezone_set('Europe/Istanbul');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ad_soyad       = $_POST['ad_soyad'];
    $telefon        = $_POST['telefon'];
    $hizmet_id      = $_POST['hizmet_id'];
    $randevu_tarihi = $_POST['randevu_tarihi'];
    $randevu_saati  = $_POST['randevu_saati'];

    if (empty($ad_soyad) || empty($telefon) || empty($hizmet_id) || empty($randevu_tarihi) || empty($randevu_saati)) {
        die("Lütfen tüm alanları doldurun!");
    }

    // --- ZAMAN KONTROLLERİ ---
    $bugunun_tarihi = date('Y-m-d');
    $suanki_saat = date('H:i');
    $randevu_gunu = date('w', strtotime("$randevu_tarihi $randevu_saati"));

    if ($randevu_tarihi < $bugunun_tarihi || ($randevu_tarihi == $bugunun_tarihi && $randevu_saati <= $suanki_saat)) {
        header("Location: randevu.php?durum=gecmis"); exit;
    }
    if ($randevu_gunu == 0) { header("Location: randevu.php?durum=pazar"); exit; }
    if ($randevu_saati < "09:00" || $randevu_saati > "18:00") { header("Location: randevu.php?durum=mesai"); exit; }

    // --- ÇAKIŞMA KONTROLÜ ---
    $hizmet_sorgu = $db->prepare("SELECT sure FROM hizmetler WHERE id = ?");
    $hizmet_sorgu->execute([$hizmet_id]);
    $hizmet = $hizmet_sorgu->fetch();
    $sure = $hizmet['sure'];

    $istenen_bitis = date('H:i', strtotime("$randevu_saati + $sure minutes"));
    $cakisma_sorgu = $db->prepare("SELECT * FROM randevular WHERE randevu_tarihi = ? AND (? < ADDTIME(randevu_saati, SEC_TO_TIME((SELECT sure FROM hizmetler WHERE id = randevular.hizmet_id) * 60))) AND (? > randevu_saati)");
    $cakisma_sorgu->execute([$randevu_tarihi, $randevu_saati, $istenen_bitis]);

    if ($cakisma_sorgu->rowCount() > 0) {
        header("Location: randevu.php?durum=dolu"); exit;
    }

    // =================================================================
    // KİMLİK DOĞRULAMA: Randevu Kimin Üzerine Kaydolacak?
    // =================================================================
    if(isset($_SESSION['kullanici_id'])) {
        // Eğer giriş yapmışsa, randevuyu doğrudan o ID'ye bağla
        $kullanici_id = $_SESSION['kullanici_id'];
    } else {
        // Eğer giriş yapmamışsa (ki biz bunu engelledik ama önlem olsun)
        // Telefonla kontrol et
        $musteri_kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE telefon = ?");
        $musteri_kontrol->execute([$telefon]);
        if ($musteri_kontrol->rowCount() > 0) {
            $kullanici_id = $musteri_kontrol->fetch()['id'];
        } else {
            // Yeni kullanıcı oluştur
            $sorgu_kullanici = $db->prepare("INSERT INTO kullanicilar (ad_soyad, telefon, eposta, sifre) VALUES (?, ?, ?, ?)");
            $sorgu_kullanici->execute([$ad_soyad, $telefon, $telefon."@star.com", '123456']);
            $kullanici_id = $db->lastInsertId();
        }
    }

    try {
        $sorgu_randevu = $db->prepare("INSERT INTO randevular (kullanici_id, hizmet_id, randevu_tarihi, randevu_saati) VALUES (?, ?, ?, ?)");
        $sorgu_randevu->execute([$kullanici_id, $hizmet_id, $randevu_tarihi, $randevu_saati]);
        header("Location: index.php?durum=basarili");
        exit;
    } catch (PDOException $e) {
        die("Hata: " . $e->getMessage());
    }
}
?>