<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions()->with('category')->latest()->get();
        $recurringTransactions = auth()->user()->recurringTransactions()->with('category')->latest()->get();

        $transactions = $transactions->merge($recurringTransactions);
        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transactions)
    {
        $categories = Category::all();
        $transactions = Transaction::where('id', $transactions->id)->first();

        return view('transactions.show', compact('transactions'));
    }

    public function create()
    {
        // Passing categories to the create view for the category dropdown
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Create new transaction
        Transaction::create([
            'user_id' => auth()->id(), // Make sure to set the logged-in user's ID
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully');
    }

    public function edit(Transaction $transactions)
    {
        // Retrieve all categories to display in a dropdown
        $categories = Category::where('user_id', auth()->id())->get();
        $transactions = Transaction::with('category')->find($transactions->id);
        // Pass the transaction and categories data to the edit view

        return view('transactions.edit', compact('transactions', 'categories'));
    }

    public function update(Request $request, Transaction $transactions)
    {
        // Validate incoming data
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // dd($request->all(), $transaction);

        // Update the transaction with new data
        $transactions->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // Redirect with success message
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully');
    }


    public function destroy(Transaction $transactions)
    {
        // Delete the transaction
        $transactions->delete();

        // Redirect with a success message
        return redirect()->route('transactions')->with('success', 'Transaction deleted successfully');
    }
}
