@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Add Warehouse</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Branch</label>
                    <select name="branch_id" class="form-control" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">Save</button>
                <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
