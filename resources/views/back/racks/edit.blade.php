@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Rack</div>
        <div class="card-body">
            <form action="{{ route('rack.update', $rack->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Rack Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $rack->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Warehouse</label>
                    <select name="warehouse_id" class="form-control" required>
                        @foreach ($warehouses as $wh)
                            <option value="{{ $wh->id }}" {{ $rack->warehouse_id == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-danger">Update</button>
                <a href="{{ route('rack.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
