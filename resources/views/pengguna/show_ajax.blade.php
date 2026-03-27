<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 20px; padding: 15px;">
        
        <div class="modal-header border-0 d-block text-center pb-0">
            <h4 class="modal-title" style="font-weight: 500; color: #555;">Detail Pengguna</h4>
            <hr style="border-top: 3px solid #555; width: 100%; margin-top: 10px; margin-bottom: 0;">
        </div>

        <div class="modal-body pt-2 pb-4">
            
            <div class="text-center mb-4">
                <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('adminlte/dist/img/user2-160x160.jpg') }}" 
                     alt="Foto Profil" class="img-circle elevation-2 mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                <h5 style="font-weight: 600; color: #333; margin-bottom: 0;">{{ $user->nama_lengkap }}</h5>
                <p class="text-muted" style="font-size: 14px; margin-bottom: 0;">{{ $user->nip }}</p>
            </div>

            <div class="px-3">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th width="40%" class="text-muted" style="font-weight: normal;">Role (Jabatan)</th>
                        <td width="5%">:</td>
                        <td style="font-weight: 500;">{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted" style="font-weight: normal;">Wilayah Kerja</th>
                        <td>:</td>
                        <td style="font-weight: 500;">{{ $user->wilayah_kerja ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted" style="font-weight: normal;">Status Akun</th>
                        <td>:</td>
                        <td>
                            @if($user->status_aktif == 1)
                                <span class="badge badge-success px-3 py-1" style="border-radius: 20px; font-weight: normal;">Active</span>
                            @else
                                <span class="badge badge-secondary px-3 py-1" style="border-radius: 20px; font-weight: normal;">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted" style="font-weight: normal;">Email</th>
                        <td>:</td>
                        <td style="font-weight: 500;">{{ $user->email ?? 'Belum diisi' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted" style="font-weight: normal;">Nomor HP</th>
                        <td>:</td>
                        <td style="font-weight: 500;">{{ $user->nomor_hp ?? 'Belum diisi' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted" style="font-weight: normal;">Alamat</th>
                        <td>:</td>
                        <td style="font-weight: 500;">{{ $user->alamat ?? 'Belum diisi' }}</td>
                    </tr>
                </table>
            </div>
            
        </div>

        <div class="modal-footer border-0 justify-content-center pt-0">
            <button type="button" class="btn btn-danger px-4" data-dismiss="modal" style="border-radius: 25px; min-width: 130px;">Tutup</button>
        </div>
        
    </div>
</div>