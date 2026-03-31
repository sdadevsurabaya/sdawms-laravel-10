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

                        {{-- Tombol Toggle Panduan (UI Improved) --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small fw-bold text-muted uppercase">Metode Pemindaian</span>
                            <button
                                class="btn btn-light btn-sm rounded-pill px-3 border shadow-sm d-flex align-items-center gap-2 toggle-guide-btn"
                                type="button" data-bs-toggle="collapse" data-bs-target="#guide-warning-section"
                                aria-expanded="false" aria-controls="guide-warning-section">
                                <i class="bx bx-help-circle text-primary fs-6"></i>
                                <span class="small fw-bold">Petunjuk Penggunaan</span>
                                <i class="bx bx-chevron-down transition-icon" id="guide-chevron"></i>
                            </button>
                        </div>

                        <style>
                            .toggle-guide-btn {
                                transition: all 0.2s ease;
                                background: #f8f9fa;
                            }

                            .toggle-guide-btn:hover {
                                background: #e9ecef;
                                transform: translateY(-1px);
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important;
                            }

                            .transition-icon {
                                transition: transform 0.3s ease;
                            }

                            .toggle-guide-btn[aria-expanded="true"] .transition-icon {
                                transform: rotate(180deg);
                            }
                        </style>

                        {{-- Bungkus Guide & Warning agar bisa di-collapse --}}
                        <div id="guide-warning-section" class="collapse">
                            {{-- ② Panduan penggunaan --}}
                            <div class="border rounded p-3 mb-3 text-start bg-light">
                                <p class="fw-semibold mb-2 text-primary">
                                    <i class="bx bx-help-circle me-1"></i>Cara Penggunaan
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
                            <div class="alert alert-info d-flex align-items-start gap-2 py-2 text-start mb-3"
                                role="alert">
                                <i class="bx bx-shield-quarter fs-5 flex-shrink-0 mt-1"></i>
                                <small>
                                    <strong>Catatan:</strong>
                                    Untuk fitur kamera, pastikan izin akses kamera sudah diberikan di browser.
                                    Untuk alat scanner, pastikan perangkat terhubung via USB/Bluetooth.
                                </small>
                            </div>
                        </div>

                        {{-- ④ INPUT ALAT SCANNER —— selalu terlihat, auto-focus --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted mb-2" for="scan-input">
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
                            <div class="text-muted mt-2" style="font-size:.75rem;">
                                <i class="bx bx-info-circle me-1"></i>Alat scanner otomatis mengisi kolom ini. Tekan
                                <kbd>Enter</kbd> atau <strong>OK</strong> untuk memproses.
                            </div>
                        </div>

                        {{-- Separator --}}
                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1">
                            <span class="px-3 small fw-bold text-muted" style="letter-spacing: 1px;">ATAU</span>
                            <hr class="flex-grow-1">
                        </div>

                        {{-- ⑤ TOMBOL Scan via Kamera --}}
                        <div id="start-box" class="text-center mb-3">
                            <button id="btn-start" class="btn btn-outline-danger px-4" onclick="startScanner()">
                                <i class="bx bx-camera me-1"></i>Scan via Kamera
                            </button>
                        </div>

                        {{-- ⑥ Scanner area kamera --}}
                        <div id="scanner-box" class="d-none text-center">
                            <div id="reader" class="mx-auto mb-2" style="width: 100%; max-width: 420px;"></div>
                            <div id="scan-status" class="text-muted small mb-2">Arahkan kamera ke QR Code pembelian...</div>
                            <button id="btn-cancel" class="btn btn-outline-secondary btn-sm mb-2" onclick="cancelScanner()">
                                <i class="bx bx-x me-1"></i>Batalkan / Tutup Kamera
                            </button>
                        </div>

                        {{-- ⑦ Result --}}
                        <div id="result-box" class="d-none">
                            <div class="card border-success shadow-none mb-3 overflow-hidden">
                                <div class="card-header bg-success text-white py-2 d-flex align-items-center gap-2 border-0">
                                    <i class="bx bx-check-circle fs-5"></i>
                                    <span class="fw-bold small text-uppercase">Data Berhasil Ditemukan</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <th class="ps-3 py-2 text-muted fw-normal" style="width: 130px;">ID Rakitan</th>
                                                    <td class="pe-3 py-2 fw-bold text-dark" id="res-id-rakitan">-</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="ps-3 py-2 text-muted fw-normal">Nama Customer</th>
                                                    <td class="pe-3 py-2 fw-bold text-primary" id="res-nama-customer">-</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="ps-3 py-2 text-muted fw-normal">No Faktur</th>
                                                    <td class="pe-3 py-2 fw-bold text-dark" id="res-no-faktur">-</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="ps-3 py-2 text-muted fw-normal">Tanggal</th>
                                                    <td class="pe-3 py-2 fw-bold text-dark" id="res-tanggal">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="p-3 border-top bg-light bg-opacity-10">
                                            <div class="text-muted small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px; font-size: 0.7rem;">
                                                <i class="bx bx-list-ul me-1"></i>Deskripsi Spesifikasi
                                            </div>
                                            <div class="fw-bold text-dark text-wrap lh-base" id="res-spesifikasi" style="font-size: 0.9rem;">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-outline-secondary btn-sm" onclick="resetAll()">
                                    <i class="bx bx-refresh me-1"></i>Scan Berikutnya
                                </button>
                            </div>
                        </div>

                        {{-- Loading Box --}}
                        <div id="loading-box" class="d-none text-center py-5">
                            <div class="spinner-border text-danger mb-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="text-muted fw-semibold">Mengambil data Rakitan...</div>
                            <div class="small text-muted mt-1">Mohon tunggu sebentar</div>
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

        /* ─── Deteksi Perangkat Mobile/Tablet ─── */
        function isMobile() {
            const regex = /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
            return regex.test(navigator.userAgent);
        }

        /* ─── Tangkap Enter & Input dari alat scanner ─── */
        const scanInput = document.getElementById('scan-input');

        scanInput.addEventListener('keydown', function(e) {
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
        async function handleDecodedText(decodedText) {
            const parts = decodedText.split('|');
            const idValue = parts[0]?.trim();
            const customerValue = parts[2]?.trim() || '-';

            // Kosongkan input
            scanInput.value = '';

            // Hanya paksa fokus kembali jika BUKAN di HP/Tablet
            if (!isMobile()) {
                scanInput.focus();
            }

            if (!idValue) {
                showError('Format QR tidak dikenali (ID Kosong). Terbaca: ' + decodedText);
                return;
            }

            // Tampilkan loading panel
            showPanel('loading-box');

            try {
                const response = await fetch(`{{ route('rakitan.data') }}?id=${idValue}`);
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const result = await response.json();

                if (result.success && result.data && result.data.length > 0) {
                    const data = result.data[0];
                    
                    document.getElementById('res-id-rakitan').textContent = data.ID_RAKITAN || idValue;
                    document.getElementById('res-nama-customer').textContent = customerValue;
                    document.getElementById('res-no-faktur').textContent = data.No_Faktur || '-';
                    document.getElementById('res-tanggal').textContent = data.Tanggal ? data.Tanggal.split(' ')[0] : '-';
                    document.getElementById('res-spesifikasi').textContent = data.NAMA_RAKITAN || '-';

                    showPanel('result-box');
                } else {
                    showError('Data Rakitan tidak ditemukan di server.');
                }
            } catch (err) {
                console.error('Fetch Error:', err);
                showError('Gagal mengambil data dari server. Periksa koneksi internet Anda.');
            }
        }

        /* ─── Tampilkan panel result/error (tanpa menutup input area) ─── */
        function showPanel(id) {
            ['result-box', 'error-box', 'loading-box'].forEach(p =>
                document.getElementById(p).classList.toggle('d-none', p !== id)
            );
        }

        /* ─── Reset ke awal ─── */
        function resetAll() {
            stopCamera().then(() => {
                const input = document.getElementById('scan-input');
                input.value = '';
                document.getElementById('result-box').classList.add('d-none');
                document.getElementById('error-box').classList.add('d-none');
                document.getElementById('start-box').classList.remove('d-none');
                document.getElementById('scanner-box').classList.add('d-none');

                if (!isMobile()) {
                    input.focus();
                }
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

        /* ─── Selalu Jaga Fokus (Hanya untuk Desktop) ─── */
        if (!isMobile()) {
            document.addEventListener('click', function(e) {
                // Jangan ambil fokus jika yang diklik adalah tombol atau input itu sendiri
                if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'A') {
                    scanInput.focus();
                }
            });
        }

        /* ─── Init ─── */
        checkCameraPermission();

        // Auto focus awal hanya untuk desktop
        if (!isMobile()) {
            scanInput.focus();
        }
    </script>
@endsection
