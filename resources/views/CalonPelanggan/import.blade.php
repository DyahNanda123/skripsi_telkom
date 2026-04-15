<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 15px;">
        <form action="{{ url('/calon_pelanggan/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
            @csrf
            
            <div class="modal-header border-0 d-block text-center pb-0">
                <h4 class="modal-title" style="font-weight: 500; color: #555;">Import Calon Pelanggan</h4>
                <hr style="border-top: 3px solid #555; width: 100%; margin-top: 10px; margin-bottom: 0;">
            </div>

            <div class="modal-body pt-3 pb-3">
                <div class="alert alert-info" style="border-radius: 10px; font-size: 14px;">
                    <i class="fas fa-info-circle"></i> <strong>Panduan Format Excel:</strong><br>
                    Siapkan file Excel (.xlsx) dengan urutan kolom berikut:<br>
                    <strong>A:</strong> Nama Pelanggan | <strong>B:</strong> Alamat Lengkap <br>
                    <strong>C:</strong> Wilayah | <strong>D:</strong> STO <br>
                    <strong>E:</strong> Jenis Pelanggan | <strong>F:</strong> Link Maps <br>
                    <strong>G:</strong> Status Langganan | <strong>H:</strong> Status Kunjungan (Visit) <br>
                    <em>*Baris pertama wajib dijadikan judul kolom (Header).</em><br>
                    <em class="text-danger">*Pastikan isi kolom C, D, E, G, dan H sesuai dengan pilihan (ENUM) di sistem.</em>
                </div>

                <div class="form-group mb-0">
                    <label class="text-muted" style="font-size: 12px; margin-bottom: 5px;">UPLOAD FILE EXCEL (.xlsx)</label>
                    <input type="file" name="file_calon_pelanggan" id="file_calon_pelanggan" class="form-control p-1" accept=".xlsx" style="border-radius: 10px; border: 1px solid #ced4da; height: auto;" required>
                    <small id="error-file_calon_pelanggan" class="error-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center pt-0">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" style="border-radius: 25px; min-width: 120px;">Batal</button>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 25px; min-width: 120px;"><i class="fas fa-upload"></i> Import</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-import").on('submit', function(e) {
            e.preventDefault(); 
            
            let form = $(this);
            let url = form.attr('action');
            let formData = new FormData(this);
            
            let btn = form.find('button[type="submit"]');
            let btnAsli = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Proses...').prop('disabled', true);
            
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    btn.html(btnAsli).prop('disabled', false);
                    $('.error-text').text('');
                    
                    if(response.status) {
                        $('#myModal').modal('hide');
                        $('.modal-backdrop').remove(); 
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');

                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL',
                            text: response.message,
                            confirmButtonColor: '#28a745'
                        });
                        
                        if (typeof tableCalonPelanggan !== 'undefined') {
                            tableCalonPelanggan.ajax.reload(null, false);
                        }
                    } else {
                        if(response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-'+prefix).text(val[0]);
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'GAGAL', text: response.message });
                        }
                    }
                },
                error: function(xhr) {
                    btn.html(btnAsli).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan server. Cek kembali file Excel-mu.'
                    });
                }
            });
        });
    });
</script>