@extends('layouts.template')

@section('content')
<style>
    /* Bikin jarak dalam tabel jadi compact persis kayak halaman Pelanggan */
    #table_pengguna th,
    #table_pengguna td {
        padding: 8px 10px !important; 
        vertical-align: middle !important; 
    }

    /* Mencegah isi kolom action turun ke bawah */
    #table_pengguna td:last-child {
        white-space: nowrap !important;
        text-align: center !important;
    }

    /* Bikin tombol action (Mata, Edit, Hapus) ukurannya imut dan pas */
    #table_pengguna td .btn {
        padding: 0.2rem 0.5rem !important; 
        font-size: 0.85rem !important;       
        border-radius: 4px;
        margin: 0 2px; /* Kasih jarak dikit antar icon */
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
                    <select class="form-control form-control-sm" id="filter_role" style="width: 150px; border-radius: 20px; margin-right: 8px;">
                        <option value="">- Role -</option>
                        <option value="admin">Admin</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="sales">Sales</option>
                    </select>
                    
                    <select class="form-control form-control-sm" id="filter_status" style="width: 150px; border-radius: 20px;">
                        <option value="">- Status -</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                
                {{-- Sisi Kanan: Tombol Export, Import, Add --}}
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group" style="margin-right: 8px;">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 20px; border: 1px solid #ced4da;">
                            <i class="fas fa-upload"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="border-radius: 10px;">
                            <a class="dropdown-item" href="{{ url('/pengguna/export_excel') }}">
                                <i class="fas fa-file-excel text-success mr-2"></i> Export Excel
                            </a>
                            <a class="dropdown-item" href="{{ url('/pengguna/export_pdf') }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger mr-2"></i> PDF
                            </a>
                        </div>
                    </div>
                    
                    <button onclick="modalAction('{{ url('/pengguna/import') }}')" class="btn btn-default btn-sm" style="border-radius: 20px; border: 1px solid #ced4da; margin-right: 8px;">
                        <i class="fas fa-download"></i> Import
                    </button>
                    
                    <button onclick="modalAction('{{ url('/pengguna/create_ajax') }}')" class="btn btn-danger btn-sm" style="border-radius: 20px;">
                        <i class="fas fa-plus"></i> Add User
                    </button>
                </div>

            </div>
        </div>

        <div class="card-body mt-2">
            {{-- Tambahan class table-responsive, table-sm, dan text-sm --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-sm text-sm" id="table_pengguna" style="width: 100%;">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Wilayah</th>
                            <th class="text-center">Status</th>
                            <th>Role</th>
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
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var dataPengguna;
    $(document).ready(function() {
        dataPengguna = $('#table_pengguna').DataTable({
            responsive: true, // Tambahan biar tabelnya responsive
            autoWidth: false, // Tambahan biar lebar kolomnya rapi
            serverSide: true,
            processing: true,
            ordering: true,
            ajax: {
                url: "{{ url('pengguna/list') }}",
                type: "POST",
                data: function(d) {
                    d.role = $('#filter_role').val();
                    d.status_aktif = $('#filter_status').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama_lengkap', name: 'nama_lengkap' },
                { data: 'nip', name: 'nip' },
                { data: 'wilayah_kerja', name: 'wilayah_kerja' },
                { data: 'status', name: 'status_aktif', className: 'text-center', orderable: false, searchable: false },
                { data: 'role', name: 'role' },
                { data: 'aksi', name: 'aksi', className: 'text-center', orderable: false, searchable: false }
            ]
        });

        $('#filter_role, #filter_status').on('change', function() {
            dataPengguna.ajax.reload();
        });
    });

    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush