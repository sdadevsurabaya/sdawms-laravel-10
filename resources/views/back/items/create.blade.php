@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add Item</div>
        <div class="card-body">
            <form action="{{ route('item.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>QR Code</label>
                    <input type="text" name="qr_code" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Barcode</label>
                    <input type="text" name="barcode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Rack</label>
                    <select name="rack_id" class="form-control" required>
                        @foreach ($racks as $rack)
                            <option value="{{ $rack->id }}">{{ $rack->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-danger">Save</button>
                <a href="{{ route('item.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
