<?php
include "../config/database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah penyakit ini sedang digunakan di tabel rules
    $cek = mysqli_query($conn, "SELECT id_rule FROM rules WHERE kode_penyakit = '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        // Jika digunakan, jangan hapus agar tidak merusak basis aturan
        echo "<script>alert('Gagal! Penyakit ini masih digunakan dalam Basis Aturan (Rules). Hapus rule terkait terlebih dahulu.'); window.location='data_penyakit.php';</script>";
    } else {
        // Jika tidak digunakan, silakan hapus
        mysqli_query($conn, "DELETE FROM penyakit WHERE kode_penyakit = '$id'");
        header("Location: data_penyakit.php?pesan=hapus-berhasil");
    }
}
?>