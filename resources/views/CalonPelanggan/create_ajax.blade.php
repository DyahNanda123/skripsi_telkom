<form action="{{ url('/calon_pelanggan/store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h4 class="modal-title font-weight-bold">Data Pelanggan/Calon Pelanggan Baru</h4>
                    <small class="text-muted">Lengkapi informasi prospek atau pelanggan di bawah ini.</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <hr class="mx-4">
            <div class="modal-body pt-0">
                <div class="form-group">
                    <label class="small font-weight-bold text-uppercase">Nama Pelanggan / Toko <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" placeholder="Contoh: Toko Berkah Jaya / SMAN 1 Ngawi" required>
                    <small id="error-nama_pelanggan" class="error-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Jenis Pelanggan</label>
                            <select name="jenis_pelanggan" id="jenis_pelanggan" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                <option value="Agrikultur">Agrikultur</option>
                                <option value="Energi">Energi</option>
                                <option value="Sekolah">Sekolah</option>
                                <option value="Ekspedisi">Ekspedisi</option>
                                <option value="Manufaktur">Manufaktur</option>
                                <option value="Puskesmas/RS">Puskesmas/RS</option>
                                <option value="SPPG">SPPG</option>
                                <option value="Media & Komunikasi">Media & Komunikasi</option>
                                <option value="Multifinance">Multifinance</option>
                                <option value="Properti">Properti</option>
                                <option value="Hotel">Hotel</option>
                                <option value="Ruko">Ruko</option>
                            </select>
                            <small id="error-jenis_pelanggan" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Link Google Maps</label>
                            <input type="text" name="link_maps" id="link_maps" class="form-control" placeholder="https://maps.app.goo.gl/...">
                            <small id="error-link_maps" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Wilayah</label>
                            {{-- <input type="text" name="wilayah" id="wilayah" class="form-control" placeholder="NGAWI"> --}}
                            <select name="wilayah" id="wilayah" class="form-control">
                                <option value="">Pilih Wilayah...</option>
                                {{-- <option value="">- STO -</option> --}}
                                <option value="Magetan">Magetan</option>
                                <option value="Ngawi">Ngawi</option>
                            </select>
                            <small id="error-wilayah" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">STO (Sentral)</label>
                            <select name="sto" id="sto" class="form-control">
                                <option value="">Pilih STO...</option>
                                {{-- <option value="">- STO -</option> --}}
                                <option value="GGR">GGR</option>
                                <option value="JGO">JGO</option>
                                <option value="KRJ">KRJ</option>
                                <option value="MGT">MGT</option>
                                <option value="NWI">NWI</option>
                                <option value="SAR">SAR</option>
                                <option value="WKU">WKU</option>
                            </select>
                            <small id="error-sto" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Status Langganan</label>
                            <select name="status_langganan" id="status_langganan" class="form-control">
                                <option value="Berlangganan">Berlangganan</option>
                                <option value="Belum Berlangganan">Belum Berlangganan</option>
                            </select>
                            <small id="error-status_langganan" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Status Kunjungan (Visit)</label>
                            <select name="status_visit" id="status_visit" class="form-control">
                                <option value="Sudah Visit">Sudah Visit</option>
                                <option value="Belum Visit">Belum Visit</option>
                                <option value="Progress">Progress</option>
                                <option value="Follow Up">Follow Up</option>
                            </select>
                            <small id="error-status_visit" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="small font-weight-bold text-uppercase">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan nama jalan, RT/RW, nomor rumah, dan patokan..." required></textarea>
                    <small id="error-alamat" class="error-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-danger px-4" style="border-radius: 8px;">Simpan Data</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).on('submit', '#form-tambah', function(e) {
    e.preventDefault();

    let form = $(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            $('.error-text').text(''); // Bersihkan pesan error lama

            if (response.status) {
                // 1️⃣ Tutup modal (Cek apakah ID-nya #myModal atau #modal-master)
                // Kita coba panggil keduanya agar pasti tertutup
                $('#myModal').modal('hide'); 
                $('.modal').modal('hide'); // Menutup semua modal yang terbuka
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove(); // Hapus bayangan hitam modal

                // 2️⃣ Reset isi form agar bersih saat dibuka lagi
                form[0].reset();

                // 3️⃣ Reload tabel agar data baru langsung muncul
                if (typeof tableCalonPelanggan !== 'undefined') {
                    tableCalonPelanggan.ajax.reload(null, false);
                }

                // 4️⃣ Tampilkan notifikasi yang otomatis hilang dalam 1.5 detik
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

            } else {
                // Tampilkan pesan error validasi per kolom
                $.each(response.msgField, function(key, value) {
                    $('#error-' + key).text(value[0]);
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message
                });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Terjadi kesalahan di server. Pastikan semua kolom ENUM diisi dengan benar.'
            });
        }
    });
});
</script>