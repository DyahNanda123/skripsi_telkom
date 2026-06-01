<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
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

        {{-- ============================================================
             NOTIFIKASI
             Query diletakkan di sini (di header/navbar) karena komponen
             ini di-include di semua halaman via layouts/template.blade.php
             ============================================================ --}}
        @php
            $notifBelumDibaca = collect();
            $notifSudahDibaca = collect();

            if (auth()->check()) {
                $notifBelumDibaca = \App\Models\Notifikasi::where('user_id', auth()->id())
                    ->where('is_read', 0)
                    ->latest()
                    ->get();

                $notifSudahDibaca = \App\Models\Notifikasi::where('user_id', auth()->id())
                    ->where('is_read', 1)
                    ->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(7))
                    ->latest('updated_at')
                    ->get();
            }

            $totalNotifBaru = $notifBelumDibaca->count();
        @endphp

        <li class="nav-item dropdown">

            {{-- Ikon bel --}}
            <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                <i class="fas fa-bell" style="font-size: 1.4rem; color: #555;"></i>
                @if($totalNotifBaru > 0)
                    <span class="badge badge-warning navbar-badge" id="badge-notif"
                          style="position: absolute; top: 4px; right: 2px; font-size: 0.6rem; font-weight: bold;">
                        {{ $totalNotifBaru }}
                    </span>
                @endif
            </a>

            {{-- Dropdown notifikasi --}}
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg"
                 style="min-width: 320px; max-width: 340px; padding: 0; overflow: hidden;">

                {{-- ── HEADER: judul + tombol tandai semua (sticky atas) ── --}}
                <div style="position: sticky; top: 0; z-index: 10;
                            background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <div class="d-flex justify-content-between align-items-center px-3 py-2">
                        <span class="font-weight-bold text-dark" style="font-size: 0.85rem;">
                            <i class="fas fa-envelope mr-1"></i>
                            Belum Dibaca
                            <span id="label-jumlah-notif">({{ $totalNotifBaru }})</span>
                        </span>

                        @if($totalNotifBaru > 0)
                            <button id="btn-tandai-semua"
                                    onclick="tandaiSemuaDibaca(event)"
                                    class="btn btn-xs btn-outline-warning"
                                    style="font-size: 0.72rem; padding: 2px 8px;
                                           border-radius: 20px; white-space: nowrap;">
                                <i class="fas fa-check-double mr-1"></i> Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>
                </div>

                {{-- ── SCROLL AREA: semua isi notifikasi ada di sini ── --}}
                <div id="notif-scroll-area"
                     style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">

                    {{-- List notif BELUM DIBACA --}}
                    <div id="list-belum-dibaca">
                        @forelse($notifBelumDibaca as $notif)
                            <a href="{{ route('notifikasi.baca', $notif->id) }}"
                               class="dropdown-item"
                               data-id="{{ $notif->id }}"
                               style="white-space: normal; background-color: #fff9e6;">
                                <div class="media">
                                    <i class="fas fa-circle text-warning mt-2 mr-2"
                                       style="font-size: 10px;"></i>
                                    <div class="media-body">
                                        <span class="text-sm font-weight-bold text-dark">
                                            {{ $notif->judul }}
                                        </span>
                                        <p class="text-sm text-muted mb-0">
                                            {{ Str::limit($notif->pesan, 60) }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $notif->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider" style="margin: 0;"></div>
                        @empty
                            <div id="notif-kosong-msg"
                                 class="dropdown-item text-center text-muted py-2 small">
                                Tidak ada notifikasi baru
                            </div>
                            <div class="dropdown-divider" style="margin: 0;"></div>
                        @endforelse
                    </div>

                    {{-- Sub-header RIWAYAT (di dalam scroll, ikut scroll) --}}
                    <div style="background: #f8f9fa;
                                border-top: 1px solid #dee2e6;
                                border-bottom: 1px solid #dee2e6;">
                        <span class="dropdown-item dropdown-header font-weight-bold text-left"
                              style="background: transparent;">
                            <i class="fas fa-history mr-1"></i> Riwayat (7 Hari)
                        </span>
                    </div>

                    {{-- List notif SUDAH DIBACA (riwayat) --}}
                    <div id="list-sudah-dibaca">
                        @forelse($notifSudahDibaca as $index => $notif)
                            <div class="item-riwayat {{ $index >= 2 ? 'd-none riwayat-tersembunyi' : '' }}">
                                <a href="{{ $notif->url ?? '#' }}"
                                   class="dropdown-item"
                                   style="white-space: normal; opacity: 0.7;">
                                    <div class="media">
                                        <i class="fas fa-check-double text-secondary mt-2 mr-2"
                                           style="font-size: 10px;"></i>
                                        <div class="media-body">
                                            <span class="text-sm text-dark">
                                                {{ $notif->judul }}
                                            </span>
                                            <p class="text-sm text-muted mb-0">
                                                {{ Str::limit($notif->pesan, 50) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $notif->created_at->translatedFormat('d M H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider" style="margin: 0;"></div>
                            </div>
                        @empty
                            <div id="riwayat-kosong-msg"
                                 class="dropdown-item text-center text-muted py-2 small">
                                Belum ada riwayat
                            </div>
                            <div class="dropdown-divider" style="margin: 0;"></div>
                        @endforelse
                    </div>

                </div>
                {{-- /notif-scroll-area --}}

                {{-- ── FOOTER: tombol lihat semua riwayat (sticky bawah) ── --}}
                @if($notifSudahDibaca->count() > 2)
                    <div style="position: sticky; bottom: 0; z-index: 10;
                                background: #fff; border-top: 1px solid #dee2e6;">
                        <a href="#" id="btnToggleRiwayat"
                           class="dropdown-item dropdown-footer font-weight-bold text-primary text-center"
                           onclick="bukaRiwayat(event)">
                            Lihat Semua Riwayat
                        </a>
                    </div>
                @endif

            </div>
        </li>

        {{-- ============================================================
             JAVASCRIPT NOTIFIKASI
             ============================================================ --}}
        <script>
            // Toggle tampil/sembunyikan riwayat lama
            function bukaRiwayat(e) {
                e.preventDefault();
                e.stopPropagation();

                document.querySelectorAll('.riwayat-tersembunyi').forEach(function (item) {
                    item.classList.toggle('d-none');
                });

                let tombol = document.getElementById('btnToggleRiwayat');
                tombol.innerText = tombol.innerText.trim() === 'Lihat Semua Riwayat'
                    ? 'Sembunyikan Riwayat'
                    : 'Lihat Semua Riwayat';
            }

            // Tandai SEMUA notif belum dibaca → dibaca via AJAX
            function tandaiSemuaDibaca(e) {
                e.preventDefault();
                e.stopPropagation();

                let tombol = document.getElementById('btn-tandai-semua');
                tombol.disabled = true;
                tombol.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...';

                fetch('{{ route("notifikasi.tandaiSemuaDibaca") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept'      : 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.status) return;

                    // 1. Kosongkan list belum dibaca, tampilkan pesan kosong
                    document.getElementById('list-belum-dibaca').innerHTML =
                        '<div class="dropdown-item text-center text-muted py-2 small">' +
                            'Tidak ada notifikasi baru' +
                        '</div>' +
                        '<div class="dropdown-divider" style="margin:0;"></div>';

                    // 2. Sembunyikan badge angka di ikon bel
                    let badge = document.getElementById('badge-notif');
                    if (badge) badge.style.display = 'none';

                    // 3. Update label jumlah "(0)" di header dropdown
                    let label = document.getElementById('label-jumlah-notif');
                    if (label) label.innerText = '(0)';

                    // 4. Sembunyikan tombol "Tandai Semua Dibaca"
                    tombol.style.display = 'none';

                    // 5. Sisipkan notif yang baru ditandai ke ATAS list riwayat
                    if (data.notifikasi && data.notifikasi.length > 0) {
                        let listSudah  = document.getElementById('list-sudah-dibaca');
                        let msgKosong  = document.getElementById('riwayat-kosong-msg');

                        // Hapus pesan "Belum ada riwayat" kalau masih ada
                        if (msgKosong) msgKosong.parentElement.remove();

                        let htmlBaru = '';
                        data.notifikasi.forEach(function (notif) {
                            htmlBaru +=
                                '<div class="item-riwayat">' +
                                    '<a href="' + (notif.url || '#') + '" class="dropdown-item" ' +
                                       'style="white-space:normal; opacity:0.7;">' +
                                        '<div class="media">' +
                                            '<i class="fas fa-check-double text-secondary mt-2 mr-2" ' +
                                               'style="font-size:10px;"></i>' +
                                            '<div class="media-body">' +
                                                '<span class="text-sm text-dark">' + notif.judul + '</span>' +
                                                '<p class="text-sm text-muted mb-0">' + notif.pesan_singkat + '</p>' +
                                                '<small class="text-muted">' + notif.waktu + '</small>' +
                                            '</div>' +
                                        '</div>' +
                                    '</a>' +
                                    '<div class="dropdown-divider" style="margin:0;"></div>' +
                                '</div>';
                        });

                        listSudah.insertAdjacentHTML('afterbegin', htmlBaru);
                    }
                })
                .catch(function () {
                    // Kalau gagal, kembalikan tombol ke semula
                    tombol.disabled = false;
                    tombol.innerHTML = '<i class="fas fa-check-double mr-1"></i> Tandai Semua Dibaca';
                });
            }
        </script>

        {{-- ============================================================
             USER MENU (profil + logout)
             ============================================================ --}}
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ (auth()->check() && auth()->user()->foto_profil)
                                ? asset('storage/' . auth()->user()->foto_profil)
                                : asset('adminlte/dist/img/user2-160x160.jpg') }}"
                     class="user-image img-circle elevation-2"
                     alt="Foto Profil"
                     style="object-fit: cover;">
                <span class="d-none d-md-inline font-weight-bold">
                    {{ auth()->check() ? strtoupper(auth()->user()->role) : 'GUEST' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-danger">
                    <img src="{{ (auth()->check() && auth()->user()->foto_profil)
                                    ? asset('storage/' . auth()->user()->foto_profil)
                                    : asset('adminlte/dist/img/user2-160x160.jpg') }}"
                         class="img-circle elevation-2"
                         alt="Foto Profil"
                         style="object-fit: cover;">
                    <p>
                        {{ auth()->check() ? auth()->user()->nama_lengkap : 'Pengguna Belum Login' }}
                        <small>{{ auth()->check() ? strtoupper(auth()->user()->role) : 'GUEST' }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">
                        <i class="fas fa-user-cog"></i> Profil
                    </a>
                    <a href="{{ url('logout') }}"
                       class="btn btn-default btn-flat float-right text-danger"
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