<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DndCategorySeeder::class,   // ← Real DND Cafe data
            DndMenuItemSeeder::class,   // ← Real DND Cafe menu
            DndTableSeeder::class,      // ← 5 real tables
            // OrderSeeder removed — no dummy orders
        ]);

        $this->command->info('');
        $this->command->info('✅ DND Cafe database ready!');
        $this->command->info('');
        $this->command->info('🔑 Admin Login:   admin@cafe.com  / password');
        $this->command->info('🍳 Kitchen Login: kitchen@cafe.com / password');
        $this->command->info('');
        $this->command->info('📱 Test menu URL: ' . url('/menu/table-1'));
        $this->command->info('');
    }
}