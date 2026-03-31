<?php include 'baglan.php'; include 'header.php'; ?>

<main style="padding-top: 100px;"> <section id="hizmetler" class="services-section">
        <div class="wide-container">
            <div class="section-head" style="text-align: center; margin-bottom: 50px;">
                <h3 style="font-family: 'Playfair Display', serif; color: white; font-size: 36px;">
                    Özel <span class="gold-italic" style="color: #c5a059; font-style: italic;">Hizmetlerimiz</span>
                </h3>
            </div>
            <div class="service-grid">
                <?php 
                $hizmetler = $db->query("SELECT * FROM hizmetler")->fetchAll(PDO::FETCH_ASSOC);
                foreach($hizmetler as $hizmet): 
                ?>
                    <div class="s-card">
                        <h4><?= $hizmet['hizmet_adi'] ?></h4>
                        <p style="color: #c5a059; font-weight: bold;"><?= $hizmet['fiyat'] ?> TL</p>
                        <p style="font-size: 12px; opacity: 0.6;">Süre: <?= $hizmet['sure'] ?> Dakika</p>
                        <a href="randevu.php" class="gold-cta" style="font-size: 12px; padding: 5px 15px;">Randevu Al</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>