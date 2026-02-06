<?php
session_start();
include "../config/database.php";

if (!isset($_GET['id'])) { header("Location: data_penyakit.php"); exit; }

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM penyakit WHERE kode_penyakit = '$id'");
$d = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $kode_baru = mysqli_real_escape_string($conn, $_POST['kode_penyakit']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penyakit']);
    $risiko = $_POST['tingkat_risiko'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $solusi = mysqli_real_escape_string($conn, $_POST['solusi']);

    // Mulai Transaksi agar data konsisten
    mysqli_begin_transaction($conn);

    try {
        // 1. Matikan sementara pengecekan foreign key (Cara Praktis)
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        // 2. Update tabel penyakit
        $sql_penyakit = "UPDATE penyakit SET 
                kode_penyakit = '$kode_baru', 
                nama_penyakit = '$nama', 
                tingkat_risiko = '$risiko', 
                lokasi = '$lokasi', 
                deskripsi = '$deskripsi', 
                solusi = '$solusi' 
                WHERE kode_penyakit = '$id'";
        mysqli_query($conn, $sql_penyakit);

        // 3. Update semua referensi kode_penyakit di tabel rules agar ikut berubah
        $sql_rules = "UPDATE rules SET kode_penyakit = '$kode_baru' WHERE kode_penyakit = '$id'";
        mysqli_query($conn, $sql_rules);

        // 4. Aktifkan kembali pengecekan foreign key
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        mysqli_commit($conn);
        echo "<script>alert('Data penyakit dan referensi aturan berhasil diperbarui!'); window.location='data_penyakit.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Gagal memperbarui data: " . $e->getMessage() . "');</script>";
    }
}
$title = "Edit Penyakit - " . $id;
include "layout/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Master Data Penyakit</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kode Penyakit</label>
                            <input type="text" name="kode_penyakit" class="form-control" value="<?= $d['kode_penyakit'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Penyakit</label>
                            <input type="text" name="nama_penyakit" class="form-control" value="<?= $d['nama_penyakit'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tingkat Risiko</label>
                            <select name="tingkat_risiko" class="form-select">
                                <option value="Rendah" <?= $d['tingkat_risiko'] == 'Rendah' ? 'selected' : '' ?>>Rendah</option>
                                <option value="Tinggi" <?= $d['tingkat_risiko'] == 'Tinggi' ? 'selected' : '' ?>>Tinggi</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= $d['lokasi'] ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $d['deskripsi'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Solusi</label>
                        <textarea name="solusi" class="form-control" rows="3"><?= $d['solusi'] ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="data_penyakit.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>