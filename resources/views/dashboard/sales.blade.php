@extends('layouts.template')

@section('content')
<div class="container-fluid pt-3">
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
        </form>
    </div>
    
    <div class="row mb-4">
        <div class="col-lg-6 col-12">
            <div class="small-box shadow-sm text-white" style="background-color: #3498db; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">{{ $totalVisit }}</h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Total Visit</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="small-box shadow-sm text-white" style="background-color: #e74c3c; border-radius: 12px;">
                <div class="inner" style="padding: 25px 20px;">
                    <h3 style="font-size: 2.5rem; font-weight: 700;">{{ $totalPS }}</h3>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.9;">Customer PS</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">Grafik Visit dan PS</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3" style="font-size: 12px; color: #6c757d;">
                        <div class="mr-3"><i class="fas fa-circle text-success mr-1"></i> Visit</div>
                        <div><i class="fas fa-circle text-primary mr-1"></i> PS</div>
                    </div>
                    
                    <div style="height: 280px; position: relative; width: 100%;">
                        <canvas id="lineChartVisitPS"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="font-weight-bold" style="color: #2d3748;">Target Pencapaian (Sales)</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="d-flex w-100 mb-2" style="font-size: 12px; color: #6c757d;">
                        <div class="mr-3"><i class="fas fa-circle text-primary mr-1"></i> Achieved ({{ $realisasi }}/{{ $jumlah_target }} PS)</div>
                        <div><i class="fas fa-circle" style="color: #e9ecef; margin-right: 4px;"></i> Remaining</div>
                    </div>

                    <div style="height: 200px; position: relative; width: 100%;">
                        <canvas id="gaugeChartTarget"></canvas>
                    </div>
                    <h3 class="font-weight-bold mt-3 mb-0" style="color: #2d3748;">{{ $persentase }}%</h3>
                </div>
            </div>
        </div>
      
        <div class="col-md-7">
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
    // --- 1. GRAFIK GARIS (VISIT & PS)  ---
    var ctxLine = document.getElementById('lineChartVisitPS').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelBulan) !!}, 
            datasets: [
                {
                    label: 'Total Visit',
                    data: {!! json_encode($visitPerBulan) !!},
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 2,
                    tension: 0.4, 
                    fill: true
                },
                {
                    label: 'Customer PS',
                    data: {!! json_encode($psPerBulan) !!},
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

    // --- 2. GRAFIK TARGET (DOUGHNUT) ---
    var ctxGauge = document.getElementById('gaugeChartTarget').getContext('2d');
    
    var pencapaianSales = {{ $persentase }}; 
    var sisaSales = 100 - pencapaianSales; 
    if(sisaSales < 0) sisaSales = 0; 

    new Chart(ctxGauge, {
        type: 'doughnut',
        data: {
            labels: ['Achieved', 'Remaining'],
            datasets: [{
                data: [pencapaianSales, sisaSales],
                backgroundColor: ['#007bff', '#e9ecef'], 
                borderWidth: 0
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            cutout: '75%', 
            plugins: { legend: { display: false } } 
        }
    });

    // --- 3. GRAFIK BAR STO ---
    var ctxBar = document.getElementById('barChartSTO').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stoLabels) !!},
            datasets: [{
                label: 'Jumlah PS',
                data: {!! json_encode($stoData) !!},
                backgroundColor: '#00a8ff',
                borderRadius: 5 
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } 
        }
    });

</script>
@endpush