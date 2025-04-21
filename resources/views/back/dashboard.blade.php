@extends('back.layouts.layout')

@section('content')
    <div class="container mt-4">
        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
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
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-bg-warning text-center">
                    <div class="card-body">
                        <h5 class="card-title">Racks</h5>
                        <h2>{{ $rackCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-bg-danger text-center">
                    <div class="card-body">
                        <h5 class="card-title">Items</h5>
                        <h2>{{ $itemCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="input-group">
                        <input type="text" name="search_rack" class="form-control" placeholder="Cari kode rack..."
                            value="{{ request('search_rack') }}">
                        <button class="btn btn-warning" type="submit">Cari Rack</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 mb-2">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="input-group">
                        <input type="text" name="search_item" class="form-control" placeholder="Cari nama/kode barang..."
                            value="{{ request('search_item') }}">
                        <button class="btn btn-danger" type="submit">Cari Barang</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 mb-2">
                <button type="button" onclick="startScann();" class="btn btn-primary w-100">
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

                            function onScanSuccess(decodedText, decodedResult) {
                                // console.log(`Code scanned = ${decodedText}`, decodedResult);
                                // const countResult = document.getElementById("qr-reader-results");
                                countSuccessScan += 1;
                                if (scanCode == decodedText) {
                                    if (countSuccessScan == 12) {
                                        playAudioSuccess();
                                        html5QrcodeScanner.clear();
                                        Swal.fire({
                                            title: decodedText,
                                            text: "Apa anda ingin mencari kode rak / barang ini?",
                                            icon: "warning",
                                            showCancelButton: true,
                                            cancelButtonColor: "#d33",
                                            cancelButtonText: "Tidak",
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "YA"

                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                stopScanning();
                                                window.location.href = "{{ route('admin.dashboard') }}?scancode=" + decodedText;

                                            } else {
                                                countSuccessScan = 0;
                                                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                                            }
                                        });
                                    } else {}
                                } else {
                                    scanCode = decodedText;
                                    countSuccessScan = 1;
                                }
                                // countResult.innerHTML = 'jumlah scan: ' + countSuccessScan;
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
        </div>
    </div>
    <script>
        new DataTable('#warehouse');
    </script>
@endsection
