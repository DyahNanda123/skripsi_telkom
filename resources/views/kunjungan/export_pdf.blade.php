<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Data Kunjungan Lapangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; } 
        .text-center { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; vertical-align: top; word-wrap: break-word; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase; }
        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
    </style>
</head>
<body>

    {{-- KOP SURAT / HEADER LAPORAN --}}
    <div class="text-center">
        <div class="header-title">Laporan Data Kunjungan Lapangan (Sales)</div>
        <div>PT Telkom Indonesia (Persero) Tbk. Witel Ngawi</div>
        <div style="margin-top: 5px; color: #555;">Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    </div>
    
    {{-- TABEL DATA --}}
    <table class="table">
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="9%">ID KUNJUNGAN</th>
                <th width="7%">TANGGAL</th>
                <th width="10%">NAMA SALES</th>
                <th width="12%">NAMA PELANGGAN</th>
                <th width="10%">NAMA PIC</th>
                <th width="8%">NO. HP PIC</th>
                <th width="11%">KEBUTUHAN UTAMA</th>
                <th width="8%">PROVIDER LAMA</th>
                <th width="6%">SPEED LAMA</th>
                <th width="7%">TAGIHAN</th>
                <th width="6%">STATUS</th>
                <th width="13%">KESIMPULAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungans as $index => $k)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $k->created_at ? '#VST-' . \Carbon\Carbon::parse($k->created_at)->format('Ymd') . '-' . str_pad($k->id, 3, '0', STR_PAD_LEFT) : '-' }}
                </td>
                <td class="text-center">{{ $k->created_at ? \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') : '-' }}</td>
                <td>{{ $k->user ? $k->user->nama_lengkap : '-' }}</td>
                <td>{{ $k->calonPelanggan ? $k->calonPelanggan->nama_pelanggan : '-' }}</td>
                <td>{{ $k->nama_pic ?? '-' }}</td>
                <td>{{ $k->no_hp_pic ?? '-' }}</td>
                <td>{{ $k->kebutuhan_utama ?? '-' }}</td>
                <td class="text-center">{{ $k->provider_eksisting ?? '-' }}</td>
                <td class="text-center">{{ $k->speed_eksisting ?? '-' }}</td>
                <td class="text-center">{{ $k->tagihan_bulanan ? number_format($k->tagihan_bulanan, 0, ',', '.') : '-' }}</td>
                <td class="text-center">{{ $k->status }}</td>
                <td>{{ $k->kesimpulan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center py-3">Belum ada data kunjungan lapangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>