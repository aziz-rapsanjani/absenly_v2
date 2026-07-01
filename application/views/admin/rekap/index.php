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
        <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
    </header>

    <div class="p-5 flex-grow-1">
        
        <div class="mb-4">
            <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Pantauan Kehadiran Berkala</h2>
            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Kelola pantauan absensi berdasarkan skema harian, 
                akumulasi mingguan, atau laporan bulanan.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white">
            <form action="<?= base_url('adminrekap'); ?>" method="GET" class="row g-3 align-items-end">
                
                <div class="col-md-3">
                    <label class="form-label fw-bold text-muted small mb-1">Rentang Rekap</label>
                    <select name="type" class="form-select border-light bg-light fw-medium" onchange="this.form.submit()">
                        <option value="harian" <?= ($type_aktif == 'harian') ? 'selected' : ''; ?>>Harian (Detail Status)</option>
                        <option value="mingguan" <?= ($type_aktif == 'mingguan') ? 'selected' : ''; ?>>Mingguan (Total)</option>
                        <option value="bulanan" <?= ($type_aktif == 'bulanan') ? 'selected' : ''; ?>>Bulanan (Total)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold text-muted small mb-1">Pilih Kelas</label>
                    <select name="kelas_id" class="form-select border-light bg-light" onchange="this.form.submit()" required>
                        <option value="" disabled <?= empty($kelas_id_aktif) ? 'selected' : ''; ?>>-- Tentukan Kelas --</option>
                        <?php if(!empty($kelas)): ?>
                            <?php foreach($kelas as $k): ?>
                                <option value="<?= $k['id']; ?>" <?= ($kelas_id_aktif == $k['id']) ? 'selected' : ''; ?>>
                                    Kelas <?= htmlspecialchars($k['nama_kelas']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <?php if ($type_aktif == 'bulanan'): ?>
                        <label class="form-label fw-bold text-muted small mb-1">Pilih Bulan</label>
                        <input type="month" name="bulan" class="form-control border-light bg-light" 
                        value="<?= $bulan_aktif; ?>" onchange="this.form.submit()" required>

                    <?php elseif ($type_aktif == 'mingguan'): ?>
                        <label class="form-label fw-bold text-muted small mb-1">Pilih Hari di Minggu Terkait</label>
                        <input type="date" name="tanggal" class="form-control border-light bg-light" 
                        value="<?= $tanggal_aktif; ?>" required>

                    <?php else: ?>
                        <label class="form-label fw-bold text-muted small mb-1">Tanggal Absensi</label>
                        <input type="date" name="tanggal" class="form-control border-light bg-light" 
                        value="<?= $tanggal_aktif; ?>" required>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 fw-medium shadow-sm" 
                    style="background-color: var(--primary-blue);">
                        <i class="bi bi-filter me-1"></i> Terapkan Filter
                    </button>
                </div>

            </form>
        </div>
        <?php if($type_aktif === 'bulanan' && !empty($kelas_id_aktif) && !empty($rekap)): ?>
            <div class="mb-3 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-medium d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                </button>
                <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-medium d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
                </button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0 table-hover align-middle">
                    
                    <?php if($type_aktif === 'harian'): ?>
                        <thead style="background-color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: #64748B;">
                            <tr>
                                <th class="px-4 py-3" width="5%">No</th>
                                <th class="px-4 py-3" width="15%">NISN</th>
                                <th class="px-4 py-3" width="35%">Nama Siswa</th>
                                <th class="px-4 py-3 text-center" width="15%">Status</th>
                                <th class="px-4 py-3" width="15%">Waktu Absen</th>
                                <th class="px-4 py-3" width="15%">Keterangan</th>
                            </tr>
                        </thead>
                    <?php else: ?>
                        <thead style="background-color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: #64748B;">
                            <tr>
                                <th class="px-4 py-3" width="5%">No</th>
                                <th class="px-4 py-3" width="15%">NISN</th>
                                <th class="px-4 py-3" width="40%">Nama Siswa</th>
                                <th class="px-4 py-3 text-center" width="10%">Hadir</th>
                                <th class="px-4 py-3 text-center" width="10%">Izin</th>
                                <th class="px-4 py-3 text-center" width="10%">Sakit</th>
                                <th class="px-4 py-3 text-center" width="10%">Alpa</th>
                            </tr>
                        </thead>
                    <?php endif; ?>

                    <tbody>
                        <?php if(empty($kelas_id_aktif)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-funnel fs-2 d-block mb-2 text-light"></i>
                                    Silakan tentukan parameter filter di atas untuk memuat laporan data.
                                </td>
                            </tr>
                        <?php elseif(!empty($rekap)): ?>
                            <?php $no=1; foreach($rekap as $r): ?>
                            <tr>
                                <td class="px-4 py-3 text-muted"><?= $no++; ?></td>
                                <td class="px-4 py-3 fw-medium font-monospace text-secondary"><?= htmlspecialchars($r['nisn']); ?></td>
                                <td class="px-4 py-3 fw-bold text-dark"><?= htmlspecialchars($r['nama_siswa']); ?></td>
                                
                                <?php if($type_aktif === 'harian'): ?>
                                    <td class="px-4 py-3 text-center">
                                        <?php 
                                            $status = strtoupper($r['status'] ?? '');
                                            if ($status == 'HADIR') echo '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 w-100">HADIR</span>';
                                            elseif ($status == 'TERLAMBAT') echo '<span class="badge bg-dark bg-opacity-75 text-white border px-3 py-2 w-100">TERLAMBAT</span>';
                                            elseif ($status == 'IZIN') echo '<span class="badge bg-dark bg-opacity-75 text-white border px-3 py-2 w-100">IZIN</span>';
                                            elseif ($status == 'SAKIT') echo '<span class="badge bg-dark bg-opacity-75 text-white border px-3 py-2 w-100">SAKIT</span>';
                                            elseif ($status == 'ALPA') echo '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 w-100">ALPA</span>';
                                            else echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-2 w-100">BELUM ABSEN</span>';
                                        ?>
                                    </td>
                                    <td class="px-4 py-3 text-muted small">
                                        <?= !empty($r['waktu_scan']) ? '<i class="bi bi-clock me-1"></i> '.date('H:i', strtotime($r['waktu_scan'])).' WIB' : '-'; ?>
                                    </td>
                                    <td class="px-4 py-3 text-muted small">
                                        <?= !empty($r['keterangan']) ? htmlspecialchars($r['keterangan']) : '-'; ?>
                                    </td>
                                <?php else: ?>
                                    <td class="px-4 py-3 text-center fw-bold <?= ($r['total_hadir'] > 0) ? 'text-black' : 'text-muted'; ?>"><?= $r['total_hadir']; ?> x</td>
                                    <td class="px-4 py-3 text-center fw-bold <?= ($r['total_izin'] > 0) ? 'text-black' : 'text-muted'; ?>"><?= $r['total_izin']; ?> x</td>
                                    <td class="px-4 py-3 text-center fw-bold <?= ($r['total_sakit'] > 0) ? 'text-black' : 'text-muted'; ?>"><?= $r['total_sakit']; ?> x</td>
                                    <td class="px-4 py-3 text-center fw-bold <?= ($r['total_alpa'] > 4) ? 'text-danger fw-extrabold' : 'text-muted'; ?>"><?= $r['total_alpa']; ?> x</td>
                                <?php endif; ?>

                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-2 d-block mb-2 text-light"></i>
                                    Tidak ada data siswa ditemukan di kelas ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
</html>