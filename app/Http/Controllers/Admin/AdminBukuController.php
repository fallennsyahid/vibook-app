<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminBukuController extends Controller
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
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:1',
            'foto_buku' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'kategori_id' => $request->kategori_id,
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('foto_buku')) {
            $data['foto_buku'] = $request->file('foto_buku')->store('buku-images', 'public');
        }

        try {
            $buku = Buku::create($data);
            return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating buku:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->route('admin.buku.index')->with('error', 'Error: ' . $e->getMessage());
        }
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
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:1',
            'foto_buku' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'deskripsi' => $request->deskripsi,
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

        try {
            $buku->update($data);
            return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating buku:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->route('admin.buku.index')->with('error', 'Error: ' . $e->getMessage());
        }
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
