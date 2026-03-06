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

                        {{-- ① Notifikasi izin kamera --}}
                        <div id="permission-alert" class="alert alert-warning d-none d-flex align-items-center gap-2 mb-3"
                            role="alert">
                            <i class="bx bx-camera-off fs-5 flex-shrink-0"></i>
                            <div>
                                <strong>Izin Kamera Dibutuhkan</strong><br>
                                <small>Izinkan akses kamera di browser Anda saat diminta.</small>
                            </div>
                        </div>

                        {{-- ② Panduan penggunaan --}}
                        <div class="border rounded p-3 mb-3 text-start bg-light">
                            <p class="fw-semibold mb-2">
                                <i class="bx bx-info-circle text-primary me-1"></i>Cara Penggunaan
                            </p>
                            <p class="small fw-semibold text-muted mb-1">
                                <i class="bx bx-barcode-reader me-1 text-secondary"></i>Menggunakan Alat Scanner:
                            </p>
                            <ol class="mb-3 ps-3 small text-secondary">
                                <li>Arahkan alat scanner ke <strong>QR Code</strong> pada struk pembelian.</li>
                                <li>Hasil scan otomatis masuk ke kolom input di bawah.</li>
                                <li>Tekan <kbd>Enter</kbd> atau tombol <strong>OK</strong> untuk memproses.</li>
                            </ol>
                            <p class="small fw-semibold text-muted mb-1">
                                <i class="bx bx-camera me-1 text-secondary"></i>Menggunakan Kamera:
                            </p>
                            <ol class="mb-0 ps-3 small text-secondary">
                                <li>Tekan tombol <strong>"Scan via Kamera"</strong> di bawah.</li>
                                <li>Arahkan kamera ke <strong>QR Code</strong> yang ada di struk pembelian.</li>
                                <li>Tahan kamera hingga QR Code terbaca otomatis.</li>
                            </ol>
                        </div>

                        {{-- ③ Catatan / warning --}}
                        <div class="alert alert-info d-flex align-items-start gap-2 py-2 text-start mb-3" role="alert">
                            <i class="bx bx-shield-quarter fs-5 flex-shrink-0 mt-1"></i>
                            <small>
                                <strong>Catatan:</strong>
                                Untuk fitur kamera, pastikan Anda sudah <strong>mengizinkan akses kamera</strong> di
                                browser.
                                Untuk alat scanner, pastikan perangkat sudah <strong>terhubung ke komputer</strong>
                                (USB/Bluetooth).
                            </small>
                        </div>

                        {{-- ④ INPUT ALAT SCANNER —— selalu terlihat, auto-focus --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted mb-1" for="scan-input">
                                <i class="bx bx-barcode-reader me-1"></i>Input Alat Scanner / Ketik Manual
                            </label>
                            <div class="input-group">
                                <input type="text" id="scan-input" class="form-control"
                                    placeholder="Arahkan alat scanner ke QR Code, atau ketik manual..." autocomplete="off"
                                    autofocus aria-label="Input QR Code Scanner">
                                <button class="btn btn-danger fw-semibold px-3" id="btn-ok" type="button"
                                    onclick="processScanInput()">
                                    <i class="bx bx-check me-1"></i>OK
                                </button>
                            </div>
                            <div class="text-muted mt-1" style="font-size:.75rem;">
                                <i class="bx bx-info-circle me-1"></i>Alat scanner otomatis mengisi kolom ini. Tekan
                                <kbd>Enter</kbd> atau <strong>OK</strong> untuk memproses.
                            </div>
                        </div>

                        {{-- ⑤ TOMBOL Scan via Kamera --}}
                        <div id="start-box" class="text-center mb-2">
                            <button id="btn-start" class="btn btn-outline-danger px-4" onclick="startScanner()">
                                <i class="bx bx-camera me-1"></i>Scan via Kamera
                            </button>
                        </div>

                        {{-- ⑥ Scanner area kamera --}}
                        <div id="scanner-box" class="d-none text-center">
                            <div id="reader" class="mx-auto mb-2" style="width: 100%; max-width: 420px;"></div>
                            <div id="scan-status" class="text-muted small mb-2">Arahkan kamera ke QR Code pembelian...</div>
                            <button id="btn-cancel" class="btn btn-outline-secondary btn-sm" onclick="cancelScanner()">
                                <i class="bx bx-x me-1"></i>Batalkan / Tutup Kamera
                            </button>
                        </div>

                        {{-- ⑦ Result --}}
                        <div id="result-box" class="d-none text-center">
                            <div class="alert alert-success d-flex flex-column align-items-center gap-1 py-4">
                                <i class="bx bx-calendar-check" style="font-size: 2.5rem;"></i>
                                <div class="fw-bold" style="font-size: 1rem;">Tanggal Pembelian</div>
                                <div id="result-date" class="display-6 fw-bold text-success"></div>
                                <div id="result-raw" class="text-muted mt-1" style="font-size:.74rem;word-break:break-all;">
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm mt-1" onclick="resetAll()">
                                <i class="bx bx-refresh me-1"></i>Scan Berikutnya
                            </button>
                        </div>

                        {{-- ⑧ Error --}}
                        <div id="error-box" class="d-none text-center">
                            <div class="alert alert-danger">
                                <i class="bx bx-error-circle me-1"></i>
                                <span id="error-msg">Format QR tidak dikenali.</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm mt-1" onclick="resetAll()">
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
        let cameraRunning = false;

        /* ─── Tangkap Enter dari alat scanner ─── */
        document.getElementById('scan-input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                processScanInput();
            }
        });

        /* ─── Proses input (alat scanner / ketik manual) ─── */
        function processScanInput() {
            const raw = document.getElementById('scan-input').value.trim();
            if (!raw) return;
            handleDecodedText(raw);
        }

        /* ─── Handler hasil scan (shared: kamera & alat) ─── */
        function handleDecodedText(decodedText) {
            const parts = decodedText.split('|');
            if (parts.length >= 2) {
                const rawDate = parts[1].trim();
                document.getElementById('result-date').textContent = formatDate(rawDate);
                document.getElementById('result-raw').textContent = 'Data: ' + decodedText;
                document.getElementById('scan-input').disabled = true;
                document.getElementById('btn-ok').disabled = true;
                showPanel('result-box');
            } else {
                document.getElementById('error-msg').textContent =
                    'Format QR tidak dikenali. Data terbaca: ' + decodedText;
                showPanel('error-box');
            }
        }

        /* ─── Tampilkan panel result/error (tanpa menutup input area) ─── */
        function showPanel(id) {
            ['result-box', 'error-box'].forEach(p =>
                document.getElementById(p).classList.toggle('d-none', p !== id)
            );
        }

        /* ─── Reset ke awal ─── */
        function resetAll() {
            stopCamera().then(() => {
                const input = document.getElementById('scan-input');
                input.value = '';
                input.disabled = false;
                document.getElementById('btn-ok').disabled = false;
                document.getElementById('result-box').classList.add('d-none');
                document.getElementById('error-box').classList.add('d-none');
                document.getElementById('start-box').classList.remove('d-none');
                document.getElementById('scanner-box').classList.add('d-none');
                input.focus();
            });
        }

        /* ─── Format tanggal DDMMYYYY → DD/MM/YYYY ─── */
        function formatDate(raw) {
            if (/^\d{8}$/.test(raw)) {
                return raw.substring(0, 2) + '/' + raw.substring(2, 4) + '/' + raw.substring(4, 8);
            }
            return raw;
        }

        /* ════════════════════════════════════
           KAMERA
        ════════════════════════════════════ */
        async function checkCameraPermission() {
            if (!navigator.permissions) return;
            try {
                const status = await navigator.permissions.query({
                    name: 'camera'
                });
                applyPermissionState(status.state);
                status.onchange = () => applyPermissionState(status.state);
            } catch (e) {}
        }

        function applyPermissionState(state) {
            document.getElementById('permission-alert')
                .classList.toggle('d-none', state === 'granted');
        }

        function startScanner() {
            document.getElementById('start-box').classList.add('d-none');
            document.getElementById('scanner-box').classList.remove('d-none');
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
                    (decodedText) => {
                        stopCamera().then(() => {
                            document.getElementById('scan-input').value = decodedText;
                            handleDecodedText(decodedText);
                        });
                    },
                    () => {}
                ).then(() => {
                    cameraRunning = true;
                }).catch(err => showError('Gagal memulai kamera: ' + err));

            }).catch(err => {
                showError('Tidak dapat mengakses kamera: ' + err);
                document.getElementById('permission-alert').classList.remove('d-none');
            });
        }

        function cancelScanner() {
            stopCamera().then(() => {
                document.getElementById('scanner-box').classList.add('d-none');
                document.getElementById('start-box').classList.remove('d-none');
                document.getElementById('scan-input').focus();
            });
        }

        function stopCamera() {
            if (!html5QrCode || !cameraRunning) return Promise.resolve();
            return html5QrCode.stop().catch(() => {}).then(() => {
                cameraRunning = false;
                document.getElementById('reader').innerHTML = '';
            });
        }

        function showError(msg) {
            stopCamera().then(() => {
                document.getElementById('error-msg').textContent = msg;
                showPanel('error-box');
            });
        }

        /* ─── Init ─── */
        checkCameraPermission();
        document.getElementById('scan-input').focus();
    </script>
@endsection
