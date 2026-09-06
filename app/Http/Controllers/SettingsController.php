<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('settings.show', compact('user'));
    }


    /*
    |--------------------------------------------------------------------------
    | GANTI PASSWORD
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {

            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        /*
        | $user->password otomatis di-hash lewat cast 'hashed'
        | di model User, jadi cukup assign plain text di sini.
        */

        $user->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | PREFERENSI NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    public function updatePreferences(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'preferences' => [
                'notif_stok_menipis' =>
                    $request->boolean('notif_stok_menipis'),

                'notif_opname_selisih' =>
                    $request->boolean('notif_opname_selisih'),

                'email_ringkasan_mingguan' =>
                    $request->boolean('email_ringkasan_mingguan'),
            ],
        ]);

        return back()->with('success', 'Preferensi berhasil disimpan.');
    }
}