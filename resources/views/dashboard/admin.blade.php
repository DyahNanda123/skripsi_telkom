@extends('layouts.template')

@section('content')
<div class="container-fluid pt-3">
    
    {{-- HEADER & FILTER BULAN DAN TAHUN --}}
    <div class="d-flex justify-content-end mb-4">
        <form method="GET" action="{{ url('/') }}" class="d-flex align-items-center">
            
            {{-- Dropdown Bulan --}}
            <label class="mr-2 mb-0 font-weight-bold" style="color: #4a5568;">Bulan:</label>
            <select name="bulan" class="form-control shadow-sm mr-3" style="border-radius: 20px; width: 160px; border: 1px solid #cbd5e0;" onchange="this.form.submit()">
                <option value="">- Semua Bulan -</option>
                @php
                    $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                @endphp
                @foreach($namaBulan as $key => $nama)
                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>

            {{-- Dropdown Tahun --}}
            <label class="mr-2 mb-0 font-weight-bold" style="color: #4a5568;">Tahun:</label>
            <select name="tahun" class="form-control shadow-sm" style="border-radius: 20px; width: 110px; border: 1px solid #cbd5e0;" onchange="this.form.submit()">
                @php $tahunSekarang = date('Y'); @endphp
                @for($t = $tahunSekarang; $t >= 2024; $t--)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
            
        </form>
    </div>
    {{--dashboard kotak di atas--}}
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box shadow-sm text-white" style="background-color: #3498db; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">{{ $totalVisit }}</h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Total Visit</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box shadow-sm text-white" style="background-color: #f39c12; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">{{ $konversiProspek }}<sup style="font-size: 20px">%</sup></h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Konversi Prospek</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box shadow-sm text-white" style="background-color: #e74c3c; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">{{ $customerPS }}</h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Customer PS</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box shadow-sm text-white" style="background-color: #2ecc71; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">
                        @if($growth >= 0) +{{ $growth }}% @else {{ $growth }}% @endif
                    </h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Presentase Kenaikan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
       {{--dashboard baris 1--}}
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">Grafik Visit dan PS</h6>
                </div>
                <div class="card-body">
                    <div style="height: 280px; position: relative; width: 100%;">
                        <canvas id="lineChartVisitPS"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">TOP SALES (PS Terbanyak)</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div style="height: 280px; position: relative; width: 100%;">
                        <canvas id="pieChartTopSales"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{--dashboard baris 2--}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">Pencapaian Target Keseluruhan</h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div style="height: 180px; position: relative; width: 100%;">
                        <canvas id="gaugeChartTarget"></canvas>
                    </div>
                    <h3 class="font-weight-bold text-primary mt-3 mb-0">{{ $pencapaianTarget }}%</h3>
                    <small class="text-muted font-weight-bold">Tercapai dari target {{ $totalTargetRencana }} PS</small>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">PS Berdasarkan STO</h6>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div style="height: 230px; position: relative; width: 100%;">
                        <canvas id="barChartSTO"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    
    // 1. GRAFIK GARIS
    var ctxLine = document.getElementById('lineChartVisitPS').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelBulan) !!}, 
            datasets: [
                {
                    label: 'Total Visit',
                    data: {!! json_encode($dataVisitGrafik) !!},
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 2,
                    tension: 0.4, 
                    fill: true
                },
                {
                    label: 'Customer PS',
                    data: {!! json_encode($dataPSGrafik) !!},
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 2. GRAFIK DOUGHNUT
    var ctxPie = document.getElementById('pieChartTopSales').getContext('2d');
    var topSalesData = @json($topSales);
    var labelsSales = topSalesData.map(function(item) { return item.user ? item.user.nama_lengkap : 'Terhapus'; });
    var dataSales = topSalesData.map(function(item) { return item.total_ps; });

    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: labelsSales.length > 0 ? labelsSales : ['Belum Ada Data'],
            datasets: [{
                data: dataSales.length > 0 ? dataSales : [1],
                backgroundColor: ['#9b59b6', '#ff7675', '#74b9ff', '#55efc4', '#ffeaa7'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '65%' }
    });

    // 3. GRAFIK TARGET
    var ctxGauge = document.getElementById('gaugeChartTarget').getContext('2d');
    var pencapaian = {{ $pencapaianTarget }}; // ngambil angka dr controller
    var sisa = 100 - pencapaian; // ngitung sisa ruang
    if(sisa < 0) sisa = 0; 

    new Chart(ctxGauge, {
        type: 'doughnut',
        data: {
            labels: ['Achieved', 'Remaining'],
            datasets: [{
                data: [pencapaian, sisa],
                backgroundColor: ['#007bff', '#e9ecef'], 
                borderWidth: 0
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '75%', 
            plugins: { legend: { display: false } } 
        }
    });

    // 4. GRAFIK STO
    var ctxBar = document.getElementById('barChartSTO').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelSTO) !!}.length > 0 ? {!! json_encode($labelSTO) !!} : ['NWI', 'MGT', 'SAR'],
            datasets: [{
                label: 'Jumlah PS',
                data: {!! json_encode($dataSTO) !!}.length > 0 ? {!! json_encode($dataSTO) !!} : [0, 0, 0],
                backgroundColor: '#00a8ff',
                borderRadius: 5 
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } 
        }
    });

});
</script>
@endpush