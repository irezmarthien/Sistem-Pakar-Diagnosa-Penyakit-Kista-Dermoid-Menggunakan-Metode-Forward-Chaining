<?php
$base_url = "/spk-kista-dermoid"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Pakar</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

    <div class="login-container"> <div class="login-header">
            <h2>Daftar Akun</h2>
            <p>Lengkapi data diri untuk memulai diagnosa</p>
        </div>

        <form action="proses_register.php" method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required style="color-scheme: dark;"> 
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="contoh@mail.com" required>
            </div>

            <div class="form-group">
                <label>PIN / Password</label>
                <input type="password" name="password" placeholder="Buat password" required>
            </div>

            <button type="submit" class="btn-login">DAFTAR SEKARANG</button>
        </form>

        <div class="register-link">
            <p>Sudah punya akun?</p>
            <a href="login.php">LOG IN DI SINI</a>
        </div>
    </div>

</body>
</html>