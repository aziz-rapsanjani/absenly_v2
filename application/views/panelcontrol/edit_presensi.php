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
        <a href="<?= base_url('/panelcontrol/detail/' . $sesi_id); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Panel
        </a>
    </header>

    <div class="p-5 flex-grow-1 d-flex justify-content-center">
        <div class="w-100" style="max-width: 650px;">
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Penyesuaian Status Siswa</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Perbarui status kehadiran dan keterangan siswa jika diperlukan.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="<?= base_url('panelcontrol/update_presensi'); ?>" method="POST">
                    <input type="hidden" name="presensi_id" value="<?= $detail['presensi_id']; ?>">
                    <input type="hidden" name="siswa_id" value="<?= $detail['siswa_id']; ?>">
                    <input type="hidden" name="sesi_id" value="<?= $sesi_id; ?>">
                    <input type="hidden" name="kelas_id" value="<?= $detail['kelas_id']; ?>">

                    <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.75rem; color: var(--primary-blue); letter-spacing: 1px;">Informasi Siswa</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">NISN</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($detail['nisn']); ?>" readonly disabled>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">NAMA LENGKAP SISWA</label>
                            <input type="text" class="form-control bg-light fw-bold" value="<?= htmlspecialchars($detail['nama_siswa']); ?>"
                            readonly disabled style="color: var(--teks-utama);">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">KELAS</label>
                        <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($detail['nama_kelas']); ?>" readonly disabled>
                    </div>

                    <hr class="border-light my-4">
                    <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.75rem; color: var(--primary-blue); letter-spacing: 1px;">Penetapan Kehadiran</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">STATUS ABSENSI</label>
                        <select class="form-select form-select-lg border-secondary shadow-none" name="status" required>
                            <option value="" <?= (!$detail['status']) ? 'selected' : ''; ?> disabled>-- Pilih Status Kehadiran --</option>
                            <option value="Hadir" <?= ($detail['status'] == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                            <option value="Terlambat" <?= ($detail['status'] == 'Terlambat') ? 'selected' : ''; ?>>Terlambat</option>
                            <option value="Sakit" <?= ($detail['status'] == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                            <option value="Izin" <?= ($detail['status'] == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                            <option value="Alpa" <?= ($detail['status'] == 'Alpa') ? 'selected' : ''; ?>>Alpa (Tanpa Keterangan)</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-semibold text-muted" style="font-size: 0.85rem;">KETERANGAN TAMBAHAN</label>
                        <textarea class="form-control border-secondary shadow-none" name="keterangan" rows="3"
                        placeholder="Tuliskan alasan spesifik (Opsional, misal: Surat sakit dari klinik dsb)">
                        <?= htmlspecialchars($detail['keterangan']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="<?= base_url('panelcontrol/detail/' . $sesi_id); ?>"
                        class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal</a>

                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill shadow-sm"
                        style="background-color: var(--primary-blue);">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Status
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>