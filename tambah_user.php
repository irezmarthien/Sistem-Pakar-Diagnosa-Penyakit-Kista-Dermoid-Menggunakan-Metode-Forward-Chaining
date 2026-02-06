<?php
session_start();
include "../config/database.php";
$base_url = "/spk-ibu-hamil"; 

/* PROTEKSI ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $tgl_lahir = $_POST['tanggal_lahir'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (nama, email, password, tanggal_lahir, role) 
            VALUES ('$nama', '$email', '$password', '$tgl_lahir', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$title = "Tambah User Baru";
include "layout/header.php";
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Form Tambah User</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Role Akses</label>
                        <select name="role" class="form-select" required>
                            <option value="user">User / Pasien</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="simpan" class="btn btn-success">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>