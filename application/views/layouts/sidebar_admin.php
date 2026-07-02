<aside class="sidebar d-flex flex-column p-4">
        <div class="mb-4 d-flex align-items-center gap-2">
            <div class="bg-primary text-white rounded p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-qr-code-scan fw-bold"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: var(--teks-utama); letter-spacing: -0.5px;">Absenly</h4>
        </div>

        <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded-3 border" style="background-color: #fafafa;">
            <div class="rounded-circle bg-black text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="overflow-hidden">
                <div class="fw-bold text-truncate" style="font-size: 0.9rem;"><?= htmlspecialchars($admin['username']); ?></div>
                <div class="badge bg-dark mt-1" style="font-size: 0.65rem;"><?= htmlspecialchars($admin['role']); ?></div>
            </div>
        </div>

        <nav class="nav flex-column mb-auto">
            
            <div class="menu-label">Overview</div>
            <a href="<?= base_url('admin'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'admin' ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="menu-label">Data Master</div>
            <a href="<?= base_url('adminguru'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'adminguru' ? 'active' : ''; ?>">
                <i class="bi bi-person-workspace"></i> Data Guru
            </a>
            <a href="<?= base_url('adminsiswa'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'adminsiswa' ? 'active' : ''; ?>">
                <i class="bi bi-people"></i> Data Siswa
            </a>
            <a href="<?= base_url('adminkelas'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'adminkelas' ? 'active' : ''; ?>">
                <i class="bi bi-door-open"></i> Data Kelas
            </a>
            <a href="<?= base_url('adminmapel'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'adminmapel' ? 'active' : ''; ?>">
                <i class="bi bi-journal-bookmark"></i> Data Mapel
            </a>

            <div class="menu-label">Laporan & Audit</div>
            <a href="<?= base_url('adminrekap'); ?>" class="nav-link text-decoration-none nav-link-custom <?= $this->uri->segment(1) == 'adminrekap' ? 'active' : ''; ?>">
                <i class="bi bi-file-earmark-bar-graph"></i> Rekap Kehadiran
            </a>
        </nav>
        
        <div class="mt-4 pt-3 border-top">
            <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-decoration-none nav-link-custom text-danger">
                <i class="bi bi-box-arrow-left"></i> Keluar Sistem
            </a>
        </div>
    </aside>