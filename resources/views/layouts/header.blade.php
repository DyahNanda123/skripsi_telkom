<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            {{-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a> --}}
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        {{-- <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline font-weight-bold">
                    {{ auth()->check() ? strtoupper(auth()->user()->role) : 'ADMIN' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-danger">
                    <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    <p>
                        {{ auth()->check() ? auth()->user()->nama_lengkap : 'Pengguna Telkom' }}
                        <small>{{ auth()->check() ? strtoupper(auth()->user()->role) : 'ADMIN' }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">
                        <i class="fas fa-user-cog"></i> Profil
                    </a>
                    <a href="{{ url('logout') }}" class="btn btn-default btn-flat float-right text-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ (auth()->check() && auth()->user()->foto_profil) ? asset('storage/' . auth()->user()->foto_profil) : asset('adminlte/dist/img/user2-160x160.jpg') }}" 
                     class="user-image img-circle elevation-2" alt="Foto Profil" style="object-fit: cover;">
                
                <span class="d-none d-md-inline font-weight-bold">
                    {{ auth()->check() ? strtoupper(auth()->user()->role) : 'GUEST' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-danger">
                    <img src="{{ (auth()->check() && auth()->user()->foto_profil) ? asset('storage/' . auth()->user()->foto_profil) : asset('adminlte/dist/img/user2-160x160.jpg') }}" 
                         class="img-circle elevation-2" alt="Foto Profil" style="object-fit: cover;">
                    <p>
                        {{ auth()->check() ? auth()->user()->nama_lengkap : 'Pengguna Belum Login' }}
                        <small>{{ auth()->check() ? strtoupper(auth()->user()->role) : 'GUEST' }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">
                        <i class="fas fa-user-cog"></i> Profil
                    </a>
                    <a href="{{ url('logout') }}" class="btn btn-default btn-flat float-right text-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>