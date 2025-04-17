<aside id="sidebar" class="expand">
    <div class="d-flex ms-auto">
        <div class="sidebar-logo">
            <a href="#" class="text-decoration-none mx-auto">SDA WMS</a>
        </div>
        <button class="toggle-btn ms-3" type="button">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>


    <div class="offcanvas-header d-block text-center text-light position-relative py-4">
        <div class="position-relative d-inline-block mb-1">
            <img src="/images/300-1.jpg" class="img-thumbnail rounded-circle border-0 bg-dark" width="66"
                alt="" style="padding:.35rem;">
        </div>
        <div class="sidebar-title">
            <h5 class="offcanvas-title" id="sidebar-logo">Web Developer </h5>
            <p class="mb-0 small text-light">
                Administrator ID
            </p>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link text-decoration-none">
                {{-- <i class="fas fa-search"></i> --}}
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('branch.index') }}" class="sidebar-link text-decoration-none">
                <i class="fa-solid fa-sitemap"></i>
                <span>Branches</span>
            </a>
            </a> <!-- Link ke halaman Branch -->
        </li>

        <li class="sidebar-item">
            <a href="{{ route('warehouse.index') }}" class="sidebar-link text-decoration-none">
                <i class="fa-solid fa-warehouse"></i>
                <span>Warehouses</span>
            </a>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('rack.index') }}" class="sidebar-link text-decoration-none">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Racks</span>
            </a>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('item.index') }}" class="sidebar-link text-decoration-none">
                <i class="fa-solid fa-toolbox"></i>
                <span>Items</span>
            </a>
            </a>
        </li>

        {{-- <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <i class="lni lni-protection"></i>
                <span>Auth</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Login</a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Register</a>
                </li>
            </ul>
        </li> --}}
        {{-- <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="lni lni-layout"></i>
                <span>Multi Level</span>
            </a>
            <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                        data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                        Two Links
                    </a>
                    <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 2</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> --}}
    </ul>
    <div class="sidebar-footer">
        <a href="#" class="sidebar-link text-decoration-none">
            <i class="fa-solid fa-circle-arrow-left"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
