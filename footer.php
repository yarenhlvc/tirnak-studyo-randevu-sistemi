 <footer>
        <div class="wide-container footer-wrap">
            <p>Bir Ennur Design Stüdyosu | 2026</p>
            <div class="socials">INSTAGRAM • TIKTOK • FACEBOOK</div>
        </div>
    </footer>
<script>
    // Sayfa tamamen yüklendiğinde çalışır
    window.onload = function() {
        // 'success-alert' sınıfına sahip kutuyu bulalım
        var basariMesaji = document.querySelector('.success-alert');
        
        // Eğer ekranda böyle bir mesaj varsa...
        if (basariMesaji) {
            // 3 saniye (3000 milisaniye) bekle
            setTimeout(function() {
                // Yavaşça şeffaflaşması için geçiş efekti verelim
                basariMesaji.style.transition = "opacity 1s ease";
                basariMesaji.style.opacity = "0";
                
                // Şeffaflaştıktan sonra tamamen yok et (yer kaplamasın)
                setTimeout(function() {
                    basariMesaji.remove();
                }, 1000); // 1 saniye de kaybolma süresi
                
            }, 3000); // Toplam 3 saniye görünecek
        }
    };
</script>