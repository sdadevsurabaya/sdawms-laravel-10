@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add Rack</div>
        <div class="card-body">
            <form action="{{ route('rack.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Rack Name</label>
                    <input type="text" name="rack_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Warehouse</label>
                    <select name="warehouse_id" class="form-control" required>
                        @foreach ($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-danger">Save</button>
                <a href="{{ route('rack.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
