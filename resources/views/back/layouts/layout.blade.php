<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    @include('back.layouts.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- font awesome icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    {{-- sidebar --}}
    {{-- <link rel="stylesheet" href="/assets/css/sidebar.css"> --}}
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/main_sidebar.css">
    <script src="/assets/js/jquery-3.7.1.min.js.js"></script>
    {{-- <script href="/assets/js/main_sidebar.js"></script> --}}
</head>

<body>

    @include('back.layouts.header')

    <div class="wrapper">
        @include('back.layouts.sidebarv2')

        <div class="content-wrapper">
            @include('back.layouts.navtop')

            <main>
                @yield('content')
            </main>

            @include('back.layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script href="/assets/js/sidebar.js"></script>
    <script href="/assets/js/script.js"></script> --}}
    <script>
        const hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function() {
            document.querySelector("#sidebar").classList.toggle("expand");
        });


        // let arrow = document.querySelectorAll(".arrow");
        // for (var i = 0; i < arrow.length; i++) {
        //     arrow[i].addEventListener("click", (e) => {
        //         let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        //         arrowParent.classList.toggle("showMenu");
        //     });
        // }

        // let sidebar = document.querySelector(".sidebar");
        // let sidebarBtn = document.querySelector(".fa-bars");
        // console.log(sidebarBtn);
        // sidebarBtn.addEventListener("click", () => {
        //     sidebar.classList.toggle("close");
        // });
    </script>
</body>

</html>
