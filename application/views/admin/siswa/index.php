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
        <a href="<?= base_url('adminsiswa/tambah'); ?>" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" style="background-color: var(--primary-blue);">
            <i class="bi bi-plus-lg me-1"></i> Tambah Siswa Baru
        </a>
    </header>

    <div class="p-5 flex-grow-1">
        <div class="mb-4">
            <h2 class="h4 fw-bold mb-1" style="color: var(--teks-utama);">Daftar Siswa Terdaftar</h2>
            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Kelola data profil siswa, penempatan kelas, dan kredensial login mereka.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-pill mb-4 p-2 px-4 bg-white" style="max-width: 600px;">
            <form action="<?= base_url('adminsiswa'); ?>" method="GET" class="d-flex align-items-center gap-3 m-0">
                <label for="filter_kelas" class="fw-bold text-muted small mb-0 text-nowrap">
                    <i class="bi bi-funnel-fill text-primary me-1"></i> Filter Kelas:
                </label>
                
                <select name="kelas_id" id="filter_kelas" class="form-select form-select-sm border-light bg-light rounded-pill px-3 fw-medium" onchange="this.form.submit()">
                    <option value="">Tampilkan Semua Siswa</option>
                    <?php if(!empty($kelas)): ?>
                        <?php foreach($kelas as $k): ?>
                            <option value="<?= $k['id']; ?>" <?= ($kelas_id_aktif == $k['id']) ? 'selected' : ''; ?>>
                                Kelas <?= htmlspecialchars($k['nama_kelas']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table mb-0 table-hover align-middle">
                    <thead style="background-color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: #64748B;">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th class="px-4 py-3" width="15%">NISN</th>
                            <th class="px-4 py-3" width="25%">Nama Siswa</th>
                            <th class="px-4 py-3" width="15%">Kelas</th>
                            <th class="px-4 py-3" width="20%">Username</th>
                            <th class="px-4 py-3 text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($siswa)): ?>
                            <?php $no=1; foreach($siswa as $s): ?>
                            <tr>
                                <td class="px-4 py-3 text-muted"><?= $no++; ?></td>
                                <td class="px-4 py-3 fw-medium font-monospace text-secondary"><?= htmlspecialchars($s['nisn']); ?></td>
                                <td class="px-4 py-3 fw-bold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px;">
                                            <?= substr($s['nama_siswa'], 0, 1); ?>
                                        </div>
                                        <?= htmlspecialchars($s['nama_siswa']); ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="bi bi-door-open me-1 text-muted"></i> 
                                        <?= $s['nama_kelas'] ? htmlspecialchars($s['nama_kelas']) : '<span class="text-danger">Belum Ada Kelas</span>'; ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3"><span class="text-muted small">@<?= htmlspecialchars($s['username']); ?></span></td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?= base_url('adminsiswa/edit/'.$s['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="konfirmasiHapus('<?= base_url('adminsiswa/hapus/'.$s['id'].'/'.$s['user_id']); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-mortarboard fs-2 d-block mb-2 text-light"></i>
                                    Belum ada data siswa terdaftar.
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
            title: 'Hapus Data Siswa?',
            text: "Data profil beserta akun loginnya akan terhapus permanen!",
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