<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

/* PROTEKSI ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

$title = "Admin Dashboard"; 
include "layout/header.php";

/* DATA USER */
$query = mysqli_query($conn, "SELECT * FROM users ORDER BY id_user ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Manajemen User</h4>
    <a href="tambah_user.php" class="btn btn-success">
        <i class="bi bi-person-plus-fill"></i> Tambah User Baru
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td class="text-center"><?= $row['id_user'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td class="text-center"><?= $row['tanggal_lahir'] ?></td>
                <td><?= $row['email'] ?></td>
                <td class="text-center">
                    <span class="badge <?= $row['role'] == 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                        <?= $row['role'] ?>
                    </span>
                </td>
                <td><?= $row['created_at'] ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="view_user.php?id=<?= $row['id_user'] ?>" class="btn btn-info btn-sm text-white">Lihat</a>
                        <a href="edit_profil.php?id=<?= $row['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_riwayat.php?id=<?= $row['id_user'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus user ini?')">Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include "layout/footer.php"; ?>