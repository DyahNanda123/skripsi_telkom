<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 15px;">
        <form action="{{ url('/pengguna/' . $user->id . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            
            <div class="modal-header border-0 d-block text-center pb-0">
                <h4 class="modal-title" style="font-weight: 500; color: #555;">Edit Pengguna</h4>
                <hr style="border-top: 3px solid #555; width: 100%; margin-top: 10px; margin-bottom: 0;">
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">NAMA LENGKAP</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-nama_lengkap" class="error-text text-danger"></small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">ROLE</label>
                    <select name="role" id="role" class="form-control" style="border-radius: 10px; border: 1px solid #ced4da; color: #555;">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pimpinan" {{ $user->role == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        <option value="sales" {{ $user->role == 'sales' ? 'selected' : '' }}>Sales</option>
                    </select>
                    <small id="error-role" class="error-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ $user->nip }}" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-nip" class="error-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">PASSWORD <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diganti" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-password" class="error-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">WILAYAH</label>
                        <select name="wilayah_kerja" id="wilayah_kerja" class="form-control" style="border-radius: 10px; border: 1px solid #ced4da; color: #555;">
                            <option value="Ngawi" {{ $user->wilayah_kerja == 'Ngawi' ? 'selected' : '' }}>Ngawi</option>
                            <option value="Magetan" {{ $user->wilayah_kerja == 'Magetan' ? 'selected' : '' }}>Magetan</option>
                        </select>
                        <small id="error-wilayah_kerja" class="error-text text-danger"></small>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label class="text-muted" style="font-size: 12px; margin-bottom: 2px;">STATUS</label>
                        <select name="status_aktif" id="status_aktif" class="form-control" style="border-radius: 10px; border: 1px solid #ced4da; color: #555;">
                            <option value="1" {{ $user->status_aktif == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status_aktif == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <small id="error-status_aktif" class="error-text text-danger"></small>
                    </div>
                </div>

            </div>

            <div class="modal-footer border-0 justify-content-center pt-0">
                <button type="button" class="btn btn-outline-danger px-4" data-dismiss="modal" style="border-radius: 25px; min-width: 130px;">Batal</button>
                <button type="submit" class="btn btn-danger px-4" style="border-radius: 25px; min-width: 130px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-edit").on('submit', function(e) {
            e.preventDefault(); 
            
            let form = $(this);
            let url = form.attr('action');
            
            $.ajax({
                url: url,
                type: "POST", // Menggunakan POST karena method spoofing @method('PUT') sudah ada di atas
                data: form.serialize(),
                success: function(response) {
                    $('.error-text').text('');
                    
                    if(response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'SUKSES',
                            text: response.message,
                            confirmButtonColor: '#28a745',
                            confirmButtonText: 'Continue',
                            customClass: { title: 'font-weight-bold' }
                        });
                        dataPengguna.ajax.reload();
                    } else {
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
                        });
                    }
                }
            });
        });
    });
</script>