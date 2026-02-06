<?php
$base_url = "/spk-kista-dermoid"; // Sesuaikan dengan folder project Anda
session_start();

// Kalau sudah login, langsung ke homepage
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include "navbar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Kista Dermoid</title>
    <link rel="stylesheet" href="<?= $base_url ?>/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Verdana', sans-serif;
        }

        .bg-welcome {
            /* Pastikan path gambar benar, jika di folder img gunakan ../img/1.jpg atau sesuai lokasi */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../img/1.jpg');
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-box {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 40px;
            border-radius: 15px;
            max-width: 800px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
            margin: 20px;
        }

        .content-box h1 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #2979ff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .content-box p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: justify;
        }

        .btn-start {
            background-color: #2979ff;
            color: white;
            padding: 12px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            border: none;
        }

        .btn-start:hover {
            background-color: #1565c0;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(41, 121, 255, 0.5);
        }
    </style>
</head>
<body>

<div class="bg-welcome">
    <div class="content-box">
        <h1>Sistem Pakar Kista Dermoid</h1>
        
        <p>
            Website yang dikembangkan merupakan website konsultasi kesehatan yang berfokus pada kista dermoid, 
            yang diklasifikasikan ke dalam empat jenis berdasarkan karakteristik gejalanya. Melalui pemilihan 
            gejala yang dialami, sistem membantu pengguna mengenali kemungkinan jenis kista dermoid yang diderita. 
            Website ini bertujuan untuk memberikan edukasi awal serta membantu pengguna dalam pengenalan dini penyakit, 
            sehingga dapat mendorong pemeriksaan lanjutan oleh tenaga medis.
        </p>

        <a href="login.php" class="btn-start">Mulai Konsultasi Sekarang</a>
    </div>
</div>

</body>
</html>