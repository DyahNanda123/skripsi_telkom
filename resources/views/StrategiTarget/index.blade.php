@extends('layouts.template')

@push('css')
<style>
    .table-custom thead th { background-color: #f9f9f9; color: #888; font-size: 11px; font-weight: 600; text-transform: uppercase; border-bottom: none; padding: 12px 15px; }
    .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f0f0f0; padding: 15px; color: #333; }
    .progress-custom { height: 6px; border-radius: 10px; background-color: #e9ecef; margin-top: 5px; }
    
    .badge-status { padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; display: inline-block; white-space: nowrap; }
   
    .promo-card { border: 1px solid #eaeaea; border-radius: 12px; padding: 15px; transition: 0.2s; background: #fff; }
    .promo-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .promo-icon-box { width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; }
    .bg-dark-img { background: #333 url('https://via.placeholder.com/60') center/cover; color: #fff; }
    .bg-light-danger { background: #fee2e2; color: #ef4444; }

    .btn-icon-only { background: transparent; border: none; padding: 5px 8px; font-size: 16px; transition: 0.2s; cursor: pointer; }
    .btn-icon-only:hover { transform: scale(1.1); }
    .btn-edit { color: #007bff; }
    .btn-delete { color: #dc3545; }
    .btn-view { color: #495057; }
</style>
@endpush

@section('content')
<div class="container-fluid pt-2">
    <div class="card card-outline card-danger" style="border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
        
        {{-- HEADER: FILTER & TOMBOL EXPORT/ADD --}}
        <div class="card-header border-0 pb-0 pt-3">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex gap-2 flex-wrap">
                    
                    {{-- Filter Nama Sales --}}
                    <select class="form-control form-control-sm mr-2" id="filter_sales" style="width: 150px; border-radius: 20px;">
                        <option value="">- Semua Sales -</option>
                        @foreach($sales as $s)
                            <option value="{{ $s->id }}" {{ request('sales') == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>

                    {{-- Filter Bulan --}}
                    <select class="form-control form-control-sm" id="filter_bulan" style="width: 130px; border-radius: 20px;">
                        <option value="1"  {{ $bulanFilter == '1'  ? 'selected' : '' }}>Januari</option>
                        <option value="2"  {{ $bulanFilter == '2'  ? 'selected' : '' }}>Februari</option>
                        <option value="3"  {{ $bulanFilter == '3'  ? 'selected' : '' }}>Maret</option>
                        <option value="4"  {{ $bulanFilter == '4'  ? 'selected' : '' }}>April</option>
                        <option value="5"  {{ $bulanFilter == '5'  ? 'selected' : '' }}>Mei</option>
                        <option value="6"  {{ $bulanFilter == '6'  ? 'selected' : '' }}>Juni</option>
                        <option value="7"  {{ $bulanFilter == '7'  ? 'selected' : '' }}>Juli</option>
                        <option value="8"  {{ $bulanFilter == '8'  ? 'selected' : '' }}>Agustus</option>
                        <option value="9"  {{ $bulanFilter == '9'  ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $bulanFilter == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ $bulanFilter == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $bulanFilter == '12' ? 'selected' : '' }}>Desember</option>
                    </select>

                    {{-- Filter Tahun --}}
                    <select class="form-control form-control-sm" id="filter_tahun" style="width: 150px; border-radius: 20px;">
                        @php $tahunSekarang = date('Y'); @endphp
                        @for($t = $tahunSekarang; $t >= 2024; $t--)
                            <option value="{{ $t }}" {{ $tahunFilter == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-6 text-right">
                    {{-- Tombol Export Dropdown --}}
                    <div class="btn-group mr-1">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="border-radius: 20px;">
                        <i class="fas fa-upload"></i> Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="border-radius: 10px;">
                        <a class="dropdown-item" href="{{ url('/strategi-target/export_excel') }}?sales={{ request('sales') }}&bulan={{ request('bulan', date('n')) }}&tahun={{ request('tahun', date('Y')) }}">
                            <i class="fas fa-file-excel text-success mr-2"></i> Excel
                        </a>
                        <a class="dropdown-item" href="{{ url('/strategi-target/export_pdf') }}?sales={{ request('sales') }}&bulan={{ request('bulan', date('n')) }}&tahun={{ request('tahun', date('Y')) }}" target="_blank">
                            <i class="fas fa-file-pdf text-danger mr-2"></i> PDF
                        </a>
                    </div>
                </div>
                    
                    {{-- TOMBOL ADD KHUSUS PIMPINAN --}}
                    @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'admin')
                        {{-- Tombol Buka Form Target Massal (Tampil di bawahnya) --}}
                        <button class="btn btn-warning btn-sm text-dark mr-1" type="button" data-toggle="collapse" data-target="#collapseTargetMassal" style="border-radius: 20px; padding: 5px 15px; font-weight: bold;">
                            <i class="fas fa-users mr-1"></i> Set Target Massal
                        </button>
                        
                        {{-- Tombol Buka Modal Promo --}}
                        <button onclick="modalAction('{{ url('/strategi-target/create_ajax') }}')" class="btn btn-danger btn-sm" style="border-radius: 20px; padding: 5px 15px;">
                            <i class="fas fa-plus mr-1"></i> Upload Promosi
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- BODY: ISI KONTEN TARGET & MATERI --}}
        <div class="card-body bg-light mt-3" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
            
            {{-- FITUR BARU: FORM TARGET MASSAL (Tersembunyi secara default) --}}
           {{-- FITUR BARU: FORM TARGET MASSAL (Tersembunyi secara default) --}}
            @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'admin')
            <div class="collapse mb-4" id="collapseTargetMassal">
                <div class="card card-body border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #dc3545 !important;">
                    <h5 class="font-weight-bold mb-3" style="color: #333;"><i class="fas fa-bullseye text-danger mr-2"></i> Form Target Bulanan Massal</h5>
                    
                    <form id="formTargetMassal" action="{{ url('/strategi-target/store_ajax') }}" method="POST">
                        @csrf
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-2 mb-0 font-weight-bold">Periode Target :</label>
                            <div class="col-sm-3">
                                <input type="month" name="periode" class="form-control" value="{{ date('Y-m') }}" required style="border-radius: 10px;">
                            </div>
                            <div class="col-sm-7 text-muted small">
                                *Isi angka target pada kolom di bawah ini. Kosongkan jika sales tidak diberi target bulan ini.
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-bordered mb-0" style="background: #fff; border-radius: 10px; overflow: hidden;">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th width="5%" class="text-center">NO</th>
                                        <th width="50%">NAMA SALES</th>
                                        <th width="45%" class="text-center">TARGET BULANAN (PS)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $noSales = 1; @endphp
                                    @foreach($sales as $s)
                                        @if($s->status_aktif == 1) {{-- Hanya nampilkan sales yang masih aktif --}}
                                        <tr>
                                            <td class="text-center">{{ $noSales++ }}</td>
                                            <td class="font-weight-bold">{{ $s->nama_lengkap }}</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" name="target[{{ $s->id }}]" class="form-control text-center" value="20" min="0" required style="border-radius: 10px 0 0 10px;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="border-radius: 0 10px 10px 0; background: #fff;">PS</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <button type="button" class="btn btn-secondary mr-2" data-toggle="collapse" data-target="#collapseTargetMassal" style="border-radius: 10px;">Batal</button>
                            <button type="submit" class="btn btn-danger font-weight-bold text-white" style="border-radius: 10px;"><i class="fas fa-save mr-1"></i> Simpan Semua Target</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- KOTAK 1: REKAP TARGET SALES --}}
            <div class="card border-0 mb-4" id="rekap-target-container" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                
                <div class="card-header bg-white border-0 text-center pt-4 pb-2" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="font-weight-bold" style="color: #333;"><i class="fas fa-chart-bar text-primary mr-2"></i> Rekap Target Sales</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">NO</th>
                                    <th width="20%">NAMA SALES</th>
                                    <th width="15%">PERIODE</th>
                                    <th width="15%">TARGET (PS)</th>
                                    <th width="25%">REALISASI (PROGRESS)</th>
                                    <th width="12%">STATUS</th> 
                                    
                                    {{-- HANYA PIMPINAN YANG BISA LIHAT KOLOM AKSI --}}
                                    @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'admin')
                                        <th width="8%" class="text-center">AKSI</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                         
                                @forelse($targets as $index => $t)
                                    @php
                                        $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                                        $bulanCetak = $namaBulan[(string)$t->bulan] ?? $t->bulan;

                                        $realisasi = \App\Models\Kunjungan::where('user_id', $t->user_id)
                                                        ->where('hasil_kunjungan', 'Berlangganan')
                                                        ->whereYear('created_at', $t->tahun)
                                                        ->whereMonth('created_at', $t->bulan)
                                                        ->count(); 
                                        
                                        // Hitung Persentase
                                        $persentase = $t->jumlah_target > 0 ? round(($realisasi / $t->jumlah_target) * 100) : 0;

                                        if ($persentase >= 100) {
                                            $textColor = '#10b981'; // Hijau
                                            $barColor  = 'bg-success';
                                        } elseif ($persentase >= 80) {
                                            $textColor = '#0ea5e9'; // Biru (On Track)
                                            $barColor  = 'bg-info';
                                        } elseif ($persentase > 0) {
                                            $textColor = '#f59e0b'; // Oranye
                                            $barColor  = 'bg-warning';
                                        } else {
                                            $textColor = '#ef4444'; // Merah (0%)
                                            $barColor  = 'bg-danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $t->user ? $t->user->nama_lengkap : 'Data Terhapus' }}</div>
                                            <div class="small text-muted">NIP: {{ $t->user ? $t->user->nip : '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-info">{{ $bulanCetak }}</div>
                                            <div class="small text-muted">{{ $t->tahun }}</div>
                                        </td>
                                        <td class="font-weight-bold text-dark">{{ $t->jumlah_target }} PS</td>
                                        <td>
                                            <div class="d-flex justify-content-between small font-weight-bold mb-1" style="color: {{ $textColor }};">
                                                <span>{{ $realisasi }} PS ({{ $persentase }}%)</span>
                                            </div>
                                            <div class="progress progress-custom">
                                                <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ $persentase > 100 ? 100 : $persentase }}%;" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($persentase >= 100)
                                                <span class="badge-status" style="background-color: #d1f5d3; color: #1e8e24;">
                                                    Tercapai <i class="fas fa-check-circle ml-1"></i>
                                                </span>
                                            @elseif($persentase >= 80)
                                                <span class="badge-status" style="background-color: #e0f2fe; color: #0284c7;">
                                                    On Track <i class="fas fa-spinner ml-1"></i>
                                                </span>
                                            @else
                                                <span class="badge-status" style="background-color: #ffecd1; color: #d97706;">
                                                    Warning <i class="fas fa-exclamation-triangle ml-1"></i>
                                                </span>
                                            @endif
                                        </td>
                                        
                                        @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'admin')
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center" style="gap: 5px;">
                                                    <button onclick="modalAction('{{ url('/strategi-target/target/' . $t->id . '/edit_ajax') }}')" class="btn-icon-only btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteAction('{{ url('/strategi-target/target/' . $t->id . '/delete_ajax') }}', this)" class="btn-icon-only btn-delete" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-box-open mb-2 fa-2x"></i><br>Belum ada data target sales yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KOTAK 2: MATERI PROMOSI AKTIF --}}
            {{-- KOTAK 2: MATERI PROMOSI AKTIF --}}
            <div class="card border-0" id="materi-promo-container" style="border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4 pb-2 border-bottom" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="font-weight-bold mb-0" style="color: #333;"><i class="fas fa-folder-open text-secondary mr-2"></i> Materi Promosi Aktif</h5>
                    <small class="text-muted font-weight-bold">Total File Aktif: {{ $promosis->count() }} File</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        
                        @forelse($promosis as $promo)
                            @php
                                $ext = pathinfo($promo->file_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                                
                                // Hitung sisa hari buat label (opsional biar keren)
                                $tglKadaluwarsa = \Carbon\Carbon::parse($promo->tanggal_kadaluwarsa);
                                $sisaHari = now()->diffInDays($tglKadaluwarsa, false);
                            @endphp
                            
                            <div class="col-md-6 mb-3">
                                <div class="promo-card d-flex align-items-center justify-content-between p-3">
                                   
                                    <div class="d-flex align-items-center" style="width: 75%; overflow: hidden;">
                                        @if($isImage)
                                            <div class="promo-icon-box bg-dark-img mr-3" style="background: url('{{ asset($promo->file_path) }}') center/cover; flex-shrink: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"></div>
                                        @else
                                            <div class="promo-icon-box bg-light-danger mr-3 text-danger" style="font-size: 16px; flex-shrink: 0;">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                        @endif

                                        <div style="min-width: 0;">
                                            <h6 class="font-weight-bold text-dark mb-1 text-truncate">{{ $promo->judul }}</h6>
                                            
                                            {{-- TAMBAHAN: Label Kadaluwarsa --}}
                                            <div class="mb-1">
                                                <span class="badge {{ $sisaHari <= 3 ? 'badge-danger' : 'badge-light' }}" style="font-size: 10px; border-radius: 10px;">
                                                    <i class="fas fa-clock mr-1"></i> Berlaku s/d: {{ $tglKadaluwarsa->format('d M Y') }}
                                                </span>
                                            </div>

                                            <p class="small text-muted mb-0 text-truncate" style="line-height: 1.2;">{{ $promo->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                        </div>
                                    </div>
                                    
                                    {{-- Sisi Kanan: Tombol Aksi --}}
                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                        @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'admin')
                                            <button onclick="modalAction('{{ url('/strategi-target/promo/' . $promo->id . '/edit_ajax') }}')" class="btn-icon-only btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteAction('{{ url('/strategi-target/promo/' . $promo->id . '/delete_ajax') }}', this)" class="btn-icon-only btn-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

                                        <button onclick="modalAction('{{ url('/strategi-target/' . $promo->id . '/show_promo_ajax') }}')" class="btn-icon-only btn-view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <span class="text-muted"><i class="fas fa-folder-open mb-2 fa-2x"></i><br>Belum ada materi promosi yang diunggah.</span>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#filter_sales, #filter_bulan, #filter_tahun').on('change', function() {
        var sales_id = $('#filter_sales').val();
        var bulan    = $('#filter_bulan').val();
        var tahun    = $('#filter_tahun').val();
        window.location.href = "{{ url('/strategi-target') }}?sales=" + sales_id + "&bulan=" + bulan + "&tahun=" + tahun;
    });

    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    // Script AJAX untuk mengirim Target Massal tanpa pindah halaman
   $('#formTargetMassal').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        
        // Tampilkan loading di tombol biar user tau lagi proses
        let btnSubmit = form.find('button[type="submit"]');
        let originalText = btnSubmit.html();
        btnSubmit.html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if(response.status) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // ✨ INI TRIK SULAPNYA BEB ✨
                    // Refresh HANYA bagian kotak tabel rekap target
                    $('#rekap-target-container').load(window.location.href + ' #rekap-target-container > *', function() {
                        // Setelah tabel selesai di-refresh, tutup formnya biar rapi
                        $('#collapseTargetMassal').collapse('hide'); 
                        
                        // Kembalikan tombol simpan ke kondisi semula
                        btnSubmit.html(originalText).prop('disabled', false);
                    });

                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                    btnSubmit.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                btnSubmit.html(originalText).prop('disabled', false);
            }
        });
    });

    function deleteAction(url, element) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(response) {
                        if(response.status) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: response.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            
                            if ($(element).closest('tr').length > 0) {
                                $(element).closest('tr').fadeOut(400, function() { $(this).remove(); });
                            } else if ($(element).closest('.col-md-6').length > 0) {
                                $(element).closest('.col-md-6').fadeOut(400, function() { $(this).remove(); });
                            }
                            
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush