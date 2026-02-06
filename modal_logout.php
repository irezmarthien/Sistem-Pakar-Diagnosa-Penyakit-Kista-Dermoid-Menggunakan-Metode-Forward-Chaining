<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel fw-bold">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Keluar
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <h5 class="mb-3">Apakah Anda yakin ingin keluar?</h5>
        <p class="text-muted">Sesi Anda akan berakhir dan Anda harus login kembali untuk mengakses panel admin.</p>
      </div>
      <div class="modal-footer bg-light d-flex justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
        <a href="<?= $base_url ?>/public/logout.php" class="btn btn-danger px-4 shadow-sm">Ya, Keluar</a>
      </div>
    </div>
  </div>
</div>