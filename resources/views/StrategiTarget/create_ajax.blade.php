<form action="{{ url('/strategi-target/store_ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 28px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body px-5 pb-5 pt-2 bg-light" style="border-radius: 12px;">
                
                <div class="card border-0 mb-4 shadow-sm" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold mb-4" style="color: #333;">
                            <i class="fas fa-bullseye text-danger mr-2"></i> Penetapan Target Sales
                        </h6>
                        
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">NAMA SALES</label>
                                <select name="user_id" class="form-control" style="border-radius: 8px; background-color: #f8f9fa;">
                                    <option value="">- Pilih Sales -</option>
                                    @foreach($sales as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                <small class="error-text user_id-error text-danger"></small>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">PERIODE (BULAN & TAHUN)</label>
                                <input type="month" name="periode" class="form-control" value="{{ date('Y-m') }}" style="border-radius: 8px; background-color: #f8f9fa;">
                                <small class="error-text periode-error text-danger"></small>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold text-muted mb-1">TARGET (PS)</label>
                                <input type="number" name="jumlah_target" class="form-control" placeholder="100" style="border-radius: 8px;">
                                <small class="error-text jumlah_target-error text-danger"></small>
                            </div>

                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-danger btn-block font-weight-bold" style="border-radius: 8px;">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                            <label class="small font-weight-bold text-muted mb-3">TARGET YANG SUDAH DISET (BULAN INI):</label>
                            <p class="text-muted small font-italic mb-0">Data target yang sudah diisi akan otomatis muncul di tabel utama.</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold mb-4" style="color: #333;">
                            <i class="fas fa-file-upload text-danger mr-2"></i> Upload Materi Promosi & Strategi
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-7 border-right pr-4">
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">JUDUL MATERI</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Promo Ramadhan" style="border-radius: 8px;">
                                    <small class="error-text judul-error text-danger"></small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">DESKRIPSI / INSTRUKSI</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan detail promo atau strategi ini untuk sales..." style="border-radius: 8px;"></textarea>
                                    <small class="error-text deskripsi-error text-danger"></small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">KATEGORI</label>
                                    <select name="kategori" class="form-control" style="border-radius: 8px;">
                                        <option value="">- Pilih Kategori -</option>
                                        <option value="brosur">Brosur</option>
                                        <option value="poster">Poster</option>
                                        <option value="video">Video</option>
                                        <option value="presentasi">Presentasi</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <small class="error-text kategori-error text-danger"></small>
                                </div>
                            </div>
                            
                            <div class="col-md-5 pl-4 d-flex flex-column justify-content-center">
                                <label class="small font-weight-bold text-muted mb-1">FILE UPLOAD</label>
                                
                                <div class="border border-dashed text-center p-4 mb-3" style="border-radius: 10px; border-width: 2px; border-style: dashed !important; border-color: #ddd; background-color: #fafafa;">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="mb-0 font-weight-bold" style="color: #666;">Drag file ke sini</p>
                                    <small class="text-muted">Atau klik untuk memilih (JPG, PNG, PDF. Max 5MB)</small>
                                    <input type="file" name="file_promo" class="form-control-file mt-2 w-100 mx-auto" style="cursor: pointer;">
                                    <small class="error-text file_promo-error text-danger d-block"></small>
                                </div>

                                <button type="submit" class="btn btn-danger btn-block font-weight-bold" style="border-radius: 8px; padding: 10px;">
                                    <i class="fas fa-upload mr-1"></i> Upload & Bagikan
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
        $('#form-tambah').on('submit', function(e) {
            e.preventDefault();
            $('.error-text').text(''); // Bersihkan error lama
            
            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
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