<?php

namespace App\Http\Controllers;

use App\Models\FundSource;
use Illuminate\Http\Request;

class FundSourceController extends Controller
{
    public function index()
    {
        $fundSources = FundSource::latest()->paginate(10);
        return view('fund-sources.index', compact('fundSources'));
    }

    public function create()
    {
        return view('fund-sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        FundSource::create($validated);

        return redirect()->route('fund-sources.index')->with('success', 'Sumber dana berhasil ditambahkan.');
    }

    public function edit(FundSource $fundSource)
    {
        return view('fund-sources.edit', compact('fundSource'));
    }

    public function update(Request $request, FundSource $fundSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        $fundSource->update($validated);

        return redirect()->route('fund-sources.index')->with('success', 'Sumber dana berhasil diperbarui.');
    }

    public function destroy(FundSource $fundSource)
    {
        if ($fundSource->transactions()->exists()) {
            return redirect()->route('fund-sources.index')->with('error', 'Sumber dana tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $fundSource->delete();
        return redirect()->route('fund-sources.index')->with('success', 'Sumber dana berhasil dihapus.');
    }
}
