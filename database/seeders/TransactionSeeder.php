<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run()
    {

        DB::statement('ALTER TABLE transactions AUTO_INCREMENT = 1');

        // Insert one transaction
        Transaction::create([
            'user_id' => 1,  // Assuming user ID 1 exists
            'category_id' => 1,  // Assuming category ID 1 exists
            'amount' => 100.00,  // Sample amount
            'type' => 'income',  // Sample type
            'date' => now()->toDateString(),  // Current date
            'description' => 'Sample income transaction',  // Sample description
        ]);

        // Insert a second transaction if needed
        Transaction::create([
            'user_id' => 1,  // Assuming user ID 1 exists
            'category_id' => 2,  // Assuming category ID 2 exists
            'amount' => 50.00,  // Sample amount
            'type' => 'expense',  // Sample type
            'date' => now()->toDateString(),  // Current date
            'description' => 'Sample expense transaction',  // Sample description
        ]);
    }
}
