<!DOCTYPE html>
<html>
<head>
    <title>Laporan Target Sales</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
    </style>
</head>
<body>

    <div class="text-center">
        <div class="header-title">LAPORAN TARGET SALES</div>
        <div>PT Telkom Indonesia (Persero) Tbk. Witel Ngawi</div>
        <div>Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th width="35%">NAMA SALES</th>
                <th width="20%" class="text-center">PERIODE (BULAN/TAHUN)</th>
                <th width="20%" class="text-center">TARGET (PS)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            @endphp
            
            @forelse($targets as $index => $t)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $t->user ? $t->user->nama_lengkap : 'Data Terhapus' }}</td>
                    <td class="text-center">{{ $namaBulan[(string)$t->bulan] ?? $t->bulan }} {{ $t->tahun }}</td>
                    <td class="text-center">{{ $t->jumlah_target }} PS</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data target sales.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>