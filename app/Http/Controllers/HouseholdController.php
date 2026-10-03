<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Household;
use Illuminate\Http\Request;

class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        $households = Household::with('block')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('household_number', 'like', '%'.$request->search.'%')
                    ->orWhere('head_name', 'like', '%'.$request->search.'%')
                    ->orWhereHas('block', function ($q) use ($request) {
                        $q->where('name', 'like', '%'.$request->search.'%');
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('households.index', compact('households'));
    }

    public function create()
    {
        $blocks = Block::where('is_active', true)->get();

        return view('households.create', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'household_number' => 'required|string|max:255',
            'head_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Household::create($validated);

        return redirect()->route('households.index')->with('success', 'Data KK berhasil ditambahkan.');
    }

    public function edit(Household $household)
    {
        $blocks = Block::where('is_active', true)->get();

        return view('households.edit', compact('household', 'blocks'));
    }

    public function update(Request $request, Household $household)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'household_number' => 'required|string|max:255',
            'head_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $household->update($validated);

        return redirect()->route('households.index')->with('success', 'Data KK berhasil diperbarui.');
    }

    public function destroy(Household $household)
    {
        $household->delete();

        return redirect()->route('households.index')->with('success', 'Data KK berhasil dihapus.');
    }
}
