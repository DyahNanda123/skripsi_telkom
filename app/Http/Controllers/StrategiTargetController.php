<?php

namespace App\Http\Controllers;

use App\Models\TargetSales;
use App\Models\StrategiPromosi;
use App\Models\Notifikasi; // TAMBAHAN WAJIB UNTUK NOTIFIKASI
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Can;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class StrategiTargetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index(Request $request) 
    {
        $sales = User::where('role', 'sales')->get();

        // Default ke bulan & tahun sekarang jika tidak ada filter
        $bulanFilter = $request->get('bulan', date('n'));
        $tahunFilter = $request->get('tahun', date('Y'));

        $queryTarget = TargetSales::with('user');
        
        if (auth()->user()->role == 'sales') {
            $queryTarget->where('user_id', auth()->id());
        } else {
            if ($request->has('sales') && $request->sales != '') {
                $queryTarget->where('user_id', $request->sales);
            }
        }
        
        if ($bulanFilter != '') { $queryTarget->where('bulan', $bulanFilter); }
        if ($tahunFilter != '') { $queryTarget->where('tahun', $tahunFilter); }
        
        $targets = $queryTarget->get();

        $promosis = StrategiPromosi::with('user')
            ->where(function($query) {
                $query->whereDate('tanggal_kadaluwarsa', '>=', now()->toDateString())
                      ->orWhereNull('tanggal_kadaluwarsa');
            })
            ->latest()
            ->get();
        // ----------------------------------------------------------

        $activeMenu = 'strategi_target'; 
        $breadcrumb = (object) [
            'title' => 'Strategi dan Target Sales',
            'list'  => ['Home', 'Strategi & Target']
        ];
        
        return view('StrategiTarget.index', compact(
            'sales', 'targets', 'promosis', 'activeMenu', 'breadcrumb',
            'bulanFilter', 'tahunFilter'
        ));
    }

   public function show_promo_ajax($id)
    {
        $promo = StrategiPromosi::with('user')->find($id);
        if (!$promo) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        return view('StrategiTarget.show_promo_ajax', compact('promo'));
    }

    public function export_excel(Request $request)
    {
        $queryTarget = TargetSales::with('user');
        if ($request->sales) { $queryTarget->where('user_id', $request->sales); }
        if ($request->bulan) { $queryTarget->where('bulan', $request->bulan); }
        $targets = $queryTarget->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Sales');
        $sheet->setCellValue('C1', 'Bulan');
        $sheet->setCellValue('D1', 'Tahun');
        $sheet->setCellValue('E1', 'Target (PS)');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $baris = 2;
        $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

        foreach ($targets as $index => $t) {
            $bulanCetak = $namaBulan[(string)$t->bulan] ?? $t->bulan;

            $sheet->setCellValue('A' . $baris, $index + 1);
            $sheet->setCellValue('B' . $baris, $t->user ? $t->user->nama_lengkap : '-');
            $sheet->setCellValue('C' . $baris, $bulanCetak);
            $sheet->setCellValue('D' . $baris, $t->tahun);
            $sheet->setCellValue('E' . $baris, $t->jumlah_target);
            $sheet->getStyle('A'.$baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $baris++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Target_Sales_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf(Request $request)
    {
        $queryTarget = TargetSales::with('user');
        if ($request->sales) { $queryTarget->where('user_id', $request->sales); }
        if ($request->bulan) { $queryTarget->where('bulan', $request->bulan); }
        $targets = $queryTarget->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('StrategiTarget.export_pdf', compact('targets'));
        
        return $pdf->download('Laporan_Target_Sales_' . date('Ymd_His') . '.pdf');
    }

    public function create_ajax()
    {
        $sales = User::where('role', 'sales')->get();
        return view('StrategiTarget.create_ajax', compact('sales'));
    }

    public function store_ajax(Request $request)
    {
        $isTargetMassal = $request->has('periode');
        $isPromo = $request->has('judul');

        if (!$isTargetMassal && !$isPromo) {
            return response()->json(['status' => false, 'message' => 'Silakan isi form!']);
        }

        // --- LOGIKA TARGET MASSAL ---
        if ($isTargetMassal) {
            $validatorTarget = Validator::make($request->all(), [
                'periode' => 'required',
                'target'  => 'required|array', 
            ]);

            if ($validatorTarget->fails()) return response()->json(['status' => false, 'msgField' => $validatorTarget->errors()]);

            $periode = explode('-', $request->periode);
            $tahun = $periode[0];
            $bulan = (string) ltrim($periode[1], '0'); 

            DB::beginTransaction();
            try {
                foreach ($request->input('target', []) as $user_id => $jumlah_target) {
                    if ($jumlah_target === null || $jumlah_target === '') continue;

                    TargetSales::updateOrCreate(
                        ['user_id' => $user_id, 'bulan' => $bulan, 'tahun' => $tahun],
                        ['jumlah_target' => $jumlah_target]
                    );

                    Notifikasi::create([
                        'user_id' => $user_id,
                        'judul'   => 'Target Baru',
                        'pesan'   => 'Pimpinan menetapkan target baru Anda sebesar ' . $jumlah_target . ' PS.',
                        'url'     => '/', 
                        'is_read' => 0
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
            }
        }
        
        // --- 🟢 PERBAIKAN: Simpan Strategi & Tanggal Kadaluwarsa ---
        if ($isPromo) {
            $validatorPromo = Validator::make($request->all(), [
                'judul' => 'required',
                'kategori' => 'required', 
                'tanggal_kadaluwarsa' => 'required|date',
                'file_promo' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            if ($validatorPromo->fails()) return response()->json(['status' => false, 'msgField' => $validatorPromo->errors()]);

            $file = $request->file('file_promo');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/promosi'), $nama_file);

            StrategiPromosi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'kategori' => $request->kategori, 
                'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa, // SIMPAN KE DB
                'file_path' => 'uploads/promosi/' . $nama_file,
                'user_id' => auth()->id() 
            ]);

            // Notifikasi (Sama seperti sebelumnya)
            $usersToNotify = User::whereIn('role', ['admin', 'sales'])->get();
            foreach ($usersToNotify as $usr) {
                Notifikasi::create([
                    'user_id' => $usr->id,
                    'judul'   => 'Strategi Promosi Baru',
                    'pesan'   => 'Pimpinan menambahkan strategi promosi baru.',
                    'url'     => '/strategi-target', 
                    'is_read' => 0
                ]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Data berhasil disimpan!']);
    }

    public function delete_target_ajax($id)
    {
        $target = TargetSales::find($id);
        if ($target) {
            $target->delete();
            return response()->json(['status' => true, 'message' => 'Target sales berhasil dihapus!']);
        }
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan!']);
    }

    public function delete_promo_ajax($id)
    {
        $promo = StrategiPromosi::find($id);
        if ($promo) {
            if (file_exists(public_path($promo->file_path))) { unlink(public_path($promo->file_path)); }
            $promo->delete();
            return response()->json(['status' => true, 'message' => 'Materi promosi berhasil dihapus!']);
        }
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan!']);
    }

    public function edit_promo_ajax($id)
    {
        $promo = StrategiPromosi::find($id);
        if (!$promo) return '<div class="modal-body text-center">Data tidak ditemukan!</div>';
        return view('StrategiTarget.edit_promo_ajax', compact('promo'));
    }

    public function update_promo_ajax(Request $request, $id)
    {
        $promo = StrategiPromosi::find($id);
        if (!$promo) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan!']);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'kategori' => 'required',
            'tanggal_kadaluwarsa' => 'required|date',
            'file_promo' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120', 
        ]);

        if ($validator->fails()) return response()->json(['status' => false, 'msgField' => $validator->errors()]);

        if ($request->hasFile('file_promo')) {
            if (file_exists(public_path($promo->file_path))) { unlink(public_path($promo->file_path)); }
            $file = $request->file('file_promo');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/promosi'), $nama_file);
            $promo->file_path = 'uploads/promosi/' . $nama_file;
        }

        // --- 🟢 PERBAIKAN: Update Data & Tanggal Kadaluwarsa ---
        $promo->judul = $request->judul;
        $promo->deskripsi = $request->deskripsi;
        $promo->kategori = $request->kategori;
        $promo->tanggal_kadaluwarsa = $request->tanggal_kadaluwarsa; // UPDATE KE DB
        $promo->save(); 

        return response()->json(['status' => true, 'message' => 'Materi Promosi berhasil diperbarui!']);
    }

    public function edit_target_ajax($id)
    {
        $target = TargetSales::find($id);
        $sales = User::where('role', 'sales')->get(); 

        if (!$target) {
            return '<div class="modal-body text-center">Data tidak ditemukan!</div>';
        }
        
        return view('StrategiTarget.edit_target_ajax', compact('target', 'sales'));
    }

    public function update_target_ajax(Request $request, $id)
    {
        $target = TargetSales::find($id);
        if (!$target) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan!']);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'periode' => 'required', 
            'jumlah_target' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $periode = explode('-', $request->periode);
        $tahun = $periode[0];
        $bulan = (string) ltrim($periode[1], '0'); 

        $target->user_id = $request->user_id;
        $target->bulan = $bulan;
        $target->tahun = $tahun;
        $target->jumlah_target = $request->jumlah_target;
        $target->save();

        // notifikasi edit target
        $salesPenerima = User::find($request->user_id);
        if ($salesPenerima) {
            // Notif untuk Sales
            Notifikasi::create([
                'user_id' => $salesPenerima->id,
                'judul'   => 'Perubahan Target',
                'pesan'   => 'Pimpinan mengubah target Anda.',
                'url'     => '/', 
                'is_read' => 0
            ]);

            // Notif untuk Admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notifikasi::create([
                    'user_id' => $admin->id,
                    'judul'   => 'Update Target Sales',
                    'pesan'   => 'Pimpinan mengubah target untuk Sales ' . $salesPenerima->nama_lengkap,
                    'url'     => '/strategi-target',
                    'is_read' => 0
                ]);
            }
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Target Sales berhasil diperbarui!'
        ]);
    }
}