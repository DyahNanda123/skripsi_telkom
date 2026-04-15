<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Data Calon Pelanggan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; } 
        .text-center { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; word-wrap: break-word; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase; }
        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
    </style>
</head>
<body>

    {{-- KOP SURAT / HEADER LAPORAN --}}
    <div class="text-center">
        <div class="header-title">Laporan Data Calon Pelanggan / Pelanggan</div>
        <div>PT Telkom Indonesia (Persero) Tbk. Witel Ngawi</div>
        <div style="margin-top: 5px; color: #555;">Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    </div>
    
    {{-- TABEL DATA --}}
    <table class="table">
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="15%">NAMA</th>
                <th width="20%">ALAMAT</th>
                <th width="10%">WILAYAH</th>
                <th width="5%">STO</th>
                <th width="12%">JENIS</th>
                <th width="15%">MAPS</th>
                <th width="10%">STATUS LANGGANAN</th>
                <th width="10%">STATUS KUNJUNGAN</th>
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
                <td colspan="9" class="text-center py-3">Belum ada data calon pelanggan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>