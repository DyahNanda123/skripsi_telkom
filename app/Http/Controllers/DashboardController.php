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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. LOGIKA FILTER (BULAN & TAHUN)
        // Jika user belum pilih bulan, default bulan sekarang (date 'n').
        // Jika user pilih "Semua Bulan" (value ""), maka $bulan akan berisi string kosong.
        $bulan = $request->has('bulan') ? $request->bulan : date('n'); 
        $tahun = $request->get('tahun', date('Y'));

        // DATA WAJIB UNTUK TEMPLATE
        $breadcrumb = (object) [
            'title' => 'DASHBOARD',
            'list'  => ['Home', 'Dashboard']
        ];
        $activeMenu = 'dashboard';

        // --- LOGIKA DASHBOARD KHUSUS SALES ---
        if ($user->role == 'sales') {
            $userId = $user->id;

            // Box Atas: Total Visit & Total PS (Sinkron dengan filter)
            $totalVisit = Kunjungan::where('user_id', $userId)
                ->whereYear('created_at', $tahun)
                ->when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('created_at', $bulan);
                })->count();

            $totalPS = Kunjungan::where('user_id', $userId)
                ->where('hasil_kunjungan', 'Berlangganan')
                ->whereYear('created_at', $tahun)
                ->when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('created_at', $bulan);
                })->count();

            // Data Grafik Visit dan PS
            $labelBulan = []; $visitPerBulan = []; $psPerBulan = [];
            if ($bulan) {
                // Jika pilih bulan tertentu: Tampilkan progres 6 bulan ke belakang
                for ($i = 5; $i >= 0; $i--) {
                    $date = Carbon::create($tahun, $bulan, 1)->subMonths($i);
                    $labelBulan[] = $date->translatedFormat('M Y');
                    $visitPerBulan[] = Kunjungan::where('user_id', $userId)->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
                    $psPerBulan[] = Kunjungan::where('user_id', $userId)->where('hasil_kunjungan', 'Berlangganan')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
                }
            } else {
                // Jika "Semua Bulan": Tampilkan grafik Januari - Desember
                for ($i = 1; $i <= 12; $i++) {
                    $date = Carbon::create($tahun, $i, 1);
                    $labelBulan[] = $date->translatedFormat('M');
                    $visitPerBulan[] = Kunjungan::where('user_id', $userId)->whereMonth('created_at', $i)->whereYear('created_at', $tahun)->count();
                    $psPerBulan[] = Kunjungan::where('user_id', $userId)->where('hasil_kunjungan', 'Berlangganan')->whereMonth('created_at', $i)->whereYear('created_at', $tahun)->count();
                }
            }

            // PS Berdasarkan STO (Filter Responsif)
            $stoLabels = ['GGR', 'JGO', 'KRJ', 'MGT', 'NWI', 'SAR', 'WKO'];
            $psByStoRaw = Kunjungan::with('calonPelanggan')
                ->where('user_id', $userId)
                ->where('hasil_kunjungan', 'Berlangganan')
                ->whereYear('created_at', $tahun)
                ->when($bulan, function ($query) use ($bulan) {
                    return $query->whereMonth('created_at', $bulan);
                })->get()->groupBy(function($item) {
                    return $item->calonPelanggan->sto ?? 'Unknown';
                })->map->count();

            $stoData = array_map(fn($sto) => $psByStoRaw[$sto] ?? 0, $stoLabels);

            // Perhitungan Target (Akumulasi jika Semua Bulan)
            $targetQuery = TargetSales::where('user_id', $userId)->where('tahun', $tahun);
            $jumlah_target = $bulan ? $targetQuery->where('bulan', $bulan)->sum('jumlah_target') : $targetQuery->sum('jumlah_target');
            
            $realisasi = $totalPS; 
            $persentase = $jumlah_target > 0 ? round(($realisasi / $jumlah_target) * 100) : 0;
            $barColor = $persentase >= 100 ? 'bg-success' : ($persentase >= 80 ? 'bg-info' : ($persentase > 0 ? 'bg-warning' : 'bg-danger'));
            $textColor = $persentase >= 100 ? '#10b981' : ($persentase >= 80 ? '#0ea5e9' : ($persentase > 0 ? '#f59e0b' : '#ef4444'));

            return view('dashboard.sales', compact(
                'breadcrumb', 'activeMenu', 'bulan', 'tahun', 'labelBulan',
                'totalVisit', 'totalPS', 'visitPerBulan', 'psPerBulan', 
                'stoLabels', 'stoData', 'jumlah_target', 'realisasi', 'persentase', 'textColor', 'barColor'
            ));
        }

        // --- LOGIKA DASHBOARD UNTUK ADMIN / PIMPINAN ---
        $visitQuery = Kunjungan::whereYear('created_at', $tahun)->where('status', 'Selesai');
        $psQuery = Kunjungan::whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan');
        
        if ($bulan) {
            $visitQuery->whereMonth('created_at', $bulan);
            $psQuery->whereMonth('created_at', $bulan);
        }
        
        $totalVisit = $visitQuery->count();
        $customerPS = $psQuery->count();
        $konversiProspek = $totalVisit > 0 ? round(($customerPS / $totalVisit) * 100, 1) : 0;

        // Logika Growth (Pertumbuhan dibanding periode sebelumnya)
        $prevBulan = $bulan ? ($bulan == 1 ? 12 : $bulan - 1) : null;
        $prevTahun = ($bulan == 1) ? $tahun - 1 : ($bulan ? $tahun : $tahun - 1);
        $psLalu = Kunjungan::where('hasil_kunjungan', 'Berlangganan')
            ->whereYear('created_at', $prevTahun)
            ->when($prevBulan, fn($q) => $q->whereMonth('created_at', $prevBulan))
            ->count();
        $growth = $psLalu > 0 ? round((($customerPS - $psLalu) / $psLalu) * 100, 1) : ($customerPS > 0 ? 100 : 0);

        // Grafik Admin
        $labelBulan = []; $dataVisitGrafik = []; $dataPSGrafik = [];
        if ($bulan) {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::create($tahun, $bulan, 1)->subMonths($i);
                $labelBulan[] = $date->translatedFormat('M Y'); 
                $dataVisitGrafik[] = Kunjungan::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('status', 'Selesai')->count();
                $dataPSGrafik[] = Kunjungan::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('hasil_kunjungan', 'Berlangganan')->count();
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $labelBulan[] = Carbon::create($tahun, $i, 1)->translatedFormat('M'); 
                $dataVisitGrafik[] = Kunjungan::whereMonth('created_at', $i)->whereYear('created_at', $tahun)->where('status', 'Selesai')->count();
                $dataPSGrafik[] = Kunjungan::whereMonth('created_at', $i)->whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan')->count();
            }
        }

        // Top 5 Sales & Pencapaian Target Nasional
        $topSales = Kunjungan::select('user_id', DB::raw('count(*) as total_ps'))->with('user')
            ->whereYear('created_at', $tahun)->where('hasil_kunjungan', 'Berlangganan')
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->groupBy('user_id')->orderByDesc('total_ps')->take(5)->get();

        $totalTargetRencana = TargetSales::where('tahun', $tahun)->when($bulan, fn($q) => $q->where('bulan', $bulan))->sum('jumlah_target');
        $pencapaianTarget = $totalTargetRencana > 0 ? round(($customerPS / $totalTargetRencana) * 100, 1) : 0;

        return view('dashboard.admin', compact(
            'breadcrumb', 'activeMenu', 'bulan', 'tahun', 'totalVisit', 'customerPS', 'konversiProspek', 'growth',
            'labelBulan', 'dataVisitGrafik', 'dataPSGrafik', 'topSales', 'totalTargetRencana', 'pencapaianTarget'
        ));
    }
}