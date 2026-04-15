<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
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

        {{--mengatur notifikasi mjd 2 bagian yaitu sudah terbaca dan belum terbaca--}}
        @php
            $notifBelumDibaca = collect();
            $notifSudahDibaca = collect();
            
            if(auth()->check()){
                // 1. Ambil yang BELUM dibaca
                $notifBelumDibaca = \App\Models\Notifikasi::where('user_id', auth()->id())
                                                    ->where('is_read', 0)
                                                    ->latest()
                                                    ->get();

                // 2. Ambil SEMUA yang SUDAH dibaca (maksimal 7 hari terakhir)
                $notifSudahDibaca = \App\Models\Notifikasi::where('user_id', auth()->id())
                                                    ->where('is_read', 1)
                                                    ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))
                                                    ->latest()
                                                    ->get(); // Hapus take(5) biar kerikues semua
            }
            $totalNotifBaru = $notifBelumDibaca->count();
        @endphp

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                <i class="fas fa-bell" style="font-size: 1.4rem; color: #555;"></i>
                @if($totalNotifBaru > 0)
                    <span class="badge badge-warning navbar-badge" style="position: absolute; top: 4px; right: 2px; font-size: 0.6rem; font-weight: bold;">
                        {{ $totalNotifBaru }}
                    </span>
                @endif
            </a>
            
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg" style="min-width: 320px;">
                <span class="dropdown-item dropdown-header font-weight-bold text-left bg-light">
                    <i class="fas fa-envelope mr-1"></i> Belum Dibaca ({{ $totalNotifBaru }})
                </span>
                <div class="dropdown-divider"></div>
                
                @forelse($notifBelumDibaca as $notif)
                    <a href="{{ url('/notifikasi/baca/' . $notif->id) }}" class="dropdown-item" style="white-space: normal; background-color: #fff9e6;">
                        <div class="media">
                            <i class="fas fa-circle text-warning mt-2 mr-2" style="font-size: 10px;"></i>
                            <div class="media-body">
                                <span class="text-sm font-weight-bold text-dark">{{ $notif->judul }}</span>
                                <p class="text-sm text-muted mb-0">{{ Str::limit($notif->pesan, 60) }}</p>
                                <small class="text-muted"><i class="far fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <div class="dropdown-item text-center text-muted py-2 small">Tidak ada notifikasi baru</div>
                    <div class="dropdown-divider"></div>
                @endforelse

                <span class="dropdown-item dropdown-header font-weight-bold text-left bg-light">
                    <i class="fas fa-history mr-1"></i> Riwayat (7 Hari)
                </span>
                <div class="dropdown-divider"></div>

                @forelse($notifSudahDibaca as $index => $notif)
                  {{--menampilkan 2 notif, jika lebih klik selengkapnya--}}
                    <div class="item-riwayat {{ $index >= 2 ? 'd-none riwayat-tersembunyi' : '' }}">
                        <a href="{{ $notif->url ?? '#' }}" class="dropdown-item" style="white-space: normal; opacity: 0.7;">
                            <div class="media">
                                <i class="fas fa-check-double text-secondary mt-2 mr-2" style="font-size: 10px;"></i>
                                <div class="media-body">
                                    <span class="text-sm text-dark">{{ $notif->judul }}</span>
                                    <p class="text-sm text-muted mb-0">{{ Str::limit($notif->pesan, 50) }}</p>
                                    <small class="text-muted">{{ $notif->created_at->translatedFormat('d M H:i') }}</small>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                @empty
                    <div class="dropdown-item text-center text-muted py-2 small">Belum ada riwayat</div>
                    <div class="dropdown-divider"></div>
                @endforelse

                {{-- Tombol Lihat Semua muncul HANYA JIKA riwayatnya lebih dari 2 --}}
                @if($notifSudahDibaca->count() > 2)
                    <a href="#" id="btnToggleRiwayat" class="dropdown-item dropdown-footer font-weight-bold text-primary text-center" onclick="bukaRiwayat(event)">Lihat Semua Riwayat</a>
                @endif
            </div>
        </li>
      
        <script>
            function bukaRiwayat(e) {
                e.preventDefault(); 
                e.stopPropagation(); /

                let elemenTersembunyi = document.querySelectorAll('.riwayat-tersembunyi');
                let tombol = document.getElementById('btnToggleRiwayat');

                elemenTersembunyi.forEach(function(item) {
                    item.classList.toggle('d-none');
                });

                if (tombol.innerText === 'Lihat Semua Riwayat') {
                    tombol.innerText = 'Sembunyikan Riwayat';
                } else {
                    tombol.innerText = 'Lihat Semua Riwayat';
                }
            }
        </script>

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