<?php

namespace App\Http\Controllers;

use App\Models\CalonPelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Can;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class CalonPelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // 1. Menampilkan Halaman Awal Tabel Calon Pelanggan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Calon Pelanggan',
            'list' => ['Home', 'Calon Pelanggan']
        ];
        
        $activeMenu = 'calon_pelanggan'; 

        return view('CalonPelanggan.index', compact('breadcrumb', 'activeMenu'));
    }

    // 2. Mengambil Data untuk Yajra DataTables (AJAX)
    public function list(Request $request)
{
    // 1. Ambil data dasar (Pastikan 'created_at' masuk di select)
    $pelanggans = CalonPelanggan::select([
        'id', 'nama_pelanggan', 'alamat', 'jenis_pelanggan', 
        'link_maps', 'status_langganan', 'status_visit', 'wilayah', 'sto', 'created_at'
    ]);

    // 2. LOGIKA SORTING YANG LEBIH SAKTI 🔥
    // Cek urutan berdasarkan kolom ke-berapa dari request DataTables
    $orderColumn = $request->input('order.0.column');

    // Kalau baru buka halaman (null) ATAU default dari DataTables (kolom 0 / 'No')
    if ($orderColumn === null || $orderColumn == '0') {
        // Paksa data terbaru nangkring di atas!
        $pelanggans->orderBy('created_at', 'desc'); 
    }

    // 3. Filter STO 
    if ($request->has('sto') && $request->sto != '') {
        $pelanggans->where('sto', $request->sto);
    }

    // 4. Filter Status Langganan
    if ($request->has('status_langganan') && $request->status_langganan != '') {
        $pelanggans->where('status_langganan', $request->status_langganan);
    }

    // 5. Filter Status Visit 
    if ($request->has('status_visit') && $request->status_visit != '') {
        $pelanggans->where('status_visit', $request->status_visit);
    }

    return DataTables::of($pelanggans)
        ->addIndexColumn()
        ->editColumn('link_maps', function ($pelanggan) {
            if ($pelanggan->link_maps) {
                return '<a href="'.$pelanggan->link_maps.'" target="_blank" class="btn btn-xs btn-info"><i class="fas fa-map-marker-alt"></i> Lokasi</a>';
            }
            return '-';
        })
        ->editColumn('status_langganan', function ($pelanggan) {
            if ($pelanggan->status_langganan == 'Berlangganan') {
                return '<span class="badge badge-success px-3 py-1" style="border-radius: 20px;"><i class="fas fa-check-circle mr-1"></i> Berlangganan</span>';
            }
            return '<span class="badge badge-warning px-3 py-1" style="border-radius: 20px;">Belum Berlangganan</span>';
        })
        ->addColumn('status_visit_label', function ($pelanggan) {
            if ($pelanggan->status_visit == 'Sudah Visit') {
                return '<span class="badge badge-success px-3 py-1" style="border-radius: 20px;">Sudah Visit</span>';
            } elseif ($pelanggan->status_visit == 'Progress') {
                return '<span class="badge badge-info px-3 py-1" style="border-radius: 20px;">Progress</span>';
            }
            return '<span class="badge badge-warning px-3 py-1" style="border-radius: 20px;">Belum Visit</span>';
        })
        ->addColumn('aksi', function ($pelanggan) {
            // Cuma ikon mata untuk Detail
            $btn = '<button onclick="modalAction(\''.url('/calon_pelanggan/'.$pelanggan->id.'/show_ajax').'\')" class="btn btn-sm text-dark"><i class="fas fa-eye"></i></button> ';

            // Admin tetap punya akses edit & hapus
            if (auth()->user()->role == 'admin') {
                $btn .= '<button onclick="modalAction(\''.url('/calon_pelanggan/'.$pelanggan->id.'/edit_ajax').'\')" class="btn btn-sm text-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url('/calon_pelanggan/'.$pelanggan->id.'/delete_ajax').'\')" class="btn btn-sm text-danger"><i class="fas fa-trash"></i></button>';
            }

            return $btn;
        })
        ->rawColumns(['link_maps', 'status_langganan', 'status_visit_label', 'aksi'])
        ->make(true);
}

    // 3. Menampilkan Form Tambah (Modal AJAX)
    public function create_ajax()
    {
        return view('CalonPelanggan.create_ajax');
    }

    public function store_ajax(Request $request)
{
    $rules = [
        'nama_pelanggan'   => 'required|string|max:100',
        'alamat'           => 'required|string',
        'jenis_pelanggan'  => 'nullable|string',
        'link_maps'        => 'nullable|string',
        'status_langganan' => 'required|string',
        'status_visit'     => 'required|string',
        'wilayah'          => 'nullable|string',
        'sto'              => 'nullable|string',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status'   => false,
            'message'  => 'Validasi gagal',
            'msgField' => $validator->errors()
        ]);
    }

    CalonPelanggan::create($validator->validated());

    return response()->json([
        'status'  => true,
        'message' => 'Data berhasil disimpan'
    ]);
}

     // 4. Menampilkan Form Edit Pengguna 
    public function edit_ajax(string $id)
    {
        $CalonPelanggan = CalonPelanggan::find($id);

        if (!$CalonPelanggan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return view('CalonPelanggan.edit_ajax', ['CalonPelanggan' => $CalonPelanggan]);
    }

    // 5. Menyimpan Perubahan Data 
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            
            $rules = [
                'nama_pelanggan'   => 'required|string|max:100',
                'alamat'           => 'required|string',
                'jenis_pelanggan'  => 'nullable|string',
                'link_maps'        => 'nullable|string',
                'status_langganan' => 'required|string',
                'status_visit'     => 'required|string',
                'wilayah'          => 'nullable|string',
                'sto'              => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $CalonPelanggan = CalonPelanggan::find($id);
            if ($CalonPelanggan) {
                $CalonPelanggan->nama_pelanggan = $request->nama_pelanggan;
                $CalonPelanggan->alamat = $request->alamat;
                $CalonPelanggan->jenis_pelanggan = $request->jenis_pelanggan;
                $CalonPelanggan->link_maps = $request->link_maps;
                $CalonPelanggan->status_langganan = $request->status_langganan;
                $CalonPelanggan->status_visit = $request->status_visit;
                $CalonPelanggan->wilayah = $request->wilayah;
                $CalonPelanggan->sto = $request->sto;

                $CalonPelanggan->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data pelanggan berhasil diperbarui!'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {

        $CalonPelanggan = CalonPelanggan::find($id);

        if (!$CalonPelanggan) {
            return response()->json([
                'status' => false, 
                'message' => 'Data pelanggan tidak ditemukan'
            ]);
        }

        return view('CalonPelanggan.show_ajax', ['CalonPelanggan' => $CalonPelanggan]);
    }
    
    // 7. Menampilkan Konfirmasi Hapus
    public function delete_ajax(string $id)
    {
        $CalonPelanggan = CalonPelanggan::find($id);

        if (!$CalonPelanggan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return view('CalonPelanggan.delete_ajax', ['CalonPelanggan' => $CalonPelanggan]);
    }

    // 8. Memproses Penghapusan Data 
    public function destroy_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $CalonPelanggan = CalonPelanggan::find($id);
            
            if ($CalonPelanggan) {

                $CalonPelanggan->delete(); // Hapus datanya dari database
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data pelanggan berhasil dihapus!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    // 9. Menampilkan Form Import Excel 
    public function import()
    {
        return view('CalonPelanggan.import');
    }

    // 10. Memproses Data dari Excel 
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_calon_pelanggan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_calon_pelanggan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) { 
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'nama_pelanggan'   => $value['A'], // Kolom A di Excel
                            'alamat'           => $value['B'], // Kolom B
                            'wilayah'          => $value['C'], // Kolom C
                            'sto'              => $value['D'], // Kolom D
                            'jenis_pelanggan'  => $value['E'], // Kolom C
                            'link_maps'        => $value['F'], // Kolom D
                            'status_langganan' => $value['G'], // Kolom E
                            'status_visit'     => $value['H'], // Kolom F
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    CalonPelanggan::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data Calon Pelanggan berhasil diimport!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data di dalam file Excel yang diunggah.'
                ]);
            }
        }
        
        return redirect('/');
    }

    // 11. Meng-export Data ke Excel
    public function export_excel()
    {
        $pelanggans = CalonPelanggan::select('nama_pelanggan', 'alamat', 'wilayah', 'sto', 'jenis_pelanggan', 'link_maps', 'status_langganan', 'status_visit')
            ->orderBy('nama_pelanggan') 
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Wilayah');
        $sheet->setCellValue('E1', 'STO');
        $sheet->setCellValue('F1', 'Jenis');
        $sheet->setCellValue('G1', 'Maps');
        $sheet->setCellValue('H1', 'Status Langganan');
        $sheet->setCellValue('I1', 'Status Kunjungan');

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2; 
        foreach ($pelanggans as $pelanggan) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $pelanggan->nama_pelanggan);
            $sheet->setCellValue('C' . $baris, $pelanggan->alamat);
            $sheet->setCellValue('D' . $baris, $pelanggan->wilayah);
            $sheet->setCellValue('E' . $baris, $pelanggan->sto);
            $sheet->setCellValue('F' . $baris, $pelanggan->jenis_pelanggan);
            $sheet->setCellValue('G' . $baris, $pelanggan->link_maps ?? '-');
            $sheet->setCellValue('H' . $baris, $pelanggan->status_langganan);
            $sheet->setCellValue('I' . $baris, $pelanggan->status_visit);
            
            $baris++;
            $no++;
        }

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Calon Pelanggan'); 

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_CalonPelanggan_' . date('Y-m-d_H-i-s') . '.xlsx';

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

    // 12. Meng-export Data ke PDF
    public function export_pdf()
    {
        $pelanggans = CalonPelanggan::select('nama_pelanggan', 'alamat', 'wilayah', 'sto', 'jenis_pelanggan', 'link_maps', 'status_langganan', 'status_visit')
            ->orderBy('nama_pelanggan')
            ->get();

        $pdf = Pdf::loadView('CalonPelanggan.export_pdf', ['pelanggans' => $pelanggans]);
        
        $pdf->setPaper('a4', 'landscape'); 
        $pdf->setOption("isRemoteEnabled", true); 

        return $pdf->stream('Data_CalonPelanggan_'.date('Y-m-d_H-i-s').'.pdf');
    }
}