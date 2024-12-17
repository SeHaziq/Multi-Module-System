<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {

        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');

        // Create some sample categories
        Category::create([
            'name' => 'Salary',  // Category name
            'type' => 'income',

        ]);

        Category::create([
            'name' => 'Food',  // Another category
            'type' => 'expense',

        ]);

        Category::create([
            'name' => 'Transport',  // Another category
            'type' => 'expense',

        ]);
    }
}
