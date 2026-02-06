<?php
session_start();
include "../config/database.php";
include "../core/forward_chaining.php";

// Pastikan session id_user ada
if (!isset($_SESSION['id_user'])) {
    die("Sesi berakhir, silakan login kembali.");
}

$gejala_input = array_map('htmlspecialchars', $_POST['gejala'] ?? []);
if (count($gejala_input) == 0) {
    die("Silakan pilih minimal satu gejala.");
}

$id_user = $_SESSION['id_user'];
$usia_kehamilan = (int) ($_POST['usia_kehamilan'] ?? 0);

// 1. Simpan konsultasi awal
$query_konsul = "INSERT INTO konsultasi (id_user, usia_kehamilan, tanggal) VALUES ($id_user, $usia_kehamilan, NOW())";
mysqli_query($conn, $query_konsul);
$id_konsultasi = mysqli_insert_id($conn);

// 2. Simpan detail gejala
foreach ($gejala_input as $g) {
    mysqli_query($conn, "INSERT INTO konsultasi_detail (id_konsultasi, kode_gejala) VALUES ($id_konsultasi, '$g')");
}

// 3. Proses forward chaining
$hasil = forwardChaining($conn, $gejala_input);

// 4. Update hasil (Hanya jika kode penyakit ditemukan/valid)
if ($hasil['kode'] !== null) {
    $kode_p = $hasil['kode'];
    $risiko = $hasil['risiko'];
    mysqli_query($conn, "UPDATE konsultasi SET kode_penyakit = '$kode_p', tingkat_risiko = '$risiko' WHERE id_konsultasi = $id_konsultasi");
} else {
    // Jika tidak cocok dengan rule manapun
    mysqli_query($conn, "UPDATE konsultasi SET tingkat_risiko = 'Tidak Terdeteksi' WHERE id_konsultasi = $id_konsultasi");
}

header("Location: hasil.php?id=$id_konsultasi");
exit;