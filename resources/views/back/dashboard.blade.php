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
                                    <td>{{ $rack->name }}</td>
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
