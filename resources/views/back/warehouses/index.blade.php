@extends('back.layouts.layout')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Warehouse List</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('warehouse.create') }}" class="btn btn-danger mb-3">+ Add Warehouse</a>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Warehouse Name</th>
                        <th>Address</th>
                        <th>Branch</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($warehouses as $warehouse)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->address }}</td>
                        <td>{{ $warehouse->branch->name }}</td>
                        <td>
                            <a href="{{ route('warehouse.edit', $warehouse->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('warehouse.destroy', $warehouse->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this warehouse?')">
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
