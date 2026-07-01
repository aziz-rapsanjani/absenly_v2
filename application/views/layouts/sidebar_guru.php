<aside class="sidebar d-flex flex-column p-4">
    <div class="mb-5 d-flex align-items-center gap-2">
        <div class="bg-primary text-white rounded p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <i class="bi bi-qr-code-scan fw-bold"></i>
        </div>
        <h4 class="fw-bold mb-0" style="color: var(--teks-utama); letter-spacing: -0.5px;">Absenly</h4>
    </div>

    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3 border" style="background-color: #fafafa;">
        <div class="rounded-circle bg-black text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 1.2rem;">
            <?= substr($guru['nama_guru'], 0, 1); ?>
        </div>
        <div class="overflow-hidden">
            <div class="fw-bold text-truncate" style="font-size: 0.9rem;"><?= htmlspecialchars($guru['nama_guru']); ?></div>
            <div class="text-muted" style="font-size: 0.75rem;">NIP. <?= htmlspecialchars($guru['nip']); ?></div>
        </div>
    </div>

    <div class="text-uppercase fw-bold mb-3" style="font-size: 0.7rem; color: var(--teks-sekunder); letter-spacing: 1px;">Menu Utama</div>

    <nav class="nav flex-column mb-auto">
        <a href="<?= base_url('guru'); ?>" class="nav-link text-decoration-none nav-link-custom <?= ($this->uri->segment(1) == 'guru' && $this->uri->segment(2) == '') || $this->uri->segment(2) == 'tambah_sesi' ? 'active' : ''; ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="<?= base_url("panelcontrol/detail/{$this->session->userdata('id_sesi_terbaru')}"); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'panelcontrol' ? 'active' : ''; ?>">
            <i class="bi bi-sliders"></i> Panel Kontrol
        </a>
        <a href="<?= base_url('gururekap'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'gururekap' ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-bar-graph"></i> Rekap Kehadiran
        </a>
    </nav>

    <div class="mt-auto pt-4 border-top">
        <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-decoration-none nav-link-custom text-danger">
            <i class="bi bi-box-arrow-left"></i> Keluar
        </a>
    </div>
</aside>