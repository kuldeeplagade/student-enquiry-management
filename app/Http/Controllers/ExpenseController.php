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
        $month = $request->input('month', Carbon::now()->format('m'));
        $year = $request->input('year', Carbon::now()->format('Y'));

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalRevenue = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount_paid');
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        $expectedRevenue = Enquiry::sum('final_fee');
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
        $expenses = Expense::with('category')  // Optional: if not already eager loaded
                        ->orderBy('created_at', 'desc') // <-- changed this line
                        ->paginate(5);

        $total = Expense::sum('amount'); // Get total of all, not just current page

        $categories = ExpenseCategory::orderBy('name')->get();

        return view('dashboard.expenses.index', compact('expenses', 'total', 'categories'));
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
