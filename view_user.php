<?php
session_start();
include "../config/database.php";

$id_user = $_GET['id'];

// 1. Ambil Data Biodata Users
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");
$user = mysqli_fetch_assoc($user_query);

// 2. Ambil Riwayat Diagnosa
$riwayat = mysqli_query($conn, "
    SELECT k.*, p.nama_penyakit, p.deskripsi, p.solusi 
    FROM konsultasi k 
    JOIN penyakit p ON k.kode_penyakit = p.kode_penyakit 
    WHERE k.id_user = $id_user 
    ORDER BY k.tanggal DESC
");

// Sertakan navbar (pastikan path benar, jika admin punya navbar sendiri)
// Jika menggunakan navbar dari public: include "../public/navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail User - <?= $user['nama'] ?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white"><h5>Biodata Pasien</h5></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> <?= $user['nama'] ?></p>
                    <p><strong>Email:</strong> <?= $user['email'] ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Lahir:</strong> <?= $user['tanggal_lahir'] ?></p>
                    <p><strong>Bergabung Sejak:</strong> <?= $user['created_at'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4>Riwayat Diagnosa</h4>
<div class="accordion shadow-sm" id="accordionHistory">
    <?php $no = 1; while($row = mysqli_fetch_assoc($riwayat)): ?>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $no ?>">
                <?= date('d M Y - H:i', strtotime($row['tanggal'])) ?> | <strong><?= $row['nama_penyakit'] ?></strong>
            </button>
        </h2>
        <div id="collapse<?= $no ?>" class="accordion-collapse collapse" data-bs-parent="#accordionHistory">
            <div class="accordion-body">
                
                <h6>Gejala yang Dialami:</h6>
                <ul class="text-muted">
                    <?php
                    // Ambil id_konsultasi dari baris riwayat saat ini
                    $id_kon = $row['id_konsultasi'];
                    
                    // Query untuk mengambil daftar gejala berdasarkan detail konsultasi
                    $query_gejala = mysqli_query($conn, "
                        SELECT g.nama_gejala 
                        FROM konsultasi_detail kd
                        JOIN gejala g ON kd.kode_gejala = g.kode_gejala
                        WHERE kd.id_konsultasi = $id_kon
                    ");

                    if (mysqli_num_rows($query_gejala) > 0) {
                        while ($g = mysqli_fetch_assoc($query_gejala)) {
                            echo "<li>" . $g['nama_gejala'] . "</li>";
                        }
                    } else {
                        echo "<li>Tidak ada data gejala.</li>";
                    }
                    ?>
                </ul>
                <hr>

                <h6>Hasil Diagnosa:</h6>
                <p><?= $row['deskripsi'] ?></p>
                <hr>
                <h6>Saran/Solusi:</h6>
                <p class="text-success"><strong><?= $row['solusi'] ?></strong></p>
            </div>
        </div>
    </div>
    <?php $no++; endwhile; ?>
</div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>