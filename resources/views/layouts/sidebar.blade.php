<div class="sidebar">
    
    <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-header">Data Master</li>

                @if(auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ url('/pengguna') }}" class="nav-link {{ $activeMenu == 'pengguna' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>
                @endif
                
            <li class="nav-item">
                <a href="{{ url('/calon_pelanggan') }}" class="nav-link {{ $activeMenu == 'calon_pelanggan' ? 'active' : '' }}">
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
                <a href="{{ url('/strategi-target') }}" class="nav-link {{ $activeMenu == 'strategi_target' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>Strategi dan Target</p>
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