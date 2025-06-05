@extends('back.layouts.layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">List of Racks</div>
            <div class="card-body">
                <a href="{{ route('rack.create') }}" class="btn btn-danger mb-3"><i class='bx bx-message-square-add'></i> Add Rack</a>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table id="rack" class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                <th>Rack Name</th>
                                <th>Warehouse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($racks as $rack)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rack->rack_number }}</td>
                                    <td>{{ $rack->warehouse->name }}</td>
                                    <td>

                                        <a href="{{ route('rack.show', $rack->id) }}" class="btn btn-sm mb-2 btn-info"><i class="fa-solid fa-circle-info"></i></i></a>
                                        <a href="{{ route('rack.edit', $rack->id) }}"
                                            class="btn btn-warning btn-sm mb-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('rack.destroy', $rack->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this rack?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm mb-2"><i class="fa-solid fa-trash"></i></button>
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
        new DataTable('#rack');
    </script>
@endsection
