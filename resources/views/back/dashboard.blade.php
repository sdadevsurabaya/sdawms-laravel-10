@extends('back.layouts.layout')

@section('content')
    <div class="container mt-4">
        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            {{-- <div class="col-md-3 col-6">
                <div class="card text-bg-primary text-center">
                    <div class="card-body">
                        <h5 class="card-title">Branches</h5>
                        <h2>{{ $branchCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-bg-success text-center">
                    <div class="card-body">
                        <h5 class="card-title">Warehouses</h5>
                        <h2>{{ $warehouseCount }}</h2>
                    </div>
                </div>
            </div> --}}
            <div class="col-6">
                <div class="card text-bg-warning text-center">
                    <div class="card-body">
                        <h5 class="card-title">Racks</h5>
                        <h2 id="rack_count">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card text-bg-danger text-center">
                    <div class="card-body">
                        <h5 class="card-title">Items</h5>
                        <h2 id="items_count">0</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                {{-- <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="input-group">
                        <input type="text" name="search_rack" class="form-control" placeholder="Cari kode rack..."
                            value="{{ request('search_rack') }}">
                        <button class="btn btn-warning" type="submit">Cari Rack</button>
                    </div>
                </form> --}}
                <form id="searchRackForm" onsubmit="searchRack(event)" data-no-loading>
                    <div class="input-group">
                        <input type="text" id="searchRackInput" class="form-control" placeholder="Cari kode rack...">
                        <button class="btn btn-warning" type="submit">Cari Rack</button>
                    </div>
                </form>

            </div>
            <div class="col-md-4 mb-2">
                <form id="searchProductForm" onsubmit="searchProduct(event)" data-no-loading>
                    <div class="input-group">
                        <input type="text" id="searchProductInput" class="form-control"
                            placeholder="Cari nama/kode barang...">
                        <button class="btn btn-danger" type="submit">Cari Barang</button>
                    </div>
                </form>

            </div>
            <div class="col-md-4 mb-2">
                <button type="button" onclick="startScann();" class="btn btn-primary py-5 py-sm-1 h-100 w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-upc-scan" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z" />
                    </svg>
                    Scan Barcode
                </button>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="scannerModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" onclick="stopScanning();" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

                        <audio id="audioSuccess">
                            <source src="{{ asset('audio/scan-success.mp3') }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>

                        <div id="qr-reader" style="width: 100%;">
                        </div>
                        <div id="qr-reader-results">
                            <ul id="scanned-codes-list"></ul>
                        </div>
                        <div id="qr-reader-results2">
                        </div>
                        <script>
                            var scannedCodes = [];
                            let scanCode = '';
                            var countSuccessScan = 0;
                            var audioSuccess = document.getElementById("audioSuccess");

                            function playAudioSuccess() {
                                audioSuccess.currentTime = 0;
                                audioSuccess.play();
                            }

                            var html5QrcodeScanner = new Html5QrcodeScanner(
                                "qr-reader", {
                                    fps: 10,
                                    qrbox: {
                                        width: 300,
                                        height: 120
                                    },
                                    aspectRatio: 1.0,
                                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                                    rememberLastUsedCamera: true
                                }, false);

                            function updateResultList(message) {
                                const resultList = document.getElementById("scanned-codes-list");
                                resultList.innerHTML = ''; // Clear existing list
                                scannedCodes.forEach(code => {
                                    const li = document.createElement("li");
                                    li.textContent = code;
                                    resultList.appendChild(li);
                                });
                                // Add message as the first item if provided
                                if (message) {
                                    const li = document.createElement("li");
                                    li.textContent = message;
                                    resultList.insertBefore(li, resultList.firstChild);
                                }
                            }

                            async function onScanSuccess(decodedText, decodedResult) {
                                countSuccessScan = (scanCode === decodedText) ? countSuccessScan + 1 : 1;
                                scanCode = decodedText;

                                if (countSuccessScan === 12) {
                                    playAudioSuccess();
                                    html5QrcodeScanner.clear();
                                    $('#scannerModal').modal('hide');

                                    // Try fetching Rack API first, fallback to Product API
                                    try {
                                        const rackResp = await fetch(`/api/wms/rack/${encodeURIComponent(decodedText)}`);
                                        if (rackResp.ok) {
                                            const rackData = await rackResp.json();
                                            if (rackData && rackData.data && rackData.data.length > 0) {
                                                renderRackResult(rackData, decodedText);
                                                return;
                                            }
                                        }
                                    } catch (e) {
                                        console.error('Scan rack error:', e);
                                    }

                                    try {
                                        const prodResp = await fetch(`/api/wms/product/${encodeURIComponent(decodedText)}`);
                                        if (prodResp.ok) {
                                            const prodData = await prodResp.json();
                                            renderProductResult(prodData, decodedText);
                                            return;
                                        }
                                    } catch (e) {
                                        console.error('Scan product error:', e);
                                    }

                                    renderRackResult(null, decodedText);
                                }
                            }


                            function onScanFailure(error) {
                                // handle scan failure, usually better to ignore and keep scanning.
                                console.warn(`QR error = ${error}`);
                            }

                            function startScann() {
                                countSuccessScan = 0;
                                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                                $('#scannerModal').modal('show');
                            }

                            function stopScanning() {
                                const resultList = document.getElementById("scanned-codes-list");
                                resultList.innerHTML = ''; // Clear existing list
                                scannedCodes = [];
                                html5QrcodeScanner.clear();
                                $('#scannerModal').modal('hide');
                            }
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="stopScanning();">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div id="rack-api-result" class="mt-3"></div>

        <div id="product-api-result" class="mt-3"></div> --}}

        <div id="rack-api-result" class="my-3" style="display: none;">
            <div id="rack-api-status"></div>
            <div class="card shadow-sm" id="rack-api-card" style="display: none;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <strong>Hasil Pencarian untuk Rack: <span id="rackResultTitle"></span></strong>
                    <button type="button" class="btn-close btn-close-white" onclick="$('#rack-api-result').hide()"></button>
                </div>
                <div class="card-body table-responsive">
                    <table id="rackDataTable" class="table table-bordered table-striped text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="product-api-result" class="my-3" style="display: none;">
            <div id="product-api-status"></div>
            <div class="card shadow-sm" id="product-api-card" style="display: none;">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <strong>Hasil Pencarian untuk Barang: <span id="productResultTitle"></span></strong>
                    <button type="button" class="btn-close btn-close-white" onclick="$('#product-api-result').hide()"></button>
                </div>
                <div class="card-body table-responsive">
                    <table id="productDataTable" class="table table-bordered table-striped text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>Rack Number</th>
                                <th>Barcode</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Rack Result --}}
        @if ($racksWithItems->count())
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-warning text-white">
                    <strong>Hasil Pencarian Berdasarkan Rack</strong>
                </div>
                <div class="card-body">
                    @foreach ($racksWithItems as $rack)
                        <div class="mb-3">
                            <h5>Rack: {{ $rack->rack_number }}</h5>
                            <p>
                                <strong>Warehouse:</strong> {{ $rack->warehouse->name }}<br>
                                <strong>Branch:</strong> {{ $rack->warehouse->branch->name }}
                            </p>
                            <ul class="list-group">
                                @forelse($rack->items as $item)
                                    <li class="list-group-item">{{ $item->code }} - {{ $item->name }}</li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada barang dalam rak ini.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Item Result --}}
        @if ($itemsWithRack->count())
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <strong>Hasil Pencarian Berdasarkan Barang</strong>
                </div>
                <div class="card-body">
                    @foreach ($itemsWithRack as $item)
                        <div class="mb-3">
                            <p class="mb-1">
                                <strong>{{ $item->code }} - {{ $item->name }}</strong>
                            </p>
                            <small>
                                Rack: {{ $item->rack->rack_number }} |
                                Warehouse: {{ $item->rack->warehouse->name }} |
                                Branch: {{ $item->rack->warehouse->branch->name }}
                            </small>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Table: Racks and Items --}}
        <div class="card mb-5">
            <div class="card-header bg-dark text-white">Rack Overview by Branch & Warehouse</div>
            <div class="card-body">
                {{-- @foreach ($branches as $branch) --}}
                {{-- <h5 class="mt-3 text-primary">{{ $branch->name }}</h5> --}}
                {{-- @foreach ($branch->warehouses as $warehouse) --}}
                {{-- <h6 class="ms-3 text-success">Warehouse: {{ $warehouse->name }}</h6> --}}
                <div class="table-responsive">
                    <table id="warehouse" class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Rack Number</th>
                                <th>Total Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="itemDetailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="itemDetailModalLabel">Items in Rack: <span
                                        id="modalRackNumber"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body table-responsive">
                                <table id="modalItemsTable" class="table table-bordered table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Item ID</th>
                                            <th>Item Name</th>
                                            <th>Brand</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @endforeach --}}
                {{-- @endforeach --}}
            </div>
        </div>
        {{-- <div class="card mb-5">
            <div class="card-header bg-dark text-white">Rack Overview by Branch & Warehouse</div>
            <div class="card-body">
                @foreach ($branches as $branch)
                    <h5 class="mt-3 text-primary">{{ $branch->name }}</h5>
                    @foreach ($branch->warehouses as $warehouse)
                        <h6 class="ms-3 text-success">Warehouse: {{ $warehouse->name }}</h6>
                        <div class="table-responsive">
                            <table id="warehouse" class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Rack Name</th>
                                        <th>Item Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($warehouse->racks as $rack)
                                        <tr>
                                            <td>{{ $rack->rack_number }}</td>
                                            <td>{{ $rack->items->count() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-muted">No racks found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div> --}}
    </div>
    <style>
        /* Styling untuk Overlay Loading */
        .loading-overlay {
            position: fixed;
            /* Tetap di viewport saat scrolling */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Semi-transparan hitam */
            display: flex;
            /* Menggunakan flexbox untuk memusatkan spinner */
            justify-content: center;
            /* Pusatkan horizontal */
            align-items: center;
            /* Pusatkan vertikal */
            z-index: 9999;
            /* Pastikan di atas elemen lain */
            transition: opacity 0.3s ease-in-out;
            /* Animasi saat muncul/hilang */
            opacity: 0;
            /* Awalnya tersembunyi */
            visibility: hidden;
            /* Awalnya tidak terlihat */
        }

        .loading-overlay.active {
            opacity: 1;
            /* Tampilkan overlay */
            visibility: visible;
            /* Jadikan terlihat */
        }

        /* Styling untuk Spinner */
        .loading-spinner {
            border: 6px solid #f3f3f3;
            /* Light grey */
            border-top: 6px solid #3498db;
            /* Biru */
            border-radius: 50%;
            /* Membuat bentuk lingkaran */
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            /* Animasi berputar */
        }

        /* Keyframes untuk Animasi Spin */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Styling untuk Teks Loading */
        .loading-text {
            color: #fff;
            /* Warna teks putih */
            margin-left: 15px;
            /* Jarak antara spinner dan teks */
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat...</div>
    </div>
    <script>
        function showLoadingOverlay(message = "Memuat...") {
            const overlay = document.getElementById('loadingOverlay');
            const text = overlay.querySelector('.loading-text');
            text.textContent = message; // Atur pesan loading

            // Tambahkan kelas 'active' untuk menampilkan overlay dengan transisi
            overlay.classList.add('active');
        }

        /**
         * Menyembunyikan overlay loading.
         */
        function hideLoadingOverlay() {
            const overlay = document.getElementById('loadingOverlay');
            // Hapus kelas 'active' untuk menyembunyikan overlay dengan transisi
            overlay.classList.remove('active');

            // Opsional: Tunggu transisi selesai sebelum mengatur visibility: hidden
            // Ini memastikan transisi selesai sebelum elemen tidak bisa lagi diklik (jika ada)
            setTimeout(() => {
                if (!overlay.classList.contains('active')) { // Pastikan tidak diaktifkan lagi selama timeout
                    overlay.style.visibility = 'hidden';
                }
            }, 300); // Sesuaikan dengan durasi transisi CSS (0.3s = 300ms)
        }
        /**
         * Mengambil dan menampilkan data ringkasan (jumlah rak dan total item)
         * dari API ke elemen HTML yang ditentukan.
         */
        function loadSummaryData() {
            const API_SUMMARY_URL = `https://bridge.tokosda.com/wms.php`; // API tanpa parameter apapun untuk ringkasan

            fetch('/api/wms/summary')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(apiResponse => {
                    if (apiResponse.data && typeof apiResponse.data.rack_count !== 'undefined' && typeof apiResponse
                        .data.total_items !== 'undefined') {
                        $('#rack_count').text(apiResponse.data.rack_count);
                        $('#items_count').text(apiResponse.data.total_items);
                    } else {
                        console.error("Data summary from API is not in the expected format:", apiResponse);
                        $('#rack_count').text('N/A');
                        $('#items_count').text('N/A');
                        // alert("Failed to load summary data. API response format is incorrect.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching summary data:", error);
                    $('#rack_count').text('Error');
                    $('#items_count').text('Error');
                    // alert("Error loading summary data: " + error.message);
                });
        }

        // Tampilkan overlay loading sebelum fetch data
        showLoadingOverlay("Memuat data gudang...");

        /**
         * Menginisialisasi DataTable dan memuat semua data rak yang dikelompokkan
         * dari API, lalu menambahkan fungsionalitas untuk melihat detail item.
         */
        function initializeWarehouseDataTable() {
            const dataTable = $('#warehouse').DataTable({
                columns: [{
                        data: 'rack_number'
                    },
                    {
                        data: 'item_count'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button class="btn btn-info btn-sm view-detail">View Items</button>`;
                        },
                        orderable: false
                    }
                ],
                processing: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });

            fetch('/api/wms/racks')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(apiResponse => {
                    if (apiResponse.data && Array.isArray(apiResponse.data)) {
                        const processedData = apiResponse.data.map(rack => ({
                            rack_number: rack.rack_number,
                            item_count: rack.item ? rack.item.length : 0,
                            full_items: rack.item || []
                        }));
                        dataTable.clear().rows.add(processedData).draw();
                    } else {
                        console.error("Data returned from API is not in the expected format:", apiResponse);
                        // alert("Failed to load data. API response format is incorrect.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                    // alert("Error loading warehouse data: " + error.message);
                })
                .finally(() => {
                    hideLoadingOverlay(); // Sembunyikan overlay setelah fetch selesai (berhasil/gagal)
                });

            // Event Listener untuk Tombol View Items
            $('#warehouse tbody').on('click', '.view-detail', function() {
                const rowData = dataTable.row($(this).parents('tr')).data();

                if (rowData && rowData.full_items && rowData.full_items.length > 0) {
                    $('#modalRackNumber').text(rowData.rack_number);
                    $('#modalItemsTable tbody').empty();

                    rowData.full_items.forEach(item => {
                        $('#modalItemsTable tbody').append(`
                    <tr>
                        <td>${item.barcode || ''}</td>
                        <td>${item.id_brg || ''}</td>
                        <td>${item.nama_brg || ''}</td>
                        <td>${item.merk || ''}</td>
                        <td>${item.qty || ''}</td>
                        <td>${item.id_satuan || ''}</td>
                        <td>${item.keterangan || ''}</td>
                    </tr>
                `);
                    });

                    // Pastikan Bootstrap JS dimuat untuk modal ini
                    const itemDetailModal = new bootstrap.Modal(document.getElementById('itemDetailModal'));
                    itemDetailModal.show();

                } else {
                    // alert(`No detailed items found for Rack: ${rowData.rack_number}`);
                }
            });
        }

        $(document).ready(function() {
            loadSummaryData(); // Memuat data ringkasan
            initializeWarehouseDataTable(); // Menginisialisasi dan memuat data tabel
        });
    </script>

    <script>
        let rackDataTableInstance = null;
        let productDataTableInstance = null;

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function renderRackResult(data, searchQuery) {
            const $resultDiv = $('#rack-api-result');
            const $statusDiv = $('#rack-api-status');
            const $cardElement = $('#rack-api-card');

            $resultDiv.show();

            if (!data || !data.data || data.data.length === 0) {
                $cardElement.hide();
                $statusDiv.html(`<div class="alert alert-warning">Data tidak ditemukan untuk Rack: <strong>${escapeHtml(searchQuery)}</strong></div>`).show();
                return false;
            }

            $statusDiv.hide().empty();
            $('#rackResultTitle').text(data.id || searchQuery);

            if ($.fn.DataTable.isDataTable('#rackDataTable')) {
                $('#rackDataTable').DataTable().destroy();
            }

            rackDataTableInstance = $('#rackDataTable').DataTable({
                data: data.data,
                columns: [
                    { data: 'barcode', defaultContent: '-' },
                    { data: 'id_brg', defaultContent: '-' },
                    { data: 'nama_brg', defaultContent: '-' },
                    { data: 'merk', defaultContent: '-' },
                    { data: 'qty', defaultContent: '0' },
                    { data: 'id_satuan', defaultContent: '-' },
                    { data: 'keterangan', defaultContent: '-' }
                ],
                destroy: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true
            });

            $cardElement.show();
            return true;
        }

        function renderProductResult(data, searchQuery) {
            const $resultDiv = $('#product-api-result');
            const $statusDiv = $('#product-api-status');
            const $cardElement = $('#product-api-card');

            $resultDiv.show();

            if (!data || !data.data || data.data.length === 0) {
                $cardElement.hide();
                $statusDiv.html(`<div class="alert alert-warning">Data tidak ditemukan untuk Barang: <strong>${escapeHtml(searchQuery)}</strong></div>`).show();
                return false;
            }

            $statusDiv.hide().empty();
            $('#productResultTitle').text(data.id || searchQuery);

            if ($.fn.DataTable.isDataTable('#productDataTable')) {
                $('#productDataTable').DataTable().destroy();
            }

            productDataTableInstance = $('#productDataTable').DataTable({
                data: data.data,
                columns: [
                    { data: 'rack_number', defaultContent: '-' },
                    { data: 'barcode', defaultContent: '-' },
                    { data: 'id_brg', defaultContent: '-' },
                    { data: 'nama_brg', defaultContent: '-' },
                    { data: 'merk', defaultContent: '-' },
                    { data: 'qty', defaultContent: '0' },
                    { data: 'id_satuan', defaultContent: '-' },
                    { data: 'keterangan', defaultContent: '-' }
                ],
                destroy: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true
            });

            $cardElement.show();
            return true;
        }

        function searchRack(event) {
            if (event) event.preventDefault();
            const rackCode = $('#searchRackInput').val().trim();
            if (!rackCode) return;

            const $resultDiv = $('#rack-api-result');
            const $statusDiv = $('#rack-api-status');
            const $cardElement = $('#rack-api-card');

            $cardElement.hide();
            $statusDiv.html('<div class="alert alert-info"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data rack...</div>').show();
            $resultDiv.show();

            fetch(`/api/wms/rack/${encodeURIComponent(rackCode)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                    return response.json();
                })
                .then(data => {
                    renderRackResult(data, rackCode);
                })
                .catch(err => {
                    console.error(err);
                    $cardElement.hide();
                    $statusDiv.html(`<div class="alert alert-danger">Terjadi kesalahan: ${escapeHtml(err.message)}</div>`).show();
                });
        }

        function searchProduct(event) {
            if (event) event.preventDefault();
            const productCode = $('#searchProductInput').val().trim();
            if (!productCode) return;

            const $resultDiv = $('#product-api-result');
            const $statusDiv = $('#product-api-status');
            const $cardElement = $('#product-api-card');

            $cardElement.hide();
            $statusDiv.html('<div class="alert alert-info"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data barang...</div>').show();
            $resultDiv.show();

            fetch(`/api/wms/product/${encodeURIComponent(productCode)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                    return response.json();
                })
                .then(data => {
                    renderProductResult(data, productCode);
                })
                .catch(err => {
                    console.error(err);
                    $cardElement.hide();
                    $statusDiv.html(`<div class="alert alert-danger">Terjadi kesalahan: ${escapeHtml(err.message)}</div>`).show();
                });
        }
    </script>


@endsection
