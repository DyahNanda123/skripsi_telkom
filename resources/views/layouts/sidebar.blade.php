<div class="sidebar">
    {{-- <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div> --}}

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            
            {{-- <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>Profile</p>
                </a>
            </li> --}}

            <li class="nav-header">Data Master</li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Data Karyawan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/calon-pelanggan') }}" class="nav-link {{ $activeMenu == 'calon_pelanggan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Calon Pelanggan</p>
                </a>
            </li>

            <li class="nav-header">Operasional Sales</li>
            <li class="nav-item">
                <a href="{{ url('/kunjungan') }}" class="nav-link {{ $activeMenu == 'kunjungan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-route"></i>
                    <p>Data Kunjungan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/target-sales') }}" class="nav-link {{ $activeMenu == 'target_sales' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bullseye"></i>
                    <p>Target Sales</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/strategi-promosi') }}" class="nav-link {{ $activeMenu == 'strategi_promosi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bullhorn"></i>
                    <p>Strategi Promosi</p>
                </a>
            </li>

            <li class="nav-header">Pengaturan</li>
            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                    <p class="text">Logout</p>
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
                </form>
            </li>
            
        </ul>
    </nav>
</div>