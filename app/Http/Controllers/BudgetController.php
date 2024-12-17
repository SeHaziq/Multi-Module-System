<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->query('month', now()->format('Y-m'));
        $startDate = Carbon::parse($currentMonth)->startOfMonth();
        $endDate = Carbon::parse($currentMonth)->endOfMonth();

        // Fetch budgets for the current user and month
        $setBudgets = Budget::with('category')
            ->where('user_id', auth()->id()) // Restrict to the current user
            ->where('month', $currentMonth)
            ->get()
            ->map(function ($budget) use ($startDate, $endDate) {
                $spent = Transaction::where('category_id', $budget->category_id)
                    ->where('user_id', auth()->id()) // Ensure this is for the current user
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('amount');
                $budget->spent = $spent; // Add spent amount dynamically
                return $budget;
            });

        // Fetch categories without budgets for the current user and month
        $unsetCategories = Category::where('type', 'expense')
            ->where('user_id', auth()->id()) // Restrict to the current user
            ->whereDoesntHave('budgets', function ($query) use ($currentMonth) {
                $query->where('user_id', auth()->id()) // Ensure this is for the current user
                    ->where('month', $currentMonth);
            })
            ->get();

        return view('budgets.index', compact('setBudgets', 'unsetCategories', 'currentMonth'));
    }




    public function create(Request $request)
    {
        // Get category and month from request
        $categoryId = $request->input('category_id');
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // Get the category
        $category = Category::find($categoryId);

        return view('budgets.create', compact('category', 'currentMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'month' => 'required|date_format:Y-m',
        ]);

        // Store the budget for the user
        Budget::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'month' => $request->month,
        ]);

        return redirect()->route('budgets.index', ['month' => $request->month])
            ->with('success', 'Budget created successfully.');
    }

    public function edit(Budget $budget)
    {
        // Ensure the budget belongs to the authenticated user
        if ($budget->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $category = $budget->category; // Get the associated category
        $currentMonth = $budget->month; // Get the budget's month

        return view('budgets.edit', compact('budget', 'category', 'currentMonth'));
    }

    public function update(Request $request, Budget $budget)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Ensure the budget belongs to the authenticated user
        if ($budget->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update the budget
        $budget->update([
            'amount' => $request->amount,
        ]);

        return redirect()->route('budgets.index', ['month' => $budget->month])
            ->with('success', 'Budget updated successfully.');
    }


    public function destroy(Budget $budget)
    {
        // Ensure the budget belongs to the authenticated user
        if ($budget->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $budget->delete();

        return redirect()->route('budgets.index', ['month' => $budget->month])
            ->with('success', 'Budget deleted successfully.');
    }
}
