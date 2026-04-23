<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buku;

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
        return view('siswa.buku.index', compact('bukus', 'kategoris', 'totalBuku', 'bukuTersedia', 'bukuMenipis', 'bukuTidakTersedia'));
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
