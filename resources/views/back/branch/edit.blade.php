@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Branch</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('branch.update', $branch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Branch Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $branch->address) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}">
                </div>

                <button type="submit" class="btn btn-danger">Update</button>
                <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
