@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="vh-100 d-flex align-items-center position-relative" style="background: url('{{ asset('images/tarii.png') }}') center center / cover no-repeat;">
    
    <!-- Overlay gradasi -->
    <div style="
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(162, 140, 74, 0.5), rgba(36, 30, 1, 0.5));
        z-index: 1;
    "></div>

    <!-- Konten hero -->
    <div class="container text-center text-white position-relative" style="z-index: 2;">
        <h1 class="fw-bold display-5 mb-3">Temukan Makna dan Cerita di <br> Balik Setiap Perayaan Budaya.</h1>
        <p class="lead">Mulai perjalanan budaya kamu dengan pesan tiket mudah secara online.</p>
    </div>
</section>


<!-- Upcoming Events -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Upcoming Events</h2>



    </div>
</section>
<!-- Buat Event Section -->
<section class="py-5" style="background-color: #4b2e18;">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between text-white">
        <div class="mb-4 mb-md-0">
            <img src="{{ asset('images/gambar1.png') }}" alt="Buat Event" class="img-fluid" style="max-height: 400px;">
        </div>
        <div class="text-md-start text-center ms-md-5">
            <h3 class="fw-bold mb-3">Buat Event</h3>
            <p class="mb-4">Kamu bisa mendaftar sebagai penyelenggara event kebudayaan.</p>
            <a href="{{ route('admin.register') }}" class="btn btn-warning text-white fw-bold px-4 py-2">Create Events</a>

        </div>
    </div>
</section>
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 100) {
            navbar.style.background = 'linear-gradient(to right, rgba(162, 140, 74, 0.9), rgba(36, 30, 1, 0.9))';
        } else {
            navbar.style.background = 'linear-gradient(to right, rgba(162, 140, 74, 0.0), rgba(36, 30, 1, 0.0))';
        }
    });
</script>

@endsection
