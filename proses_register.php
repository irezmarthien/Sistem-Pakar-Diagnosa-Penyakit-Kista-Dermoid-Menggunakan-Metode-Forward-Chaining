<?php
include '../config/database.php';

$nama = $_POST['nama'];
$tgl  = $_POST['tanggal_lahir'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nama, tanggal_lahir, email, password)
        VALUES ('$nama', '$tgl', '$email', '$pass')";

mysqli_query($conn, $sql);

header("Location: login.php");
