@if (session('impersonator_id'))
    <div class="impersonation-banner d-flex align-items-center justify-content-between px-3 py-1">
        <span>
            <i class="bx bx-transfer-alt me-1"></i>
            Anda sedang login sebagai <strong>{{ Auth::user()->name }}</strong>
        </span>
        <form action="{{ route('users.leave-impersonation') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-light fw-semibold">
                <i class="bx bx-arrow-back me-1"></i>Kembali ke Admin
            </button>
        </form>
    </div>
@endif

<div class="navtop-bar d-flex align-items-center justify-content-between px-3 py-2">

    {{-- Kiri: tombol toggle sidebar --}}
    <div class="d-flex align-items-center gap-2">
        <i class="bx bx-menu fs-4 nav-toggle-btn" id="sidebar-open" style="cursor:pointer;"></i>
    </div>

    {{-- Tengah: Install PWA button (muncul jika bisa diinstall) --}}
    <button id="pwa-install-btn" class="btn btn-sm d-none align-items-center gap-1 pwa-install-btn"
        title="Install sebagai App">
        <i class="bx bx-download"></i>
        <span class="d-none d-sm-inline">Install App</span>
    </button>

    {{-- Kanan: profil user + dropdown --}}
    @auth
        <div class="dropdown">
            <button class="btn d-flex align-items-center gap-2 py-1 px-2 rounded-3 nav-profile-btn" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-avatar d-flex align-items-center justify-content-center rounded-circle bg-danger text-white fw-bold"
                    style="width:34px;height:34px;font-size:.85rem;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="d-none d-md-block text-start lh-sm">
                    <div class="fw-semibold"
                        style="font-size:.85rem;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-muted" style="font-size:.72rem;">
                        @if ((int) Auth::user()->role_id === 1)
                            <span class="badge bg-danger" style="font-size:.65rem;">Admin</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.65rem;">Gudang</span>
                        @endif
                    </div>
                </div>
                <i class="bx bx-chevron-down text-muted d-none d-md-block"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width:210px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-semibold" style="font-size:.88rem;">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size:.78rem;">{{ Auth::user()->email }}</div>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#"
                        onclick="event.preventDefault();navLogout();">
                        <i class="bx bx-log-out"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    @endauth

    <form id="nav-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

<script>
    function navLogout() {
        fetch('/refresh-csrf')
            .then(r => r.json())
            .then(data => {
                document.getElementById('nav-logout-form').querySelector('input[name="_token"]').value = data
                    .csrfToken;
                document.getElementById('nav-logout-form').submit();
            });
    }
</script>
