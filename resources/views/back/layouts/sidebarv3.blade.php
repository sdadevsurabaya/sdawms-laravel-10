<nav class="sidebar">
    <div class="logo_items flex">
        <span class="nav_image">
            <img src="/images/icon-new-24.ico" alt="logo_img" />
        </span>
        <span class="logo_name">SDA WMS</span>
        <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
        <i class="bx bx-x" id="sidebar-close"></i>
    </div>

    <div class="menu_container">
        <div class="menu_items">
            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title">Dashboard</span>
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="{{ route('admin.dashboard') }}" class="link flex">
                        <i class='bx bxs-dashboard'></i>
                        <span>Overview</span>
                    </a>
                </li>
            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title">Location</span>
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="{{ route('branch.index') }}" class="link flex">
                        <i class='bx bx-vector'></i>
                        <span>Branch</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('warehouse.index') }}" class="link flex">
                        <i class='bx bx-home-circle'></i>
                        <span>Warehouse</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('rack.index') }}" class="link flex">
                        <i class='bx bxs-server'></i>
                        <span>Rack</span>
                    </a>
                </li>
            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title">Item</span>
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="{{ route('item.index') }}" class="link flex">
                        <i class='bx bx-unite' ></i>
                        <span>Items</span>
                    </a>
                </li>
                <li class="item">
                    <a href="#" class="link flex">
                        <i class="bx bx-cog"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar_profile flex">
            <span class="nav_image">
                <img src="/images/300-15.jpg" alt="logo_img" />
            </span>
            <div class="data_text">
                <span class="name">David Oliva</span>
                <span class="email">david@gmail.com</span>
            </div>
        </div>
    </div>
</nav>
