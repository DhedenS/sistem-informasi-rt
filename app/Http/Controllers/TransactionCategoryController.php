<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    public function index()
    {
        $categories = TransactionCategory::latest()->paginate(10);
        return view('transaction-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('transaction-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:masuk,keluar',
            'is_active' => 'boolean',
        ]);

        TransactionCategory::create($validated);

        return redirect()->route('transaction-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(TransactionCategory $transactionCategory)
    {
        return view('transaction-categories.edit', compact('transactionCategory'));
    }

    public function update(Request $request, TransactionCategory $transactionCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:masuk,keluar',
            'is_active' => 'boolean',
        ]);

        $transactionCategory->update($validated);

        return redirect()->route('transaction-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(TransactionCategory $transactionCategory)
    {
        $transactionCategory->delete();
        return redirect()->route('transaction-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
