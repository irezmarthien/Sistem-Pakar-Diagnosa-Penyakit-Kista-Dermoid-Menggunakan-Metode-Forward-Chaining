<?php
include "../config/database.php";

$id = $_GET['id'];

// 1. Hapus detail gejala (terhubung ke tabel konsultasi)
mysqli_query($conn, "DELETE FROM konsultasi_detail WHERE id_konsultasi IN (SELECT id_konsultasi FROM konsultasi WHERE id_user = $id)");

// 2. Hapus riwayat konsultasi
mysqli_query($conn, "DELETE FROM konsultasi WHERE id_user = $id");

// 3. Hapus dari tabel 'users' (pastikan pakai 's')
$hapus = mysqli_query($conn, "DELETE FROM users WHERE id_user = $id");

if($hapus) {
    echo "<script>alert('Data User Berhasil Dihapus'); window.location='dashboard.php';</script>";
}
?>