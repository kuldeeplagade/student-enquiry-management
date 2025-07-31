<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        // Avoid duplicate category (case-insensitive)
        $existing = ExpenseCategory::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
        if ($existing) {
            return response()->json(['message' => 'Category already exists.'], 422);
        }

        $category = ExpenseCategory::create([
            'name' => ucwords(strtolower($request->name)),
        ]);

        return response()->json($category);
    }

    // Update category name
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = ExpenseCategory::findOrFail($id);

        // Check for duplicate
        $existing = ExpenseCategory::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Another category with this name already exists.'], 422);
        }

        $category->name = ucwords(strtolower($request->name));
        $category->save();

        return response()->json($category);
    }


    // Delete category
    public function destroy($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        if ($category->expenses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete. Category is used in existing expenses.'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

}
