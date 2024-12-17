<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class RecurringTransactionController extends Controller
{
    /**
     * Display a listing of the recurring transactions.
     */
    public function index()
    {
        $recurringTransactions = RecurringTransaction::with(['user', 'category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('recurring-transactions.index', compact('recurringTransactions'));
    }

    /**
     * Show the form for creating a new recurring transaction.
     */
    public function create()
    {
        $categories = Category::all();
        return view('recurring-transactions.create', compact('categories'));
    }

    /**
     * Store a newly created recurring transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
        ]);

        RecurringTransaction::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction created successfully.');
    }

    /**
     * Show the form for editing the specified recurring transaction.
     */
    public function edit(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('update', $recurringTransaction);

        $categories = Category::all();
        return view('recurring-transactions.edit', compact('recurringTransaction', 'categories'));
    }

    /**
     * Update the specified recurring transaction in storage.
     */
    public function update(Request $request, RecurringTransaction $recurringTransaction)
    {
        $this->authorize('update', $recurringTransaction);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
        ]);

        $recurringTransaction->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction updated successfully.');
    }

    /**
     * Remove the specified recurring transaction from storage.
     */
    public function destroy(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('delete', $recurringTransaction);

        $recurringTransaction->delete();

        return redirect()
            ->route('recurring-transactions.index')
            ->with('success', 'Recurring transaction deleted successfully.');
    }
}
