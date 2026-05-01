@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'SUKSES',
                    text: 'DATA BERHASIL DISIMPAN!',
                    confirmButtonColor: '#28a745', 
                    confirmButtonText: 'Continue',
                    customClass: {
                        title: 'font-weight-bold'
                    }
                });
            </script>
            @endif

            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Akun</h3>
                </div>
                
                <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        
                        <div class="row bg-light p-3 mb-4 rounded border">
                            <div class="col-md-4">
                                <label>NIP</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->nip }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Jabatan (Role)</label>
                                <input type="text" class="form-control" value="{{ strtoupper(auth()->user()->role) }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Status Aktif</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->status_aktif == 1 ? 'Aktif' : 'Non-Aktif' }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ auth()->user()->nama_lengkap }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor HP</label>
                                    <input type="text" name="nomor_hp" class="form-control" value="{{ auth()->user()->nomor_hp }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Wilayah Kerja</label>
                                    <input type="text" name="wilayah_kerja" class="form-control" value="{{ auth()->user()->wilayah_kerja }}" placeholder="Contoh: Witel Ngawi">
                                </div>
                                
                                {{-- PERUBAHAN DI SINI BEBB! Penambahan @error penangkap validasi --}}
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ganti">
                                    @error('password')
                                        <small class="text-danger font-weight-bold mt-1 d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Foto Profil Baru</label>
                                    <input type="file" name="foto_profil" class="form-control" accept="image/png, image/jpeg, image/jpg">
                                    <small class="text-muted">Format: JPG/PNG. Maks 2MB.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ auth()->user()->alamat }}</textarea>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection