<div class="sidebar">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('branch.index') }}">Branches</a> <!-- Link ke halaman Branch -->
    <a href="{{ route('warehouse.index') }}">Warehouses</a>
    <a href="{{ route('rack.index') }}">Racks</a>
    <a href="{{ route('item.index') }}">Items</a>
    <a href="#" onclick="event.preventDefault();btnSubmit();">
        Logout
    </a>
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
</div>
