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
            <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
            <a href="<?= base_url('guru'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </header>

        <div class="p-5 flex-grow-1 d-flex justify-content-center">
            <div class="w-100" style="max-width: 700px;">

                <div class="mb-4">
                    <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Buat Sesi Baru</h2>
                    <p class="mb-0 text-muted" style="font-size: 0.9rem;">Silakan lengkapi detail kelas, mata pelajaran,
                        dan waktu absensi.</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <form action="<?= base_url('guru/simpan_sesi'); ?>" method="POST">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold"
                                    style="font-size: 0.85rem; color: var(--teks-sekunder);">MATA PELAJARAN</label>
                                <select name="mapel_id"
                                    class="form-select form-select-lg border-light shadow-none bg-light" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    <?php foreach ($mapel as $m): ?>
                                        <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['nama_mapel']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold"
                                    style="font-size: 0.85rem; color: var(--teks-sekunder);">KELAS</label>
                                <select name="kelas_id"
                                    class="form-select form-select-lg border-light shadow-none bg-light" required>
                                    <option value="" disabled selected>-- Pilih Kelas Tujuan --</option>
                                    <?php foreach ($kelas as $k): ?>
                                        <option value="<?= $k['id']; ?>"><?= htmlspecialchars($k['nama_kelas']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold"
                                    style="font-size: 0.85rem; color: var(--teks-sekunder);">TANGGAL SESI</label>
                                <input type="date" name="tanggal_sesi"
                                    class="form-control form-control-lg border-light shadow-none bg-light"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold"
                                    style="font-size: 0.85rem; color: var(--teks-sekunder);">JAM MULAI SESI</label>

                                <input type="time" name="jam_mulai"
                                    class="form-control form-control-lg border-light shadow-none bg-light"
                                    value="<?= date('H:i'); ?>" required>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <div class="d-flex p-3 rounded-3 mb-4 border border-light" style="background-color: #fafafa;">
                            <div class="me-3 mt-1">
                                <i class="bi bi-shield-lock text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <label class="fw-bold mb-1 d-block" for="hotspotCheck"
                                    style="cursor: pointer; color: var(--teks-utama);">Aktifkan Validasi Hotspot Jarak
                                    Dekat</label>
                                <div class="text-muted" style="font-size: 0.8rem;">Jika diaktifkan, siswa hanya bisa
                                    melakukan pemindaian jika terhubung ke jaringan Hotspot/Wi-Fi yang sama dengan
                                    perangkat guru.</div>
                            </div>
                            <div class="ms-3 d-flex align-items-center">
                                <div class="form-check form-switch form-check-reverse">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        name="is_hotspot_validation" value="1" id="hotspotCheck"
                                        style="width: 2.5rem; height: 1.25rem; cursor: pointer;">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <a href="<?= base_url('guru'); ?>"
                                class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal
                            </a>
                            <button onclick="window.location.fref='<?= base_url('/guru/simpan_sesi') ?>'"
                                type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill"
                                style="background-color: var(--primary-blue);">
                                <i class="bi bi-save me-1"></i> Simpan Sesi Absensi
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