<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 15px;">
        <div class="modal-header border-0 pb-0">
            <div>
                <h4 class="modal-title font-weight-bold">Detail Data Pelanggan/Calon Pelanggan</h4>
                <small class="text-muted">Informasi detail prospek atau pelanggan.</small>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <hr class="mx-4">
        <div class="modal-body pt-0">
            <div class="form-group">
                <label class="small font-weight-bold text-uppercase">Nama Pelanggan / Toko</label>
                <input type="text" class="form-control" value="{{ $CalonPelanggan->nama_pelanggan }}" disabled>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Jenis Pelanggan</label>
                        <select class="form-control" disabled>
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Link Google Maps</label>
                        <input type="text" class="form-control" value="{{ $CalonPelanggan->link_maps }}" disabled>
                        {{-- disertakan link sehingga maps langsung mengarah ke link--}}
                        @if($CalonPelanggan->link_maps)
                            <a href="{{ $CalonPelanggan->link_maps }}" target="_blank" class="btn btn-sm btn-info mt-2" style="border-radius: 8px;">
                                <i class="fas fa-map-marker-alt"></i> Buka Maps
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Wilayah</label>
                        <select class="form-control" disabled>
                            <option value="">Pilih Wilayah...</option>
                            <option value="Magetan" {{ $CalonPelanggan->wilayah == 'Magetan' ? 'selected' : '' }}>Magetan</option>
                            <option value="Ngawi" {{ $CalonPelanggan->wilayah == 'Ngawi' ? 'selected' : '' }}>Ngawi</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">STO (Sentral)</label>
                        <select class="form-control" disabled>
                            <option value="">Pilih STO...</option>
                            <option value="GGR" {{ $CalonPelanggan->sto == 'GGR' ? 'selected' : '' }}>GGR</option>
                            <option value="JGO" {{ $CalonPelanggan->sto == 'JGO' ? 'selected' : '' }}>JGO</option>
                            <option value="KRJ" {{ $CalonPelanggan->sto == 'KRJ' ? 'selected' : '' }}>KRJ</option>
                            <option value="MGT" {{ $CalonPelanggan->sto == 'MGT' ? 'selected' : '' }}>MGT</option>
                            <option value="NWI" {{ $CalonPelanggan->sto == 'NWI' ? 'selected' : '' }}>NWI</option>
                            <option value="SAR" {{ $CalonPelanggan->sto == 'SAR' ? 'selected' : '' }}>SAR</option>
                            <option value="WKU" {{ $CalonPelanggan->sto == 'WKU' ? 'selected' : '' }}>WKU</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Status Langganan</label>
                        <select class="form-control" disabled>
                            <option value="Berlangganan" {{ $CalonPelanggan->status_langganan == 'Berlangganan' ? 'selected' : '' }}>Berlangganan</option>
                            <option value="Belum Berlangganan" {{ $CalonPelanggan->status_langganan == 'Belum Berlangganan' ? 'selected' : '' }}>Belum Berlangganan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold text-uppercase">Status Kunjungan (Visit)</label>
                        <select class="form-control" disabled>
                            <option value="Sudah Visit" {{ $CalonPelanggan->status_visit == 'Sudah Visit' ? 'selected' : '' }}>Sudah Visit</option>
                            <option value="Belum Visit" {{ $CalonPelanggan->status_visit == 'Belum Visit' ? 'selected' : '' }}>Belum Visit</option>
                            <option value="Progress" {{ $CalonPelanggan->status_visit == 'Progress' ? 'selected' : '' }}>Progress</option>
                            <option value="Follow Up" {{ $CalonPelanggan->status_visit == 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="small font-weight-bold text-uppercase">Alamat Lengkap</label>
                <textarea class="form-control" rows="3" disabled>{{ $CalonPelanggan->alamat }}</textarea>
            </div>
        </div>
        <div class="modal-footer border-0 d-flex justify-content-end">
        @if(auth()->check() && auth()->user()->role == 'sales')
        <form action="{{ url('/kunjungan/mulai/' . $CalonPelanggan->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success px-4 me-2" style="border-radius: 8px;">
                <i class="fas fa-clipboard-check"></i> Lakukan Kunjungan
            </button>
        </form>
        @endif
        <button type="button" 
                class="btn btn-danger px-4" 
                data-dismiss="modal" 
                style="border-radius: 8px;">
            Tutup
        </button>
        </div> 
    </div>
</div>