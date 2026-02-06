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
    header("Location: dashboard.php");
    exit;
}

$id_user = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("Data user tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tgl_lahir = $_POST['tanggal_lahir'];

    $sql = "UPDATE users SET nama = '$nama', email = '$email', tanggal_lahir = '$tgl_lahir' WHERE id_user = $id_user";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Biodata berhasil diperbarui!'); window.location='dashboard.php';</script>";
    }
}

$title = "Edit Biodata - " . $user['nama'];
include "layout/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Biodata Pasien</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= $user['tanggal_lahir'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">ID User</label>
                            <input type="text" class="form-control bg-light" value="<?= $user['id_user'] ?>" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>