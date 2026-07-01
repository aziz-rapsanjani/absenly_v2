<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absenly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            background-color: #0F172A;
            color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .monitor-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            backdrop-filter: blur(16px);
        }

        #qrcode-container {
            background-color: #ffffff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            display: inline-block;
            transition: all 0.3s ease;
        }

        #qrcode-container img {
            margin: 0 auto;
        }

        .progress-bar-custom {
            height: 6px;
            background-color: #2563EB;
            width: 100%;
            transition: width 1s linear;
            border-radius: 3px;
        }
    </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center min-vh-100 p-4">

    <div class="text-center w-100" style="max-width: 650px;">

        <div class="mb-4">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-2 fw-semibold text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">
                Sesi Presensi Mandiri Aktif
            </span>
            <h1 class="fw-bold h2 mb-1 text-white"><?= htmlspecialchars($sesi['nama_mapel']); ?></h1>
            <p class="text-white mb-0 fs-5">
                Kelas: <span class="fw-medium"><?= htmlspecialchars($sesi['nama_kelas']); ?></span> &nbsp;·&nbsp; Jam Buka: <?= date('H:i', strtotime($sesi['jam_mulai'])); ?> WIB
            </p>
        </div>

        <div class="monitor-card p-5 shadow-lg mb-4 text-center">
            <div class="d-flex justify-content-center mb-4">
                <div id="qrcode-container">
                    <div id="qrcode"></div>
                </div>
            </div>

            <div class="px-4">
                <div class="d-flex justify-content-between text-muted small mb-2" style="font-size: 0.85rem;">
                    <span><i class="bi bi-arrow-clockwise animate-spin"></i> Sinkronisasi Keamanan Token</span>
                    <span id="countdown-text" class="text-info fw-bold">Memperbarui dalam 20 detik</span>
                </div>
                <div class="w-100 bg-secondary rounded-pill overflow-hidden" style="height: 6px; background-color: rgba(255,255,255,0.1) !important;">
                    <div id="progress-bar" class="progress-bar-custom"></div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-2 text-white" style="font-size: 0.9rem;">
            <i class="bi bi-info-circle"></i>
            <span>Siswa silakan buka websaid <strong>Absenly</strong> di HP masing-masing dan scan kode di atas.</span>
        </div>
    </div>

    <script>
        const sesiId = "<?= $sesi['id']; ?>";
        let currentToken = "<?= $sesi['qr_token_aktif']; ?>";
        let waktuSisa = 20;
        let qrcodeObj = null;

        function inisialisasiQRCode() {
            qrcodeObj = new QRCode(document.getElementById("qrcode"), {
                text: currentToken,
                width: 300,
                height: 300,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        function perbaruiTampilanQR(tokenBaru) {
            if (qrcodeObj) {
                qrcodeObj.clear();
                qrcodeObj.makeCode(tokenBaru);
            }
        }

        function requestTokenBaruDariServer() {
            let formData = new FormData();
            formData.append('sesi_id', sesiId);

            fetch('<?= base_url("guru/perbarui_token_qr"); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        currentToken = data.token;
                        perbaruiTampilanQR(currentToken);
                        console.log("Token Sinkronisasi Berhasil: " + currentToken);
                    } else {
                        console.error("Gagal sinkronisasi token database: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Kesalahan jaringan server terputus:", error);
                });
        }

        function jalankanTimerLoop() {
            setInterval(() => {
                waktuSisa--;
                document.getElementById('countdown-text').innerText = `Memperbarui dalam ${waktuSisa} detik`;
                let persenLebar = (waktuSisa / 20) * 100;
                document.getElementById('progress-bar').style.width = `${persenLebar}%`;

                if (waktuSisa <= 0) {
                    waktuSisa = 20;
                    requestTokenBaruDariServer();
                }
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            inisialisasiQRCode();
            jalankanTimerLoop();
        });
    </script>
</body>

</html>