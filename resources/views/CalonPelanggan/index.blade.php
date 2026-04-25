@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-danger">
        <div class="card-header border-0 pb-0">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex gap-2 flex-wrap">
                    {{-- Filter STO --}}
                    <select class="form-control form-control-sm mr-2" id="filter_sto" style="width: 120px; border-radius: 20px;">
                        <option value="">- STO -</option>
                        <option value="GGR">GGR</option>
                        <option value="JGO">JGO</option>
                        <option value="KRJ">KRJ</option>
                        <option value="MGT">MGT</option>
                        <option value="NWI">NWI</option>
                        <option value="SAR">SAR</option>
                        <option value="WKU">WKU</option>
                    </select>

                    {{-- Filter Langganan --}}
                    <select class="form-control form-control-sm mr-2" id="filter_langganan" style="width: 180px; border-radius: 20px;">
                        <option value="">- Status Langganan -</option>
                        <option value="Berlangganan">Berlangganan</option>
                        <option value="Belum Berlangganan">Belum Berlangganan</option>
                    </select>

                    {{-- Filter Visit --}}
                    <select class="form-control form-control-sm" id="filter_visit" style="width: 160px; border-radius: 20px;">
                        <option value="">- Status Kunjungan -</option>
                        <option value="Sudah Visit">Sudah Visit</option>
                        <option value="Belum Visit">Belum Visit</option>
                        <option value="Progress">Progress</option>
                        <option value="Follow Up">Follow Up</option>
                    </select>
                </div>
                
                <div class="col-md-4 text-right">
                    <div class="btn-group mr-1">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" style="border-radius: 20px;">
                            <i class="fas fa-upload"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('/calon_pelanggan/export_excel') }}">
                                <i class="fas fa-file-excel text-success mr-2"></i> Excel
                            </a>
                            <a class="dropdown-item" href="{{ url('/calon_pelanggan/export_pdf') }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger mr-2"></i> PDF
                            </a>
                        </div>
                    </div>
                    @if(auth()->user()->role == 'admin')
                    <button onclick="modalAction('{{ url('/calon_pelanggan/import') }}')" class="btn btn-default btn-sm mr-2" style="border-radius: 20px;">
                        <i class="fas fa-download"></i> Import</button>
                    <button onclick="modalAction('{{ url('/calon_pelanggan/create_ajax') }}')" class="btn btn-danger">
                        <i class="fas fa-plus"></i> Add Calon Pelanggan
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-hover table-striped" id="table_calon_pelanggan" style="width: 100%;">
                <thead class="bg-danger text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Wilayah</th>
                        <th>STO</th>
                        <th>Jenis</th>
                        <th class="text-center">Maps</th>
                        <th class="text-center">Status Langganan</th>
                        <th class="text-center">Status Kunjungan</th>
                        <th class="text-center">Actions</th>
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

    var tableCalonPelanggan;
    $(document).ready(function() {
        tableCalonPelanggan = $('#table_calon_pelanggan').DataTable({
            serverSide: true,
            processing: true,
            ordering:[],
            ajax: {
                url: "{{ url('calon_pelanggan/list') }}",
                type: "POST",
                data: function(d) {
                    d.sto = $('#filter_sto').val();
                    d.status_langganan = $('#filter_langganan').val();
                    d.status_visit = $('#filter_visit').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama_pelanggan', name: 'nama_pelanggan' },
                { data: 'alamat', name: 'alamat' },
                { data: 'wilayah', name: 'wilayah' },
                { data: 'sto', name: 'sto' },
                { data: 'jenis_pelanggan', name: 'jenis_pelanggan' },
                { data: 'link_maps', name: 'link_maps', className: 'text-center', orderable: false },
                { data: 'status_langganan', name: 'status_langganan', className: 'text-center' },
                { data: 'status_visit_label', name: 'status_visit', className: 'text-center' },
                { data: 'aksi', name: 'aksi', className: 'text-center', orderable: false, searchable: false }
            ]
        });

        $('#filter_sto, #filter_langganan, #filter_visit').on('change', function() {
            tableCalonPelanggan.ajax.reload();
        });
    });

    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush