@extends('back.layouts.layout')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-group fs-5"></i>
                    <span class="fw-semibold">Manajemen User</span>
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-danger btn-sm">
                    <i class="bx bx-user-plus me-1"></i>Tambah User
                </a>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bx bx-check-circle me-1"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bx bx-error-circle me-1"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="user-table" class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ((int) $user->role_id === 1)
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Gudang</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-light text-secondary border">Anda</span>
                                        @endif
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
        new DataTable('#user-table');
    </script>
@endsection
