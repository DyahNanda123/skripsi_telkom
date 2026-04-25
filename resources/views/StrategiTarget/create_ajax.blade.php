<form action="{{ url('/strategi-target/store_ajax') }}" method="POST" id="form-tambah-promo" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-upload mr-2"></i> Upload Materi Promosi & Strategi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="row">
                            {{-- Sisi Kiri: Detail Teks --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark small">JUDUL MATERI</label>
                                    <input type="text" class="form-control" name="judul" placeholder="Contoh: Promo Ramadhan" required style="border-radius: 8px;">
                                    <small id="error-judul" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark small">DESKRIPSI / INSTRUKSI</label>
                                    <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan detail promo atau strategi ini untuk sales..." style="border-radius: 8px;"></textarea>
                                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark small">KATEGORI</label>
                                    <select class="form-control" name="kategori" required style="border-radius: 8px;">
                                        <option value="">- Pilih Kategori -</option>
                                        <option value="Brosur">Brosur</option>
                                        <option value="Flyer">Flyer</option>
                                        <option value="Video">Video</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <small id="error-kategori" class="error-text form-text text-danger"></small>
                                </div>
                                                                {{-- TAMBAHKAN INI: Input Tanggal Kadaluwarsa --}}
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark small">TANGGAL KADALUWARSA</label>
                                    <input type="date" class="form-control" name="tanggal_kadaluwarsa" required style="border-radius: 8px;" min="{{ date('Y-m-d') }}">
                                    <small class="text-muted" style="font-size: 11px;">
                                        <i class="fas fa-info-circle mr-1"></i> Materi akan otomatis tersembunyi setelah tanggal ini berakhir.
                                    </small>
                                    <small id="error-tanggal_kadaluwarsa" class="error-text form-text text-danger"></small>
                                </div>
                            </div>

                            {{-- Sisi Kanan: Upload Area --}}
                            <div class="col-md-6">
                                <div class="form-group h-100">
                                    <label class="font-weight-bold text-dark small">FILE UPLOAD</label>
                                    <div class="border rounded text-center d-flex flex-column justify-content-center align-items-center" style="background-color: #f8f9fa; border: 2px dashed #cbd5e1 !important; height: calc(100% - 30px); border-radius: 10px !important;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3 mt-3"></i>
                                        <p class="font-weight-bold mb-1 text-dark">Drag file ke sini</p>
                                        <p class="small text-muted mb-3">Atau klik untuk memilih (JPG, PNG, PDF. Max 5MB)</p>
                                        
                                        <input type="file" class="d-none" id="file_promo" name="file_promo" required accept=".jpg,.jpeg,.png,.pdf">
                                        
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="document.getElementById('file_promo').click()" style="border-radius: 8px;">Browse...</button>
                                        <div id="file-name-display" class="mb-3 small font-weight-bold text-danger">No file selected.</div>
                                    </div>
                                    <small id="error-file_promo" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="submit" class="btn btn-danger w-100" style="border-radius: 8px; font-weight: bold;">
                    <i class="fas fa-upload mr-1"></i> Upload & Bagikan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Ganti teks saat file dipilih
        $('#file_promo').change(function() {
            var fileName = $(this).val().split('\\').pop();
            $('#file-name-display').text(fileName ? fileName : 'No file selected.');
        });

        // Proses submit form AJAX
        $("#form-tambah-promo").on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            
            let btnSubmit = form.find('button[type="submit"]');
            let originalText = btnSubmit.html();
            btnSubmit.html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengupload...').prop('disabled', true);
            
            $('.error-text').text('');

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                        Swal.fire('Gagal!', response.message, 'error');
                        btnSubmit.html(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    btnSubmit.html(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>