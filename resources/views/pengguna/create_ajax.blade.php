<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 15px;">
        <form action="{{ url('/pengguna/ajax') }}" method="POST" id="form-tambah">
            @csrf
            
            <div class="modal-header border-0 d-block text-center pb-0">
                <h4 class="modal-title" style="font-weight: 500; color: #555;">Tambah Pengguna</h4>
                <hr style="border-top: 3px solid #555; width: 100%; margin-top: 10px; margin-bottom: 0;">
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="NAMA" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-nama_lengkap" class="error-text text-danger"></small>
                </div>
                
                <div class="form-group mb-3">
                    <select name="role" id="role" class="form-control" style="border-radius: 10px; border: 1px solid #ced4da; color: #6c757d;">
                        <option value="">ROLE</option>
                        <option value="admin">Admin</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="sales">Sales</option>
                    </select>
                    <small id="error-role" class="error-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-nip" class="error-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="PASSWORD" style="border-radius: 10px; border: 1px solid #ced4da;">
                    <small id="error-password" class="error-text text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <select name="wilayah_kerja" id="wilayah_kerja" class="form-control" style="border-radius: 10px; border: 1px solid #ced4da; color: #6c757d;">
                        <option value="">WILAYAH</option>
                        <option value="Ngawi">Ngawi</option>
                        <option value="Magetan">Magetan</option>
                    </select>
                    <small id="error-wilayah_kerja" class="error-text text-danger"></small>
                </div>

                <input type="hidden" name="status_aktif" value="1">
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
        // Ketika tombol Simpan diklik
        $("#form-tambah").on('submit', function(e) {
            e.preventDefault(); // Mencegah loading halaman
            
            let form = $(this);
            let url = form.attr('action');
            
            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    // Kosongkan pesan error sebelumnya
                    $('.error-text').text('');
                    
                    if(response.status) {
                        // Jika sukses: Tutup modal dan munculkan SweetAlert
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'SUKSES',
                            text: response.message,
                            confirmButtonColor: '#28a745',
                            confirmButtonText: 'Continue',
                            customClass: {
                                title: 'font-weight-bold'
                            }
                        });
                        // Refresh tabel otomatis
                        dataPengguna.ajax.reload();
                    } else {
                        // Jika ada validasi gagal: Tampilkan pesan error di bawah input
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
                        });
                    }
                }
            });
        });
    });
</script>