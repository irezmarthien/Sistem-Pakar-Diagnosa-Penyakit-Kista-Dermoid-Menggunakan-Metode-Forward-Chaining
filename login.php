<?php
session_start();
$base_url = "/spk-kista-dermoid"; 

// Ambil pesan sukses atau error dari session
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KISTA DERMOID</title>
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

    <main>
        <div class="login-container">
            <h2>Login</h2>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success" style="color: #ccffcc; font-size: 12px; margin-bottom: 10px;"><?= $success_message ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-error" style="color: #ffcccc; font-size: 12px; margin-bottom: 10px;"><?= $error_message ?></div>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
                <div class="form-group">
                    <label>Email / Username</label>
                    <input type="email" name="email" placeholder="Masukkan email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="register-link">
                <p>Belum punya akun? 
                    <a href="register.php" style="color: #a349a4;">Daftar disini</a>
                </p>
            </div>
        </div>
    </main>

    <footer style="position: fixed; bottom: 0; width: 100%; background-color: rgba(0,0,0,.7); padding: 10px 0; text-align: center;">
        <p style="color: white; font-size: 12px;">&copy; 2026 Sistem Pakar Kista Dermoid</p>
    </footer>
</body>
</html>