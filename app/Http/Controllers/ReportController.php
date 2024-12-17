<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->query('month', now()->format('Y-m')); // Default to current month
        [$year, $month] = explode('-', $selectedMonth);

        $transactions = Transaction::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        return view('reports.index', compact('transactions', 'selectedMonth'));
    }

    public function download(Request $request)
    {
        $selectedMonth = $request->query('month', now()->format('Y-m'));
        [$year, $month] = explode('-', $selectedMonth);

        $transactions = Transaction::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact('transactions', 'selectedMonth'));

        return $pdf->download('Report-' . $selectedMonth . '.pdf');
    }
}
