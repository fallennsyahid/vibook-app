<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::with('kategori')->paginate(9);
        $kategoris = Kategori::where('status', 'active')->get();
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuMenipis = Buku::where('stok', '<=', 5)->where('stok', '>', 0)->count();
        $bukuTidakTersedia = Buku::where('stok', '=', 0)->count();
        return view('admin.buku.index', compact('bukus', 'kategoris', 'totalBuku', 'bukuTersedia', 'bukuMenipis', 'bukuTidakTersedia'));
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
        $request->validate([
            'nama_buku' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'stok' => 'required|integer|min:1',
            'foto_buku' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_buku' => $request->nama_buku,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('foto_buku')) {
            $data['foto_buku'] = $request->file('foto_buku')->store('buku-images', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'nama_buku' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'stok' => 'required|integer|min:1',
            'foto_buku' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_buku' => $request->nama_buku,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('foto_buku')) {
            // Delete old image if exists
            if ($buku->foto_buku) {
                Storage::disk('public')->delete($buku->foto_buku);
            }
            $data['foto_buku'] = $request->file('foto_buku')->store('buku-images', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        // Delete image if exists
        if ($buku->foto_buku) {
            Storage::disk('public')->delete($buku->foto_buku);
        }

        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
