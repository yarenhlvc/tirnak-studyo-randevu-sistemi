<?php 
include 'baglan.php'; 
$hizmetler = $db->query("SELECT * FROM hizmetler")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Randevu Al | Star Nail Studio</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    
    <link rel="stylesheet" href="style.css"> 
 <?php if(isset($_GET['durum']) && $_GET['durum'] == 'dolu'): ?>
    <div class="error-alert">
        ⚠️ Üzgünüz, seçtiğiniz saat aralığı başka bir randevu ile çakışıyor. Lütfen başka bir saat seçiniz.
    </div>
<?php endif; ?>
    <style>
        .appointment-form {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border: 1px solid rgba(197, 160, 89, 0.2);
            border-radius: 15px;
        }
        .form-group { margin-bottom: 20px; position: relative; }
        label { display: block; color: #c5a059; margin-bottom: 8px; font-size: 14px; }
        input, select {
            width: 100%;
            padding: 12px;
            background: #050a0f;
            border: 1px solid #222;
            color: white;
            border-radius: 5px;
        }
        input:focus { border-color: #c5a059; outline: none; }
        .flatpickr-calendar { background: #0a141d !important; border: 1px solid #c5a059 !important; }
    </style>
</head>
<body>

    <header>
        <div class="wide-container nav-flex">
            <div class="logo">✨ STAR <span>NAIL STUDIO</span></div>
            <nav>
                <a href="index.php">Ana Sayfa</a>
                <a href="index.php#hizmetler">Hizmetler</a>
                <a href="randevu.php" class="gold-cta">Randevu Al</a>
            </nav>
        </div>
    </header>

    <div class="wide-container">
        <div class="appointment-form">
            <h2 style="font-family: 'Playfair Display', serif; color: white; margin-bottom: 30px; text-align: center;">
                Işıltını <span style="color: #c5a059; font-style: italic;">Planla</span>
            </h2>

            <form action="islem.php" method="POST">
                <div class="form-group">
                    <label>Adınız ve Soyadınız</label>
                    <input type="text" name="ad_soyad" placeholder="Örn: Yaren Yıldız" required>
                </div>

                <div class="form-group">
                    <label>Telefon Numaranız</label>
                    <input type="tel" name="telefon" placeholder="05XX XXX XX XX" required>
                </div>

                <div class="form-group">
                    <label>İstediğiniz Hizmet</label>
                    <select name="hizmet_id" required>
                        <option value="">Lütfen seçiniz...</option>
                        <?php foreach($hizmetler as $hizmet): ?>
                            <option value="<?= $hizmet['id'] ?>">
                                <?= $hizmet['hizmet_adi'] ?> (<?= $hizmet['fiyat'] ?> TL)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Randevu Tarihi</label>
                    <input type="text" id="tarih_secici" name="randevu_tarihi" placeholder="Tarih seçiniz..." required>
                </div>

                <div class="form-group">
                    <label>Tercih Ettiğiniz Saat</label>
                    <input type="text" id="saat_secici" name="randevu_saati" placeholder="Saat seçiniz..." required>
                </div>

                <button type="submit" class="shimmer-btn" style="width: 100%; cursor: pointer; border: none; background: #c5a059; color: black; padding: 15px; font-weight: bold; border-radius: 5px;">
                    RANDEVUYU ONAYLA
                </button>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script> 
<script>
    flatpickr("#tarih_secici", {
        locale: "tr",
        dateFormat: "Y-m-d",
        minDate: "today",
        static: true, 
        disable: [function(date) { return (date.getDay() === 0); }]
    });

    flatpickr("#saat_secici", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        static: true, 
        disableMobile: "true",
        minTime: "09:00",
        maxTime: "20:00",
    });
</script>
<script>
    window.addEventListener('load', function() {
        // Hem başarı hem hata mesajlarını yakalayalım
        var mesaj = document.querySelector('.error-alert');
        
        if (mesaj) {
            setTimeout(function() {
                mesaj.style.transition = "opacity 1s ease";
                mesaj.style.opacity = "0";
                
                setTimeout(function() {
                    mesaj.remove();
                }, 1000);
            }, 4000); // Hata mesajları biraz daha uzun kalsın (4 saniye)
        }
    });
</script>
</body>
</html>