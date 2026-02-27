@extends('layouts.template')

@section('content')
    {{-- <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- Tambahkan text-danger agar judul berwarna merah --}}
                    {{-- <h1 class="text-danger font-weight-bold">Dashboard</h1>
                </div>
            </div>
        </div>
    </section> --}} 

    <div class="row mb-3">
                <div class="col-sm-4 col-md-3 col-lg-2">
                    <select class="form-control" name="filter_bulan" id="filter_bulan">
                        <option value="">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>11</h3>
                            <p>Total Visit</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>20<sup style="font-size: 20px">%</sup></h3>
                            <p>Konversi Prospek</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Customer PS</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>+10<sup style="font-size: 20px">%</sup></h3>
                            <p>Presentase Kenaikan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-6">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Grafik Visit dan PS</h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted"><i class="fas fa-chart-line fa-3x mb-2 d-block text-center"></i> (Tempat Chart Garis)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">TOP SALES</h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted"><i class="fas fa-chart-pie fa-3x mb-2 d-block text-center"></i> (Tempat Chart Donut)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Target</h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted"><i class="fas fa-bullseye fa-3x mb-2 d-block text-center"></i> (Tempat Chart Lingkaran)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">PS Berdasarkan STO</h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <span class="text-muted"><i class="fas fa-chart-bar fa-3x mb-2 d-block text-center"></i> (Tempat Chart Batang)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection