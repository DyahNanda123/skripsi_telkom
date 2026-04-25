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
                        <i class="fas fa-eye text-danger mr-2"></i> Detail Materi Promosi & Strategi
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-7 border-right pr-4">
                            
                            <div class="mb-4">
                                <label class="small font-weight-bold text-muted mb-1 d-block text-uppercase">Judul Materi</label>
                                <h5 class="font-weight-bold text-dark">{{ $promo->judul }}</h5>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label class="small font-weight-bold text-muted mb-1 d-block text-uppercase">Kategori</label>
                                    <span class="badge badge-danger px-3 py-1 text-capitalize" style="font-size: 13px; border-radius: 6px;">
                                        {{ $promo->kategori ?? '-' }}
                                    </span>
                                </div>
                                
                                {{-- TAMBAHAN: TANGGAL KADALUWARSA DI SINI --}}
                                <div class="col-6">
                                    <label class="small font-weight-bold text-muted mb-1 d-block text-uppercase">Berlaku Sampai</label>
                                    <div class="text-danger font-weight-bold" style="font-size: 15px;">
                                        <i class="fas fa-calendar-times mr-1"></i>
                                        {{ $promo->tanggal_kadaluwarsa ? \Carbon\Carbon::parse($promo->tanggal_kadaluwarsa)->format('d M Y') : 'Selamanya' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="small font-weight-bold text-muted mb-1 d-block text-uppercase">Deskripsi / Instruksi</label>
                                <p class="text-dark" style="line-height: 1.6; font-size: 15px; background: #f8f9fa; padding: 12px; border-radius: 8px; border: 1px solid #eee;">
                                    {{ $promo->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-6">
                                    <label class="small font-weight-bold text-muted mb-0 text-uppercase">Diupload Oleh</label>
                                    <div class="text-dark font-weight-bold">{{ $promo->user ? $promo->user->nama_lengkap : 'Pimpinan' }}</div>
                                </div>
                                <div class="col-6">
                                    <label class="small font-weight-bold text-muted mb-0 text-uppercase">Tanggal Upload</label>
                                    <div class="text-dark font-weight-bold">{{ \Carbon\Carbon::parse($promo->created_at)->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-5 pl-4 d-flex flex-column justify-content-center align-items-center">
                            <label class="small font-weight-bold text-muted mb-3 text-uppercase text-center w-100">Preview File</label>
                            
                            @php
                                $ext = pathinfo($promo->file_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp

                            <div class="w-100 text-center d-flex flex-column justify-content-center align-items-center p-3" style="min-height: 250px; background-color: #fafafa; border-radius: 10px; border: 2px dashed #ddd;">
                                
                                @if($isImage)
                                    <img src="{{ asset($promo->file_path) }}" alt="Preview Promo" class="img-fluid shadow-sm" style="max-height: 220px; border-radius: 8px; object-fit: contain;">
                                @else
                                    <i class="fas fa-file-pdf text-danger mb-3" style="font-size: 60px;"></i>
                                    <h6 class="font-weight-bold text-muted px-2 text-truncate" style="max-width: 100%;">{{ $promo->judul }}.{{ $ext }}</h6>
                                @endif
                                                
                            </div>
                            <a href="{{ asset($promo->file_path) }}" target="_blank" class="btn btn-danger btn-block font-weight-bold text-white mt-3" style="border-radius: 8px; padding: 10px;">
                                <i class="fas fa-external-link-alt mr-1"></i> Buka File Full
                            </a>
                            
                            <button type="button" class="btn btn-light btn-block font-weight-bold mt-2" data-dismiss="modal" style="border-radius: 8px; padding: 10px; color: #555; border: 1px solid #ddd;">
                                Tutup Panel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>