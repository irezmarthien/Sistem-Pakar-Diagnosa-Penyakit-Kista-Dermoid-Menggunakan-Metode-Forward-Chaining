<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['login'])) {
    header("Location: welcome.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$title = "Hasil Diagnosa - Kista Dermoid";
include "navbar.php";

/* =========================
   AMBIL RIWAYAT DIAGNOSA
========================= */
$riwayat = mysqli_query($conn, "
    SELECT k.*, p.nama_penyakit, p.deskripsi, p.solusi, p.tingkat_risiko
    FROM konsultasi k
    LEFT JOIN penyakit p ON k.kode_penyakit = p.kode_penyakit
    WHERE k.id_user = $id_user
    ORDER BY k.tanggal DESC
");
?>

<style>
    body {
        background-image: url('../img/1.jpg'); /* Sesuaikan path gambar background */
        background-size: cover;
        background-attachment: fixed;
        font-family: verdana;
    }
    .hasil-container {
        width: 80vw;
        margin: 0 auto;
        padding: 20px 30px;
        margin-top: 80px; /* Jarak dari navbar */
    }
    .card-hasil {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 14px;
        padding: 25px 30px;
        margin-bottom: 25px;
        border-radius: 4px;
        border-left: 5px solid #2979ff; /* Aksen warna biru */
    }
    .card-hasil h2 {
        margin-top: 0;
        color: #2979ff;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        padding-bottom: 10px;
    }
    .badge-risiko {
        padding: 4px 10px;
        border-radius: 3px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
    }
    .risiko-tinggi { background-color: #d32f2f; }
    .risiko-sedang { background-color: #f57c00; }
    .risiko-rendah { background-color: #388e3c; }
    
    .gejala-list {
        margin: 10px 0;
        padding-left: 20px;
        line-height: 20px;
    }
    footer {
        background-color: rgba(0,0,0,.7);
        padding: 15px;
        color: white;
        text-align: center;
        margin-top: 40px;
    }
</style>

<div class="hasil-container">
    <h1 style="color: white; text-align: center; text-shadow: 2px 2px 4px #000;">Riwayat Hasil Diagnosa</h1>
    <p style="color: white; text-align: center; margin-bottom: 40px;">Berikut adalah daftar hasil pemeriksaan yang telah Anda lakukan.</p>

    <?php 
    $no = 1;
    if (mysqli_num_rows($riwayat) > 0) {
        while ($row = mysqli_fetch_assoc($riwayat)) { 
            $tanggal = date('d F Y, H:i', strtotime($row['tanggal']));
            $risiko_class = 'risiko-' . strtolower($row['tingkat_risiko']);
    ?>
        <article class="card-hasil">
            <h2><?= $tanggal ?></h2>
            
            <p style="margin-top: 15px;"><strong>Data Pasien:</strong> Usia Kehamilan <?= $row['usia_kehamilan'] ?> Bulan</p>
            
            <p style="margin-top: 15px;"><strong>Gejala yang dialami:</strong></p>
            <ul class="gejala-list">
                <?php
                $id_konsul = $row['id_konsultasi'];
                $g_query = mysqli_query($conn, "
                    SELECT ge.nama_gejala
                    FROM konsultasi_detail kd
                    JOIN gejala ge ON kd.kode_gejala = ge.kode_gejala
                    WHERE kd.id_konsultasi = $id_konsul
                ");
                while ($gejala = mysqli_fetch_assoc($g_query)) {
                    echo "<li>- " . $gejala['nama_gejala'] . "</li>";
                }
                ?>
            </ul>

            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 5px; margin-top: 20px;">
                <p><strong>Hasil Kesimpulan:</strong> <span style="font-size: 18px; color: #00e676;"><?= $row['nama_penyakit'] ?></span></p>
                <p><strong>Tingkat Risiko:</strong> <span class="badge-risiko <?= $risiko_class ?>"><?= $row['tingkat_risiko'] ?></span></p>
                
                <p style="margin-top: 10px;"><strong>Penjelasan:</strong><br><?= $row['deskripsi'] ?></p>
                <p style="margin-top: 10px;"><strong>Rekomendasi / Solusi:</strong><br><?= $row['solusi'] ?></p>
            </div>
        </article>
    <?php 
            $no++; 
        } 
    } else { ?>
        <article class="card-hasil" style="text-align: center;">
            <p>Belum ada riwayat diagnosa yang ditemukan.</p>
        </article>
    <?php } ?>
</div>

<?php 
include "footer.php";
?>