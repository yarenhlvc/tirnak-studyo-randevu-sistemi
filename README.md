# tirnak-studyo-randevu-sistemi
Bitirme Projesi II - Tırnak Stüdyosu Randevu Sistemi



AMASYA ÜNİVERSİTESİ  
TEKNİK BİLİMLER MESLEK YÜKSEKOKULU 
Bilgisayar Programcılığı Bölümü   
BLG206 - Bitirme Projesi-II Dersi Proje Öneri Formu 
Projeyi Yürütecek  
Öğrencilere Ait Bilgiler 
Numara 
Ad Soyad 
244212034 Yaren HELVACI 
Proje Danışmanı 
Proje Adı 
Doç. Dr. H. Hüseyin ÖKTEN 
STAR NAIL STUDIO RANDEVU SİSTEMİ 
Projenin Github Bağlantısı https://github.com/yarenhlvc/tirnak-studyo-randevu-sistemi 
Proje Özeti (Proje Tanımı) 
Bu proje, butik bir tırnak stüdyosunun iş akışını dijital ortama taşımak için geliştirilecektir. Temel 
amacı, müşterilerin telefon trafiğine girmeden stüdyonun müsaitlik durumunu takvim üzerinden 
görerek randevu almalarını sağlamaktır. Sistem, tırnak bakımı, kalıcı oje, nail art gibi spesifik 
hizmetlerin seçimine olanak tanıyacak ve stüdyonun konum bilgilerini (Google Maps entegrasyonu 
veya detaylı adres) içerecektir. Bu sayede hem randevu karışıklıkları önlenecek hem de yeni 
müşterilerin stüdyoyu bulması kolaylaştırılacaktır. 
Geliştirilecek Uygulamanın Son Kullanıcısının Temel İhtiyaçları: 
Uygulamayı kullanacak olan kişilerin beklentileri şu şekildedir:  
• Müşteri Gereksinimleri:  
o Sunulan tırnak bakım hizmetlerini ve fiyatlarını listeleyebilme.  
o İnteraktif Takvim: Boş gün ve saatleri görüp anında randevu oluşturabilme. 
o Konum Erişimi: Stüdyonun harita üzerindeki konumunu görebilme ve yol tarifi alabilme. 
o Kullanıcı profili üzerinden geçmiş randevularını takip edebilme. 
• Stüdyo Sahibi (Admin) Gereksinimleri:  
o Takvim üzerinden çalışma saatlerini ve tatil günlerini ayarlayabilme. 
o Yeni hizmet türleri (örneğin: protez tırnak, manikür) ekleyip güncelleyebilme.  
o Gelen randevu taleplerini onaylama, reddetme veya müşteri ile iletişime geçme. 
Projenin Sınırlarının Belirlenmesi 
Son kullanıcı (tırnak stüdyosu sahibi ve müşteriler) istek ve ihtiyaçlarına göre projenin genel sınırları şu 
şekilde belirlenmiştir: 
• Kullanıcı Giriş Sistemi: Sistemde iki farklı kullanıcı tipi (Müşteri ve Admin) bulunacaktır. Tüm 
kullanıcılar kendilerine ait kullanıcı adı ve şifre ile sisteme giriş yapacaktır. 
• Hizmet Yönetimi: Admin (stüdyo sahibi) tarafından sunulan tırnak bakım hizmetleri (kalıcı oje, 
protez tırnak, nail art vb.) için ekleme, silme, güncelleme ve listeleme işlemleri yapılabilecektir. 
• Randevu Yönetimi: * Müşteriler, sistem üzerinden uygun tarih ve saati seçerek randevu 
oluşturabilecek ve kendi randevularını listeleyebilecektir. 
o Randevu iptal işlemi yapılabilecek, iptal edilen kayıtlar sistemde "İptal" durumuna 
getirilecektir. 
• Çalışma Gün ve Saatleri: Stüdyo sahibi, takvim üzerinden hangi günlerin randevuya açık 
olacağını ve günlük mesai saatlerini (başlangıç/bitiş) dinamik olarak ayarlayabilecektir. 
• Konum ve İletişim: Uygulama içerisinde stüdyonun fiziksel konumu bir harita bileşeni (veya 
linki) olarak yer alacak ve iletişim bilgileri statik/dinamik olarak gösterilecektir. 
• Veri Saklama: Tüm müşteri bilgileri, randevu geçmişi ve hizmet detayları MySQL veritabanında 
saklanacaktır. 
• Kapsam Dışı: Bu proje kapsamında çevrimiçi ödeme sistemi (kredi kartı entegrasyonu) yer 
almayacaktır; ödemeler stüdyoda fiziksel olarak yapılacaktır. 
Projenin Amacı ve Faydaları:  
Stüdyo sahibi için manuel ajanda tutma yükünü ortadan kaldırmak ve müşterilere profesyonel bir 
rezervasyon deneyimi sunmaktır. Konum ekleme özelliği sayesinde stüdyonun erişilebilirliği 
artacak, takvim yönetimi sayesinde ise çakışan randevuların önüne geçilecektir. 
Projede Kullanılacak Metod ve Yazılım Dilleri:  
• Frontend: HTML5 ve CSS3.  
• Backend: Dinamik veri yönetimi için PHP dili kullanılacaktır.  
• Veritabanı: Randevu, kullanıcı ve hizmet verileri için MySQL tercih edilecektir. 
Proje Planı:  
Projenin geliştirme aşamaları aşağıdaki biçimde olacaktır. 
Proje Bölümleri ve Tasarımı 
• 1. Bölüm: İhtiyaç Analizi ve Gereksinimlerin Belirlenmesi: Tırnak stüdyosunun hizmet türleri, 
çalışma saatleri ve randevu akışının detaylandırılarak dökümante edilmesi. 
• 2. Bölüm: Arayüz (Frontend) Tasarımı: Kullanıcıların randevu alacağı, hizmetleri göreceği ve 
konum bilgisini inceleyeceği sayfaların HTML ve CSS ile tasarlanması. 
• 3. Bölüm: Veri Tabanı Tasarımı: Müşteri bilgileri, randevu saatleri, hizmet türleri ve konum 
verilerinin tutulacağı MySQL tablolarının oluşturulması. 
• 4. Bölüm: Müşteri Kayıt ve Profil Modülünün Geliştirilmesi: Kullanıcıların sisteme üye olması, 
giriş yapması ve kendi randevularını takip edebileceği panelin kodlanması. 
• 5. Bölüm: Randevu ve Takvim Modülünün Geliştirilmesi: PHP ile takvim üzerinden gün/saat 
seçimi ve randevu çakışmalarını önleyen mantıksal yapının kurulması. 
• 6. Bölüm: Hizmet ve Konum Modülünün Geliştirilmesi: Sunulan tırnak bakım hizmetlerinin 
listelenmesi ve stüdyonun harita üzerindeki konumunun sisteme entegre edilmesi. 
• 7. Bölüm: Yönetim (Admin) Paneli Modülünün Geliştirilmesi: Stüdyo sahibinin yeni hizmet 
eklemesi, randevuları onaylaması ve çalışma saatlerini düzenlemesi için gerekli panelin 
hazırlanması. 
• 8. Bölüm: Yazılım Test ve Raporlama Süreci: Sistemin tüm fonksiyonlarının test edilmesi, 
hataların giderilmesi ve projenin son haline getirilerek raporlanması 
Proje Plan Tablosu 
Bölümün 
No 
Adı 
Kim Tarafından 
Süresi 
Başlangıç 
Bitiş Zamanı 
Yapılacağı 
1 
1.Bölüm 
Yaren HELVACI 
(Hafta) 
1 
Zamanı 
1.Hafta Başı 
2 
2.Bölüm 
Yaren HELVACI 
2 
1.Hafta Sonu 
2.Hafta Başı 
3 
3.Bölüm 
Yaren HELVACI 
1 
3.Hafta Sonu 
4.Hafta Başı 
4 
4.Bölüm 
Yaren HELVACI 
2 
4.Hafta Sonu 
5.Hafta Başı 
5 
5.Bölüm 
Yaren HELVACI 
2 
6.Hafta Sonu 
7.Hafta Başı 
6 
6.Bölüm 
Yaren HELVACI 
1 
8.Hafta Sonu 
9.Hafta Başı 
7 
7.Bölüm 
Yaren HELVACI 
2 
9.Hafta Sonu 
10.Hafta Başı 
8 
8.Bölüm 
Yaren HELVACI 
1 
11.Hafta Sonu 
12.Hafta Başı 
Projenin Başlangıç Zamanı: 03.03.2026  
Projenin Bitiş Zamanı: 24.05.2026 
12.Hafta Sonu 
 
 
 
 
 
Grantt Şeması 
Projenin Bölümleri Kişi Bölüm No 1 2 3 4 5 6 7 8 9 10 11 12 
İhtiyaç Analizi Yaren HELVACI 1             
Arayüz Tasarımı Yaren HELVACI 2             
Veri Tabanı Yaren HELVACI 3             
Müşteri Modülü Yaren HELVACI 4             
Randevu ve Takvim Yaren HELVACI 5             
Hizmet ve Konum Yaren HELVACI 6             
Yönetim Paneli Yaren HELVACI 7             
Test ve Rapor Yaren HELVACI 8            
