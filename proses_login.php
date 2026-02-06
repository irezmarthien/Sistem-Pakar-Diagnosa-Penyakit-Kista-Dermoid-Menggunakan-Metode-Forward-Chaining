<?php
session_start();
include '../config/database.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass  = $_POST['password'];

$data = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($data);

if ($user && password_verify($pass, $user['password'])) {

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;

} else {
    // Memberikan alert JavaScript dan redirect kembali ke login.php
    echo "<script>
            alert('Login Gagal! Email atau Password salah.');
            window.location.href = 'login.php';
          </script>";
    exit;
}
?>