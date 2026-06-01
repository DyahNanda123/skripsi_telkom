<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tandai SATU notifikasi sebagai sudah dibaca,
     * lalu redirect ke URL tujuan notifikasi tersebut.
     */
    public function baca($id)
    {
        $notif = Notifikasi::find($id);

        if ($notif && $notif->user_id == auth()->id()) {
            $notif->is_read    = 1;
            $notif->updated_at = Carbon::now(); // catat waktu dibaca via updated_at
            $notif->save();
            return redirect($notif->url ?? '/');
        }

        return back();
    }

    /**
     * Tandai SEMUA notifikasi belum dibaca menjadi sudah dibaca.
     * Dipanggil via AJAX POST dari tombol "Tandai Semua Dibaca" di header.
     *
     * updated_at di-set ke now() supaya filter riwayat "7 hari sejak dibaca"
     * di header berjalan benar — notif lama pun tetap muncul di riwayat
     * selama 7 hari setelah ditandai dibaca.
     */
    public function tandaiSemuaDibaca(Request $request)
    {
        $notifBelumDibaca = Notifikasi::where('user_id', auth()->id())
                                      ->where('is_read', 0)
                                      ->latest()
                                      ->get();

        if ($notifBelumDibaca->isEmpty()) {
            return response()->json(['status' => true, 'notifikasi' => []]);
        }

        // Update is_read=1 + updated_at=sekarang agar masuk filter riwayat 7 hari
        Notifikasi::where('user_id', auth()->id())
                  ->where('is_read', 0)
                  ->update([
                      'is_read'    => 1,
                      'updated_at' => Carbon::now(),
                  ]);

        // Kirim data ringkas ke frontend untuk langsung ditampilkan di riwayat
        $data = $notifBelumDibaca->map(function ($notif) {
            return [
                'judul'         => $notif->judul,
                'pesan_singkat' => Str::limit($notif->pesan, 50),
                'url'           => $notif->url ?? '#',
                'waktu'         => Carbon::now()->translatedFormat('d M H:i'), // waktu dibaca
            ];
        });

        return response()->json(['status' => true, 'notifikasi' => $data]);
    }
}