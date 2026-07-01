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
</body>
<main class="main-content">

    <header class="bg-white border-bottom px-5 py-3 d-flex justify-content-between align-items-center sticky-top" style="z-index: 50;">
        <h1 class="h5 fw-bold mb-0"><?= $title; ?></h1>
        <a href="<?= base_url('adminmapel'); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </header>

    <div class="p-5 flex-grow-1 d-flex justify-content-center">
        <div class="w-100" style="max-width: 600px;">
            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Tambah Mata Pelajaran</h2>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Masukkan nama mata pelajaran baru ke dalam sistem.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="<?= base_url('adminmapel/simpan'); ?>" method="POST">

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size: 0.85rem; color: var(--teks-sekunder);">NAMA MATA PELAJARAN</label>
                        <input type="text" name="nama_mapel" class="form-control form-control-lg border-light shadow-none bg-light" placeholder="Contoh: Matematika, Bahasa Indonesia" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('adminmapel'); ?>" class="btn btn-light px-4 py-2 fw-medium rounded-pill">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill" style="background-color: var(--primary-blue);">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
</body>

</html>