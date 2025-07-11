<div class="container p-3 bg-lg-white">
    <div class="d-flex justify-content-between align-items-center my-0 my-lg-4">
        <i class="bx bx-menu" id="sidebar-open"></i>
        <h3 class="text-dark d-none d-lg-block mb-0">Dashboards</h3>
        <div class="d-flex justify-content-end w-lg-25 w-50">
            <button onclick="event.preventDefault();btnSubmit();" class="btn btn-danger">
                <i class='bx bx-log-out'></i>
                <span>Logout</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <script>
                function btnSubmit() {
                    fetch('/refresh-csrf')
                        .then(response => response.json())
                        .then(data => {
                            document.querySelector('input[name="_token"]').value = data.csrfToken;
                            document.getElementById('logout-form').submit();
                        });
                }
            </script>
            {{-- <input type="text" class="form-control" placeholder="Search product...">
            <span class="input-group-text"><i class="fas fa-search"></i></span> --}}
        </div>
    </div>
    {{-- <div class="navbar d-flex">
        <i class="bx bx-menu" id="sidebar-open"></i>
        <input type="text" placeholder="Search..." class="search_box" />
        <span class="nav_image">
            <img src="/images/300-1.jpg" alt="logo_img" />
        </span>
    </div> --}}


</div>
