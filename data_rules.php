<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

$title = "Manajemen Rules";
include "layout/header.php";

// Query utama untuk mengambil data Rule dan SEMUA kolom dari tabel Penyakit
$query = mysqli_query($conn, "
    SELECT r.*, 
           p.kode_penyakit,
           p.nama_penyakit,
           p.lokasi,
           p.deskripsi,
           p.tingkat_risiko,
           p.solusi,
           p.keterangan as keterangan_penyakit
    FROM rules r 
    JOIN penyakit p ON r.kode_penyakit = p.kode_penyakit
    ORDER BY r.id_rule ASC
");
?>

<div class="d-flex justify-content-between mb-4">
    <h4>Basis Pengetahuan (Rules)</h4>
    <a href="tambah_rule.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Rule</a>
</div>

<div class="row">
    <?php while($r = mysqli_fetch_assoc($query)): ?>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Rule #<?= $r['id_rule'] ?>: <?= $r['nama_penyakit'] ?></span>
                <div>
                    <a href="edit_rule.php?id=<?= $r['id_rule'] ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                    <a href="hapus_rule.php?id=<?= $r['id_rule'] ?>" class="btn btn-light btn-sm text-danger" onclick="return confirm('Hapus rule?')"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <div class="card-body">
                <!-- Informasi Penyakit Lengkap -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold text-primary"><?= $r['nama_penyakit'] ?></h6>
                        <span class="badge bg-<?= $r['tingkat_risiko'] == 'Tinggi' ? 'danger' : ($r['tingkat_risiko'] == 'Sedang' ? 'warning' : 'success') ?>">
                            <?= $r['tingkat_risiko'] ?>
                        </span>
                    </div>
                    
                    <div class="small mb-2">
                        <i class="bi bi-clipboard-pulse text-muted"></i>
                        <strong>Kode Penyakit:</strong> <?= $r['kode_penyakit'] ?>
                    </div>
                    
                    <?php if(!empty($r['lokasi'])): ?>
                    <div class="small mb-2">
                        <i class="bi bi-geo-alt text-muted"></i>
                        <strong>Lokasi:</strong> <?= $r['lokasi'] ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($r['deskripsi'])): ?>
                    <div class="small mb-2">
                        <i class="bi bi-info-circle text-muted"></i>
                        <strong>Deskripsi:</strong> <?= $r['deskripsi'] ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($r['solusi'])): ?>
                    <div class="small mb-2">
                        <i class="bi bi-bandaid text-muted"></i>
                        <strong>Solusi:</strong> <?= $r['solusi'] ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($r['keterangan_penyakit'])): ?>
                    <div class="small mb-2">
                        <i class="bi bi-journal-text text-muted"></i>
                        <strong>Keterangan:</strong> <?= $r['keterangan_penyakit'] ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <hr>
                
                <!-- Gejala Syarat -->
                <h6 class="fw-bold">Gejala Syarat:</h6>
                <ul class="list-unstyled small">
                    <?php
                    $id_rule = $r['id_rule'];
                    // Query detail gejala diletakkan DI DALAM perulangan rule
                    $details = mysqli_query($conn, "
                        SELECT rd.*, g.nama_gejala, g.kategori 
                        FROM rule_detail rd 
                        JOIN gejala g ON rd.kode_gejala = g.kode_gejala 
                        WHERE rd.id_rule = $id_rule
                    ");
                    
                    while($d = mysqli_fetch_assoc($details)): ?>
                        <li class='mb-1'>
                            <i class='bi bi-check2-circle text-success me-2'></i>
                            <span class="badge bg-light text-dark border mr-1"><?= $d['kategori'] ?></span> 
                            <?= $d['nama_gejala'] ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                
                <hr>
                
                <!-- Logika Rule -->
                <div class="small text-muted">
                    <strong>Logika Rule:</strong> <?= $r['keterangan'] ?>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include "layout/footer.php"; ?>