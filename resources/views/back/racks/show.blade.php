@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h4>Detail Rack: {{ $rack->rack_number }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6><strong>Nomor Rack:</strong> {{ $rack->rack_number }}</h6>
                    <h6><strong>Barcode:</strong> {{ $rack->barcode }}</h6>
                    <h6><strong>QR Code:</strong> {{ $rack->qr_code }}</h6>
                </div>
                <div class="col-md-6">
                    <h6><strong>Warehouse:</strong> {{ $rack->warehouse->name }}</h6>
                    <h6><strong>Branch:</strong> {{ $rack->warehouse->branch->name }}</h6>
                </div>
            </div>

            <hr>

            <h5 class="mt-4">Daftar Items dalam Rack</h5>

            @if($rack->items->count())
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Barcode</th>
                                <th>QR Code</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rack->items as $item)
                            <tr>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->barcode }}</td>
                                <td>{{ $item->qr_code }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tidak ada barang dalam rack ini.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('rack.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
