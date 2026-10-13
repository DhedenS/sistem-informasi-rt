<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $blocks = Block::with('ketuaBlok')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('code', 'like', '%'.$request->search.'%');
                });
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
        // Calon ketua: akun yang terhubung ke KK di blok ini
        $candidates = User::whereHas('household', function ($q) use ($block) {
                $q->where('block_id', $block->id);
            })->orderBy('name')->get();

        $ketuaSekarang = $block->ketuaBlok;

        return view('blocks.edit', compact('block', 'candidates', 'ketuaSekarang'));
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:blocks,code,'.$block->id,
            'ketua_user_id' => 'nullable|exists:users,id',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $ketuaBaruId = $validated['ketua_user_id'] ?? null;
        unset($validated['ketua_user_id']);

        DB::transaction(function () use ($block, $validated, $ketuaBaruId) {
            $block->update($validated);

            // Copot ketua lama (kalau berbeda dengan yang baru)
            $ketuaLama = User::where('block_id', $block->id)
                ->role('Ketua Block')->get();

            foreach ($ketuaLama as $user) {
                if ($user->id != $ketuaBaruId) {
                    $user->removeRole('Ketua Block');
                    $user->update(['block_id' => null]);
                }
            }

            // Angkat ketua baru
            if ($ketuaBaruId) {
                $baru = User::whereHas('household', fn ($q) => $q->where('block_id', $block->id))
                    ->findOrFail($ketuaBaruId);

                $baru->update(['block_id' => $block->id]);

                if (! $baru->hasRole('Ketua Block')) {
                    $baru->assignRole('Ketua Block');
                }
            }
        });

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil diperbarui.');
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil dihapus.');
    }
}
