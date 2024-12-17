<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;

class ProcessRecurringTransactions extends Command
{
    protected $signature = 'transactions:process-recurring';
    protected $description = 'Process recurring transactions and create new ones based on intervals';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all active recurring transactions
        $recurringTransactions = RecurringTransaction::all();

        foreach ($recurringTransactions as $recurring) {
            // Get the last transaction date for this recurring transaction
            $lastTransactionDate = $recurring->transactions()->latest()->first()?->date;

            // If there is no last transaction or it's due for the next interval
            if (!$lastTransactionDate || $this->isDueForNextInterval($lastTransactionDate, $recurring->interval)) {
                // Create a new transaction based on the recurring transaction data
                Transaction::create([
                    'user_id' => $recurring->user_id,
                    'category_id' => $recurring->category_id,
                    'amount' => $recurring->amount,
                    'type' => 'expense',  // Or based on your logic
                    'date' => Carbon::now(),  // Current date for the transaction
                    'description' => $recurring->description,
                ]);
            }
        }

        $this->info('Recurring transactions processed successfully.');
    }

    private function isDueForNextInterval($lastTransactionDate, $interval)
    {
        switch ($interval) {
            case 'daily':
                return $lastTransactionDate->isToday();
            case 'weekly':
                return $lastTransactionDate->isToday() || $lastTransactionDate->diffInWeeks(Carbon::now()) > 0;
            case 'monthly':
                return $lastTransactionDate->isToday() || $lastTransactionDate->diffInMonths(Carbon::now()) > 0;
            case 'yearly':
                return $lastTransactionDate->isToday() || $lastTransactionDate->diffInYears(Carbon::now()) > 0;
            default:
                return false;
        }
    }
}
