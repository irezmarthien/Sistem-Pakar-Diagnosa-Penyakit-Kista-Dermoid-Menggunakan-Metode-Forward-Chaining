<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

$title = "Manajemen Gejala";
include "layout/header.php";

$query = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kode_gejala ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Gejala</h4>
    <a href="tambah_gejala.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Gejala
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
    <thead class="table-dark">
        <tr>
            <th width="10%">Kode</th>
            <th width="20%">Nama Gejala</th>
            <th width="20%">Kategori</th> <th width="30%">Keterangan</th>
            <th width="20%" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($g = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td class="fw-bold"><?= $g['kode_gejala'] ?></td>
            <td><?= $g['nama_gejala'] ?></td>
            <td><span class="badge bg-info text-dark"><?= $g['kategori'] ?></span></td> <td class="text-muted"><?= $g['keterangan'] ?></td>
            <td class="text-center">
                <div class="btn-group">
                    <a href="edit_gejala.php?id=<?= $g['kode_gejala'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_gejala.php?id=<?= $g['kode_gejala'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>