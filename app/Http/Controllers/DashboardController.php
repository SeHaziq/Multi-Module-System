<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the current month and year
        $totalUsers = User::count();
        $currentMonth = Carbon::now()->format('F Y');
        $currentMonthName = Carbon::now()->format('F'); // Get only the month name (e.g., January)

        // Fetch total expenses for each category for the current user and month
        $expensesByCategory = Transaction::where('type', 'expense')
            ->where('user_id', auth()->id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->selectRaw('category_id, SUM(amount) as total')
            ->with('category')
            ->groupBy('category_id')
            ->get();

        // Fetch total income for each category for the current user and month
        $incomeByCategory = Transaction::where('type', 'income')
            ->where('user_id', auth()->id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->selectRaw('category_id, SUM(amount) as total')
            ->with('category')
            ->groupBy('category_id')
            ->get();

        // Calculate all-time total expenses and total income for the current user
        $totalExpenses = Transaction::where('type', 'expense')
            ->where('user_id', auth()->id())
            ->sum('amount');

        $totalIncome = Transaction::where('type', 'income')
            ->where('user_id', auth()->id())
            ->sum('amount');

        // Calculate total income and total expenses for the current month
        $totalIncomeThisMonth = Transaction::where('type', 'income')
            ->where('user_id', auth()->id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        $totalExpensesThisMonth = Transaction::where('type', 'expense')
            ->where('user_id', auth()->id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        return view('dashboard', compact('totalUsers', 'currentMonth', 'currentMonthName', 'expensesByCategory', 'incomeByCategory', 'totalExpenses', 'totalIncome', 'totalIncomeThisMonth', 'totalExpensesThisMonth'));
    }
}
