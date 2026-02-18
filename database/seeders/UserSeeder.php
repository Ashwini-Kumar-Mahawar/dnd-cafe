<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@cafe.com'],
            [
                'name'              => 'Admin',
                'email'             => 'admin@cafe.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // ── Kitchen Staff User ────────────────────────────────────
        $kitchen = User::firstOrCreate(
            ['email' => 'kitchen@cafe.com'],
            [
                'name'              => 'Kitchen Staff',
                'email'             => 'kitchen@cafe.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $kitchen->assignRole('kitchen');

        // ── Second Kitchen Staff ───────────────────────────────────
        // Uncomment if you have multiple kitchen screens/staff
        /*
        $kitchen2 = User::firstOrCreate(
            ['email' => 'kitchen2@cafe.com'],
            [
                'name'              => 'Kitchen Staff 2',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $kitchen2->assignRole('kitchen');
        */

        $this->command->info('  ✓ Users created (admin + kitchen).');
    }
}