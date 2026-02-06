<?php
// layout/header.php
$base_url = "/spk-kista-dermoid"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Dashboard'; ?></title>

    <link rel="stylesheet" href="<?= $base_url ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<?php include "sidebar.php"; ?>
<div class="content">
    <div class="container-fluid">