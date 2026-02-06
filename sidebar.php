<?php
// ambil nama file aktif
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar position-fixed top-0 start-0 vh-100 shadow">
    <div class="text-center py-4 border-bottom border-secondary border-opacity-25">
        <i class="bi bi-person-circle fs-1 text-white"></i>
        <h6 class="mt-2 text-white fw-bold mb-0">ADMINISTRATOR</h6>
        <small class="text-white-50">SPK Kista Hermoid pada Ibu Hamil</small>
    </div>

    <div class="mt-3">
        <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-people me-2"></i> User Manajemen
        </a>

        <a href="data_gejala.php" class="<?= $currentPage == 'data_gejala.php' ? 'active' : '' ?>">
            <i class="bi bi-clipboard2-pulse me-2"></i> Data Gejala
        </a>

        <a href="data_penyakit.php" class="<?= $currentPage == 'data_penyakit.php' ? 'active' : '' ?>">
    <i class="bi bi-virus me-2"></i> Data Penyakit
</a>

        <a href="data_rules.php" class="<?= $currentPage == 'data_rules.php' ? 'active' : '' ?>">
            <i class="bi bi-diagram-3 me-2"></i> Basis Aturan (Rules)
        </a>
    </div>

    <a href="data_kritik.php" class="<?= $currentPage == 'data_kritik.php' ? 'active' : '' ?>">
        <i class="bi bi-chat-left-text me-2"></i> Kritik & Saran User
    </a>

    <div class="position-absolute bottom-0 w-100 p-3 border-top border-secondary border-opacity-25">
        <a href="#" 
           class="text-danger d-flex align-items-center justify-content-center text-decoration-none py-2 rounded" 
           data-bs-toggle="modal" 
           data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-right me-2"></i> <strong>Keluar</strong>
        </a>
    </div>
</div>

<?php 
// Panggil file modal agar selalu tersedia di setiap halaman yang ada sidebar-nya
include "modal_logout.php"; 
?>