@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-danger">
        <div class="card-header border-0 pb-0">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex gap-2">
                    <select class="form-control form-control-sm mr-2" id="filter_role" style="width: 150px; border-radius: 20px;">
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
                
                <div class="col-md-6 text-right">
                    <div class="btn-group mr-1">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 20px;">
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
                    <button onclick="modalAction('{{ url('/pengguna/import') }}')" class="btn btn-default btn-sm mr-2" style="border-radius: 20px;"><i class="fas fa-download"></i> Import</button>
                    <button onclick="modalAction('{{ url('/pengguna/create_ajax') }}')" class="btn btn-danger btn-sm" style="border-radius: 20px;"><i class="fas fa-plus"></i> Add User</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-hover table-striped" id="table_pengguna" style="width: 100%;">
                <thead class="bg-danger text-white">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Wilayah</th>
                        <th class="text-center">Status</th>
                        <th>Role</th>
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
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var dataPengguna;
    $(document).ready(function() {
        dataPengguna = $('#table_pengguna').DataTable({
            serverSide: true,
            processing: true,
            ordering: false,
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