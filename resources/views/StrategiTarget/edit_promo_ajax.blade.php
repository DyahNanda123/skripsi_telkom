<form action="{{ url('/strategi-target/promo/'.$promo->id.'/update_ajax') }}" method="POST" id="form-edit-promo" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 28px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body px-5 pb-5 pt-2 bg-light" style="border-radius: 12px;">
                
                <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold mb-4" style="color: #333;">
                            <i class="fas fa-edit text-danger mr-2"></i> Edit Materi Promosi & Strategi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-7 border-right pr-4">
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">JUDUL MATERI</label>
                                    <input type="text" name="judul" class="form-control" value="{{ $promo->judul }}" style="border-radius: 8px;">
                                    <small class="error-text judul-error text-danger"></small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">DESKRIPSI / INSTRUKSI</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" style="border-radius: 8px;">{{ $promo->deskripsi }}</textarea>
                                    <small class="error-text deskripsi-error text-danger"></small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">KATEGORI</label>
                                    <select name="kategori" class="form-control" style="border-radius: 8px;">
                                        <option value="brosur" {{ $promo->kategori == 'brosur' ? 'selected' : '' }}>Brosur</option>
                                        <option value="poster" {{ $promo->kategori == 'poster' ? 'selected' : '' }}>Poster</option>
                                        <option value="video" {{ $promo->kategori == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="presentasi" {{ $promo->kategori == 'presentasi' ? 'selected' : '' }}>Presentasi</option>
                                        <option value="lainnya" {{ $promo->kategori == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    <small class="error-text kategori-error text-danger"></small>
                                </div>
                                <div class="form-group">
                                <label class="font-weight-bold text-dark small">TANGGAL KADALUWARSA</label>
                                <input type="date" class="form-control" name="tanggal_kadaluwarsa" 
                                    value="{{ $promo->tanggal_kadaluwarsa }}" required style="border-radius: 8px;">
                                <small class="text-muted" style="font-size: 11px;">Ubah tanggal jika masa berlaku promo diperpanjang.</small>
                                <small id="error-tanggal_kadaluwarsa" class="error-text form-text text-danger"></small>
                            </div>
                            </div>
                            
                            <div class="col-md-5 pl-4 d-flex flex-column justify-content-center">
                                <label class="small font-weight-bold text-muted mb-1">FILE UPLOAD (Opsional)</label>
                                
                                <div class="border border-dashed text-center p-4 mb-3" style="border-radius: 10px; border-width: 2px; border-style: dashed !important; border-color: #ddd; background-color: #fafafa;">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="mb-0 font-weight-bold" style="color: #666;">Drag file baru</p>
                                    <small class="text-muted">Kosongi jika tidak ganti file.</small>
                                    <input type="file" name="file_promo" class="form-control-file mt-2 w-100 mx-auto" style="cursor: pointer;">
                                    <small class="error-text file_promo-error text-danger d-block"></small>
                                </div>

                                <button type="submit" class="btn btn-danger btn-block font-weight-bold text-white" style="border-radius: 8px; padding: 10px;">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-edit-promo').on('submit', function(e) {
            e.preventDefault();
            $('.error-text').text(''); 
            
            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST', // Walaupun update, tetap pakai POST karena ada upload file gambar/pdf
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status) {
                        $('#myModal').modal('hide'); 
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        
                        $('.card-body.bg-light.mt-3').load(window.location.href + ' .card-body.bg-light.mt-3 > *');
                    } else {
                        $.each(response.msgField, function(prefix, val) {
                            $('.'+prefix+'-error').text(val[0]);
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan sistem!', 'error');
                }
            });
        });
    });
</script>