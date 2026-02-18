<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DndCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Burger',      'sort_order' => 1,  'is_active' => true],
            ['name' => 'Sandwich',    'sort_order' => 2,  'is_active' => true],
            ['name' => 'Pizza',       'sort_order' => 3,  'is_active' => true],
            ['name' => 'Fries',       'sort_order' => 4,  'is_active' => true],
            ['name' => 'Momos',       'sort_order' => 5,  'is_active' => true],
            ['name' => 'Manchurian',  'sort_order' => 6,  'is_active' => true],
            ['name' => 'Noodles',     'sort_order' => 7,  'is_active' => true],
            ['name' => 'Pasta',       'sort_order' => 8,  'is_active' => true],
            ['name' => 'Maggie',      'sort_order' => 9,  'is_active' => true],
            ['name' => 'Soup',        'sort_order' => 10, 'is_active' => true],
            ['name' => 'Hot Drinks',  'sort_order' => 11, 'is_active' => true],
            ['name' => 'Cold Coffee', 'sort_order' => 12, 'is_active' => true],
            ['name' => 'Shakes',      'sort_order' => 13, 'is_active' => true],
            ['name' => 'Mocktail',    'sort_order' => 14, 'is_active' => true],
            ['name' => 'Combos',      'sort_order' => 15, 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        $this->command->info('  ✓ DND Cafe categories created.');
    }
}