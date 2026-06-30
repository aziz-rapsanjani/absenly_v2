<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenly</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href='<?= base_url("assets/css/guru.css"); ?>'>
</head>

<body>

    <main class="main-content">
        <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top"
            style="z-index: 50;">
            <h1 class="h5 fw-bold mb-0"><?php echo $title ?></h1>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-calendar3 me-1" viewBox="0 0 16 16">
                    <path
                        d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z" />
                    <path
                        d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                </svg>
                <?= date('l, d F Y'); ?>
            </span>
        </header>

        <div class="p-5 flex-grow-1">

            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1">Daftar Sesi Absensi</h2>
                    <p class="mb-0 text-muted" style="font-size: 0.9rem;">Kelola dan pantau riwayat sesi absensi yang
                        telah Anda buat.</p>
                </div>
            </div>

            <div style="max-height: 385px;" class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-custom mb-0 table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Mata Pelajaran</th>
                                <th width="12%">Kelas</th>
                                <th width="15%">Waktu Sesi</th>
                                <th width="15%" class="text-center">Validasi Hotspot</th>
                                <th width="15%">Token Sesi</th>
                                <th width="18%" class="text-center">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($daftar_sesi)): ?>
                                <?php $no = 1;
                                foreach ($daftar_sesi as $row): ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $no++; ?></td>
                                        <td class="fw-bold" style="color: var(--teks-utama);">
                                            <?= htmlspecialchars($row['nama_mapel']); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2 py-1">
                                                <?= htmlspecialchars($row['nama_kelas']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-medium"><?= date('d/m/Y', strtotime($row['tanggal_sesi'])); ?></div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Jam:
                                                <?= date('H:i', strtotime($row['jam_mulai'])); ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['is_hotspot_validation'] == 1): ?>
                                                <span class="badge bg-black text-white"><i class="bi bi-shield-check me-1"></i>
                                                    Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border"><i class="bi bi-shield-x me-1"></i>
                                                    Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <code class="text-primary bg-primary bg-opacity-10 px-2 py-1 rounded"
                                                style="font-size: 0.75rem;">
                                                <?= htmlspecialchars(substr($row['qr_token_aktif'], 0, 8)); ?>...
                                            </code>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= base_url('panelcontrol/detail/' . $row['id']); ?>"
                                                    class="btn btn-sm btn-outline-dark rounded-pill px-1"
                                                    style="font-size: 0.75rem; font-weight: 600;">
                                                    Lihat Panel <i class="bi bi-arrow-right-short"></i>
                                                </a>

                                                <a href="<?= base_url('guru/tampilkan_qr/' . $row['id']); ?>" target="_blank"
                                                    class="btn btn-sm btn-primary rounded-pill px-3"
                                                    style="font-size: 0.75rem; font-weight: 600; background-color: var(--primary-blue);">
                                                    <i class="bi bi-qr-code me-1"></i> QR
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted mb-2" style="font-size: 2rem;"><i class="bi bi-inboxes"></i>
                                        </div>
                                        <div class="fw-medium" style="color: var(--teks-utama);">Belum Ada Sesi Absensi
                                        </div>
                                        <div class="text-muted small">Anda belum membuat sesi absensi satupun.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="button" onclick="window.location.href='<?= base_url('/guru/tambah_sesi'); ?>';"
                class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-flex align-items-center gap-2"
                style="background-color: var(--primary-blue);">
                <i class="bi bi-plus-circle-fill"></i> Tambah Sesi Absensi Baru
            </button>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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