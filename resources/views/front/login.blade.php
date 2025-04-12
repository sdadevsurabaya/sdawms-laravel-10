@extends('front.layouts.layout')

@section('content')
<style>
    body {
        background-image: url('{{ asset("images/login-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
    }
    .login-card {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        max-width: 400px;
        width: 100%;
    }
</style>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card">
        <h3 class="text-center mb-4">SDA</h3>
        <h4 class="text-center mb-4">WMS (WAREHOUSE MANAGEMENT SYSTEMS)</h4>
        <form method="POST" action="#">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-dark w-100" type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
