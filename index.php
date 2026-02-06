<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: welcome.php");
    exit;
}

include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

$title = "Beranda - Kista Dermoid";
include "navbar.php";

// Ambil data jenis kista/penyakit dari database
$query_penyakit = mysqli_query($conn, "SELECT nama_penyakit FROM penyakit");
?>

<main style=" color: white; font-family: 'Verdana', sans-serif; background: rgba(0,0,0,0.3);">
    
    <section id="hero" style="height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 0 20px; 
              background-image: url('<?= $base_url ?>/img/1.jpg'); 
              background-size: cover;
              background-position: center;
              background-attachment: fixed; /* Membuat efek parallax agar gambar tetap diam saat di-scroll */
              position: relative;">
        
        <div style="max-width: 800px; 
                    background: rgba(0, 0, 0, 0.6); /* Kotak dibuat agak gelap agar teks putih kontras */
                    backdrop-filter: blur(12px);    /* Efek blur hanya di dalam kotak */
                    -webkit-backdrop-filter: blur(12px);
                    border-radius: 30px;           /* Sudut lebih bulat sesuai permintaan */
                    padding: 50px 40px; 
                    border: 1px solid rgba(255, 255, 255, 0.2); 
                    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
                    z-index: 10;">
            
            <h1 style="font-size: 3.2rem; margin-bottom: 20px; line-height: 1.2; text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">
                Kenali Gejala <span style="color: #2979ff;">Kista Dermoid</span> pada Wanita
            </h1>
            
            <p style="font-size: 1.1rem; line-height: 1.8; opacity: 0.9; margin-bottom: 40px; padding: 0 20px;">
                Sistem pakar berbasis web untuk membantu Anda mengidentifikasi kemungkinan jenis kista dermoid secara cepat dan akurat menggunakan metode <b>Forward Chaining</b>.
            </p>
            
            <a href="diagnosa.php" style="padding: 18px 50px; background: #2979ff; color: white; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(41, 121, 255, 0.4); transition: 0.3s; display: inline-block;">
                MULAI KONSULTASI SEKARANG
            </a>
        </div>
    </section>

    <section id="overview" style="padding: 80px 10%; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; border-top: 4px solid #a349a4;">
                <h3 style="margin-bottom: 15px; color: #a349a4;">Apa itu Kista Dermoid?</h3>
                <p style="font-size: 14px; line-height: 1.7; opacity: 0.8;">Kista dermoid adalah pertumbuhan kantung (kantung) yang berisi jaringan seperti rambut, gigi, cairan minyak, hingga jaringan saraf. Ini terjadi akibat jaringan yang terperangkap saat perkembangan janin.</p>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; border-top: 4px solid #2979ff;">
                <h3 style="margin-bottom: 15px; color: #2979ff;">Mengapa Deteksi Dini Penting?</h3>
                <p style="font-size: 14px; line-height: 1.7; opacity: 0.8;">Meskipun umumnya jinak, kista ini bisa membesar dan menekan organ di sekitarnya, menyebabkan nyeri hebat, infeksi, hingga komplikasi serius jika pecah di dalam tubuh.</p>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px; border-top: 4px solid #00e676;">
    <h3 style="margin-bottom: 15px; color: #00e676;">Jenis yang Dideteksi</h3>
    <ul style="font-size: 14px; opacity: 0.8; padding-left: 18px;">
        <?php 
        // Melakukan perulangan data dari database
        while ($p = mysqli_fetch_assoc($query_penyakit)) { 
        ?>
            <li><?= $p['nama_penyakit']; ?></li>
        <?php 
        } 
        ?>
    </ul>
</div>
        </div>
    </section>

    <section id="how-it-works" style="padding: 80px 10%; text-align: center;">
        <h2 style="margin-bottom: 50px;">Bagaimana Cara Kerjanya?</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px;">
            
            <div style="width: 200px;">
                <div style="font-size: 40px; margin-bottom: 15px;">📝</div>
                <h4>Pilih Gejala</h4>
                <p style="font-size: 12px; opacity: 0.7;">Pilih keluhan yang Anda rasakan secara jujur.</p>
            </div>
            <div style="width: 200px;">
                <div style="font-size: 40px; margin-bottom: 15px;">⚙️</div>
                <h4>Analisis Pakar</h4>
                <p style="font-size: 12px; opacity: 0.7;">Sistem mencocokkan data dengan basis pengetahuan.</p>
            </div>
            <div style="width: 200px;">
                <div style="font-size: 40px; margin-bottom: 15px;">📋</div>
                <h4>Hasil</h4>
                <p style="font-size: 12px; opacity: 0.7;">Dapatkan kemungkinan jenis kista dan saran.</p>
            </div>
        </div>
    </section>

    <section id="safety" style="padding: 60px 10%; background: rgba(0,0,0,0.7); text-align: center; border-top: 1px solid rgba(255,255,255,0.1);">
        <div style="margin-bottom: 30px; font-weight: bold; color: #2979ff; letter-spacing: 2px;">
            Dukungan Sistem: 4 Rule Pakar & 5+ Basis Gejala
        </div>
        <div style="max-width: 900px; margin: 0 auto; padding: 25px; border: 1px dashed #ff4d4d; border-radius: 10px;">
            <h5 style="color: #ff4d4d; margin-bottom: 10px;">⚠️ DISCLAIMER PENTING</h5>
            <p style="font-size: 13px; line-height: 1.6; color: #ccc;">
                Hasil diagnosa sistem ini bersifat edukatif sebagai langkah deteksi dini dan <b>BUKAN</b> pengganti diagnosa medis profesional dari dokter atau ahli patologi. Segera hubungi tenaga medis untuk pemeriksaan fisik, USG, atau MRI guna memastikan kondisi kesehatan Anda.
            </p>
        </div>
    </section>

</main>

<?php 
include "footer.php";
?>