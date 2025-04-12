@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Warehouse</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $warehouse->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $warehouse->address) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Branch</label>
                    <select name="branch_id" class="form-control" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $warehouse->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">Update</button>
                <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
