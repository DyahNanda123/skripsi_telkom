<form action="{{ url('/kunjungan/'.$kunjungan->id.'/simpan_hasil_ajax') }}" method="POST" id="form-hasil" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-warning text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Form Hasil Kunjungan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                
                {{-- 1. INFORMASI UMUM --}}
                <div class="card bg-light mb-4 border-0">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-danger mb-3 border-bottom pb-2">INFORMASI UMUM</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="text-muted mb-0">Tanggal Kunjungan</label>
                                <p class="font-weight-bold">{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('d F Y') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted mb-0">Nama Sales</label>
                                <p class="font-weight-bold">{{ $kunjungan->user->nama_lengkap }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted mb-0">Nama Pelanggan</label>
                                <p class="font-weight-bold">{{ $kunjungan->calonPelanggan->nama_pelanggan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. DATA TEKNIS & KOMPETITOR --}}
                <h6 class="font-weight-bold text-danger mb-3 border-bottom pb-2">DATA TEKNIS & KOMPETITOR</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 form-group">
                        <label>Nama PIC</label>
                        <input type="text" name="nama_pic" class="form-control" value="{{ $kunjungan->nama_pic }}"placeholder="Cth: Ibu Dyah">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>No. HP PIC</label>
                        <input type="text" name="no_hp_pic" class="form-control" value="{{ $kunjungan->no_hp_pic }}"placeholder="Cth: 000000000000">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kebutuhan Utama</label>
                        <input type="text" name="kebutuhan_utama" class="form-control" value="{{ $kunjungan->kebutuhan_utama }}"placeholder="Cth: Cepat">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Provider Eksisting</label>
                        <input type="text" name="provider_eksisting" class="form-control" value="{{ $kunjungan->calonPelanggan->provider_eksisting }}" placeholder="Cth: Indihome">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Speed Eksisting</label>
                        <input type="text" name="speed_eksisting" class="form-control" value="{{ $kunjungan->calonPelanggan->speed_eksisting }}" placeholder="Cth: 50MBPS">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Tagihan Bulanan</label>
                        <input type="text" name="tagihan_bulanan" class="form-control" value="{{ $kunjungan->calonPelanggan->tagihan_bulanan }}" placeholder="Cth: 50000">
                    </div>
                </div>

                {{-- 3. HASIL KUNJUNGAN & BUKTI --}}
                <h6 class="font-weight-bold text-danger mb-3 border-bottom pb-2">HASIL KUNJUNGAN & BUKTI</h6>
                <div class="form-group mb-3">
                    <label>Hasil Akhir Kunjungan <span class="text-danger">*</span></label>
                    <select name="hasil_kunjungan" class="form-control" required>
                        <option value="">-- Pilih Hasil Akhir --</option>
                        <option value="Berlangganan">Berhasil Berlangganan (PS)</option>
                        <option value="Belum">Belum Berlangganan</option> 
                    </select>
                    <small class="error-text hasil_kunjungan-error text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kesimpulan / Catatan Sales <span class="text-danger">*</span></label>
                    <textarea name="catatan_sales" class="form-control" rows="3" placeholder="Tuliskan catatan hasil pertemuan di sini..." required></textarea>
                    <small class="error-text catatan_sales-error text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bukti Foto Kunjungan</label>
                    <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                    <small class="error-text bukti_foto-error text-danger d-block"></small>
                </div>

            </div>
            <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 20px;">Tutup</button>
                <button type="submit" class="btn btn-primary" style="border-radius: 20px;"><i class="fas fa-save mr-1"></i> Simpan Hasil</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-hasil').on('submit', function(e) {
            e.preventDefault();
            
            $('.error-text').text('');
            
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
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataKunjungan.ajax.reload();
                    } else {
                        $.each(response.msgField, function(prefix, val) {
                            $('.'+prefix+'-error').text(val[0]);
                        });
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan sistem!');
                }
            });
        });
    });
</script>