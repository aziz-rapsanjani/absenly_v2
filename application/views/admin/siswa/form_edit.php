<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href='<?= base_url("assets/css/admin.css"); ?>'>
</head>
</body>

<main class="main-content">
    <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 50;">
        <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
        <a href="<?= base_url('adminsiswa'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </header>

    <div class="p-5 flex-grow-1 d-flex justify-content-center">
        <div class="w-100" style="max-width: 800px;">
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Perbarui Informasi Siswa</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Ubah data profil, mutasi kelas, atau perbarui kredensial akun login siswa.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="<?= base_url('adminsiswa/update'); ?>" method="POST">
                    <input type="hidden" name="siswa_id" value="<?= $siswa['id']; ?>">
                    <input type="hidden" name="user_id" value="<?= $siswa['user_id']; ?>">
                    
                    <h5 class="fw-bold mb-3" style="font-size: 0.95rem; color: var(--primary-blue);">
                        <i class="bi bi-person-vcard me-2"></i>1. Informasi Profil & Kelas
                    </h5>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">NOMOR INDUK SISWA (NISN)</label>
                            <input type="text" name="nisn" class="form-control form-control-lg border-light shadow-none bg-light" value="<?= htmlspecialchars($siswa['nisn']); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">NAMA LENGKAP SISWA</label>
                            <input type="text" name="nama_siswa" class="form-control form-control-lg border-light shadow-none bg-light" value="<?= htmlspecialchars($siswa['nama_siswa']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">PENEMPATAN KELAS</label>
                            <select name="kelas_id" class="form-select form-select-lg border-light shadow-none bg-light" required>
                                <option value="" disabled>-- Pilih Kelas Penempatan --</option>
                                <?php if(!empty($kelas)): ?>
                                    <?php foreach($kelas as $k): ?>
                                        <option value="<?= $k['id']; ?>" <?= ($siswa['kelas_id'] == $k['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($k['nama_kelas']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <hr class="border-light my-4">
                    <h5 class="fw-bold mb-3" style="font-size: 0.95rem; color: var(--primary-blue);">
                        <i class="bi bi-shield-lock me-2"></i>2. Kredensial Akun
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-light text-muted">@</span>
                                <input type="text" name="username" class="form-control form-control-lg border-light shadow-none bg-light" value="<?= htmlspecialchars($siswa['username']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">GANTI PASSWORD <span class="text-danger fw-normal">(Opsional)</span></label>
                            <input type="password" name="password" class="form-control form-control-lg border-light shadow-none bg-light" placeholder="Kosongkan jika tidak diubah">
                            <div class="form-text" style="font-size: 0.75rem;">
                                <i class="bi bi-exclamation-circle"></i> Isi hanya jika ingin mereset password siswa.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="<?= base_url('adminsiswa'); ?>" class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill" style="background-color: var(--primary-blue);">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>