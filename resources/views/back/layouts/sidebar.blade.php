<div class="sidebar d-none d-lg-block">
    <div class="offcanvas-header d-block text-center position-relative py-4">
        <div class="position-relative d-inline-block mb-1">
            <img src="/images/300-1.jpg" class="img-thumbnail rounded-circle border-0 bg-dark" width="66" alt=""
                style="padding:.35rem;">
        </div>

        <h5 class="offcanvas-title" id="sidebarLabel">Web Developer </h5>
        <p class="mb-0 small text-secondary">
            Administrator ID
        </p>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-1 d-lg-none" data-bs-dismiss="offcanvas"
            data-bs-target="#sidebar" aria-label="Close"></button>
    </div>
    <ul class="metismenu list-unstyled mm-show">
        <li class="menu-list px-0">
            <a href="{{ route('admin.dashboard') }}">
                {{-- <i class="fas fa-search"></i> --}}
                <i class="fa-solid fa-table-cells-large"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-list px-0">
            <a href="{{ route('branch.index') }}">
                <i class="fa-solid fa-sitemap"></i>
                <span>Branches</span>
            </a> <!-- Link ke halaman Branch -->
        </li>
        <li class="menu-list px-0">
            <a href="{{ route('warehouse.index') }}">
                <i class="fa-solid fa-warehouse"></i>
                <span>Warehouses</span>
            </a>
        </li>
        <li class="menu-list px-0">
            <a href="{{ route('rack.index') }}">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Racks</span>
            </a>
        </li>
        <li class="menu-list px-0">
            <a href="{{ route('item.index') }}">
                <i class="fa-solid fa-toolbox"></i>
                <span>Items</span>
            </a>
        </li>
    </ul>
</div>
