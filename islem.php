<?php
// 1. Veritabanı bağlantısını çağırıyoruz
include 'baglan.php';

// 2. Formdan gelen verileri kontrol ediyoruz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Formdan gelen bilgileri değişkenlere atayalım
    $ad_soyad      = $_POST['ad_soyad'];
    $telefon       = $_POST['telefon'];
    $hizmet_id     = $_POST['hizmet_id'];
    $randevu_tarihi = $_POST['randevu_tarihi'];
    $randevu_saati  = $_POST['randevu_saati'];

    // --- YENİ: Hizmet süresini çekiyoruz ---
$hizmet_sorgu = $db->prepare("SELECT sure FROM hizmetler WHERE id = ?");
$hizmet_sorgu->execute([$hizmet_id]);
$hizmet = $hizmet_sorgu->fetch();
$sure = $hizmet['sure'];

// --- YENİ: Başlangıç ve bitişi hesapla ---
$istenen_baslangic = $randevu_saati;
$istenen_bitis = date('H:i', strtotime("$randevu_saati + $sure minutes"));

// --- YENİ: Çakışma Kontrol Sorgusu ---
$cakisma_sorgu = $db->prepare("
    SELECT * FROM randevular 
    WHERE randevu_tarihi = ? 
    AND (
        (? < ADDTIME(randevu_saati, SEC_TO_TIME((SELECT sure FROM hizmetler WHERE id = randevular.hizmet_id) * 60)))
        AND
        (? > randevu_saati)
    )
");
$cakisma_sorgu->execute([$randevu_tarihi, $istenen_baslangic, $istenen_bitis]);

// --- YENİ: Eğer doluysa durdur ---
if ($cakisma_sorgu->rowCount() > 0) {
    header("Location: randevu.php?durum=dolu");
    exit;
}

// Burası senin eski kayıt (INSERT) kodların...
$sorgu_kullanici = $db->prepare("INSERT INTO kullanicilar..."); 
// ... ve randevu kayıt kodları
    // Boş alan kontrolü yapalım
    if (empty($ad_soyad) || empty($telefon) || empty($hizmet_id)) {
        die("Lütfen tüm alanları doldurun!");
    }

    try {
        // ÖNCE: Kullanıcıyı 'kullanicilar' tablosuna kaydedelim
        // (Şifre ve e-posta formda olmadığı için şimdilik boş/varsayılan bırakıyoruz)
        $sorgu_kullanici = $db->prepare("INSERT INTO kullanicilar (ad_soyad, telefon, eposta, sifre) VALUES (?, ?, ?, ?)");
        $varsayilan_eposta = $telefon . "@star.com"; // Telefonu e-posta gibi kullandık şimdilik
        $sorgu_kullanici->execute([$ad_soyad, $telefon, $varsayilan_eposta, '123456']);
        
        // Az önce eklenen kullanıcının ID'sini alalım
        $kullanici_id = $db->lastInsertId();

        // SONRA: Randevuyu 'randevular' tablosuna kaydedelim
        $sorgu_randevu = $db->prepare("INSERT INTO randevular (kullanici_id, hizmet_id, randevu_tarihi, randevu_saati) VALUES (?, ?, ?, ?)");
        $sorgu_randevu->execute([$kullanici_id, $hizmet_id, $randevu_tarihi, $randevu_saati]);

        // İşlem başarılıysa ana sayfaya teşekkür mesajıyla dönelim
        header("Location: index.php?durum=basarili");
        exit;

    } catch (PDOException $e) {
        die("Hata oluştu, randevu kaydedilemedi: " . $e->getMessage());
    }
}
?>