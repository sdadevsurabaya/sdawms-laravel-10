<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    @include('back.layouts.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- font awesome icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap5.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- datatables --}}
    <script src="/assets/js/dataTables.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.js"></script>


</head>

<body>
    @include('back.layouts.header')

    <div class="wrapper">
        @include('back.layouts.sidebarv3')

        <div class="content-wrapper">
            @include('back.layouts.navtop')

            <main>
                @yield('content')
            </main>

            @include('back.layouts.footer')
        </div>
    </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Selecting the sidebar and buttons
        const sidebar = document.querySelector(".sidebar");
        const sidebarOpenBtn = document.querySelector("#sidebar-open");
        const sidebarCloseBtn = document.querySelector("#sidebar-close");
        const sidebarLockBtn = document.querySelector("#lock-icon");

        // Function to toggle the lock state of the sidebar
        const toggleLock = () => {
            sidebar.classList.toggle("locked");
            // If the sidebar is not locked
            if (!sidebar.classList.contains("locked")) {
                sidebar.classList.add("hoverable");
                sidebarLockBtn.classList.replace("bx-lock-alt", "bx-lock-open-alt");
            } else {
                sidebar.classList.remove("hoverable");
                sidebarLockBtn.classList.replace("bx-lock-open-alt", "bx-lock-alt");
            }
        };

        // Function to hide the sidebar when the mouse leaves
        const hideSidebar = () => {
            if (sidebar.classList.contains("hoverable")) {
                sidebar.classList.add("close");
            }
        };

        // Function to show the sidebar when the mouse enter
        const showSidebar = () => {
            if (sidebar.classList.contains("hoverable")) {
                sidebar.classList.remove("close");
            }
        };

        // Function to show and hide the sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle("close");
        };

        // If the window width is less than 800px, close the sidebar and remove hoverability and lock
        if (window.innerWidth < 800) {
            sidebar.classList.add("close");
            sidebar.classList.remove("locked");
            sidebar.classList.remove("hoverable");
        }

        // Adding event listeners to buttons and sidebar for the corresponding actions
        sidebarLockBtn.addEventListener("click", toggleLock);
        sidebar.addEventListener("mouseleave", hideSidebar);
        sidebar.addEventListener("mouseenter", showSidebar);
        sidebarOpenBtn.addEventListener("click", toggleSidebar);
        sidebarCloseBtn.addEventListener("click", toggleSidebar);
    </script>
</body>

</html>
