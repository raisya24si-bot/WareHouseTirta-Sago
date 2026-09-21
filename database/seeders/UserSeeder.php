<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'raisya@tirtasago.id',
            ],
            [
                'name' => 'Raisya',
                'password' => 'password123',
            ]
        );
    }
}