<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'bio', 'photo_url', 'phone', 'address', 'preferences'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
        ];
    }


    public function getPreference(string $key, $default = null)
    {
        return data_get($this->preferences, $key, $default);
    }


    /*
    |--------------------------------------------------------------------------
    | AVATAR URL
    |--------------------------------------------------------------------------
    |
    | Kalau user belum upload foto profil, dulu dipakein fallback ke
    | ui-avatars.com (request ke luar tiap halaman dibuka, ikut nambah
    | lama loading). Sekarang di-generate sendiri lokal sebagai inline
    | SVG (data URI) -- lingkaran warna + inisial nama, tanpa request
    | jaringan sama sekali.
    |--------------------------------------------------------------------------
    */

    public function avatarUrl(int $size = 64): string
    {
        if ($this->photo_url) {
            return asset($this->photo_url);
        }

        $initials = collect(preg_split('/\s+/', trim($this->name ?? '')))
            ->filter()
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->take(2)
            ->implode('');

        $initials = $initials !== '' ? $initials : '?';

        $fontSize = (int) round($size * 0.42);

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '">'
            . '<rect width="100%" height="100%" rx="' . ($size / 2) . '" fill="#0059bb"/>'
            . '<text x="50%" y="50%" dy=".35em" text-anchor="middle" font-family="Arial, sans-serif" font-size="' . $fontSize . '" fill="#ffffff" font-weight="bold">' . $initials . '</text>'
            . '</svg>';

        return 'data:image/svg+xml,' . rawurlencode($svg);
    }
}