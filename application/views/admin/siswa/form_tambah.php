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
    <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top"
        style="z-index: 50;">
        <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
        <a href="<?= base_url('adminsiswa'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </header>

    <div class="p-5 flex-grow-1 d-flex justify-content-center">
        <div class="w-100" style="max-width: 800px;">
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Pendaftaran Siswa Baru</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Lengkapi informasi profil, penempatan kelas, dan
                    buatkan kredensial login untuk siswa.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="<?= base_url('adminsiswa/simpan'); ?>" method="POST" novalidate>
                    <h5 class="fw-bold mb-3" style="font-size: 0.95rem; color: var(--primary-blue);">
                        <i class="bi bi-person-vcard me-2"></i>1. Informasi Profil & Kelas
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold"
                                style="font-size: 0.85rem; color: var(--teks-sekunder);">NOMOR INDUK SISWA
                                (NISN)</label>
                            <input type="text" name="nisn"
                                class="form-control form-control-lg border-light shadow-none bg-light <?= form_error('nisn') ? 'is-invalid' : ''; ?>"
                                placeholder="Masukkan 10 digit NISN" value="<?= set_value('nisn'); ?>" required>
                            <?= form_error('nisn', '<div class="invalid-feedback d-block">', '</div>'); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"
                                style="font-size: 0.85rem; color: var(--teks-sekunder);">NAMA LENGKAP SISWA</label>
                            <input type="text" name="nama_siswa"
                                class="form-control form-control-lg border-light shadow-none bg-light <?= form_error('nama_siswa') ? 'is-invalid' : ''; ?>"
                                placeholder="Contoh: Ahmad Fadillah" value="<?= set_value('nama_siswa'); ?>" required>
                            <?= form_error('nama_siswa', '<div class="invalid-feedback d-block">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold"
                                style="font-size: 0.85rem; color: var(--teks-sekunder);">PENEMPATAN KELAS</label>
                            <select name="kelas_id"
                                class="form-select form-select-lg border-light shadow-none bg-light <?= form_error('kelas_id') ? 'is-invalid' : ''; ?>"
                                required>
                                <option value="" disabled <?= set_select('kelas_id', '', TRUE); ?>>-- Pilih Kelas
                                    Penempatan --</option>
                                <?php if (!empty($kelas)): ?>
                                    <?php foreach ($kelas as $k): ?>
                                        <option value="<?= $k['id']; ?>" <?= set_select('kelas_id', $k['id']); ?>>
                                            <?= htmlspecialchars($k['nama_kelas']); ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Data kelas belum tersedia. Buat data kelas terlebih dahulu.
                                    </option>
                                <?php endif; ?>
                            </select>
                            <?= form_error('kelas_id', '<div class="invalid-feedback d-block">', '</div>'); ?>
                        </div>
                    </div>

                    <hr class="border-light my-4">
                    <h5 class="fw-bold mb-3" style="font-size: 0.95rem; color: var(--primary-blue);">
                        <i class="bi bi-shield-lock me-2"></i>2. Kredensial Akun
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold"
                                style="font-size: 0.85rem; color: var(--teks-sekunder);">USERNAME</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text bg-light border-light text-muted">@</span>
                                <input type="text" name="username"
                                    class="form-control form-control-lg border-light shadow-none bg-light <?= form_error('username') ? 'is-invalid' : ''; ?>"
                                    placeholder="Buat username unik" value="<?= set_value('username'); ?>" required>
                                <?= form_error('username', '<div class="invalid-feedback d-block">', '</div>'); ?>
                            </div>
                            <div class="form-text" style="font-size: 0.75rem;">Disarankan menggunakan NISN atau nama
                                panggilan.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"
                                style="font-size: 0.85rem; color: var(--teks-sekunder);">PASSWORD AWAL</label>
                            <input type="password" name="password"
                                class="form-control form-control-lg border-light shadow-none bg-light <?= form_error('password') ? 'is-invalid' : ''; ?>"
                                placeholder="Masukkan kata sandi awal" required>
                            <?= form_error('password', '<div class="invalid-feedback d-block">', '</div>'); ?>
                            <div class="form-text" style="font-size: 0.75rem;">Siswa nantinya dapat mengubah password
                                ini.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="<?= base_url('adminsiswa'); ?>"
                            class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill"
                            style="background-color: var(--primary-blue);">
                            <i class="bi bi-save me-1"></i> Simpan & Buat Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>