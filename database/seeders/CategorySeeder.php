<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed default categories.
     */
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Alat Kantor',
            'Perlengkapan Acara',
            'Furnitur',
            'Lain-lain',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
