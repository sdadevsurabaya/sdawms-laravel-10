<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDAWMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts - Roboto --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Roboto', sans-serif;
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
