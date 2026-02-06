<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

$title = "Manajemen Data Penyakit";
include "layout/header.php";

$query = mysqli_query($conn, "SELECT * FROM penyakit ORDER BY kode_penyakit ASC");
?>

<div class="d-flex justify-content-between mb-4">
    <h4>Data Penyakit</h4>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPenyakit">
        <i class="bi bi-plus-circle"></i> Tambah Penyakit
    </button>
</div>

<div class="row">
    <?php while($p = mysqli_fetch_assoc($query)): ?>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold"><?= $p['kode_penyakit'] ?> - <?= $p['nama_penyakit'] ?></span>
                <div>
                    <a href="edit_penyakit.php?id=<?= $p['kode_penyakit'] ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                    <a href="hapus_penyakit.php?id=<?= $p['kode_penyakit'] ?>" class="btn btn-light btn-sm text-danger" onclick="return confirm('Hapus data penyakit ini?')"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="badge bg-<?= $p['tingkat_risiko'] == 'Tinggi' ? 'danger' : 'success' ?>">
                        Risiko: <?= $p['tingkat_risiko'] ?>
                    </span>
                    <?php if(!empty($p['lokasi'])): ?>
                        <span class="badge bg-info text-dark">Lokasi: <?= $p['lokasi'] ?></span>
                    <?php endif; ?>
                </div>
                
                <p class="small mb-2"><strong>Deskripsi:</strong><br><?= $p['deskripsi'] ?: '-' ?></p>
                <p class="small mb-0 text-success"><strong>Solusi:</strong><br><?= $p['solusi'] ?: '-' ?></p>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div class="modal fade" id="modalTambahPenyakit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="proses_cepat.php?return_id=data_penyakit" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penyakit Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Penyakit</label>
                        <input type="text" name="kode_penyakit" class="form-control" placeholder="Contoh: P01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Penyakit</label>
                        <input type="text" name="nama_penyakit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tingkat Risiko</label>
                        <select name="tingkat_risiko" class="form-select">
                            <option value="Rendah">Rendah</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi penyakit..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Solusi</label>
                        <textarea name="solusi" class="form-control" rows="3" placeholder="Masukkan solusi penanganan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_p" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>