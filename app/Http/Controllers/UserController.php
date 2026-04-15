<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator; // <-- Tambahkan ini
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Pengguna',
            'list' => ['Home', 'Pengguna']
        ];
        
        $activeMenu = 'pengguna';

        return view('pengguna.index', compact('breadcrumb', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $users = User::select('id', 'nama_lengkap', 'nip', 'wilayah_kerja', 'status_aktif', 'role');

        if ($request->role) {
            $users->where('role', $request->role);
        }
        if ($request->status_aktif != '') {
            $users->where('status_aktif', $request->status_aktif);
        }

        return DataTables::of($users)
            ->addIndexColumn() 
            ->addColumn('status', function ($user) {
                if ($user->status_aktif == 1) {
                    return '<span class="badge badge-success px-3 py-1" style="border-radius: 20px; font-weight: normal;">Active</span>';
                } else {
                    return '<span class="badge badge-secondary px-3 py-1" style="border-radius: 20px; font-weight: normal;">Inactive</span>';
                }
            })
            
            ->editColumn('role', function ($user) {
                return ucfirst($user->role); 
            })

            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\''.url('/pengguna/'.$user->id.'/edit_ajax').'\')" class="btn btn-sm text-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url('/pengguna/'.$user->id.'/delete_ajax').'\')" class="btn btn-sm text-danger"><i class="fas fa-trash"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url('/pengguna/'.$user->id.'/show_ajax').'\')" class="btn btn-sm text-dark"><i class="fas fa-eye"></i></button>';
                return $btn;
            })
            
            ->rawColumns(['status', 'aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('pengguna.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            
            $rules = [
                'nama_lengkap'  => 'required|string|max:255',
                'nip'           => 'required|string|max:20|unique:users,nip', // NIP nggak boleh kembar
                'email'         => 'nullable|email|max:255|unique:users,email',
                'password'      => 'required|min:8',
                'role'          => 'required|in:admin,pimpinan,sales',
                'status_aktif'  => 'required|integer',
                'wilayah_kerja' => 'nullable|string|max:100',
                'nomor_hp'      => 'nullable|string|max:20',
                'alamat'        => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors() // Mengirim pesan error per kolom
                ]);
            }
            User::create([
                'nama_lengkap'  => $request->nama_lengkap,
                'nip'           => $request->nip,
                'email'         => $request->email,
                'password'      => Hash::make($request->password), // Password dienkripsi
                'role'          => $request->role,
                'status_aktif'  => $request->status_aktif,
                'wilayah_kerja' => $request->wilayah_kerja,
                'nomor_hp'      => $request->nomor_hp,
                'alamat'        => $request->alamat
                // Catatan: foto_profil sengaja dikosongkan, nanti user bisa upload sendiri saat Edit Profil
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data pengguna berhasil ditambahkan!'
            ]);
        }
        
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return view('pengguna.edit_ajax', ['user' => $user]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            
            $rules = [
                'nama_lengkap'  => 'required|string|max:255',
                'nip'           => 'required|string|max:20|unique:users,nip,' . $id, 
                'password'      => 'nullable|min:8', // Boleh kosong
                'role'          => 'required|in:admin,pimpinan,sales',
                'status_aktif'  => 'required|integer',
                'wilayah_kerja' => 'nullable|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $user = User::find($id);
            if ($user) {
                $user->nama_lengkap  = $request->nama_lengkap;
                $user->nip           = $request->nip;
                $user->role          = $request->role;
                $user->status_aktif  = $request->status_aktif;
                $user->wilayah_kerja = $request->wilayah_kerja;

                // Jika user mengetik password baru, maka update. Jika kosong, biarkan password lama.
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data pengguna berhasil diperbarui!'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false, 
                'message' => 'Data pengguna tidak ditemukan'
            ]);
        }

        return view('pengguna.show_ajax', ['user' => $user]);
    }

    public function delete_ajax(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return view('pengguna.delete_ajax', ['user' => $user]);
    }

    public function destroy_ajax(Request $request, string $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $user = User::find($id);
        
        if ($user) {
            
            if ($user->role == 'admin') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal! Akun dengan role Admin tidak boleh dihapus demi keamanan sistem.'
                ]);
            }
            if ($user->foto_profil && file_exists(storage_path('app/public/' . $user->foto_profil))) {
                unlink(storage_path('app/public/' . $user->foto_profil));
            }

            $user->delete(); // Hapus datanya dari database
            
            return response()->json([
                'status' => true,
                'message' => 'Data pengguna berhasil dihapus!'
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

    public function import()
    {
        return view('pengguna.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_pengguna' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_pengguna');
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
                            'nama_lengkap'  => $value['A'], 
                            'nip'           => $value['B'], 
                            'role'          => strtolower($value['C']), 
                            'wilayah_kerja' => $value['D'], 
                            'password'      => Hash::make($value['E']), 
                            'status_aktif'  => 1, // Otomatis aktif
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    User::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data di dalam file Excel'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $users = User::select('nama_lengkap', 'nip', 'role', 'wilayah_kerja', 'status_aktif', 'email', 'nomor_hp', 'alamat')
            ->orderBy('role') 
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Bikin Judul Kolom (Header) - Tambah sampai I
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'NIP');
        $sheet->setCellValue('D1', 'Role');
        $sheet->setCellValue('E1', 'Wilayah Kerja');
        $sheet->setCellValue('F1', 'Status Akun');
        $sheet->setCellValue('G1', 'Email');
        $sheet->setCellValue('H1', 'No. HP');
        $sheet->setCellValue('I1', 'Alamat');

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2; 
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $user->nama_lengkap);
            $sheet->setCellValue('C' . $baris, $user->nip);
            $sheet->setCellValue('D' . $baris, ucfirst($user->role));
            $sheet->setCellValue('E' . $baris, $user->wilayah_kerja ?? '-');
            
            $status = ($user->status_aktif == 1) ? 'Active' : 'Inactive';
            $sheet->setCellValue('F' . $baris, $status);
            
            $sheet->setCellValue('G' . $baris, $user->email ?? '-');
            $sheet->setCellValue('H' . $baris, $user->nomor_hp ?? '-');
            $sheet->setCellValue('I' . $baris, $user->alamat ?? '-');
            
            $baris++;
            $no++;
        }

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Pengguna'); 

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Karyawan_Telkom_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $users = User::select('nama_lengkap', 'nip', 'role', 'wilayah_kerja', 'status_aktif', 'email', 'nomor_hp', 'alamat')
            ->orderBy('role')
            ->get();

        $pdf = Pdf::loadView('pengguna.export_pdf', ['users' => $users]);
       
        $pdf->setPaper('a4', 'landscape'); 
        $pdf->setOption("isRemoteEnabled", true); 

        return $pdf->stream('Data_Karyawan_Telkom_'.date('Y-m-d_H-i-s').'.pdf');
    }
}