<?php
session_start();
include "../config/database.php";
$base_url = "/spk-kista-dermoid"; 

// Proteksi halaman: hanya admin yang boleh masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . $base_url . "/public/welcome.php"); 
    exit;
}

$title = "Kritik & Saran User";
include "layout/header.php";

// Mengambil data dari tabel kritik yang terbaru diletakkan di atas
$query = mysqli_query($conn, "SELECT * FROM kritik ORDER BY tanggal DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Kritik & Saran User</h4>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Nama User</th>
                        <th width="20%">Email</th>
                        <th width="30%">Isi Kritik/Saran</th>
                        <!-- <th width="10%" class="text-center">Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($k = mysqli_fetch_assoc($query)): 
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($k['tanggal'])) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($k['nama']) ?></td>
                        <td><?= htmlspecialchars($k['email']) ?></td>
                        <td class="text-muted"><?= nl2br(htmlspecialchars($k['pesan'])) ?></td>
                        <!-- <td class="text-center">
                            <a href="hapus_kritik.php?id=<?= $k['id_kritik'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus kritik ini?')">
                               <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td> -->
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada kritik atau saran yang masuk.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>