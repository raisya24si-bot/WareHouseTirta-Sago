<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);

        $query = Notifikasi::with(['barang', 'opname'])
            ->latest('id_notifikasi');

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->string('tipe')->toString());
        }

        if ($request->boolean('unread_only')) {
            $query->unread();
        }

        $notifikasis = $query
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        $summary = [
            'total' => Notifikasi::count(),
            'belum_dibaca' => Notifikasi::unread()->count(),
            'stok_habis' => Notifikasi::where('tipe', 'STOK_HABIS')->unread()->count(),
            'opname_selisih' => Notifikasi::where('tipe', 'OPNAME_SELISIH')->unread()->count(),
        ];

        return view('notifikasi.index', compact('notifikasis', 'perPage', 'summary'));
    }


    /*
    |--------------------------------------------------------------------------
    | BUKA 1 NOTIFIKASI: tandai dibaca, lalu lempar ke halaman terkait
    |--------------------------------------------------------------------------
    */

    public function open(Notifikasi $notifikasi)
    {
        if (! $notifikasi->isRead()) {
            $notifikasi->update(['dibaca_at' => now()]);
        }

        return redirect($notifikasi->url);
    }


    public function markAllRead()
    {
        Notifikasi::unread()->update(['dibaca_at' => now()]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}