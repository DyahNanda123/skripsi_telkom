<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\CalonPelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Can;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    public function index()
{
    $activeMenu = 'kunjungan'; 
    
    $breadcrumb = (object) [
        'title' => 'Data Kunjungan Sales',
        'list'  => ['Home', 'Kunjungan'] 
    ];

    $sales = User::where('role', 'sales')->get();
    $user = Auth::user(); 

    // 1. Inisialisasi variabel supaya tidak undefined di View
    $jumlahProgress = 0;
    $kunjungans = collect(); // Bikin koleksi kosong dulu biar aman

    if ($user->role == 'sales') {
        $jumlahProgress = Kunjungan::where('user_id', $user->id)
                                  ->where('status', 'Progress')
                                  ->count();
        
        $kunjungans = Kunjungan::with('calonPelanggan')
                                ->where('user_id', $user->id)
                                ->get();
    } else {
        // Ambil data untuk Admin/Pimpinan
        $kunjungans = Kunjungan::with(['calonPelanggan', 'user'])->get();
    }

    // Pastikan semua variabel ini masuk ke compact
    return view('kunjungan.index', compact('sales', 'activeMenu', 'breadcrumb', 'kunjungans', 'jumlahProgress'));
}

    public function list(Request $request)
    {
        $kunjungans = Kunjungan::with(['user', 'calonPelanggan'])
            ->select('kunjungan.*');
        $tahun = $request->input('tahun', date('Y')); 
    
    // Filter data berdasarkan tahun dari kolom created_at
    $kunjungans->whereYear('kunjungan.created_at', $tahun);

        if (auth()->user()->role == 'sales') {
            $kunjungans->where('user_id', auth()->id());
        }

        if ($request->sales_id) {
            $kunjungans->where('user_id', $request->sales_id);
        }

        if ($request->status) {
            $kunjungans->where('status', $request->status);
        }

        return DataTables::of($kunjungans)
            ->addIndexColumn()
            ->addColumn('nama_sales', function ($row) {
                return $row->user ? $row->user->nama_lengkap : '<span class="text-danger">Tidak Ada</span>';
            })
            ->addColumn('nama_pelanggan', function ($row) {
                return $row->calonPelanggan ? $row->calonPelanggan->nama_pelanggan : '<span class="text-danger">Tidak Ada</span>';
            })
            ->addColumn('tanggal', function ($row) {
                return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') : '-';
            })
            ->addColumn('status_badge', function ($row) {
                if ($row->status == 'Selesai') {
                    return '<span class="badge badge-success px-3 py-1" style="border-radius: 20px;">Selesai</span>';
                } elseif ($row->status == 'Progress') {
                    return '<span class="badge badge-info px-3 py-1" style="border-radius: 20px;">Progress</span>';
                }
                return '<span class="badge badge-warning px-3 py-1" style="border-radius: 20px;">Follow Up</span>';
            })
            ->addColumn('hasil_kunjungan', function ($row) {
                if (auth()->user()->role == 'sales' && $row->status == 'Progress') {
                    return '<button onclick="modalAction(\''.url('/kunjungan/'.$row->id.'/isi_form_ajax').'\')" 
                            class="btn btn-sm btn-warning text-white px-3 py-1" 
                            style="border-radius: 20px; font-weight: bold; font-size: 12px; border: none;">
                            Isi Form
                            </button>';
                }

                if ($row->hasil_kunjungan == 'Berlangganan') {
                    return '<span class="badge badge-success px-3 py-1" style="border-radius: 20px;"><i class="fas fa-check-circle mr-1"></i> Berlangganan</span>';
                } elseif ($row->hasil_kunjungan == 'Belum') {
                    return '<span class="badge badge-danger px-3 py-1" style="border-radius: 20px;"><i class="fas fa-times-circle mr-1"></i> Belum</span>';
                }
                return '<span class="badge badge-secondary px-3 py-1" style="border-radius: 20px; opacity: 0.7;">Belum Minat</span>';
            })
            ->addColumn('aksi', function ($row) {
                return '<button onclick="modalAction(\''.url('/kunjungan/'.$row->id.'/show_ajax').'\')" class="btn btn-sm text-dark"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['nama_sales', 'nama_pelanggan', 'status_badge', 'hasil_kunjungan', 'aksi'])
            ->make(true);
    }

 
    // menampilkan detail kunjungan
    public function show_ajax($id)
    {
        $kunjungan = Kunjungan::with(['user', 'calonPelanggan'])->find($id);
       
        if (!$kunjungan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return view('kunjungan.show_ajax', compact('kunjungan'));
    }

    public function export_excel()
    {
        $kunjungans = Kunjungan::with(['user', 'calonPelanggan'])
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Kunjungan'); 
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Nama Sales');
        $sheet->setCellValue('E1', 'Nama Pelanggan');
        $sheet->setCellValue('F1', 'Nama PIC');
        $sheet->setCellValue('G1', 'No. HP PIC');
        $sheet->setCellValue('H1', 'Kebutuhan Utama');
        $sheet->setCellValue('I1', 'Provider Lama');
        $sheet->setCellValue('J1', 'Speed Lama');
        $sheet->setCellValue('K1', 'Tagihan (Rp)');
        $sheet->setCellValue('L1', 'Status');
        $sheet->setCellValue('M1', 'Kesimpulan');

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2; 
        foreach ($kunjungans as $k) {
            $tanggal = $k->created_at ? \Carbon\Carbon::parse($k->created_at)->format('d-m-Y') : '-';
            
            $id_kunjungan = $k->created_at ? '#VST-' . \Carbon\Carbon::parse($k->created_at)->format('Ymd') . '-' . str_pad($k->id, 3, '0', STR_PAD_LEFT) : '-';
            
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $id_kunjungan); 
            $sheet->setCellValue('C' . $baris, $tanggal);
            $sheet->setCellValue('D' . $baris, $k->user ? $k->user->nama_lengkap : '-');
            $sheet->setCellValue('E' . $baris, $k->calonPelanggan ? $k->calonPelanggan->nama_pelanggan : '-');
            $sheet->setCellValue('F' . $baris, $k->nama_pic ?? '-');
            $sheet->setCellValue('G' . $baris, $k->no_hp_pic ?? '-');
            $sheet->setCellValue('H' . $baris, $k->kebutuhan_utama ?? '-');
            $sheet->setCellValue('I' . $baris, $k->provider_eksisting ?? '-');
            $sheet->setCellValue('J' . $baris, $k->speed_eksisting ?? '-');
            $sheet->setCellValue('K' . $baris, $k->tagihan_bulanan ?? '-');
            $sheet->setCellValue('L' . $baris, $k->status);
            $sheet->setCellValue('M' . $baris, $k->kesimpulan ?? '-');
            
            $baris++;
            $no++;
        }

        foreach (range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Kunjungan'); 

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Kunjungan_Sales_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $kunjungans = Kunjungan::with(['user', 'calonPelanggan'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('kunjungan.export_pdf', ['kunjungans' => $kunjungans]);
        
        $pdf->setPaper('legal', 'landscape'); 
        $pdf->setOption("isRemoteEnabled", true); 

        return $pdf->stream('Data_Kunjungan_Sales_'.date('Y-m-d_H-i-s').'.pdf');
    }

    public function mulai($id)
{
    $calonPelanggan = CalonPelanggan::findOrFail($id);

    $calonPelanggan->update([
        'status_visit' => 'Progress' 
    ]);

    Kunjungan::create([
        'calon_pelanggan_id' => $calonPelanggan->id,
        'user_id' => auth()->id(),
        'status' => 'Progress',
    ]);

    return redirect('/kunjungan')->with('success', 'Berhasil! Silakan isi form kunjungan.');
}
public function isi_form_ajax($id)
{
    $kunjungan = Kunjungan::with(['calonPelanggan', 'user'])->findOrFail($id);
    
    return view('kunjungan.isi_form_ajax', compact('kunjungan'));
}

public function simpan_hasil_ajax(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'hasil_kunjungan' => 'required',
        'catatan_sales' => 'required', 
        'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
    }

    $kunjungan = Kunjungan::findOrFail($id);
    $calonPelanggan = $kunjungan->calonPelanggan;
    $sales = auth()->user(); // Ambil data sales yang sedang login

    // Upload Foto
    if ($request->hasFile('bukti_foto')) {
        $file = $request->file('bukti_foto');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/kunjungan'), $nama_file);
        $kunjungan->bukti_foto = $nama_file;
    }

    // UPDATE DI TABEL KUNJUNGAN
    $kunjungan->kesimpulan = $request->catatan_sales;
    $kunjungan->hasil_kunjungan = $request->hasil_kunjungan;
    $kunjungan->nama_pic = $request->nama_pic;
    $kunjungan->no_hp_pic = $request->no_hp_pic;
    $kunjungan->kebutuhan_utama = $request->kebutuhan_utama;
    $kunjungan->provider_eksisting = $request->provider_eksisting;
    $kunjungan->speed_eksisting = $request->speed_eksisting;
    $kunjungan->tagihan_bulanan = $request->tagihan_bulanan;
    $kunjungan->status = 'Selesai'; 
    $kunjungan->save();

    $statusLangganan = ($request->hasil_kunjungan == 'Berlangganan') ? 'Berlangganan' : 'Belum Berlangganan';

    $calonPelanggan->update([
        'status_visit' => 'Sudah Visit',
        'status_langganan' => $statusLangganan
    ]);

    // LOGIKA NOTIFIKASI UNTUK ADMIN & PIMPINAN
    
    $penerimaNotif = \App\Models\User::whereIn('role', ['admin', 'pimpinan'])->get();
    
    foreach ($penerimaNotif as $penerima) {
        \App\Models\Notifikasi::create([
            'user_id' => $penerima->id,
            'judul'   => 'Kunjungan Selesai',
            'pesan'   => $sales->nama_lengkap . ' telah mengisi form kunjungan untuk ' . $calonPelanggan->nama_pelanggan,
            'is_read' => 0,
            'url'     => url('/kunjungan'), 
        ]);
    }
    // ==========================================

    return response()->json([
        'status' => true,
        'message' => 'Hasil kunjungan berhasil disimpan!'
    ]);
}

}

