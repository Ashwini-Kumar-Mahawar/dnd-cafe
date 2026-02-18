<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\CafeTable;

class DndTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['name' => 'Table 1', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 2', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 3', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 4', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 5', 'capacity' => 4, 'is_active' => true],
        ];

        foreach ($tables as $table) {
            CafeTable::firstOrCreate(
                ['name' => $table['name']],
                [
                    'name'      => $table['name'],
                    'slug'      => Str::slug($table['name']),
                    'capacity'  => $table['capacity'],
                    'is_active' => $table['is_active'],
                ]
            );
        }

        $this->command->info('  ✓ DND Cafe tables created (5 tables).');
    }
}