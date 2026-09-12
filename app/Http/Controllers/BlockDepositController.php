<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockDeposit;
use Illuminate\Http\Request;

class BlockDepositController extends Controller
{
    public function index()
    {
        $deposits = BlockDeposit::with([
            'block',
            'user'
        ])
            ->latest()
            ->paginate(10);

        return view('block-deposits.index', compact('deposits'));
    }

    public function create()
    {
        /*
         * Sementara ambil semua blok.
         *
         * NANTI:
         * blok ini akan otomatis mengikuti blok
         * milik Ketua Blok yang sedang login.
         */
        $blocks = Block::orderBy('name')->get();

        return view('block-deposits.create', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => [
                'required',
                'exists:blocks,id'
            ],

            'month' => [
                'required',
                'integer',
                'between:1,12'
            ],

            'year' => [
                'required',
                'integer',
                'min:2020',
                'max:2100'
            ],

            'expected_amount' => [
                'required',
                'numeric',
                'min:0'
            ],

            'submitted_amount' => [
                'required',
                'numeric',
                'min:0'
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);

        $alreadyExists = BlockDeposit::where(
            'block_id',
            $validated['block_id']
        )
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($alreadyExists) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Setoran untuk blok dan bulan tersebut sudah pernah diajukan.'
                );
        }

        $expectedAmount = $validated['expected_amount'];
        $submittedAmount = $validated['submitted_amount'];

        $deposit = BlockDeposit::create([
            'block_id' => $validated['block_id'],

            'user_id' => auth()->id(),

            'month' => $validated['month'],
            'year' => $validated['year'],

            'expected_amount' => $expectedAmount,

            'submitted_amount' => $submittedAmount,

            'difference' =>
                $submittedAmount - $expectedAmount,

            'status' =>
                BlockDeposit::STATUS_PENDING,

            'notes' =>
                $validated['notes'] ?? null,

            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('block-deposits.show', $deposit)
            ->with(
                'success',
                'Setoran berhasil diajukan dan menunggu approval Bendahara.'
            );
    }

    public function show(BlockDeposit $blockDeposit)
    {
        $blockDeposit->load([
            'block',
            'user'
        ]);

        return view(
            'block-deposits.show',
            compact('blockDeposit')
        );
    }
}