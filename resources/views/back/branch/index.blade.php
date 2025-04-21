@extends('back.layouts.layout')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Branch List</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('branch.create') }}" class="btn btn-danger mb-3"><i class='bx bx-message-square-add'></i> Add Branch</a>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table id="branch" class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Branch Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td>{{ $branch->phone }}</td>
                                    <td>
                                        <a href="{{ route('branch.edit', $branch->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('branch.destroy', $branch->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this branch?')">
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
    </div>
    <script>
        new DataTable('#branch');
    </script>
@endsection
