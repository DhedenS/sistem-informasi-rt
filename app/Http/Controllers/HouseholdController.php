<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Household;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class HouseholdController extends Controller
{
    /** Role yang boleh dipilih dari form edit KK (Ketua RT & Ketua Block tidak ada). */
    private const ASSIGNABLE_ROLES = ['Bendahara', 'Sekretaris', 'Warga'];

    /** Role yang tidak boleh diubah lewat form ini (Ketua Block diatur lewat menu Blok). */
    private const LOCKED_ROLES = ['Ketua RT', 'Ketua Block', 'Superadmin'];

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
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        $validated['is_active'] = $request->has('is_active');

        DB::transaction(function () use ($validated) {
            $email = $validated['email'];
            unset($validated['email']);

            $household = Household::create($validated);

            // Auto-generate akun warga untuk KK baru (password awal: "password")
            $user = User::create([
                'name' => $household->head_name,
                'email' => $email,
                'password' => 'password', // di-hash otomatis oleh cast 'hashed'
                'household_id' => $household->id,
            ]);

            // Pastikan role Warga ada (dibuat otomatis jika belum ada)
            Role::firstOrCreate(['name' => 'Warga', 'guard_name' => 'web']);
            $user->assignRole('Warga');
        });

        return redirect()->route('households.index')->with('success', 'Data KK berhasil ditambahkan beserta akun warga (password awal: password).');
    }

    public function edit(Household $household)
    {
        $blocks = Block::where('is_active', true)->get();
        $user = $household->user;
        $roles = self::ASSIGNABLE_ROLES;
        $roleLocked = $user && $user->hasAnyRole(self::LOCKED_ROLES);
        $currentRole = $user ? $user->roles->pluck('name')->first() : null;

        return view('households.edit', compact('household', 'blocks', 'user', 'roles', 'roleLocked', 'currentRole'));
    }

    public function update(Request $request, Household $household)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'household_number' => 'required|string|max:255',
            'head_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'role' => ['nullable', Rule::in(self::ASSIGNABLE_ROLES)],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $newRole = $validated['role'] ?? null;
        unset($validated['role']);

        DB::transaction(function () use ($household, $validated, $newRole) {
            $household->update($validated);

            $user = $household->user;

            // Tidak ada akun, atau akun dengan role terkunci: role tidak disentuh
            if (! $user || ! $newRole || $user->hasAnyRole(self::LOCKED_ROLES)) {
                // Ketua Block pindah blok: ikutkan block_id-nya
                if ($user && $user->hasRole('Ketua Block')) {
                    $this->makeKetuaBlock($user, $household->block_id);
                }
                return;
            }

            Role::firstOrCreate(['name' => $newRole, 'guard_name' => 'web']);

            $user->syncRoles([$newRole]);
            $user->update(['block_id' => null]);
        });

        return redirect()->route('households.index')->with('success', 'Data KK berhasil diperbarui.');
    }

    public function destroy(Household $household)
    {
        $household->delete();

        return redirect()->route('households.index')->with('success', 'Data KK berhasil dihapus.');
    }

    /**
     * Jadikan user Ketua Block untuk blok tertentu.
     * Ketua Block lama di blok yang sama diturunkan jadi Warga (1 blok = 1 ketua).
     */
    private function makeKetuaBlock(User $user, int $blockId): void
    {
        Role::firstOrCreate(['name' => 'Ketua Block', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Warga', 'guard_name' => 'web']);

        User::where('block_id', $blockId)
            ->where('id', '!=', $user->id)
            ->role('Ketua Block')
            ->get()
            ->each(function (User $lama) {
                $lama->syncRoles(['Warga']);
                $lama->update(['block_id' => null]);
            });

        $user->syncRoles(['Ketua Block']);
        $user->update(['block_id' => $blockId]);
    }
}