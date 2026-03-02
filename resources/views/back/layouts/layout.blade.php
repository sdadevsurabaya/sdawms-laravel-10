<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    @include('back.layouts.title-meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#8a2432">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SDA WMS">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/images/icon-96.png">
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

    {{-- =========================================================
         GLOBAL LOADING OVERLAY
    ========================================================= --}}
    <div id="global-loading"
        style="
        display:none;
        position:fixed;top:0;left:0;width:100%;height:100%;z-index:99999;
        background:rgba(255,255,255,0.72);backdrop-filter:blur(3px);
        justify-content:center;align-items:center;flex-direction:column;
        gap:12px;
    ">
        <div
            style="
            width:44px;height:44px;
            border:4px solid #e5e7eb;
            border-top-color:#8a2432;
            border-radius:50%;
            animation:gl-spin .7s linear infinite;
        ">
        </div>
        <span id="gl-msg" style="font-size:.85rem;color:#555;font-weight:500;">Memuat...</span>
    </div>
    <style>
        @keyframes gl-spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        /* ----- Global Loading Overlay -----
         * Tampilkan overlay saat:
         * 1. Klik link navigasi (bukan #hash, bukan target=_blank)
         * 2. Submit form (bukan form logout inline yang pakai fetch)
         */
        const GL = document.getElementById('global-loading');
        const GLMsg = document.getElementById('gl-msg');

        function glShow(msg) {
            GLMsg.textContent = msg || 'Memuat...';
            GL.style.display = 'flex';
        }

        function glHide() {
            GL.style.display = 'none';
        }

        // Hide on back/forward navigation
        window.addEventListener('pageshow', glHide);

        document.addEventListener('click', function(e) {
            const a = e.target.closest('a');
            if (!a) return;
            const href = a.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript')) return;
            if (a.target === '_blank') return;
            if (a.dataset.noLoading !== undefined) return;
            glShow('Memuat halaman...');
        });

        document.addEventListener('submit', function(e) {
            const form = e.target;
            // Kecualikan form yang pakai fetch manual (logout) atau yang punya data-no-loading
            if (form.id === 'logout-form' || form.id === 'nav-logout-form' || form.dataset.noLoading !== undefined)
                return;
            glShow('Menyimpan data...');
        });
    </script>

    {{-- ========= PWA: Install Handler + Service Worker ========= --}}
    <script>
        let _pwaPrompt = null;
        const pwaBtn = document.getElementById('pwa-install-btn');

        // Jika sudah running sebagai standalone app → sembunyikan tombol
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
            if (pwaBtn) pwaBtn.classList.add('d-none');
        }

        // Tangkap event beforeinstallprompt SETIAP KALI muncul → simpan
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            _pwaPrompt = e;
            if (pwaBtn) {
                pwaBtn.classList.remove('d-none');
                pwaBtn.classList.add('d-flex');
            }
        });

        // Klik tombol → panggil ulang prompt
        if (pwaBtn) {
            pwaBtn.addEventListener('click', async () => {
                if (!_pwaPrompt) {
                    // Prompt sudah dipakai / tidak tersedia
                    alert('Gunakan menu browser (Add to Home Screen / Install) untuk menginstall app ini.');
                    return;
                }
                _pwaPrompt.prompt();
                const {
                    outcome
                } = await _pwaPrompt.userChoice;
                if (outcome === 'accepted') {
                    pwaBtn.classList.add('d-none');
                    _pwaPrompt = null;
                }
                // Jika ditolak: tombol TETAP MUNCUL → user bisa coba lagi
            });
        }

        // Setelah berhasil diinstall → sembunyikan tombol
        window.addEventListener('appinstalled', () => {
            if (pwaBtn) pwaBtn.classList.add('d-none');
            _pwaPrompt = null;
        });

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
</body>

</html>
