@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">List of Items</div>
        <div class="card-body">
            <a href="{{ route('item.create') }}" class="btn btn-danger mb-3">+ Add Item</a>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Rack</th>
                        <th>QR Code</th>
                        <th>Barcode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->rack->name }}</td>
                            <td>{{ $item->qr_code }}</td>
                            <td>{{ $item->barcode }}</td>
                            <td>
                                <a href="{{ route('item.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('item.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
