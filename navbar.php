<?php
// Pastikan session sudah dimulai di file utama (index.php/beranda.php)
$base_url = "/spk-kista-dermoid"; 
?>
<head>

    <link rel="stylesheet" href="<?= $base_url ?>/css/style.css?v=<?= time() ?>">
    
    <style>
        /* CSS Tambahan khusus Navbar Baru */
        #menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 50px;
            background: #1a1a1a;
            height: 70px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        #heading a {
            font-family: 'Verdana';
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            letter-spacing: 1px;
        }

        #menu ul {
            display: flex;
            list-style: none;
            align-items: center;
            margin: 0;
        }

        #menu ul li {
            position: relative;
            padding: 0 15px;
        }

        #menu ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        #menu ul li a:hover {
            color: #2979ff;
        }

        /* Style Khusus Tombol Diagnosa */
        .btn-diagnosa {
            background-color: #2979ff;
            padding: 8px 20px !important;
            border-radius: 20px;
            font-weight: bold !important;
            color: white !important;
        }

        .btn-diagnosa:hover {
            background-color: #1565c0 !important;
            box-shadow: 0 0 10px rgba(41, 121, 255, 0.5);
        }

        /* Dropdown Styling */
        #menu ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #2e3030;
            flex-direction: column;
            min-width: 180px;
            padding: 10px 0;
            border-radius: 0 0 8px 8px;
        }

        #menu ul li:hover ul {
            display: flex;
        }

        #menu ul li ul li {
            padding: 10px 20px;
        }

        /* Modal Logout Style */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #222;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            color: white;
            border: 1px solid #444;
        }
    </style>
</head>
<body>

<nav id="menu">
    <div id="heading">
        <a href="<?= $base_url ?>/public/index.php">KISTA DERMOID</a>
    </div>

    <ul>
        <li><a href="<?= $base_url ?>/public/index.php">Beranda</a></li>
        <li><a href="<?= $base_url ?>/public/hasil.php">Riwayat Diagnosa</a></li>
        
        <li>
            <a href="#">Info ▾</a>
            <ul>
                <li><a href="<?= $base_url ?>/public/pengertian.php">Pengertian Kista</a></li>
                <li><a href="<?= $base_url ?>/public/kritik.php">Kritik & Saran</a></li>
            </ul>
        </li>

        <!-- muncul ketika login -->
        <?php if(isset($_SESSION['id_user'])): ?>
            <!-- <li><a href="<?= $base_url ?>/user/riwayat.php">Riwayat</a></li> -->
            
            <li style="margin-left: 20px;">
                <a href="#">👤 <?= $_SESSION['nama'] ?? 'User'; ?> ▾</a>
                <ul>
                    <!-- <li><a href="<?= $base_url ?>/user/profil.php">Profil Saya</a></li> -->
                    <li><a href="#" id="logoutBtn" style="color: #ff4d4d;">Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li><a href="<?= $base_url ?>/public/login.php">Login</a></li>
        <?php endif; ?>
    </ul> 
</nav>
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <div style="font-size: 50px; color: #ff4d4d; margin-bottom: 15px;">⚠️</div>
        <h3 style="margin-bottom: 10px; font-size: 20px;">Konfirmasi Logout</h3>
        <p style="color: #ccc; margin-bottom: 25px; font-size: 14px;">Apakah Anda yakin ingin keluar dari sistem <br>Kista Dermoid?</p>
        
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnCancel" style="padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; background: #444; color: white;">Batal</button>
            <a href="<?= $base_url ?>/public/logout.php" style="text-decoration: none; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; background: #ff4d4d; color: white; font-weight: bold;">Ya, Keluar</a>
        </div>
    </div>
</div>

<script>
    // 1. Logika Modal Logout
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutModal = document.getElementById('logoutModal');
    const btnCancel = document.getElementById('btnCancel');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            logoutModal.classList.add('active');
        });
    }

    if (btnCancel) {
        btnCancel.addEventListener('click', function() {
            logoutModal.classList.remove('active');
        });
    }

    // Tutup modal jika klik di luar kotak (overlay)
    window.addEventListener('click', function(e) {
        if (e.target === logoutModal) {
            logoutModal.classList.remove('active');
        }
    });

    // 2. Efek Scroll Navbar (Opsional: Navbar jadi sedikit transparan saat scroll)
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('#menu');
        if (window.scrollY > 50) {
            nav.style.background = 'rgba(26, 26, 26, 0.95)';
            nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.5)';
        } else {
            nav.style.background = '#1a1a1a';
            nav.style.boxShadow = 'none';
        }
    });

    // 3. Penanganan Dropdown untuk Perangkat Mobile (Sentuhan)
    const dropdowns = document.querySelectorAll('#menu ul li');
    dropdowns.forEach(dd => {
        dd.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                const subMenu = this.querySelector('ul');
                if (subMenu) {
                    subMenu.style.display = (subMenu.style.display === 'flex') ? 'none' : 'flex';
                }
            }
        });
    });
</script>
