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
        <a href="<?= base_url('adminkelas/tambah'); ?>" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" style="background-color: var(--primary-blue);">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kelas Baru
        </a>
    </header>

    <div class="p-5 flex-grow-1">
        <div class="mb-4">
            <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Daftar Kelas</h2>
            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Kelola seluruh data ruang kelas beserta pembagian Wali Kelas masing-masing.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0 table-hover align-middle">
                    <thead style="background-color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: #64748B;">
                        <tr>
                            <th class="px-4 py-3" width="10%">No</th>
                            <th class="px-4 py-3" width="40%">Nama Kelas</th>
                            <th class="px-4 py-3" width="30%">Wali Kelas</th>
                            <th class="px-4 py-3 text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($kelas)): ?>
                            <?php $no=1; foreach($kelas as $k): ?>
                            <tr>
                                <td class="px-4 py-3 text-muted"><?= $no++; ?></td>
                                <td class="px-4 py-3 fw-bold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center fw-bold" style="width: 40px; height: 35px;">
                                            <i class="bi bi-door-open-fill"></i>
                                        </div>
                                        <?= htmlspecialchars($k['nama_kelas']); ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if(!empty($k['nama_wali'])): ?>
                                        <span class="fw-medium text-secondary">
                                            <i class="bi bi-person-badge me-1 text-muted"></i> <?= htmlspecialchars($k['nama_wali']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-danger border px-2 py-1">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Belum Ada Wali Kelas
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?= base_url('adminkelas/edit/'.$k['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="konfirmasiHapus('<?= base_url('adminkelas/hapus/'.$k['id']); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-door-closed fs-2 d-block mb-2 text-light"></i>
                                    Belum ada data kelas yang dibuat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapus(url) {
        Swal.fire({
            title: 'Hapus Data Kelas?',
            text: "Siswa yang berada di kelas ini akan kehilangan asosiasi kelas mereka!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#0F172A',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

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