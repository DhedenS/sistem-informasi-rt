<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar surat masuk.
     */
    public function index()
    {
        $suratMasuks = SuratMasuk::latest()->get();

        return view('surat-masuk.index', compact('suratMasuks'));
    }

    /**
     * Menampilkan form tambah surat masuk.
     */
    public function create()
    {
        return view('surat-masuk.create');
    }

    /**
     * Menyimpan surat masuk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat-masuk', 'public');
        }

        SuratMasuk::create($validated);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail surat masuk.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Menampilkan form edit surat masuk.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * Memperbarui surat masuk.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi_ringkas' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat-masuk', 'public');
        }

        $suratMasuk->update($validated);

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Menghapus surat masuk.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}