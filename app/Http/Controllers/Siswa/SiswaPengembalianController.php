<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Peminjaman yang belum dikembalikan (status: dipinjam)
        $peminjamans = Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->with('details.buku')
            ->orderBy('created_at', 'desc')
            ->get();

        // Riwayat pengembalian
        $pengembalians = Pengembalian::whereHas('peminjaman', function ($query) use ($anggota) {
            $query->where('anggota_id', $anggota->id);
        })
            ->with('peminjaman.details.buku')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBelumKembali = $peminjamans->count();
        $totalSudahKembali = $pengembalians->count();
        $totalTerlambat = $pengembalians->filter(function ($pengembalian) {
            return $pengembalian->tanggal_kembali_asli > $pengembalian->peminjaman->tanggal_kembali_rencana;
        })->count();

        return view('siswa.pengembalian.index', compact(
            'peminjamans',
            'pengembalians',
            'totalBelumKembali',
            'totalSudahKembali',
            'totalTerlambat'
        ));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengembalian = Pengembalian::where('id', $id)
            ->with(['peminjaman.details.buku', 'peminjaman.anggota'])
            ->firstOrFail();

        $anggota = Auth::user()->anggota;

        // Pastikan user hanya bisa melihat pengembalian sendiri
        if ($pengembalian->peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        return view('siswa.pengembalian.show', compact('pengembalian'));
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
