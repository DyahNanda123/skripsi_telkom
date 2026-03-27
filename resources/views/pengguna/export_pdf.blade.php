<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Pengguna</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; } /* Font dikecilin dikit biar muat */
        .text-center { text-align: center; }
        .text-danger { color: #ed1c24; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
    </style>
</head>
<body>
    
    <h2 class="text-center text-danger" style="margin-bottom: 5px;">DATA LENGKAP KARYAWAN TELKOM</h2>
    <p class="text-center" style="margin-top: 0; color: #555;">Dicetak pada: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Lengkap</th>
                <th width="10%">NIP</th>
                <th width="8%">Role</th>
                <th width="10%">Wilayah</th>
                <th width="8%">Status</th>
                <th width="15%">Email</th>
                <th width="12%">No. HP</th>
                <th width="19%">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->nip }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->wilayah_kerja ?? '-' }}</td>
                <td class="text-center">{{ $user->status_aktif == 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>{{ $user->nomor_hp ?? '-' }}</td>
                <td>{{ $user->alamat ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>