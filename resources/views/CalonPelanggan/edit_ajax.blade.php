<form action="{{ url('/calon_pelanggan/' . $CalonPelanggan->id . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h4 class="modal-title font-weight-bold">Edit Data Pelanggan/Calon Pelanggan</h4>
                    <small class="text-muted">Perbarui informasi prospek atau pelanggan di bawah ini.</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <hr class="mx-4">
            <div class="modal-body pt-0">
                <div class="form-group">
                    <label class="small font-weight-bold text-uppercase">Nama Pelanggan / Toko <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="{{ $CalonPelanggan->nama_pelanggan }}" required>
                    <small id="error-nama_pelanggan" class="error-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Jenis Pelanggan</label>
                            <select name="jenis_pelanggan" id="jenis_pelanggan" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                <option value="Agrikultur" {{ $CalonPelanggan->jenis_pelanggan == 'Agrikultur' ? 'selected' : '' }}>Agrikultur</option>
                                <option value="Energi" {{ $CalonPelanggan->jenis_pelanggan == 'Energi' ? 'selected' : '' }}>Energi</option>
                                <option value="Sekolah" {{ $CalonPelanggan->jenis_pelanggan == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                <option value="Ekspedisi" {{ $CalonPelanggan->jenis_pelanggan == 'Ekspedisi' ? 'selected' : '' }}>Ekspedisi</option>
                                <option value="Manufaktur" {{ $CalonPelanggan->jenis_pelanggan == 'Manufaktur' ? 'selected' : '' }}>Manufaktur</option>
                                <option value="Puskesmas/RS" {{ $CalonPelanggan->jenis_pelanggan == 'Puskesmas/RS' ? 'selected' : '' }}>Puskesmas/RS</option>
                                <option value="SPPG" {{ $CalonPelanggan->jenis_pelanggan == 'SPPG' ? 'selected' : '' }}>SPPG</option>
                                <option value="Media & Komunikasi" {{ $CalonPelanggan->jenis_pelanggan == 'Media & Komunikasi' ? 'selected' : '' }}>Media & Komunikasi</option>
                                <option value="Multifinance" {{ $CalonPelanggan->jenis_pelanggan == 'Multifinance' ? 'selected' : '' }}>Multifinance</option>
                                <option value="Properti" {{ $CalonPelanggan->jenis_pelanggan == 'Properti' ? 'selected' : '' }}>Properti</option>
                                <option value="Hotel" {{ $CalonPelanggan->jenis_pelanggan == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="Ruko" {{ $CalonPelanggan->jenis_pelanggan == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                            </select>
                            <small id="error-jenis_pelanggan" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Link Google Maps</label>
                            <div class="input-group">
                                <input type="text" name="link_maps" id="link_maps_edit" class="form-control" value="{{ $CalonPelanggan->link_maps }}" placeholder="http://googleusercontent.com/maps...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalPetaEdit">📍 Edit Peta</button>
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
                                <option value="Magetan" {{ $CalonPelanggan->wilayah == 'Magetan' ? 'selected' : '' }}>Magetan</option>
                                <option value="Ngawi" {{ $CalonPelanggan->wilayah == 'Ngawi' ? 'selected' : '' }}>Ngawi</option>
                            </select>
                            <small id="error-wilayah" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">STO (Sentral)</label>
                            <select name="sto" id="sto" class="form-control">
                                <option value="">Pilih STO...</option>
                                <option value="GGR" {{ $CalonPelanggan->sto == 'GGR' ? 'selected' : '' }}>GGR</option>
                                <option value="JGO" {{ $CalonPelanggan->sto == 'JGO' ? 'selected' : '' }}>JGO</option>
                                <option value="KRJ" {{ $CalonPelanggan->sto == 'KRJ' ? 'selected' : '' }}>KRJ</option>
                                <option value="MGT" {{ $CalonPelanggan->sto == 'MGT' ? 'selected' : '' }}>MGT</option>
                                <option value="NWI" {{ $CalonPelanggan->sto == 'NWI' ? 'selected' : '' }}>NWI</option>
                                <option value="SAR" {{ $CalonPelanggan->sto == 'SAR' ? 'selected' : '' }}>SAR</option>
                                <option value="WKU" {{ $CalonPelanggan->sto == 'WKU' ? 'selected' : '' }}>WKU</option>
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
                                <option value="Berlangganan" {{ $CalonPelanggan->status_langganan == 'Berlangganan' ? 'selected' : '' }}>Berlangganan</option>
                                <option value="Belum Berlangganan" {{ $CalonPelanggan->status_langganan == 'Belum Berlangganan' ? 'selected' : '' }}>Belum Berlangganan</option>
                            </select>
                            <small id="error-status_langganan" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-uppercase">Status Kunjungan (Visit)</label>
                            <select name="status_visit" id="status_visit" class="form-control">
                                <option value="Sudah Visit" {{ $CalonPelanggan->status_visit == 'Sudah Visit' ? 'selected' : '' }}>Sudah Visit</option>
                                <option value="Belum Visit" {{ $CalonPelanggan->status_visit == 'Belum Visit' ? 'selected' : '' }}>Belum Visit</option>
                                <option value="Progress" {{ $CalonPelanggan->status_visit == 'Progress' ? 'selected' : '' }}>Progress</option>
                                <option value="Follow Up" {{ $CalonPelanggan->status_visit == 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                            </select>
                            <small id="error-status_visit" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="small font-weight-bold text-uppercase">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $CalonPelanggan->alamat }}</textarea>
                    <small id="error-alamat" class="error-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-danger px-4" style="border-radius: 8px;">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modalPetaEdit" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Lokasi Maps Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted small mb-2">1. Gunakan icon kaca pembesar di peta jika ingin pindah lokasi alamat baru.<br>2. <b>Double Click (Klik 2x)</b> pada peta untuk memperbarui titik koordinat lokasi.</p>
        <div id="mapPickerEdit" style="width: 100%; height: 400px; border-radius: 8px;"></div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // SCRIPT UTAMA AJAX BAWAAN KAMU
    $("#form-edit").on('submit', function(e) {
        e.preventDefault(); 
        
        let form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: "POST", 
            data: form.serialize(),
            success: function(response) {
                $('.error-text').text('');
                
                if(response.status) {
                    $('#myModal').modal('hide');
                    $('.modal-backdrop').remove(); 
                    $('body').removeClass('modal-open');
                    $('body').css('padding-right', '');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    if (typeof tableCalonPelanggan !== 'undefined') {
                        tableCalonPelanggan.ajax.reload(null, false);
                    }
                } else {
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-'+prefix).text(val[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Terjadi kesalahan sistem.'
                });
                console.log(xhr.responseText);
            }
        });
    });

    // --- SCRIPT BARU: INTEGRASI LEAFLET MAPS PADA FORM EDIT ---
    var mapEdit;
    var markerEdit;

    $('#modalPetaEdit').on('shown.bs.modal', function () {
        var currentLink = $('#link_maps_edit').val();
        var defaultLat = -7.644872; // Default koordinat Jawa Timur (Magetan/Ngawi sekitar)
        var defaultLng = 111.326302;
        var hasOldLocation = false;

        // Mendeteksi koordinat lama dari format URL "maps.google.com/5lat,lng"
        if (currentLink) {
            var match = currentLink.match(/com\/5(-?\d+\.\d+),(-?\d+\.\d+)/);
            if (match) {
                defaultLat = parseFloat(match[1]);
                defaultLng = parseFloat(match[2]);
                hasOldLocation = true;
            }
        }

        if (!mapEdit) {
            mapEdit = L.map('mapPickerEdit').setView([defaultLat, defaultLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapEdit);

            // Jika koordinat lama terdeteksi, berikan pin marker merah
            if (hasOldLocation) {
                var redIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });
                markerEdit = L.marker([defaultLat, defaultLng], {icon: redIcon}).addTo(mapEdit).bindPopup("Lokasi Toko Saat Ini").openPopup();
            }

            // Tambah kontrol pencarian alamat (Geocoder)
            var geocoderEdit = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: "Cari alamat baru..."
            })
            .on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                mapEdit.fitBounds(poly.getBounds());
            })
            .addTo(mapEdit);

            // Aksi Double Click untuk mengambil titik koordinat baru
            mapEdit.on('dblclick', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                var googleMapsLink = "https://www.google.com/maps?q=" + lat + "," + lng;
                $('#link_maps_edit').val(googleMapsLink);

                if (markerEdit) {
                    mapEdit.removeLayer(markerEdit);
                }
                
                // Gunakan marker default untuk lokasi baru
                markerEdit = L.marker([lat, lng]).addTo(mapEdit);

                // Otomatis menutup modal peta setelah dipilih
                $('#modalPetaEdit').modal('hide');
            });
        } else {
            // Jika peta sudah ada, reposisi ke lokasi ter-update
            mapEdit.setView([defaultLat, defaultLng], 15);
            if (hasOldLocation) {
                if (markerEdit) { mapEdit.removeLayer(markerEdit); }
                var redIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });
                markerEdit = L.marker([defaultLat, defaultLng], {icon: redIcon}).addTo(mapEdit).bindPopup("Lokasi Toko Saat Ini").openPopup();
            }
        }
        
        // Fix rendering peta abu-abu sebagian di modal Bootstrap
        setTimeout(function() {
            mapEdit.invalidateSize();
        }, 200);
    });
});
</script>