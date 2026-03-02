@extends('front.layouts.layout')

@section('content')
    <style>
        body {
            background-image: url('{{ asset('images/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            /* min-height: 100vh; */
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
    </style>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="login-card">
            <div class="text-center mb-3">
                <img src="/images/sda.svg" alt="logo" width="250px">
            </div>
            <h4 class="text-center mb-4">WAREHOUSE MANAGEMENT SYSTEMS</h4>
            <form method="POST" action="{{ route('submit.login') }}">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger py-2 text-center small">{{ session('error') }}</div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                        value="{{ old('username') }}" required autofocus autocomplete="username">
                    @error('username')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required
                        autocomplete="current-password">
                </div>
                <button class="btn btn-dark w-100" type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
