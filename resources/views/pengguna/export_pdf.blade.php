<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Data Pengguna</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; } /* Ukuran font 11px biar muat banyak kolom */
        .text-center { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 6px 8px; } /* Padding disesuaikan */
        .table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
    </style>
</head>
<body>

    {{-- KOP SURAT / HEADER LAPORAN --}}
    <div class="text-center">
        <div class="header-title">Data Lengkap Karyawan</div>
        <div>PT Telkom Indonesia (Persero) Tbk. Witel Ngawi</div>
        <div style="margin-top: 5px; color: #555;">Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    </div>

    {{-- TABEL DATA --}}
    <table class="table">
        <thead>
            <tr>
                <th width="3%" class="text-center">NO</th>
                <th width="15%">NAMA LENGKAP</th>
                <th width="10%" class="text-center">NIP</th>
                <th width="8%" class="text-center">ROLE</th>
                <th width="10%">WILAYAH</th>
                <th width="8%" class="text-center">STATUS</th>
                <th width="15%">EMAIL</th>
                <th width="12%" class="text-center">NO. HP</th>
                <th width="19%">ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td class="text-center">{{ $user->nip }}</td>
                <td class="text-center">{{ ucfirst($user->role) }}</td>
                <td>{{ $user->wilayah_kerja ?? '-' }}</td>
                <td class="text-center">{{ $user->status_aktif == 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td class="text-center">{{ $user->nomor_hp ?? '-' }}</td>
                <td>{{ $user->alamat ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Belum ada data pengguna/karyawan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>