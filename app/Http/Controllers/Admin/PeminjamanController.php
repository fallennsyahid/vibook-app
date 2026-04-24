<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with('anggota', 'details.buku')->latest()->paginate(10);
        $totalPeminjaman = Peminjaman::count();
        $totalPending = Peminjaman::where('status', 'pending')->count();
        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $totalDitolak = Peminjaman::where('status', 'ditolak')->count();
        return view('admin.peminjaman.index', compact('peminjamans', 'totalPeminjaman', 'totalPending', 'totalDisetujui', 'totalDitolak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with('anggota', 'details.buku')->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Approve peminjaman request.
     */
    public function approve(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->route('admin.peminjaman.show', $id)->with('error', 'Hanya pengajuan pending yang dapat disetujui.');
        }

        $peminjaman->update([
            'status' => 'disetujui',
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject peminjaman request.
     */
    public function reject(Request $request, string $id)
    {
        $request->validate([
            'note' => 'required|string|min:5',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->route('admin.peminjaman.show', $id)->with('error', 'Hanya pengajuan pending yang dapat ditolak.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'note' => $request->note,
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
