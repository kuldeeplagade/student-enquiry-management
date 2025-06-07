<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Expense;

class ExpenseController extends Controller
{
    // Middleware to ensure only super admin can access
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->is_super_admin) {
                return $next($request);
            }
            abort(403, 'Unauthorized');
        });
    }

    // Show list of expenses
    public function index()
    {
        $expenses = Expense::all();
        return view('expenses.index', compact('expenses'));
    }

    // Show form to create a new expense
    public function create()
    {
        return view('expenses.create');
    }

    // Store a new expense
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }    
}
