<?php include 'header.php'; ?>

<main style="padding-top: 100px;"> <section id="galeri" class="gallery-section">
        <div class="wide-container">
            <div class="section-head" style="text-align: center; margin-bottom: 50px;">
                <h3 style="font-family: 'Playfair Display', serif; color: white; font-size: 36px;">
                    Işıltılı <span class="gold-italic" style="color: #c5a059; font-style: italic;">Kareler</span>
                </h3>
                <p style="color: rgba(255,255,255,0.6);">Sanatımızın en güzel örneklerini keşfedin.</p>
            </div>

            <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div class="gallery-item" style="border-radius: 15px; overflow: hidden; height: 350px; position: relative;">
                    <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?q=80&w=500" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="gallery-item" style="border-radius: 15px; overflow: hidden; height: 350px; position: relative;">
                    <img src="https://images.unsplash.com/photo-1632345031435-81979cd75a39?q=80&w=500" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="gallery-item" style="border-radius: 15px; overflow: hidden; height: 350px; position: relative;">
                    <img src="https://images.unsplash.com/photo-1607779097040-26e80aa78e66?q=80&w=500" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>