<?php
include "../config/database.php";

// 1. Tentukan tujuan kembali
$return_id = isset($_GET['return_id']) ? $_GET['return_id'] : null;

// Logika penentuan lokasi
if ($return_id === 'data_penyakit') {
    $location = "data_penyakit.php";
} elseif ($return_id) {
    $location = "edit_rule.php?id=$return_id";
} else {
    $location = "tambah_rule.php";
}

// 2. Proses Tambah Penyakit
if (isset($_POST['tambah_p'])) {
    $kode = mysqli_real_escape_string($conn, $_POST['kode_penyakit']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_penyakit']);
    $risk = $_POST['tingkat_risiko'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $solusi    = mysqli_real_escape_string($conn, $_POST['solusi']);
    
    // --- TAMBAHKAN PENGECEKAN KODE DOUBLE DI SINI ---
    $cek = mysqli_query($conn, "SELECT kode_penyakit FROM penyakit WHERE kode_penyakit = '$kode'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Gagal! Kode Penyakit $kode sudah ada. Gunakan kode lain.');
                window.history.back();
              </script>";
        exit;
    }
    // -----------------------------------------------
    
    $query = "INSERT INTO penyakit (kode_penyakit, nama_penyakit, tingkat_risiko, deskripsi, solusi) 
              VALUES ('$kode', '$nama', '$risk', '$deskripsi', '$solusi')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data Penyakit Berhasil Ditambahkan!');
                window.location.href='$location';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// 3. Proses Tambah Gejala
if (isset($_POST['tambah_g'])) {
    $kode = $_POST['kode_gejala'];
    $nama = $_POST['nama_gejala'];
    $kat  = $_POST['kategori']; // Tambahkan ini
    $ket  = $_POST['keterangan'];
// cek kueri
    $cek = mysqli_query($conn, "SELECT kode_gejala FROM gejala WHERE kode_gejala = '$kode'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Gagal! Kode Gejala $kode sudah ada di database.');
                window.history.back();
              </script>";
        exit;
    }
    
    // Sebutkan nama kolomnya secara eksplisit agar lebih aman
    $query = "INSERT INTO gejala (kode_gejala, nama_gejala, kategori, keterangan) 
              VALUES ('$kode', '$nama', '$kat', '$ket')";
    
    if(mysqli_query($conn, $query)) {
    echo "<script>
            alert('Data Gejala Berhasil Ditambahkan!');
            window.location.href='$location';
          </script>";
    exit;
}
    
    header("Location: $location");
    exit;
}
?>