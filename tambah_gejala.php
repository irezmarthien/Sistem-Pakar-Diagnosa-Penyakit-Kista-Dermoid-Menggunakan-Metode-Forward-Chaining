<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

/* PROTEKSI ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

if (isset($_POST['simpan'])) {
    $kode = mysqli_real_escape_string($conn, $_POST['kode_gejala']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_gejala']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $ket  = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // --- PENGECEKAN DI SINI ---
    $cek = mysqli_query($conn, "SELECT kode_gejala FROM gejala WHERE kode_gejala = '$kode'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Gagal! Kode $kode sudah terdaftar.'); window.history.back();</script>";
        exit;
    }
    // ------------------------------------

    $insert = mysqli_query($conn, "INSERT INTO gejala VALUES ('$kode', '$nama','$kategori', '$ket')");
    if ($insert) {
        echo "<script>alert('Gejala berhasil ditambahkan!'); window.location='data_gejala.php';</script>";
        exit;
    }
}

$title = "Tambah Gejala Baru";
include "layout/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Gejala Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Gejala</label>
                        <input type="text" name="kode_gejala" class="form-control" placeholder="Contoh: G01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Gejala</label>
                        <input type="text" name="nama_gejala" class="form-control" placeholder="Masukkan nama gejala" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Masukkan nama kategori" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Penjelasan singkat mengenai gejala..."></textarea>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="data_gejala.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>