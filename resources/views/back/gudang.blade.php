<h1>DASHBOARD GUDANG</h1>
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
                document.querySelector(`input[name="_token"]`).value = data.csrfToken;
                document.getElementById("logout-form").submit();
            });
    }
</script>
