<div class="sidebar d-flex flex-column p-3" style="width: 250px;">
    <a href="{{ url('/admin/dashboard') }}" class="mb-3 fs-4 text-center fw-bold d-block">Menu</a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ url('/admin/dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/events') }}" class="nav-link {{ request()->is('admin/events') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Kelola Event
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data User
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/transactions') }}" class="nav-link {{ request()->is('admin/transactions') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/reports') }}" class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Laporan
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link p-0 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>


    </ul>
</div>
