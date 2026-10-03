<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $blocks = Block::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('code', 'like', '%'.$request->search.'%');
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('blocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:blocks,code',
            'is_active' => 'boolean',
        ]);

        Block::create($validated);

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil ditambahkan.');
    }

    public function edit(Block $block)
    {
        return view('blocks.edit', compact('block'));
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:blocks,code,'.$block->id,
            'is_active' => 'boolean',
        ]);

        $block->update($validated);

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil diperbarui.');
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil dihapus.');
    }
}
