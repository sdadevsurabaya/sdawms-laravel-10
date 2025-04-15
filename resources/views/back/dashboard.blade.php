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
                <button type="button" data-bs-toggle="modal" data-bs-target="#scannerModal" class="btn btn-primary w-100">
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- <div class="modal-body">
                        <style>
                            #camera video {
                                width: 100%;
                                max-width: 640px;
                            }

                            .error-message {
                                color: red;
                                margin-top: 10px;
                                display: none;
                            }
                        </style>
                        <div id="camera" style="width:100%"></div>
                        <div id="error-message" class="error-message"></div>
                        <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
                        <script>
                            function showError(message) {
                                const errorDiv = document.getElementById("error-message");
                                errorDiv.textContent = message;
                                errorDiv.style.display = "block";
                            }
                            const quaggaConf = {
                                inputStream: {
                                    target: document.querySelector("#camera"),
                                    type: "LiveStream",
                                    constraints: {
                                        width: {
                                            min: 640
                                        },
                                        height: {
                                            min: 480
                                        },
                                        facingMode: "environment",
                                        aspectRatio: {
                                            min: 1,
                                            max: 2
                                        }
                                    }
                                },
                                decoder: {
                                    readers: ['code_128_reader']
                                },
                            }

                            Quagga.init(quaggaConf, function(err) {
                                if (err) {
                                    showError(err);
                                    return console.log(err);
                                }
                                Quagga.start();
                            });

                            Quagga.onDetected(function(result) {
                                alert("Detected barcode: " + result.codeResult.code);
                            });
                        </script>
                    </div> --}}
                    {{-- <div class="modal-body">
                        <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
                        <div id="qr-reader" style="width: 100%"></div>
                        <div id="qr-reader-results"></div>
                        <script>
                            function showResult(message) {
                                const errorDiv = document.getElementById("qr-reader-results");
                                errorDiv.textContent = message;
                            }

                            function onScanSuccess(decodedText, decodedResult) {
                                console.log(`Code scanned = ${decodedText}`, decodedResult);
                                showResult(`Code scanned = ${decodedText}`, decodedResult);
                            }
                            var html5QrcodeScanner = new Html5QrcodeScanner(
                                "qr-reader", {
                                    fps: 10,
                                    qrbox: 250
                                });
                            html5QrcodeScanner.render(onScanSuccess);
                        </script>
                    </div> --}}

                    {{-- <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
                    <div id="qr-reader" style="width: 100%"></div>
                    <div id="qr-reader-results"></div>
                    <script>
                        const scannedCodes = [];

                        function showResult(message) {
                            const resultDiv = document.getElementById("qr-reader-results");
                            resultDiv.textContent = message;
                        }

                        function onScanSuccess(decodedText, decodedResult) {
                            console.log(`Code scanned = ${decodedText}`, decodedResult);

                            // Check if code is already in array
                            if (!scannedCodes.includes(decodedText)) {
                                scannedCodes.push(decodedText);
                                showResult(`Code scanned: ${decodedText}\nUnique codes: ${scannedCodes.join(', ')}`);
                            } else {
                                showResult(`Code already scanned: ${decodedText}\nUnique codes: ${scannedCodes.join(', ')}`);
                            }
                        }

                        var html5QrcodeScanner = new Html5QrcodeScanner(
                            "qr-reader", {
                                fps: 10,
                                qrbox: 250
                            });
                        html5QrcodeScanner.render(onScanSuccess);
                    </script> --}}
                    <div class="modal-body">
                        {{-- <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script> --}}
                        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
                        <div id="qr-reader" style="width: 100%;height: 50%;"></div>
                        <div id="qr-reader-results">
                            <ul id="scanned-codes-list"></ul>
                        </div>
                        <script>
                            const scannedCodes = [];

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
                                console.log(`Code scanned = ${decodedText}`, decodedResult);

                                // Check if code is already in array
                                if (!scannedCodes.includes(decodedText)) {
                                    scannedCodes.push(decodedText);
                                    updateResultList(`Code scanned: ${decodedText}`);
                                } else {
                                    updateResultList(`Code already scanned: ${decodedText}`);
                                }
                            }

                            var html5QrcodeScanner = new Html5QrcodeScanner(
                                "qr-reader", {
                                    fps: 10,
                                    qrbox: {width: 300, height: 120},
                                    // qrbox: 200,
                                    aspectRatio: 1.5,
                                });
                            html5QrcodeScanner.render(onScanSuccess);
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
            <div class="card-body table-responsive">
                @foreach ($branches as $branch)
                    <h5 class="mt-3 text-primary">{{ $branch->name }}</h5>
                    @foreach ($branch->warehouses as $warehouse)
                        <h6 class="ms-3 text-success">Warehouse: {{ $warehouse->name }}</h6>
                        <table class="table table-bordered table-sm ms-4">
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
                    @endforeach
                @endforeach
            </div>
        </div>






    </div>
@endsection
