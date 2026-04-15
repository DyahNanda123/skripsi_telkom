<div id="modal-master" class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    
        <div class="modal-header border-0 pb-2 pt-4 px-4 d-flex justify-content-between align-items-center" style="background-color: #fdfdfd; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <div>
                <h4 class="modal-title font-weight-bold mb-1" style="color: #1a1a1a;">Detail Kunjungan Lapangan</h4>
                <small style="color: #888; font-weight: 500;">
                    ID Kunjungan: #VST-{{ $kunjungan->created_at ? \Carbon\Carbon::parse($kunjungan->created_at)->format('Ymd') : date('Ymd') }}-{{ str_pad($kunjungan->id, 3, '0', STR_PAD_LEFT) }}
                </small>
            </div>
            <div>
    
                @if($kunjungan->status == 'Selesai')
                    <span class="badge badge-success px-4 py-2" style="border-radius: 20px; font-weight: 600; letter-spacing: 0.5px;">SELESAI</span>
                @elseif($kunjungan->status == 'Progress')
                    <span class="badge badge-info px-4 py-2" style="border-radius: 20px; font-weight: 600; letter-spacing: 0.5px;">PROGRESS</span>
                @else
                    <span class="badge badge-warning px-4 py-2" style="border-radius: 20px; font-weight: 600; letter-spacing: 0.5px; color: #fff;">FOLLOW UP</span>
                @endif
            </div>
        </div>
        
        <hr class="mx-4 my-0" style="border-top: 1px solid #f0f0f0;">

        <div class="modal-body px-4 pt-4 pb-4" style="background-color: #ffffff;">
  
            <h6 class="font-weight-bold mb-3" style="color: #4a5568;">INFORMASI UMUM</h6>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Tanggal Kunjungan</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">
                        {{ $kunjungan->created_at ? \Carbon\Carbon::parse($kunjungan->created_at)->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Nama Sales</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">
                        {{ $kunjungan->user ? $kunjungan->user->nama_lengkap : 'Sales Tidak Diketahui' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Nama Pelanggan</label>
                    <div style="font-size: 15px; font-weight: 600; color: #e53e3e;">
                        {{ $kunjungan->calonPelanggan ? $kunjungan->calonPelanggan->nama_pelanggan : 'Data Terhapus' }}
                    </div>
                </div>
            </div>

            <h6 class="font-weight-bold mb-3 mt-4" style="color: #4a5568;">DATA TEKNIS & KOMPETITOR</h6>
            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Nama PIC (Kontak)</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">{{ $kunjungan->nama_pic ?? '-' }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">No. HP PIC</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">{{ $kunjungan->no_hp_pic ?? '-' }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Kebutuhan Utama</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">{{ $kunjungan->kebutuhan_utama ?? '-' }}</div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Provider Eksisting</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">{{ $kunjungan->provider_eksisting ?? '-' }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Speed Eksisting</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">{{ $kunjungan->speed_eksisting ?? '-' }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted text-uppercase mb-1" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Tagihan Bulanan</label>
                    <div style="font-size: 15px; font-weight: 600; color: #2d3748;">
                        {{ $kunjungan->tagihan_bulanan ? 'Rp ' . number_format($kunjungan->tagihan_bulanan, 0, ',', '.') . ' / bln' : '-' }}
                    </div>
                </div>
            </div>

            <h6 class="font-weight-bold mb-3 mt-4" style="color: #4a5568;">HASIL KUNJUNGAN & BUKTI</h6>
            <div class="p-4" style="border: 1px solid #e2e8f0; border-radius: 12px; background-color: #fafbfc;">
                
                <div class="mb-4 text-center p-3" style="border-radius: 8px; border: 1px dashed #cbd5e0; background-color: {{ $kunjungan->hasil_kunjungan == 'Berlangganan' ? '#f0fff4' : ($kunjungan->hasil_kunjungan == 'Belum' ? '#fff5f5' : '#f7fafc') }};">
                    <h6 class="small text-muted text-uppercase mb-2 font-weight-bold" style="letter-spacing: 1px;">Hasil Akhir Kunjungan</h6>
                    
                    @if($kunjungan->hasil_kunjungan == 'Berlangganan')
                        <h4 class="mb-0 font-weight-bold text-success"><i class="fas fa-check-circle mr-2"></i>Berhasil Berlangganan (PS)</h4>
                    @elseif($kunjungan->hasil_kunjungan == 'Belum')
                        <h4 class="mb-0 font-weight-bold text-danger"><i class="fas fa-times-circle mr-2"></i>Belum Berlangganan (Tunda/Menolak)</h4>
                    @else
                        <h5 class="mb-0 font-weight-bold text-secondary"><i class="fas fa-hourglass-half mr-2"></i>Belum Ada Keputusan</h5>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="small text-muted text-uppercase mb-2" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Kesimpulan / Catatan Sales</label>
                        <div class="p-3" style="background-color: #fff; border: 1px solid #edf2f7; border-radius: 8px; min-height: 150px; font-size: 14px; color: #4a5568; line-height: 1.6;">
                            {{ $kunjungan->kesimpulan ?? 'Belum ada kesimpulan yang dicatat.' }}
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <label class="small text-muted text-uppercase mb-2" style="font-weight: 600; font-size: 11px; letter-spacing: 0.5px;">Bukti Foto Lokasi</label>
                        <div class="p-1" style="background-color: #fff; border: 1px solid #edf2f7; border-radius: 8px; height: 150px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; background-color: #e2e8f0;">
                            
                            @if($kunjungan->bukti_foto)
                                <img src="{{ asset('uploads/kunjungan/' . $kunjungan->bukti_foto) }}" alt="Bukti Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                <div style="position: absolute; bottom: 8px; left: 8px; background-color: rgba(0,0,0,0.6); color: white; font-size: 11px; padding: 4px 10px; border-radius: 15px;">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $kunjungan->calonPelanggan->nama_pelanggan ?? 'Lokasi' }}
                                </div>
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-2x mb-2 text-secondary"></i><br>
                                    <small>Belum ada foto yang diunggah</small>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer border-0 pb-4 pt-2 px-4 justify-content-end" style="background-color: #ffffff; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
            <button type="button" class="btn btn-danger px-4 font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Tutup Detail</button>
        </div>
    </div>
</div>