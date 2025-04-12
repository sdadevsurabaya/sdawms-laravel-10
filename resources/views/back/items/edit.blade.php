@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Item</div>
        <div class="card-body">
            <form action="{{ route('item.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label>QR Code</label>
                    <input type="text" name="qr_code" value="{{ $item->qr_code }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Barcode</label>
                    <input type="text" name="barcode" value="{{ $item->barcode }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Rack</label>
                    <select name="rack_id" class="form-control" required>
                        @foreach ($racks as $rack)
                            <option value="{{ $rack->id }}" {{ $item->rack_id == $rack->id ? 'selected' : '' }}>{{ $rack->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-danger">Update</button>
                <a href="{{ route('item.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
