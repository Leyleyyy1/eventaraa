<div class="sidebar d-flex flex-column p-3 shadow"
     style="width: 250px; background-color: #ffffff; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000;">

    <!-- Logo dan Nama -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo Eventara" style="width: 60px; height: auto;">
        <h5 class="mt-2" style="color: #5C4A28; font-weight: bold;">Eventara</h5>
    </div>

    <!-- Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ url('/admin/dashboard') }}"
               class="nav-link {{ request()->is('admin/dashboard') ? 'active-custom' : '' }}">
                <i class="bi bi-speedometer2 me-2 icon-brown"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/events') }}"
               class="nav-link {{ request()->is('admin/events') ? 'active-custom' : '' }}">
                <i class="bi bi-calendar-event me-2 icon-brown"></i> Kelola Event
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/transactions') }}"
               class="nav-link {{ request()->is('admin/transactions') ? 'active-custom' : '' }}">
                <i class="bi bi-receipt me-2 icon-brown"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/profile') }}"
               class="nav-link {{ request()->is('admin/profile') ? 'active-custom' : '' }}">
                <i class="bi bi-person-circle me-2 icon-brown"></i> Profil
            </a>
        </li>

        <!-- Logout Link -->
        <li>
            <a href="#" id="logout-button" class="nav-link">
                <i class="bi bi-box-arrow-right me-2 icon-brown"></i> Logout
            </a>
            <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<!-- Styling -->
<style>
    .nav-link {
        color: #5C4A28 !important;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .nav-link:hover {
        background-color: #EFE9DC;
        color: #3B2C12 !important;
    }

    .active-custom {
        background-color: #E7DDD0;
        color: #3B2C12 !important;
        font-weight: 600;
    }

    .icon-brown {
        color: #7B5E2A;
    }
</style>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Logout Script -->
<script>
    document.getElementById('logout-button').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Kamu akan keluar dari akun admin.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
