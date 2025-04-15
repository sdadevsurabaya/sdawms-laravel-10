<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    @include('back.layouts.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background-image: url('{{ asset("images/login-bg.jpg") }}');
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            min-height: 0;
        }

        .sidebar {
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 1rem;
        }

        footer {
            background-color: #212529;
            color: white;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                order: 1;
            }

            .content-wrapper {
                order: 2;
                width: 100%;
            }
        }

        @media (min-width: 769px) {
            .sidebar {
                width: 250px;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>

    @include('back.layouts.header')

    <div class="wrapper">
        @include('back.layouts.sidebar')

        <div class="content-wrapper">
            @include('back.layouts.navtop')

            <main>
                @yield('content')
            </main>

            @include('back.layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
