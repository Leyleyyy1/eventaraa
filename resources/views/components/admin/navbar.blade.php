<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold""></span>

        <div class="d-flex align-items-center">
            <span class="me-3">Hi, {{ Auth::guard('admin')->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name) }}&background=F4A825&color=fff" alt="Admin Avatar" class="rounded-circle" width="40" height="40">

        </div>
    </div>
</nav>
