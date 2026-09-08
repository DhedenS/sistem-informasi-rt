<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::with(['user'])
            ->latest()
            ->paginate(10);

        return view('approval.index', compact('approvals'));
    }

    public function show(Approval $approval)
    {
        $approval->load(['user', 'approvable']);

        return view('approval.show', compact('approval'));
    }

    public function verify(Request $request, Approval $approval)
    {
        $approval->update([
            'status' => 'verified',
            'notes' => $request->notes,
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil diverifikasi.');
    }

    public function approve(Request $request, Approval $approval)
    {
        $approval->update([
            'status' => 'approved',
            'notes' => $request->notes,
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, Approval $approval)
    {
        $approval->update([
            'status' => 'rejected',
            'notes' => $request->notes,
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function revision(Request $request, Approval $approval)
    {
        $approval->update([
            'status' => 'revision',
            'notes' => $request->notes,
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan dikembalikan untuk revisi.');
    }

    public function archive(Request $request, Approval $approval)
    {
        $approval->update([
            'status' => 'archived',
            'notes' => $request->notes,
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil diarsipkan.');
    }
}