<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

/* PROTEKSI ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: data_rules.php");
    exit;
}

$id = $_GET['id'];
$query_rule = mysqli_query($conn, "SELECT * FROM rules WHERE id_rule = '$id'");
$rule_data = mysqli_fetch_assoc($query_rule);

if (!$rule_data) { die("Data Rule tidak ditemukan."); }

$selected_gejala = [];
$res_detail = mysqli_query($conn, "SELECT kode_gejala FROM rule_detail WHERE id_rule = '$id'");
while($row = mysqli_fetch_assoc($res_detail)) { $selected_gejala[] = $row['kode_gejala']; }

if (isset($_POST['update'])) {
    $kode_p_lama = $_POST['kode_penyakit_lama']; // Kode asli untuk WHERE clause
    $kode_p_baru = $_POST['kode_penyakit_baru']; // Kode baru jika diubah
    $nama_p      = $_POST['nama_penyakit'];
    $tingkat_r   = $_POST['tingkat_risiko'];
    $lokasi      = $_POST['lokasi'];
    $ket_rule    = $_POST['keterangan'];
    $gejala_input = $_POST['gejala'] ?? [];

    // 1. Update Tabel Penyakit (Termasuk Kode dan Nama)
    // Gunakan kode_p_lama di WHERE agar record yang tepat terupdate
    $update_p = "UPDATE penyakit SET 
                 kode_penyakit = '$kode_p_baru', 
                 nama_penyakit = '$nama_p', 
                 tingkat_risiko = '$tingkat_r', 
                 lokasi = '$lokasi' 
                 WHERE kode_penyakit = '$kode_p_lama'";
    mysqli_query($conn, $update_p);

    // 2. Update Tabel Rules (Sesuaikan kode penyakit jika berubah)
    mysqli_query($conn, "UPDATE rules SET kode_penyakit='$kode_p_baru', keterangan='$ket_rule' WHERE id_rule='$id'");

    // 3. Update Detail Gejala (Hapus yang lama, masukkan yang baru)
    mysqli_query($conn, "DELETE FROM rule_detail WHERE id_rule='$id'"); 
    foreach ($gejala_input as $g) {
        mysqli_query($conn, "INSERT INTO rule_detail (id_rule, kode_gejala) VALUES ('$id', '$g')");
    }

    echo "<script>alert('Rule dan Data Penyakit berhasil diperbarui!'); window.location='data_rules.php';</script>";
}

$title = "Edit Rule #" . $id;
include "layout/header.php";
?>

<div class="row justify-content-center pb-5">
    <div class="col-md-10">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Aturan Diagnosa #<?= $id ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">1. Hasil Diagnosa (Penyakit)</label>
                        <select name="kode_penyakit_lama" class="form-select" required id="selectPenyakit">
                            <?php 
                            $penyakit = mysqli_query($conn, "SELECT * FROM penyakit");
                            while($p = mysqli_fetch_assoc($penyakit)): 
                            ?>
                                <option value="<?= $p['kode_penyakit'] ?>" 
                                        <?= ($p['kode_penyakit'] == $rule_data['kode_penyakit']) ? 'selected' : '' ?>
                                        data-nama="<?= htmlspecialchars($p['nama_penyakit']) ?>"
                                        data-lokasi="<?= htmlspecialchars($p['lokasi']) ?>"
                                        data-risiko="<?= $p['tingkat_risiko'] ?>"
                                        data-deskripsi="<?= htmlspecialchars($p['deskripsi']) ?>"
                                        data-solusi="<?= htmlspecialchars($p['solusi']) ?>">
                                    <?= $p['kode_penyakit'] ?> - <?= $p['nama_penyakit'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        


                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Gejala Syarat</label>
                        <div class="border rounded p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                            <?php 
                            $all_gejala = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kategori, kode_gejala ASC");
                            $current_kat = "";
                            while($g = mysqli_fetch_assoc($all_gejala)): 
                                $is_checked = in_array($g['kode_gejala'], $selected_gejala) ? 'checked' : '';
                                if($current_kat != $g['kategori']): 
                                    $current_kat = $g['kategori'];
                            ?>
                                <div class="bg-secondary text-white px-2 py-1 small fw-bold mb-2 mt-2 rounded">
                                    KATEGORI: <?= strtoupper($current_kat) ?>
                                </div>
                            <?php endif; ?>
                            
                                <div class="form-check border-bottom py-2">
                                    <input class="form-check-input" type="checkbox" name="gejala[]" 
                                           value="<?= $g['kode_gejala'] ?>" 
                                           id="g<?= $g['kode_gejala'] ?>" <?= $is_checked ?>>
                                    <label class="form-check-label" for="g<?= $g['kode_gejala'] ?>">
                                        <strong><?= $g['kode_gejala'] ?></strong> - <?= $g['nama_gejala'] ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">3. Keterangan Logika Rule</label>
                        <textarea name="keterangan" class="form-control" rows="2"><?= $rule_data['keterangan'] ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="data_rules.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('selectPenyakit').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const infoDiv = document.getElementById('infoPenyakit');
    
    if (selected.value) {
        // Ambil data dari atribut data-
        const kode = selected.value;
        const nama = selected.getAttribute('data-nama');
        const lokasi = selected.getAttribute('data-lokasi');
        const risiko = selected.getAttribute('data-risiko');
        const deskripsi = selected.getAttribute('data-deskripsi');
        const solusi = selected.getAttribute('data-solusi');

        // Isi nilai ke input form agar bisa diedit
        document.getElementById('editKodeP').value = kode;
        document.getElementById('editNamaP').value = nama || '';
        document.getElementById('editLokasi').value = lokasi || '';
        document.getElementById('editRisiko').value = (risiko === 'Tinggi') ? 'Tinggi' : 'Rendah';

        // Tampilkan info tambahan
        document.getElementById('infoDeskripsi').innerHTML = deskripsi ? '<strong>Deskripsi:</strong> ' + deskripsi : '';
        document.getElementById('infoSolusi').innerHTML = solusi ? '<strong>Solusi:</strong> ' + solusi : '';
        
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
    }
});

window.addEventListener('load', function() {
    document.getElementById('selectPenyakit').dispatchEvent(new Event('change'));
});
</script>

<?php include "layout/footer.php"; ?>