<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Enquiry;

class ExpenseController extends Controller
{
    // Total Expenses, Revenue, Net Profit and Expected Revenue (with optional month filter)
    public function revenueSummary(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('m'));
        $year = $request->input('year', Carbon::now()->format('Y'));

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalRevenue = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount_paid');
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $expectedRevenue = Enquiry::sum('total_amount');
        $netProfit = $totalRevenue - $totalExpenses;

        return view('dashboard.expenses.revenue-summary', compact(
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'expectedRevenue',
            'month',
            'year'
        ));
    }

    public function index()
    {
        $expenses = Expense::orderBy('date', 'desc')->get();
        $total = $expenses->sum('amount');
        return view('dashboard.expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        return view('dashboard.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            Expense::create($request->all());
            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            \Log::error('Expense store error: '.$e->getMessage());
            return back()->with('error', 'Something went wrong while saving expense.');
        }
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('dashboard.expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }

}
