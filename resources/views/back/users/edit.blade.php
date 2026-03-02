@extends('back.layouts.layout')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center gap-2">
                        <i class="bx bx-edit fs-5"></i>
                        <span class="fw-semibold">Edit User: {{ $user->name }}</span>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                    <option value="1" {{ old('role_id', $user->role_id) == '1' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="2" {{ old('role_id', $user->role_id) == '2' ? 'selected' : '' }}>
                                        Gudang</option>
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <p class="text-muted small mb-3"><i class="bx bx-info-circle me-1"></i>Biarkan password kosong
                                jika tidak ingin mengubah password.</p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter (kosongkan jika tidak diubah)">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ulangi password baru">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-save me-1"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i>Kembali
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
