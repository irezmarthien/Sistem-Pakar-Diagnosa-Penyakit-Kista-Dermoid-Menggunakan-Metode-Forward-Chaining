<?php
include "../config/database.php";

// Ambil ID dari URL (pastikan di file data_gejala.php kirimnya pakai ?id=...)
$id = $_GET['id'];

// 1. Hapus relasi di rule_detail terlebih dahulu
// Gunakan nama kolom 'kode_gejala' sesuai database kamu
mysqli_query($conn, "DELETE FROM rule_detail WHERE kode_gejala = '$id'");

// 2. Hapus data di tabel gejala
// Pastikan nama tabelnya 'gejala' dan kolomnya 'kode_gejala'
mysqli_query($conn, "DELETE FROM gejala WHERE kode_gejala = '$id'");

header("Location: data_gejala.php");
?>