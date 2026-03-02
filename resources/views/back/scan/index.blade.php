@extends('back.layouts.layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center gap-2">
                        <i class="bx bx-qr-scan fs-5"></i>
                        <span class="fw-semibold">Scan QR Code</span>
                    </div>
                    <div class="card-body">

                        {{-- ① Notifikasi izin kamera (hanya muncul jika belum ada akses) --}}
                        <div id="permission-alert" class="alert alert-warning d-none d-flex align-items-center gap-2 mb-3"
                            role="alert">
                            <i class="bx bx-camera-off fs-5 flex-shrink-0"></i>
                            <div>
                                <strong>Izin Kamera Dibutuhkan</strong><br>
                                <small>Izinkan akses kamera di browser Anda saat diminta.</small>
                            </div>
                        </div>

                        {{-- ② Layar Idle: instruksi + tombol mulai --}}
                        <div id="start-box">

                            {{-- Instruksi penggunaan --}}
                            <div class="border rounded p-3 mb-3 text-start bg-light">
                                <p class="fw-semibold mb-2"><i class="bx bx-info-circle text-primary me-1"></i>Cara
                                    Penggunaan</p>
                                <ol class="mb-0 ps-3 small text-secondary">
                                    <li>Tekan tombol <strong>"Scan Sekarang"</strong> di bawah.</li>
                                    <li>Arahkan kamera ke <strong>QR Code</strong> yang ada di struk pembelian.</li>
                                    <li>Tahan kamera hingga QR Code terbaca otomatis.</li>
                                    <li>Tanggal pembelian akan langsung ditampilkan.</li>
                                </ol>
                            </div>

                            {{-- Catatan --}}
                            <div class="alert alert-info d-flex align-items-start gap-2 py-2 text-start mb-3"
                                role="alert">
                                <i class="bx bx-shield-quarter fs-5 flex-shrink-0 mt-1"></i>
                                <small><strong>Catatan:</strong> Pastikan Anda sudah <strong>mengizinkan akses
                                        kamera</strong> di browser. Tanpa izin, scanner tidak dapat berjalan.</small>
                            </div>

                            <div class="text-center">
                                <i class="bx bx-qr-scan text-secondary mb-2" style="font-size: 4rem;"></i>
                                <br>
                                <button id="btn-start" class="btn btn-danger px-4 mt-2">
                                    <i class="bx bx-camera me-1"></i>Scan Sekarang
                                </button>
                            </div>
                        </div>

                        {{-- ③ Scanner area + tombol cancel --}}
                        <div id="scanner-box" class="d-none text-center">
                            <div id="reader" class="mx-auto mb-2" style="width: 100%; max-width: 420px;"></div>
                            <div id="scan-status" class="text-muted small mb-2">Arahkan kamera ke QR Code pembelian...</div>
                            <button id="btn-cancel" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-x me-1"></i>Batalkan / Tutup Kamera
                            </button>
                        </div>

                        {{-- ④ Result Card --}}
                        <div id="result-box" class="d-none text-center">
                            <div class="alert alert-success d-flex flex-column align-items-center gap-1 py-4">
                                <i class="bx bx-calendar-check" style="font-size: 2.5rem;"></i>
                                <div class="fw-bold" style="font-size: 1rem;">Tanggal Pembelian</div>
                                <div id="result-date" class="display-6 fw-bold text-success"></div>
                            </div>
                            <button id="btn-scan-again" class="btn btn-outline-secondary btn-sm mt-1">
                                <i class="bx bx-refresh me-1"></i>Scan Ulang
                            </button>
                        </div>

                        {{-- ⑤ Error --}}
                        <div id="error-box" class="d-none text-center">
                            <div class="alert alert-danger">
                                <i class="bx bx-error-circle me-1"></i>
                                <span id="error-msg">Format QR tidak dikenali.</span>
                            </div>
                            <button id="btn-scan-again-err" class="btn btn-outline-secondary btn-sm mt-1">
                                <i class="bx bx-refresh me-1"></i>Coba Lagi
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- html5-qrcode CDN --}}
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        let html5QrCode = null;

        // ---- Cek status izin kamera ----
        async function checkCameraPermission() {
            if (!navigator.permissions) return;
            try {
                const status = await navigator.permissions.query({
                    name: 'camera'
                });
                applyPermissionState(status.state);
                status.onchange = () => applyPermissionState(status.state);
            } catch (e) {
                /* browser tidak mendukung */ }
        }

        function applyPermissionState(state) {
            const el = document.getElementById('permission-alert');
            if (state === 'granted') {
                el.classList.add('d-none');
            } else {
                el.classList.remove('d-none');
            }
        }

        // ---- Tampil/Sembunyikan panel ----
        function showPanel(id) {
            ['start-box', 'scanner-box', 'result-box', 'error-box'].forEach(panel => {
                document.getElementById(panel).classList.toggle('d-none', panel !== id);
            });
        }

        // ---- Start Scanner ----
        function startScanner() {
            showPanel('scanner-box');
            document.getElementById('reader').innerHTML = '';
            document.getElementById('scan-status').textContent = 'Arahkan kamera ke QR Code pembelian...';

            html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(cameras => {
                if (!cameras || cameras.length === 0) {
                    showError('Kamera tidak ditemukan atau ditolak aksesnya.');
                    return;
                }

                document.getElementById('permission-alert').classList.add('d-none');

                const cameraId = cameras[cameras.length - 1].id;

                html5QrCode.start(
                    cameraId, {
                        fps: 10,
                        qrbox: {
                            width: 280,
                            height: 280
                        }
                    },
                    onScanSuccess,
                    () => {} // silent failure
                ).catch(err => showError('Gagal memulai kamera: ' + err));

            }).catch(err => {
                showError('Tidak dapat mengakses kamera: ' + err);
                document.getElementById('permission-alert').classList.remove('d-none');
            });
        }

        // ---- Stop & kembali ke idle ----
        function cancelScanner() {
            const stop = html5QrCode ? html5QrCode.stop().catch(() => {}) : Promise.resolve();
            stop.then(() => {
                document.getElementById('reader').innerHTML = '';
                showPanel('start-box');
            });
        }

        // ---- Stop & lanjut ke panel lain ----
        function stopScanner() {
            const stop = html5QrCode ? html5QrCode.stop().catch(() => {}) : Promise.resolve();
            return stop.then(() => {
                document.getElementById('reader').innerHTML = '';
            });
        }

        // ---- Scan berhasil ----
        function onScanSuccess(decodedText) {
            stopScanner().then(() => {
                const parts = decodedText.split('|');
                if (parts.length >= 2) {
                    const rawDate = parts[1].trim();
                    document.getElementById('result-date').textContent = formatDate(rawDate);
                    showPanel('result-box');
                } else {
                    showError('Format QR tidak dikenali. Pastikan QR dari pembelian yang valid.');
                }
            });
        }

        // ---- Error ----
        function showError(msg) {
            stopScanner().then(() => {
                document.getElementById('error-msg').textContent = msg;
                showPanel('error-box');
            });
        }

        // ---- Format tanggal DDMMYYYY -> DD/MM/YYYY ----
        function formatDate(raw) {
            if (/^\d{8}$/.test(raw)) {
                return raw.substring(0, 2) + '/' + raw.substring(2, 4) + '/' + raw.substring(4, 8);
            }
            return raw;
        }

        // ---- Event Listeners ----
        document.getElementById('btn-start').addEventListener('click', startScanner);
        document.getElementById('btn-cancel').addEventListener('click', cancelScanner);
        document.getElementById('btn-scan-again').addEventListener('click', () => showPanel('start-box'));
        document.getElementById('btn-scan-again-err').addEventListener('click', () => showPanel('start-box'));

        // ---- Init ----
        checkCameraPermission();
    </script>
@endsection
