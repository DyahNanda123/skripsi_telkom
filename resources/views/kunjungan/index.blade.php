@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-danger">
        <div class="card-header border-0 pb-0">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex gap-2">
                    {{-- DROPDOWN SALES: Disembunyikan jika Role = Sales --}}
                    @if(auth()->user()->role != 'sales')
                    <select class="form-control form-control-sm mr-2" id="filter_sales" style="width: 150px; border-radius: 20px;">
                        <option value="">- Semua Sales -</option>
                        @foreach($sales as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @endif

                    <select class="form-control form-control-sm" id="filter_status" style="width: 150px; border-radius: 20px;">
                        <option value="">- Status -</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Progress">Progress</option>
                        <option value="Follow Up">Follow Up</option>
                    </select>
                    <select class="form-control form-control-sm" id="filter_tahun" style="width: 150px; border-radius: 20px;">
                        <option value="">- Semua Tahun -</option>
                        @php $tahunSekarang = date('Y'); @endphp
                        @for($t = $tahunSekarang; $t >= 2024; $t--)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-6 text-right">
                    <div class="btn-group mr-1">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="border-radius: 20px;">
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

        <div class="card-body">
            <table class="table table-hover table-striped" id="table_kunjungan" style="width: 100%;">
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
                        <th class="text-center" width="15%">Actions</th>
                    </tr>
                </thead>
            </table>
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
                    icon: 'warning', // Ganti 'info' ke 'warning' biar ikonnya warna kuning/oranye (lebih kontras)
                    html:
                        'Halo <b>{{ auth()->user()->nama_lengkap }}</b>, <br><br>' +
                        'Kamu punya <b>' + jmlProgress + '</b> data kunjungan yang masih <b>Progress</b>. ' +
                        'Jangan lupa segera isi formnya ya!',
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Siap, laksanakan!',
                    confirmButtonColor: '#dc3545', // MERAH TELKOM (Biar senada sama header tabel & sidebar)
                    background: '#ffffff',
                    color: '#333', // Warna teks utama biar tegas
                    customClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                });
            }
        @endif

        dataKunjungan = $('#table_kunjungan').DataTable({
            serverSide: true,
            processing: true,
            ordering: false,
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
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                @if(auth()->user()->role != 'sales')
                    { data: 'nama_sales', name: 'user.nama_lengkap' },
                @endif
                { data: 'nama_pelanggan', name: 'calonPelanggan.nama_pelanggan' },
                { data: 'tanggal', name: 'created_at', className: 'text-center' },
                { data: 'status_badge', name: 'status', className: 'text-center', orderable: false, searchable: false },
                { data: 'hasil_kunjungan', name: 'hasil_kunjungan', className: 'text-center' },
                { data: 'aksi', name: 'aksi', className: 'text-center', orderable: false, searchable: false }
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