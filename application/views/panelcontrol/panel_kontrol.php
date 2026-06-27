<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenly</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href='<?= base_url("assets/css/panelcontrol.css"); ?>'>
</head>

</body>
<main class="main-content">
    <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 50;">
        <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
        <a href="<?= base_url('guru'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </header>

    <div class="p-5 flex-grow-1">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 d-flex flex-row justify-content-between align-items-center"
        style="background: linear-gradient(135deg, #0F172A, #1e293b); color: white;">
            <div>
                <span class="badge bg-primary px-2 py-1 rounded mb-2 text-uppercase"
                style="font-size: 0.65rem; letter-spacing: 1px;">Live Panel</span>

                <h2 class="h4 fw-bold mb-1"><?= htmlspecialchars($sesi['nama_mapel']); ?></h2>
                <p class="mb-0 text-light opacity-75" style="font-size: 0.9rem;">
                    Kelas: <strong><?= htmlspecialchars($sesi['nama_kelas']); ?></strong> &nbsp;|&nbsp; 
                    Tanggal: <?= date('d M Y', strtotime($sesi['tanggal_sesi'])); ?> &nbsp;|&nbsp; 
                    Jam Buka: <?= date('H:i', strtotime($sesi['jam_mulai'])); ?> WIB
                </p>
            </div>

            <div>
                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold shadow-sm"onclick="window.location.reload();">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
            <div class="table-responsive">
                <table class="table table-custom mb-0 table-hover align-middle">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th width="5%" class="text-center text-muted fw-semibold" style="font-size: 0.75rem;">NO</th>
                            <th width="15%" class="text-muted fw-semibold" style="font-size: 0.75rem;">NISN</th>
                            <th width="25%" class="text-muted fw-semibold" style="font-size: 0.75rem;">NAMA SISWA</th>
                            <th width="10%" class="text-muted fw-semibold text-center" style="font-size: 0.75rem;">KLS</th>
                            <th width="15%" class="text-muted fw-semibold text-center" style="font-size: 0.75rem;">STATUS</th>
                            <th width="20%" class="text-muted fw-semibold" style="font-size: 0.75rem;">KETERANGAN</th>
                            <th width="10%" class="text-muted fw-semibold text-center" style="font-size: 0.75rem;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($presensi)): ?>
                            <?php $no = 1; foreach ($presensi as $row): ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no++; ?></td>
                                <td><code class="text-dark h6 px-2 py-1"><?= htmlspecialchars($row['nisn']); ?></code></td>
                                <td class="fw-bold" style="color: var(--teks-utama);"><?= htmlspecialchars($row['nama_siswa']); ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['nama_kelas']); ?></td>
                                
                                <td class="text-center">
                                    <?php 
                                        $status_aktif = $row['status'] ? $row['status'] : 'Belum Absen';
                                        $badge_class = 'bg-light text-muted border';
                                        if ($status_aktif == 'Hadir') $badge_class = 'bg-success text-white';
                                        if ($status_aktif == 'Terlambat') $badge_class = 'bg-warning text-dark';
                                        if ($status_aktif == 'Sakit' || $status_aktif == 'Izin') $badge_class = 'bg-info text-dark';
                                        if ($status_aktif == 'Alpa') $badge_class = 'bg-danger text-white';
                                    ?>
                                    <span class="badge <?= $badge_class; ?> rounded-pill px-3 py-2 fw-medium" style="font-size: 0.8rem;">
                                        <?= $status_aktif; ?>
                                    </span>
                                </td>
                                
                                <td class="text-muted" style="font-size: 0.85rem;">
                                    <?php if($row['status']): ?>
                                        <?= htmlspecialchars($row['keterangan'] ? $row['keterangan'] : '-'); ?>
                                        <br><small class="opacity-50">Jam: <?= date('H:i:s', strtotime($row['waktu_scan'])); ?></small>
                                    <?php else: ?>
                                        <span class="text-black-50" style="font-style: italic;">Menunggu pemindaian...</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center">
                                    <a href="<?= base_url('panelcontrol/edit_presensi/' . $row['siswa_id'] . '/' . $sesi['id']); ?>" 
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                        style="font-size: 0.75rem; font-weight: 600;">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-2" style="font-size: 2rem;"><i class="bi bi-people"></i></div>
                                    <div class="fw-medium" style="color: var(--teks-utama);">Tidak Ada Data Siswa</div>
                                    <div class="text-muted small">Tidak ditemukan data siswa aktif terdaftar di dalam kelas ini.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

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