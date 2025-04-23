<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDAWMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            /* min-height: 100vh; */
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        main {
            flex: 1;
        }
        .navbar, .footer {
            background-color: #212529; /* dark grey */
        }
        .navbar-brand, .footer {
            color: #fff;
        }
        .card-header {
            background-color: #c82333; /* red tone */
        }
        .bg-primary {
            background-color: #c82333 !important;
        }
        .btn-primary {
            background-color: #c82333;
            border-color: #c82333;
        }
        .btn-primary:hover {
            background-color: #a71d2a;
            border-color: #a71d2a;
        }
    </style>
</head>
<body>

    @include('front.layouts.header')

    <main class="container">
        @yield('content')
    </main>

    @include('front.layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
