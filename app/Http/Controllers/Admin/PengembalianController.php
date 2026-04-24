<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pending peminjamans (belum dikembalikan)
        $peminjamans = Peminjaman::with('details.buku', 'anggota')
            ->whereIn('status', ['dipinjam'])
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->get();

        // Get completed pengembalians (riwayat)
        $pengembalians = Pengembalian::with(['peminjaman.details.buku', 'peminjaman.anggota'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total pengembalian
        $totalPengembalian = $pengembalians->count();

        // Hitung total peminjaman (dipinjam)
        $totalPeminjaman = $peminjamans->count();

        return view('admin.pengembalian.index', compact(
            'peminjamans',
            'pengembalians',
            'totalPengembalian',
            'totalPeminjaman'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_kembali_asli' => 'required|date|before_or_equal:today',
            'bukti_pengambilan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string'
        ], [
            'peminjaman_id.required' => 'Pilihan peminjaman harus diisi',
            'peminjaman_id.exists' => 'Peminjaman tidak ditemukan',
            'tanggal_kembali_asli.required' => 'Tanggal pengembalian harus diisi',
            'tanggal_kembali_asli.before_or_equal' => 'Tanggal pengembalian tidak boleh melebihi hari ini',
            'bukti_pengambilan.image' => 'File harus berupa gambar',
            'bukti_pengambilan.max' => 'Ukuran gambar maksimal 2MB',
            'kondisi.required' => 'Kondisi buku harus dipilih',
            'kondisi.in' => 'Kondisi buku tidak valid'
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::find($request->peminjaman_id);

            // Cek status peminjaman adalah 'dipinjam'
            if ($peminjaman->status !== 'dipinjam') {
                return redirect()->back()
                    ->with('error', 'Hanya peminjaman dengan status "Dipinjam" yang dapat dikembalikan.')
                    ->withInput();
            }

            $path = null;
            // Handle file upload jika ada
            if ($request->hasFile('bukti_pengambilan')) {
                $file = $request->file('bukti_pengambilan');
                $filename = 'bukti_pengambilan_' . $peminjaman->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pengembalian', $filename, 'public');
            }

            // Buat pengembalian baru
            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali_asli' => $request->tanggal_kembali_asli,
                'bukti_pengambilan' => $path,
                'kondisi' => $request->kondisi,
                'catatan' => $request->catatan
            ]);

            // Update status peminjaman menjadi dikembalikan
            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);

            DB::commit();

            return redirect()->route('admin.pengembalian.index')
                ->with('success', 'Pengembalian berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
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
