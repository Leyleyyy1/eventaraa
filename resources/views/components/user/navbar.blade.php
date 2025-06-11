<nav id="navbar" class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" style="background: linear-gradient(to right, rgba(162, 140, 74, 0.0), rgba(36, 30, 1, 0.0)); transition: background 0.3s ease;">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Eventara" width="30" height="30" class="d-inline-block align-text-top">
            Eventara
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light me-2" href="{{ route('user.login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn text-white" style="background-color: #8B5E3C;" href="{{ url('user/register') }}">Register</a>



                </li>
            </ul>
        </div>
    </div>
</nav>
