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
            <div class="col-md-6 mb-2">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="input-group">
                        <input type="text" name="search_rack" class="form-control" placeholder="Cari kode rack..." value="{{ request('search_rack') }}">
                        <button class="btn btn-warning" type="submit">Cari Rack</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 mb-2">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="input-group">
                        <input type="text" name="search_item" class="form-control" placeholder="Cari nama/kode barang..." value="{{ request('search_item') }}">
                        <button class="btn btn-danger" type="submit">Cari Barang</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Rack Result --}}
        @if($racksWithItems->count())
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                <strong>Hasil Pencarian Berdasarkan Rack</strong>
            </div>
            <div class="card-body">
                @foreach($racksWithItems as $rack)
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
        @if($itemsWithRack->count())
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white">
                <strong>Hasil Pencarian Berdasarkan Barang</strong>
            </div>
            <div class="card-body">
                @foreach($itemsWithRack as $item)
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
                                <tr><td colspan="2" class="text-muted">No racks found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @endforeach
            @endforeach
        </div>
    </div>






</div>
@endsection
