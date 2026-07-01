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
        <a href="<?= base_url('adminkelas'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </header>

    <div class="p-5 flex-grow-1 d-flex justify-content-center">
        <div class="w-100" style="max-width: 600px;">
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Pembuatan Kelas Baru</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Definisikan nama ruang kelas baru beserta penugasan Guru sebagai Wali Kelas.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="<?= base_url('adminkelas/simpan'); ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">NAMA KELAS</label>
                        <input type="text" name="nama_kelas" class="form-control form-control-lg border-light shadow-none bg-light" placeholder="Contoh: X IPA 1, XII IPS 3, dll." required>
                        <div class="form-text" style="font-size: 0.75rem;">Gunakan format nama kelas yang seragam agar pengurutan lebih rapi.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">WALI KELAS <span class="text-muted fw-normal">(Opsional)</span></label>
                        <select name="guru_id" class="form-select form-select-lg border-light shadow-none bg-light">
                            <option value="" selected>-- Tanpa Wali Kelas / Pilih Nanti --</option>
                            <?php if(!empty($guru)): ?>
                                <?php foreach($guru as $g): ?>
                                    <option value="<?= $g['id']; ?>"><?= htmlspecialchars($g['nama_guru']); ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Data guru belum tersedia. Daftarkan guru terlebih dahulu.</option>
                            <?php endif; ?>
                        </select>
                        <div class="form-text" style="font-size: 0.75rem;">Satu guru idealnya hanya memegang satu jabatan Wali Kelas.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="<?= base_url('adminkelas'); ?>" class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill" style="background-color: var(--primary-blue);">
                            <i class="bi bi-save me-1"></i> Daftarkan Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>