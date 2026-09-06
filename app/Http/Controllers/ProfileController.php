<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('profile.show', compact('user'));
    }


    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],

        
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);


        if ($request->hasFile('photo')) {

            $oldPath = $this->extractStoredPath($user->photo_url);

            $filename = $user->id . '-' . Str::random(10) . '.' .
                $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->storeAs('', $filename, 'avatars');

            $validated['photo_url'] = '/uploads/avatars/' . $filename;


            if ($oldPath && Storage::disk('avatars')->exists($oldPath)) {
                Storage::disk('avatars')->delete($oldPath);
            }
        }

        unset($validated['photo']);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }



    private function extractStoredPath(?string $photoUrl): ?string
    {
        if (! $photoUrl) {
            return null;
        }

        if (! Str::startsWith($photoUrl, '/uploads/avatars/')) {
            return null;
        }

        return Str::after($photoUrl, '/uploads/avatars/');
    }
}