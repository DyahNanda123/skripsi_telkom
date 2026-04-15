<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\TargetSales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. DATA WAJIB UNTUK TEMPLATE
        $breadcrumb = (object) [
            'title' => 'DASHBOARD',
            'list'  => ['Home', 'Dashboard']
        ];
        $activeMenu = 'dashboard';

        // Jika yg login sales
        if ($user->role == 'sales') {
            $userId = $user->id;
            $tahunSekarang = date('Y');
      
            $bulan = $request->bulan ?? date('n'); 

            // 1. Total Visit & Total PS (Sesuai Filter Bulan)
            $visitQuery = Kunjungan::where('user_id', $userId)->whereYear('created_at', $tahunSekarang);
            $psQuery = Kunjungan::where('user_id', $userId)->where('hasil_kunjungan', 'Berlangganan')->whereYear('created_at', $tahunSekarang);

            if ($bulan) {
                $visitQuery->whereMonth('created_at', $bulan);
                $psQuery->whereMonth('created_at', $bulan);
            }

            $totalVisit = $visitQuery->count();
            $totalPS = $psQuery->count();

            // 2. Data Grafik Visit dan PS 
            $labelBulan = [];
            $visitPerBulan = [];
            $psPerBulan = [];

            if ($bulan) {
                for ($i = 5; $i >= 0; $i--) {
                    $date = Carbon::create($tahunSekarang, $bulan, 1)->subMonths($i);
                    $labelBulan[] = $date->translatedFormat('M Y');
                    $visitPerBulan[] = Kunjungan::where('user_id', $userId)->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
                    $psPerBulan[] = Kunjungan::where('user_id', $userId)->where('hasil_kunjungan', 'Berlangganan')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
                }
            } else {
                for ($i = 1; $i <= 12; $i++) {
                    $date = Carbon::create($tahunSekarang, $i, 1);
                    $labelBulan[] = $date->translatedFormat('M');
                    $visitPerBulan[] = Kunjungan::where('user_id', $userId)->whereMonth('created_at', $i)->whereYear('created_at', $tahunSekarang)->count();
                    $psPerBulan[] = Kunjungan::where('user_id', $userId)->where('hasil_kunjungan', 'Berlangganan')->whereMonth('created_at', $i)->whereYear('created_at', $tahunSekarang)->count();
                }
            }

            // 3. PS Berdasarkan STO
            $stoQuery = Kunjungan::with('calonPelanggan')
                            ->where('user_id', $userId)
                            ->where('hasil_kunjungan', 'Berlangganan')
                            ->whereYear('created_at', $tahunSekarang);
            
            if ($bulan) {
                $stoQuery->whereMonth('created_at', $bulan);
            }

            $psByStoRaw = $stoQuery->get()->groupBy(function($item) {
                                return $item->calonPelanggan->sto ?? 'Unknown';
                            })->map->count();

            $stoLabels = ['GGR', 'JGO', 'KRJ', 'MGT', 'NWI', 'SAR', 'WKO'];
            $stoData = [];
            foreach ($stoLabels as $sto) {
                $stoData[] = $psByStoRaw[$sto] ?? 0;
            }

            // 4. DATA TARGET 
            $dataTargetDB = TargetSales::where('user_id', $userId)
                                       ->where('bulan', $bulan)
                                       ->where('tahun', $tahunSekarang)
                                       ->first();
     
            $jumlah_target = $dataTargetDB ? $dataTargetDB->jumlah_target : 0;
            $realisasi = $totalPS; 

            // Hitung Persentase Target untuk Bar
            $persentase = $jumlah_target > 0 ? round(($realisasi / $jumlah_target) * 100) : 0;

            // Set Warna untuk View
            if ($persentase >= 100) {
                $textColor = '#10b981'; $barColor = 'bg-success';
            } elseif ($persentase >= 80) {
                $textColor = '#0ea5e9'; $barColor = 'bg-info';
            } elseif ($persentase > 0) {
                $textColor = '#f59e0b'; $barColor = 'bg-warning';
            } else {
                $textColor = '#ef4444'; $barColor = 'bg-danger';
            }

            return view('dashboard.sales', compact(
                'breadcrumb', 'activeMenu', 'bulan', 'labelBulan',
                'totalVisit', 'totalPS', 'visitPerBulan', 'psPerBulan', 
                'stoLabels', 'stoData', 
                'jumlah_target', 'realisasi', 'persentase', 'textColor', 'barColor'
            ));
        }

        // JIKA YANG LOGIN ADALAH ADMIN / PIMPINAN
     
        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');

        $visitQuery = Kunjungan::whereYear('created_at', $tahun)->where('status', 'Selesai');
        $psQuery = Kunjungan::whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan');
        
        if ($bulan) {
            $visitQuery->whereMonth('created_at', $bulan);
            $psQuery->whereMonth('created_at', $bulan);
        }
        
        $totalVisit = $visitQuery->count();
        $customerPS = $psQuery->count();
        $konversiProspek = $totalVisit > 0 ? round(($customerPS / $totalVisit) * 100, 1) : 0;

        // Logika Growth
        if ($bulan) {
            $bulanLalu = $bulan == 1 ? 12 : $bulan - 1;
            $tahunLalu = $bulan == 1 ? $tahun - 1 : $tahun;
            $psLalu = Kunjungan::whereMonth('created_at', $bulanLalu)->whereYear('created_at', $tahunLalu)->where('hasil_kunjungan', 'Berlangganan')->count();
        } else {
            $tahunLalu = $tahun - 1;
            $psLalu = Kunjungan::whereYear('created_at', $tahunLalu)->where('hasil_kunjungan', 'Berlangganan')->count();
        }
        
        if ($psLalu > 0) {
            $growth = round((($customerPS - $psLalu) / $psLalu) * 100, 1);
        } else {
            $growth = $customerPS > 0 ? 100 : 0;
        }

        $labelBulan = [];
        $dataVisitGrafik = [];
        $dataPSGrafik = [];
        
        if ($bulan) {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::create($tahun, $bulan, 1)->subMonths($i);
                $labelBulan[] = $date->translatedFormat('M Y'); 
                $dataVisitGrafik[] = Kunjungan::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('status', 'Selesai')->count();
                $dataPSGrafik[] = Kunjungan::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('hasil_kunjungan', 'Berlangganan')->count();
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::create($tahun, $i, 1);
                $labelBulan[] = $date->translatedFormat('M'); 
                $dataVisitGrafik[] = Kunjungan::whereMonth('created_at', $i)->whereYear('created_at', $tahun)->where('status', 'Selesai')->count();
                $dataPSGrafik[] = Kunjungan::whereMonth('created_at', $i)->whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan')->count();
            }
        }

        // TOP SALES
        $topSalesQuery = Kunjungan::select('user_id', DB::raw('count(*) as total_ps'))->with('user')->whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan');
        if ($bulan) $topSalesQuery->whereMonth('created_at', $bulan);
        $topSales = $topSalesQuery->groupBy('user_id')->orderByDesc('total_ps')->take(5)->get();

        // PENCAPAIAN TARGET
        $targetQuery = TargetSales::where('tahun', $tahun);
        if ($bulan) $targetQuery->where('bulan', $bulan);
        $totalTargetRencana = $targetQuery->sum('jumlah_target');
        
        $pencapaianTarget = $totalTargetRencana > 0 ? round(($customerPS / $totalTargetRencana) * 100, 1) : 0;

        // PS BERDASARKAN STO
        $stoQuery = Kunjungan::join('calon_pelanggan', 'kunjungan.calon_pelanggan_id', '=', 'calon_pelanggan.id')
            ->select('calon_pelanggan.sto', DB::raw('count(*) as total'))
            ->whereYear('kunjungan.created_at', $tahun)->where('kunjungan.hasil_kunjungan', 'Berlangganan');
        if ($bulan) $stoQuery->whereMonth('kunjungan.created_at', $bulan);
        $psPerSTO = $stoQuery->groupBy('calon_pelanggan.sto')->get();

        $labelSTO = $psPerSTO->pluck('sto')->toArray();
        $dataSTO = $psPerSTO->pluck('total')->toArray();

        return view('dashboard.admin', compact(
            'breadcrumb', 'activeMenu', 'bulan', 'tahun',
            'totalVisit', 'customerPS', 'konversiProspek', 'growth',
            'labelBulan', 'dataVisitGrafik', 'dataPSGrafik',
            'topSales', 'totalTargetRencana', 'pencapaianTarget',
            'labelSTO', 'dataSTO'
        ));
    }
}