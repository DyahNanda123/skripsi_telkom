@extends('layouts.template')

@section('content')
<style>
    /* Bikin jarak dalam tabel jadi compact persis kayak halaman Pelanggan & Pengguna */
    #table_kunjungan th,
    #table_kunjungan td {
        padding: 8px 10px !important; 
        vertical-align: middle !important; 
    }

    /* Mencegah isi kolom action turun ke bawah */
    #table_kunjungan td:last-child {
        white-space: nowrap !important;
        text-align: center !important;
    }

    /* Bikin tombol action (Mata, Edit, Hapus) ukurannya imut dan pas */
    #table_kunjungan td .btn {
        padding: 0.2rem 0.5rem !important; 
        font-size: 0.85rem !important;       
        border-radius: 4px;
        margin: 0 2px;
    }

    /* Memastikan dropdown export gak ketutup */
    .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
    }
</style>

<div class="container-fluid">
    <div class="card card-outline card-danger">
        <div class="card-header border-0 pb-0 pt-3">
            {{-- BAGIAN HEADER: Dibagi 2 sisi persis (Kiri untuk Filter, Kanan untuk Tombol) --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                
                {{-- Sisi Kiri: Filter --}}
                <div class="d-flex align-items-center flex-wrap gap-2 mb-2 mb-md-0">
                    {{-- DROPDOWN SALES: Disembunyikan jika Role = Sales --}}
                    @if(auth()->user()->role != 'sales')
                    <select class="form-control form-control-sm" id="filter_sales" style="width: 150px; border-radius: 20px; margin-right: 8px;">
                        <option value="">- Semua Sales -</option>
                        @foreach($sales as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @endif

                    <select class="form-control form-control-sm" id="filter_status" style="width: 150px; border-radius: 20px; margin-right: 8px;">
                        <option value="">- Status -</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Progress">Progress</option>
                        <option value="Follow Up">Follow Up</option>
                    </select>

                    <select class="form-control form-control-sm" id="filter_tahun" style="width: 150px; border-radius: 20px;">
                        {{-- <option value="">- Semua Tahun -</option> --}}
                        @php $tahunSekarang = date('Y'); @endphp
                        @for($t = $tahunSekarang; $t >= 2024; $t--)
                            <option value="{{ $t }}" {{ $t == $tahunSekarang ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                {{-- Sisi Kanan: Tombol Export --}}
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="border-radius: 20px; border: 1px solid #ced4da;">
                            <i class="fas fa-upload"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('/kunjungan/export_excel') }}"><i class="fas fa-file-excel text-success mr-2"></i> Export Excel</a>
                            <a class="dropdown-item" href="{{ url('/kunjungan/export_pdf') }}" target="_blank"><i class="fas fa-file-pdf text-danger mr-2"></i> Export PDF</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="card-body mt-2">
            {{-- Tambahan class table-responsive, table-sm, dan text-sm --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-sm text-sm" id="table_kunjungan" style="width: 100%;">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            {{-- KOLOM SALES: Disembunyikan jika Role = Sales --}}
                            @if(auth()->user()->role != 'sales')
                                <th>Sales</th>
                            @endif
                            <th>Pelanggan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Hasil</th>
                            <th class="text-center" width="13%">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var dataKunjungan;
    $(document).ready(function() {
        // reminder kunjungn untuk sales (sesuai kunjungnnya)
        @if(auth()->user()->role == 'sales')
            let jmlProgress = {{ $jumlahProgress ?? 0 }};
            if (jmlProgress > 0) {
                Swal.fire({
                    title: '<span style="color: #dc3545;">Reminder Kunjungan!</span>',
                    icon: 'warning', 
                    html:
                        'Halo <b>{{ auth()->user()->nama_lengkap }}</b>, <br><br>' +
                        'Kamu punya <b>' + jmlProgress + '</b> data kunjungan yang masih <b>Progress</b>. ' +
                        'Jangan lupa segera isi formnya ya!',
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Siap, laksanakan!',
                    confirmButtonColor: '#dc3545', 
                    background: '#ffffff',
                    color: '#333', 
                    customClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                });
            }
        @endif

        dataKunjungan = $('#table_kunjungan').DataTable({
            responsive: true, // Tambahan biar tabelnya responsive
            autoWidth: false, // Tambahan biar lebar kolomnya rapi
            serverSide: true,
            processing: true,
            ordering: true, // mengatur sorting ke terbaru
            order: [[3, 'desc']],
            ajax: {
                url: "{{ url('kunjungan/list') }}",
                type: "POST",
                data: function(d) {
                    d.sales_id = $('#filter_sales').val();
                    d.status = $('#filter_status').val();
                    d.tahun = $('#filter_tahun').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false, width: '5%' },
                @if(auth()->user()->role != 'sales')
                    { data: 'nama_sales', name: 'user.nama_lengkap' },
                @endif
                { data: 'nama_pelanggan', name: 'calonPelanggan.nama_pelanggan' },
                { data: 'tanggal', name: 'created_at', className: 'text-center' },
                { data: 'status_badge', name: 'status', className: 'text-center', orderable: false, searchable: false },
                { data: 'hasil_kunjungan', name: 'hasil_kunjungan', className: 'text-center' },
                { data: 'aksi', name: 'aksi', className: 'text-center', orderable: false, searchable: false, width: '13%' }
            ]
        });

        $('#filter_sales, #filter_status, #filter_tahun').on('change', function() {
            dataKunjungan.ajax.reload();
        });
    });

    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush