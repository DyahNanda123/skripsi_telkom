<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Calon Pelanggan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h3 { text-align: center; margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #555; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h3>DATA CALON PELANGGAN / PELANGGAN</h3>
    
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama</th>
                <th width="20%">Alamat</th>
                <th width="8%">Wilayah</th>
                <th width="5%">STO</th>
                <th width="12%">Jenis</th>
                <th width="12%">Maps</th>
                <th width="10%">Status Langganan</th>
                <th width="10%">Status Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->nama_pelanggan }}</td>
                <td>{{ $p->alamat }}</td>
                <td class="text-center">{{ $p->wilayah }}</td>
                <td class="text-center">{{ $p->sto }}</td>
                <td>{{ $p->jenis_pelanggan }}</td>
                <td>{{ $p->link_maps ?? '-' }}</td>
                <td class="text-center">{{ $p->status_langganan }}</td>
                <td class="text-center">{{ $p->status_visit }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>