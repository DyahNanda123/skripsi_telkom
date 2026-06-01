<!DOCTYPE html>
<html>
<head>
    <title>Laporan Target & Realisasi Sales</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #666; padding: 6px 8px; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; color: #d32f2f; }
        .sub-title { font-size: 12px; font-weight: bold; margin-bottom: 3px; }
    </style>
</head>
<body>

    <div class="text-center">
        <div class="header-title">LAPORAN TARGET & REALISASI SALES</div>
        <div class="sub-title">PT Telkom Indonesia (Persero) Tbk. Witel Ngawi</div>
        <div>Dicetak pada: {{ date('d-m-Y H:i') }} WIB</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th width="30%">NAMA SALES</th>
                <th width="20%" class="text-center">PERIODE</th>
                <th width="15%" class="text-center">TARGET</th>
                <th width="15%" class="text-center">REALISASI</th>
                <th width="15%" class="text-center">PENCAPAIAN (%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            @endphp
            
            @forelse($targets as $index => $t)
                @php
                    // Mengambil data realisasi yang telah dihitung di Controller
                    $realisasi = $t->realisasi ?? 0;
                    $persen = $t->jumlah_target > 0 ? ($realisasi / $t->jumlah_target) * 100 : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $t->user ? $t->user->nama_lengkap : 'Data Terhapus' }}</td>
                    <td class="text-center">{{ $namaBulan[(string)$t->bulan] ?? $t->bulan }} {{ $t->tahun }}</td>
                    <td class="text-center">{{ $t->jumlah_target }} PS</td>
                    <td class="text-center">{{ $realisasi }} PS</td>
                    <td class="text-center" style="font-weight: bold; color: {{ $persen >= 100 ? 'green' : 'red' }};">
                        {{ number_format($persen, 1) }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data target dan realisasi sales.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>