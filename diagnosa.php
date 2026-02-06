<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

// Ambil data gejala
$gejala = mysqli_query($conn, "SELECT * FROM gejala");

$title = "Form Diagnosa - Kista Dermoid";
include "navbar.php";
?>

<style>
    /* Background Marquee Bergerak ke Atas */
    body {
        margin: 0;
        padding: 0;
        background-image: url('<?= $base_url ?>/img/1.jpg');
        background-size: cover;
        background-repeat: repeat-y;
        animation: marqueeBg 60s linear infinite;
        background-attachment: fixed;
    }

    @keyframes marqueeBg {
        from { background-position: center 0; }
        to { background-position: center -1000px; }
    }

    /* Kotak Form yang Kontras */
    .diagnosa-box {
        background: rgba(0, 0, 0, 0.85); /* Hitam pekat transparan agar tulisan putih jelas */
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #2979ff;
        box-shadow: 0 0 20px rgba(0,0,0,1);
        color: white;
    }

    /* Style Input & Label agar terbaca */
    .input-group label {
        color: #2979ff;
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    .input-field {
        width: 100%;
        padding: 12px;
        background: #222;
        border: 1px solid #444;
        color: white;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .checkbox-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: 0.3s;
        cursor: pointer;
    }

    .checkbox-item:hover {
        background: rgba(41, 121, 255, 0.2);
    }

    .checkbox-item input {
        margin-right: 15px;
        transform: scale(1.3);
    }
</style>

<main style="padding: 100px 20px;">
    <div style="max-width: 700px; margin: 0 auto;" class="diagnosa-box">
        <h2 style="text-align: center; color: white; margin-bottom: 10px; font-size: 24px;">Form Diagnosa Penyakit</h2>
        <p style="text-align: center; color: #ccc; margin-bottom: 35px; font-size: 13px;">Silakan isi data dan pilih gejala yang Anda alami secara akurat.</p>

        <form action="proses.php" method="post">
            <div class="input-group">
    <label>Usia Kehamilan (Bulan)</label>
    <input 
        type="number" 
        name="usia_kehamilan" 
        class="input-field" 
        placeholder="Input 1 - 10" 
        min="1" 
        max="10" 
        oninput="if(value > 10) value = 10; if(value < 0) value = 1;"
    >
    <small style="color: #ff4d4d; display: block; margin-top: -15px; margin-bottom: 20px; font-size: 11px;">
        *Maksimal input adalah 10 bulan
    </small>
</div>

            <p style="color: #2979ff; font-weight: bold; margin-bottom: 15px;">Pilih Gejala yang Dialami:</p>

            <div style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                <?php while ($g = mysqli_fetch_assoc($gejala)) { ?>
                    <label class="checkbox-item">
                        <input type="checkbox" name="gejala[]" value="<?= $g['kode_gejala']; ?>">
                        <span style="font-size: 14px;">
                           <b><?= $g['kode_gejala']; ?></b> - <?= $g['nama_gejala']; ?>
                        </span>
                    </label>
                <?php } ?>
            </div>

            <button type="submit" style="width: 100%; padding: 15px; background: #2979ff; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 30px; box-shadow: 0 5px 15px rgba(41, 121, 255, 0.4);">
                PROSES DIAGNOSA SEKARANG
            </button>
        </form>
    </div>
</main>

<?php include "footer.php"; ?>