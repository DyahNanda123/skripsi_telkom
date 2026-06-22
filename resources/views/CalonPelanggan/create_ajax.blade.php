<div id="modal-master" class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    
    {{-- FORM LANGSUNG DIJADIKAN MODAL-CONTENT --}}
    <form action="{{ url('/calon_pelanggan/store_ajax') }}" method="POST" id="form-tambah" class="modal-content" style="border-radius: 15px;">
        @csrf
        
        <div class="modal-header border-0 pb-0">
            <div>
                <h4 class="modal-title font-weight-bold">Data Pelanggan/Calon Pelanggan Baru</h4>
                <small class="text-muted">Lengkapi informasi prospek atau pelanggan di bawah ini.</small>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
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
                        <div class="input-group">
                            <input type="text" name="link_maps" id="link_maps" class="form-control" placeholder="http://googleusercontent.com/maps...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalPeta">📍 Pilih Peta</button>
                            </div>
                        </div>
                        <small id="error-link_maps" class="error-text text-danger"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Wilayah</label>
                        <select name="wilayah" id="wilayah" class="form-control">
                            <option value="">Pilih Wilayah...</option>
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
        
    </form>
</div>

{{-- MODAL PETA LEAFLET --}}
<div class="modal fade" id="modalPeta" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cari & Pilih Lokasi Maps</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted small mb-2">1. Ketik nama tempat di icon kaca pembesar.<br>2. <b>Double Click (Klik 2x)</b> pada peta untuk konfirmasi titik lokasi.</p>
        <div id="mapPicker" style="width: 100%; height: 400px; border-radius: 8px;"></div>
      </div>
    </div>
  </div>
</div>

{{-- SCRIPT AJAX & LEAFLET --}}
<script>
// SCRIPT AJAX BAWAAN
$(document).on('submit', '#form-tambah', function(e) {
    e.preventDefault();

    let form = $(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            $('.error-text').text(''); 

            if (response.status) {
                $('#myModal').modal('hide'); 
                $('.modal').modal('hide'); 
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
               
                form[0].reset();

                if (typeof tableCalonPelanggan !== 'undefined') {
                    tableCalonPelanggan.ajax.reload(null, false);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

            } else {

                $('#myModal').modal('hide');
                $('#modalPeta').modal('hide');

                setTimeout(function() {

                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('body').css('padding-right', '');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });

                }, 300);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Terjadi kesalahan di server. Pastikan semua kolom diisi dengan benar.'
            });
        }
    });
});

// SCRIPT LEAFLET MAPS
var map;
var marker;

$('#modalPeta').on('shown.bs.modal', function () {
    if (!map) {
        // Set awal ke area Madiun/Magetan/Ngawi (Bisa diganti kordinatnya)
        map = L.map('mapPicker').setView([-7.644872, 111.326302], 10); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Fitur Search Geocoder
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari (Contoh: SMAN 1 Plaosan)..."
        })
        .on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());
        })
        .addTo(map);

        // Event Double Click buat ambil kordinat
        map.on('dblclick', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Bikin link google maps
            var googleMapsLink = "https://www.google.com/maps?q=" + lat + "," + lng;

            // Tempel ke input form
            $('#link_maps').val(googleMapsLink);

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);

            // Tutup modal peta
            $('#modalPeta').modal('hide');
        });
    }
    
    // Fix map render issue di dalam modal
    setTimeout(function() {
        map.invalidateSize();
    }, 100);
});
</script>