<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = TransactionCategory::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
