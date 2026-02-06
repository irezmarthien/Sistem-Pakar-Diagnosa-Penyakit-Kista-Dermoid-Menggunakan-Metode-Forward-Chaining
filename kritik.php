<?php
session_start();
include "../config/database.php";

// Proteksi halaman
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama'];
// Asumsi email tersimpan di session saat login, jika tidak ada bisa ambil dari DB
$email_user = $_SESSION['email'] ?? ""; 

$pesan_sent = false;

if (isset($_POST['submit'])) {
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    $tgl = date("Y-m-d H:i:s");

    $query = "INSERT INTO kritik (id_user, nama, email, pesan, tanggal) 
              VALUES ('$id_user', '$nama_user', '$email_user', '$pesan', '$tgl')";
    
    if (mysqli_query($conn, $query)) {
        $pesan_sent = true;
    }
}

$title = "Kritik & Saran";
include "navbar.php";
?>

<html>
<head>
    <title>Kritik</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url('../img/1.jpg'); /* Background marquee sama dengan diagnosa */
            background-size: cover;
            background-attachment: fixed;
            font-family: verdana;
        }
    </style>
</head>
<body>

<main style="width: 100%; min-height: 100vh; position: relative;">
<div style="width: 500px; background-color: rgba(0, 0, 0, 0.7); top: 50%; left: 50%; transform: translate(-50%,-50%); position: absolute; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.5);">
    <h1 style="text-align: center; color: #ffffff; margin-bottom: 20px; text-transform: uppercase; font-size: 20px; margin-top: 25px;">Kritik & Saran Untuk Kami</h1>
    
    <form style="margin: 35px;" action="" method="POST">
        <input style="font-family: verdana; width: 400px; height: 40px; margin-top: 20px; padding-left: 10px; padding-right: 10px; border: 1px solid #777; border-radius: 14px; background: rgba(255,255,255,0.1); color: #ccc;"
         type="text" name="nama" value="<?= $nama_user; ?>" readonly>
        
        <input style="font-family: verdana; width: 400px; height: 40px; margin-top: 20px; padding-left: 10px; padding-right: 10px; border: 1px solid #777; border-radius: 14px; background: rgba(255,255,255,0.1); color: #ccc;"
         type="email" name="email" value="<?= $email_user; ?>" placeholder="Email tidak tersedia..." readonly>
        
        <textarea style="font-family: verdana; height: 150px; padding-top: 10px; padding-left: 10px; padding-right: 10px; width: 400px; margin-top: 20px; border: 1px solid #777; border-radius: 14px; background: white;"
         name="pesan" placeholder="Tulis kritik atau saran anda di sini..." required></textarea> <br>
        
        <input style="font-family: verdana; border-radius: 20px; color: #FFF; margin-top: 18px; padding: 10px 30px; background-color: #2979ff; box-shadow: 0 0 10px rgba(41,121,255,.3); font-size: 12px; border: none; cursor: pointer; font-weight: bold;"
         type="submit" name="submit" value="Kirim Pesan">
    </form>
</div>
</main>


<?php if ($pesan_sent): ?>
<script>
    Swal.fire({
        title: 'Bagus!',
        text: 'Kritik dan saran Anda telah terkirim.',
        icon: 'success',
        confirmButtonColor: '#2979ff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php';
        }
    });
</script>
<?php endif; ?>

<?php 
include "footer.php";
?>