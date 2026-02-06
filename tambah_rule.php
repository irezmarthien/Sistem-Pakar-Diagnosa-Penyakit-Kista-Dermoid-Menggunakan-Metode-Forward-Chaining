<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

// PROTEKSI ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

// LOGIKA SIMPAN RULE BARU
if (isset($_POST['simpan_rule'])) {
    $kode_p = mysqli_real_escape_string($conn, $_POST['kode_penyakit']);
    $ket    = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $gejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

    // 1. Simpan ke tabel rules
    $sql_rule = "INSERT INTO rules (kode_penyakit, keterangan) VALUES ('$kode_p', '$ket')";
    if (mysqli_query($conn, $sql_rule)) {
        $id_baru = mysqli_insert_id($conn);

        // 2. Simpan detail gejala (rule_detail)
        foreach ($gejala as $g) {
            $g_safe = mysqli_real_escape_string($conn, $g);
            mysqli_query($conn, "INSERT INTO rule_detail (id_rule, kode_gejala) VALUES ('$id_baru', '$g_safe')");
        }
        
        echo "<script>alert('Rule berhasil ditambahkan!'); window.location='data_rules.php';</script>";
        exit; 
    }
}

$title = "Tambah Rule Diagnosa";
include "layout/header.php";
?>

<div class="row justify-content-center pb-5">
    <div class="col-md-10">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-diagram-3"></i> Buat Aturan Diagnosa Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-4">
                        <label class="fw-bold text-primary">1. Hasil Diagnosa (Penyakit)</label>
                        <div class="input-group">
                            <select name="kode_penyakit" class="form-select" required id="selectPenyakit">
                                <option value="">-- Pilih Penyakit --</option>
                                <?php 
                                $penyakit = mysqli_query($conn, "SELECT * FROM penyakit ORDER BY kode_penyakit ASC");
                                while($p = mysqli_fetch_assoc($penyakit)): 
                                ?>
                                    <option value="<?= $p['kode_penyakit'] ?>"
                                            data-lokasi="<?= htmlspecialchars($p['lokasi']) ?>"
                                            data-deskripsi="<?= htmlspecialchars($p['deskripsi']) ?>"
                                            data-risiko="<?= $p['tingkat_risiko'] ?>"
                                            data-solusi="<?= htmlspecialchars($p['solusi']) ?>"
                                            data-keterangan="<?= htmlspecialchars($p['keterangan']) ?>">
                                        <?= $p['kode_penyakit'] ?> - <?= $p['nama_penyakit'] ?> (Risiko: <?= $p['tingkat_risiko'] ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPenyakit">
                                <i class="bi bi-plus-lg"></i> Baru
                            </button>
                        </div>
                        
                        <!-- Info Detail Penyakit yang Dipilih -->
                        <div id="infoPenyakit" class="mt-3 p-3 border rounded bg-light" style="display: none;">
                            <h6 class="fw-bold text-primary mb-2">Detail Penyakit yang Dipilih:</h6>
                            <div class="small">
                                <div class="mb-2" id="infoRisiko"></div>
                                <div class="mb-2" id="infoLokasi"></div>
                                <div class="mb-2" id="infoDeskripsi"></div>
                                <div class="mb-2" id="infoSolusi"></div>
                                <div class="mb-2" id="infoKeterangan"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">2. Pilih Gejala yang Terkait</label>
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalGejala">
                                <i class="bi bi-plus-circle"></i> Tambah Gejala Baru
                            </button>
                        </div>
                        <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                            <?php
                            // Ambil gejala urut berdasarkan kategori
                            $query_gejala = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kategori, kode_gejala ASC");
                            $current_kat = "";
                            while($g = mysqli_fetch_assoc($query_gejala)): 
                                if($current_kat != $g['kategori']): $current_kat = $g['kategori'];
                            ?>
                                <div class="bg-secondary text-white px-2 py-1 small fw-bold mb-2 mt-3 rounded">
                                    KATEGORI: <?= strtoupper($current_kat) ?>
                                </div>
                            <?php endif; ?>
                                <div class="form-check border-bottom py-2">
                                    <input class="form-check-input" type="checkbox" name="gejala[]" value="<?= $g['kode_gejala'] ?>" id="g<?= $g['kode_gejala'] ?>">
                                    <label class="form-check-label" for="g<?= $g['kode_gejala'] ?>">
                                        <strong><?= $g['kode_gejala'] ?></strong> - <?= $g['nama_gejala'] ?>
                                        <?php if(!empty($g['keterangan'])): ?>
                                            <br><small class="text-muted"><?= $g['keterangan'] ?></small>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <small class="text-muted">* Pilih satu atau lebih gejala yang menjadi syarat untuk diagnosa ini</small>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-primary">3. Keterangan Logika Rule</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: IF (Nyeri panggul AND Pembesaran abdomen) OR Nyeri perut mendadak THEN Diagnosa Kista Dermoid Ovarium"></textarea>
                        <small class="text-muted">* Jelaskan logika penalaran untuk rule ini (opsional tapi direkomendasikan)</small>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="data_rules.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="simpan_rule" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Rule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Penyakit Cepat -->
<div class="modal fade" id="modalPenyakit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_cepat.php" method="POST">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Tambah Penyakit Cepat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
                <label class="small fw-bold">Kode Penyakit <span class="text-danger">*</span></label>
                <input type="text" name="kode_penyakit" placeholder="Contoh: P05" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Nama Penyakit <span class="text-danger">*</span></label>
                <input type="text" name="nama_penyakit" placeholder="Nama Penyakit" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Lokasi</label>
                <input type="text" name="lokasi" placeholder="Lokasi penyakit" class="form-control">
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi penyakit" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Tingkat Risiko <span class="text-danger">*</span></label>
                <select name="tingkat_risiko" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Tinggi">Tinggi</option>
                    <option value="Rendah">Rendah</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Solusi</label>
                <textarea name="solusi" placeholder="Solusi penanganan" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Keterangan</label>
                <textarea name="keterangan" placeholder="Keterangan tambahan" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah_p" class="btn btn-success">Simpan & Refresh</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Gejala Cepat -->
<div class="modal fade" id="modalGejala" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_cepat.php" method="POST">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Tambah Gejala Cepat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
                <label class="small fw-bold">Kode Gejala <span class="text-danger">*</span></label>
                <input type="text" name="kode_gejala" placeholder="Contoh: G10" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Nama Gejala <span class="text-danger">*</span></label>
                <input type="text" name="nama_gejala" placeholder="Nama Gejala" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Kategori <span class="text-danger">*</span></label>
                <input type="text" name="kategori" placeholder="Contoh: Nyeri, Fisik, Sistemik" class="form-control" required>
                <small class="text-muted">Kategori yang sudah ada: Nyeri, Nyeri Akut, Tekanan, Fisik, Fungsional, Sistemik, Asimtomatik</small>
            </div>
            <div class="mb-2">
                <label class="small fw-bold">Keterangan</label>
                <textarea name="keterangan" placeholder="Keterangan gejala (opsional)" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah_g" class="btn btn-success">Simpan & Refresh</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Script untuk menampilkan info penyakit saat dipilih
document.getElementById('selectPenyakit').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const infoDiv = document.getElementById('infoPenyakit');
    
    if (selected.value) {
        const lokasi = selected.getAttribute('data-lokasi');
        const deskripsi = selected.getAttribute('data-deskripsi');
        const risiko = selected.getAttribute('data-risiko');
        const solusi = selected.getAttribute('data-solusi');
        const keterangan = selected.getAttribute('data-keterangan');
        
        // Badge warna sesuai risiko
        let badgeClass = 'bg-success';
        if (risiko === 'Tinggi') badgeClass = 'bg-danger';
        else if (risiko === 'Sedang') badgeClass = 'bg-warning text-dark';
        
        document.getElementById('infoRisiko').innerHTML = 
            '<i class="bi bi-exclamation-triangle-fill"></i> <strong>Tingkat Risiko:</strong> <span class="badge ' + badgeClass + '">' + risiko + '</span>';
        
        document.getElementById('infoLokasi').innerHTML = 
            lokasi && lokasi !== 'null' ? '<i class="bi bi-geo-alt-fill"></i> <strong>Lokasi:</strong> ' + lokasi : '';
        
        document.getElementById('infoDeskripsi').innerHTML = 
            deskripsi && deskripsi !== 'null' ? '<i class="bi bi-info-circle-fill"></i> <strong>Deskripsi:</strong> ' + deskripsi : '';
        
        document.getElementById('infoSolusi').innerHTML = 
            solusi && solusi !== 'null' ? '<i class="bi bi-bandaid-fill"></i> <strong>Solusi:</strong> ' + solusi : '';
        
        document.getElementById('infoKeterangan').innerHTML = 
            keterangan && keterangan !== 'null' ? '<i class="bi bi-journal-text"></i> <strong>Keterangan:</strong> ' + keterangan : '';
        
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
    }
});
</script>

<?php include "layout/footer.php"; ?>