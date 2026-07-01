<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Absenly</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href='<?= base_url("assets/css/siswa.css"); ?>'>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 p-0 m-0">

    <svg style="display: none" xmlns="http://www.w3.org/2000/svg">
        <filter id="glass-blur" x="-20%" y="-20%" width="140%" height="140%" filterUnits="objectBoundingBox">
            <feTurbulence type="fractalNoise" baseFrequency="0.01 0.02" numOctaves="2" result="turbulence" />
            <feDisplacementMap in="SourceGraphic" in2="turbulence" scale="300" xChannelSelector="R"
                yChannelSelector="G" />
        </filter>
    </svg>

    <div id="canvas" class="w-100 d-flex flex-column shadow-sm position-relative min-vh-100" style="max-width: 480px;">
        <header style="background-color: #0285c70c;"
            class="d-flex justify-content-between align-items-center px-4 py-3">
            <h1 class="h4 fw-bold mb-0" style="color: white; letter-spacing: -0.5px;">Absenly</h1>
            <div class="badge bg-black text-white px-3 py-2 rounded-pill fw-medium text-truncate"
                style="max-width: 200px; font-size: 0.75rem;">
                <?= htmlspecialchars($siswa['nama_siswa']); ?>
            </div>
        </header>

        <main class="flex-grow-1 px-4 py-4 d-flex flex-column align-items-center justify-content-start">
            <?php if ($sesi): ?>
                <div id="card-mapel"
                    class="w-100 p-3 rounded-4 glass-card-mapel mb-4 d-flex justify-content-between align-items-center">
                    <div class="liquid-glass--bend"></div>
                    <div class="liquid-glass--face"></div>
                    <div class="liquid-glass--edge"></div>

                    <div class="liquid-glass__content">
                        <h2 class="h5 fw-bold mb-1 text-white" id="sesi-mapel"
                            style="text-shadow: 0 1px 4px rgba(0,0,0,0.2);">
                            <?= htmlspecialchars($sesi['nama_mapel']); ?>
                        </h2>
                        <p class="small mb-0 text-white" id="sesi-detail"
                            style="opacity: 0.85; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                            Kelas <?= htmlspecialchars($sesi['nama_kelas']); ?> &nbsp;·&nbsp;
                            <?= date('H:i', strtotime($sesi['jam_mulai'])); ?> WIB
                        </p>
                    </div>

                    <span
                        class="badge bg-danger rounded-pill fw-bold text-uppercase px-3 py-2 animate-pulse liquid-glass__badge"
                        style="font-size: 0.65rem; letter-spacing: 0.5px;">Live</span>
                </div>

                <div class="scanner-wrap my-3 position-relative">
                    <div class="w-100 h-100 rounded-4 overflow-hidden shadow-md bg-dark position-relative">
                        <div id="qr-reader"></div>
                    </div>
                </div>

                <p class="small text-center px-3 mt-3" id="hint-text" style="color: #ffffff; line-height: 1.6;">
                    Arahkan kamera belakang perangkat Anda tepat ke arah <strong>QR Code</strong> yang ditampilkan oleh guru
                    di monitor depan kelas.
                </p>

            <?php else: ?>
                <div
                    class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center my-auto py-5 w-100">
                    <div class="p-4 rounded-4 w-100 text-white"
                        style="background: rgba(255, 255, 255, 0.07); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div class="mb-3" style="font-size: 2.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor"
                                class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-2">Belum Ada Sesi Aktif</h5>
                        <p class="small mb-0 opacity-75" style="line-height: 1.6;">
                            Guru mata pelajaran belum mengaktifkan sesi absensi untuk kelas
                            <strong><?= htmlspecialchars($siswa['nama_kelas']); ?></strong> saat ini.
                        </p>
                        <button onclick="window.location.reload();"
                            class="btn btn-light btn-sm rounded-pill px-4 mt-4 fw-semibold text-dark"
                            style="font-size: 0.8rem; shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            Refresh
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <footer class="py-3 text-center border-top border-light"
            style="font-size: 0.75rem; background: #F8F9FA; color: #64748B;">
            &copy; <?= date('Y'); ?> Absenly &mdash; Sistem Presensi Digital
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let html5Qr;
        <?php if ($sesi): ?>
            function startScanner() {
                html5Qr = new Html5Qrcode('qr-reader');
                html5Qr.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 220, height: 220 } },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    console.error("Gagal inisialisasi kamera: ", err);
                    document.getElementById('hint-text').innerHTML =
                        `<span class="text-danger fw-bold">Gagal Mengakses Kamera!</span><br>Pastikan izin penggunaan kamera telah diizinkan pada pengaturan browser Anda.`;
                });
            }

            function onScanSuccess(decodedText) {
                if (html5Qr) {
                    html5Qr.stop().then(() => {
                        let formData = new FormData();
                        formData.append('token_qr', decodedText);

                        fetch('<?= base_url("siswa/proses_absen"); ?>', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire({
                                    icon: data.swal.icon,
                                    title: data.swal.title,
                                    text: data.swal.text,
                                    confirmButtonColor: '#2196f3'
                                }).then(() => {
                                    if (data.status === 'error') {
                                        startScanner();
                                    } else {
                                        window.location.reload();
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Koneksi Terputus',
                                    text: 'Gagal terhubung ke server Absenly.',
                                    confirmButtonColor: '#2196f3'
                                }).then(() => startScanner());
                            });

                    }).catch(err => console.error(err));
                }
            }

            function onScanFailure(error) { }
            window.addEventListener('DOMContentLoaded', startScanner);
        <?php endif; ?>

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