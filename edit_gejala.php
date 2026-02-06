<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

/* PROTEKSI ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}


$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gejala WHERE kode_gejala = '$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_gejala'];
    $ket  = $_POST['keterangan'];

    mysqli_query($conn, "UPDATE gejala SET nama_gejala='$nama', keterangan='$ket' WHERE kode_gejala='$id'");
    header("Location: data_gejala.php");
    exit;
}

$title = "Edit Gejala - " . $id;
include "layout/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Gejala: <?= $id ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Gejala</label>
                        <input type="text" name="nama_gejala" class="form-control" value="<?= $data['nama_gejala'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="4"><?= $data['keterangan'] ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                        <a href="data_gejala.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>