<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use App\Models\Enquiry;

class ExpenseController extends Controller
{
    // Total Expenses, Revenue, Net Profit and Expected Revenue (with optional month filter)
    public function revenueSummary(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Date Range Calculation
        if ($month === 'All' && $year === 'All') {
            $startDate = Carbon::create(2023, 1, 1)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($month === 'All') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($year === 'All') {
            $startDate = Carbon::create(2023, $month, 1)->startOfMonth();
            $endDate = Carbon::now()->endOfDay();
        } else {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        }

        // Actual Revenue = total of payments made
        $totalRevenue = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount_paid');

        // Matching logic from revenue()
        $enquiries = Enquiry::with('payments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $expectedRevenue = $enquiries->sum(fn($e) => $e->final_fee ?? $e->default_fee ?? 0);

        // Total Expenses
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');

        // Net Profit = Revenue - Expenses
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
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $expenses = Expense::with('category')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

        // Total for current month only
        $total = Expense::whereYear('date', $currentYear)
                        ->whereMonth('date', $currentMonth)
                        ->sum('amount');

        $categories = ExpenseCategory::orderBy('name')->get();

        return view('dashboard.expenses.index', compact('expenses', 'total', 'categories', 'currentMonth'));
    }



    public function create()
    {
        $categories = ExpenseCategory::orderBy('created_at','desc')->get();
        return view('dashboard.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_mode' => 'required|string|in:Cash,UPI,Bank Transfer,Cheque,Other',
            'category' => ['required', 'string', Rule::exists('expense_categories', 'name')],
            'branch_name' =>'required|string|in:Mumbai Branch 1,Mumbai Branch 2',
            'notes' => 'nullable|string',
        ]);

        try {
            // Map category name to ID
            $category = ExpenseCategory::where('name', $request->category)->first();

            // Save expense
            Expense::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $request->date,
                'payment_mode' => $request->payment_mode,
                'category_id' => $category?->id, // set category_id correctly
                'branch_name' => $request->branch_name,
                'notes' => $request->notes,
            ]);

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            \Log::error('Expense store error: '.$e->getMessage());
            return back()->with('error', 'Something went wrong while saving expense.');
        }
    }


    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $categories = ExpenseCategory::orderBy('created_at', 'desc')->get();
        return view('dashboard.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string|in:Cash,UPI,Bank Transfer,Cheque,Other',
            'category' => 'nullable|string|max:255',
            'branch_name' =>'required|string|in:Mumbai Branch 1,Mumbai Branch 2',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);

        // If category is provided, map it to category_id
        $categoryId = null;
        if ($request->filled('category')) {
            $category = ExpenseCategory::where('name', $request->category)->first();
            $categoryId = $category?->id;
        }

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'category_id' => $categoryId,
            'branch_name' => $request->branch_name,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }

}
