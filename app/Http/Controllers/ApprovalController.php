<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\ApprovalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::with('user')
            ->latest()
            ->paginate(10);

        return view('approval.index', compact('approvals'));
    }

    public function show(Approval $approval)
    {
        $approval->load([
            'user',
            'histories.user',
        ]);

        return view('approval.show', compact('approval'));
    }

    public function verify(Request $request, Approval $approval)
    {
        if ($approval->status !== Approval::STATUS_PENDING) {
            return back()->with('error', 'Pengajuan ini tidak dapat diverifikasi.');
        }

        return $this->changeStatus(
            $request,
            $approval,
            Approval::STATUS_VERIFIED,
            'verify',
            'Pengajuan berhasil diverifikasi.'
        );
    }

    public function approve(Request $request, Approval $approval)
    {
        if ($approval->status !== Approval::STATUS_VERIFIED) {
            return back()->with('error', 'Pengajuan harus diverifikasi terlebih dahulu.');
        }

        return $this->changeStatus(
            $request,
            $approval,
            Approval::STATUS_APPROVED,
            'approve',
            'Pengajuan berhasil disetujui.'
        );
    }

    public function reject(Request $request, Approval $approval)
    {
        $request->validate([
            'notes' => ['required', 'string', 'max:1000'],
        ]);

        if (!in_array($approval->status, [
            Approval::STATUS_PENDING,
            Approval::STATUS_VERIFIED,
        ])) {
            return back()->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        return $this->changeStatus(
            $request,
            $approval,
            Approval::STATUS_REJECTED,
            'reject',
            'Pengajuan berhasil ditolak.'
        );
    }

    public function revision(Request $request, Approval $approval)
    {
        $request->validate([
            'notes' => ['required', 'string', 'max:1000'],
        ]);

        if (!in_array($approval->status, [
            Approval::STATUS_PENDING,
            Approval::STATUS_VERIFIED,
        ])) {
            return back()->with('error', 'Pengajuan ini tidak dapat dikembalikan untuk revisi.');
        }

        return $this->changeStatus(
            $request,
            $approval,
            Approval::STATUS_REVISION,
            'revision',
            'Pengajuan dikembalikan untuk revisi.'
        );
    }

    public function archive(Request $request, Approval $approval)
    {
        if (!in_array($approval->status, [
            Approval::STATUS_APPROVED,
            Approval::STATUS_REJECTED,
        ])) {
            return back()->with('error', 'Hanya pengajuan selesai yang dapat diarsipkan.');
        }

        return $this->changeStatus(
            $request,
            $approval,
            Approval::STATUS_ARCHIVED,
            'archive',
            'Pengajuan berhasil diarsipkan.'
        );
    }

    private function changeStatus(
        Request $request,
        Approval $approval,
        string $newStatus,
        string $action,
        string $message
    ) {
        return DB::transaction(function () use (
            $request,
            $approval,
            $newStatus,
            $action,
            $message
        ) {
            $oldStatus = $approval->status;

            $approval->update([
                'status' => $newStatus,
                'notes' => $request->notes,
                'acted_at' => now(),
            ]);

            ApprovalHistory::create([
                'approval_id' => $approval->id,
                'user_id' => auth()->id(),
                'action' => $action,
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'notes' => $request->notes,
                'acted_at' => now(),
            ]);

            return back()->with('success', $message);
        });
    }
}