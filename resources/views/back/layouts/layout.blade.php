<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    @include('back.layouts.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- font awesome icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- <link rel="stylesheet" href="css/custom.css"> --}}
    {{-- <link rel="stylesheet" href="/assets/css/custom.css"> --}}
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>

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
