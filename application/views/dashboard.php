<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href='<?= base_url("assets/css/admin.css"); ?>'>
</head>
<body>

    <main class="main-content">
        <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 50;">
            <h1 class="h5 fw-bold mb-0 text-capitalize"><?= htmlspecialchars($title); ?></h1>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-medium text-muted">
                <i class="bi bi-calendar3 me-1"></i> <?= date('l, d F Y'); ?>
            </span>
        </header>

        <div class="p-5 flex-grow-1">
            
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1">Ringkasan Sistem</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Statistik terkini data master dan operasional hari ini.</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1"><?= number_format($total_guru); ?></h3>
                        <span class="text-muted small fw-medium text-uppercase letter-spacing-1">Total Guru</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1"><?= number_format($total_siswa); ?></h3>
                        <span class="text-muted small fw-medium text-uppercase letter-spacing-1">Total Siswa</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-door-open"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1"><?= number_format($total_kelas); ?></h3>
                        <span class="text-muted small fw-medium text-uppercase letter-spacing-1">Total Kelas</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card shadow-sm p-4 h-100" style="background: linear-gradient(135deg, #0F172A, #1E293B); color: white;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="stat-icon bg-white bg-opacity-25 text-white">
                                <i class="bi bi-activity"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1"><?= number_format($sesi_today); ?></h3>
                        <span class="text-white-50 small fw-medium text-uppercase letter-spacing-1">Sesi Aktif Hari Ini</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 fs-6">Aktivitas Kelas Hari Ini</h5>
                    <a href="<?= base_url('admin/rekapitulasi'); ?>" class="btn btn-sm btn-light rounded-pill fw-medium text-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 table-hover align-middle">
                        <thead style="background-color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--teks-sekunder);">
                            <tr>
                                <th class="px-4 py-3">Guru / Pengajar</th>
                                <th class="px-4 py-3">Mata Pelajaran</th>
                                <th class="px-4 py-3">Kelas</th>
                                <th class="px-4 py-3 text-center">Waktu Mulai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($sesi_aktif)): ?>
                                <?php foreach($sesi_aktif as $row): ?>
                                <tr>
                                    <td class="px-4 py-3 fw-medium">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center fw-bold border" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                <?= substr($row['nama_guru'], 0, 1); ?>
                                            </div>
                                            <?= htmlspecialchars($row['nama_guru']); ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-dark"><?= htmlspecialchars($row['nama_mapel']); ?></td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark border px-2 py-1"><?= htmlspecialchars($row['nama_kelas']); ?></span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-muted">
                                        <i class="bi bi-clock me-1"></i> <?= date('H:i', strtotime($row['jam_mulai'])); ?> WIB
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inboxes fs-3 d-block mb-2"></i>
                                        Belum ada sesi absensi yang dibuat oleh guru hari ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php $swal = $this->session->flashdata('swal'); ?>
        <?php if ($swal): ?>
            Swal.fire({
                icon: '<?= $swal['icon']; ?>',
                title: '<?= $swal['title']; ?>',
                text: '<?= $swal['text']; ?>',
                confirmButtonColor: '#2196f3'
            });
        <?php endif; ?>
    </script>
</body>
</html>