<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiswaPeminjamanController extends Controller
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

        $peminjamans = Peminjaman::where('anggota_id', $anggota->id)
            ->with('details')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalPengajuan = $peminjamans->count();
        $pengajuanDisetujui = $peminjamans->where('status', 'disetujui')->count();
        $pengajuanPending = $peminjamans->where('status', 'pending')->count();
        $pengajuanDitolak = $peminjamans->where('status', 'ditolak')->count();

        // Ambil semua buku untuk form
        $bukus = Buku::with('kategori')->where('stok', '>', 0)->get();

        return view('siswa.peminjaman.index', compact(
            'peminjamans',
            'totalPengajuan',
            'pengajuanDisetujui',
            'pengajuanPending',
            'pengajuanDitolak',
            'bukus'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'alasan_meminjamn' => 'required|string|min:10',
            'buku' => 'required|array|min:1',
            'buku.*.buku_id' => 'required|exists:bukus,id',
            'buku.*.jumlah' => 'required|integer|min:1'
        ], [
            'tanggal_pinjam.required' => 'Tanggal peminjaman harus diisi',
            'tanggal_pinjam.after_or_equal' => 'Tanggal peminjaman harus hari ini atau setelahnya',
            'tanggal_kembali_rencana.required' => 'Tanggal pengembalian harus diisi',
            'tanggal_kembali_rencana.after' => 'Tanggal pengembalian harus setelah tanggal peminjaman',
            'alasan_meminjamn.required' => 'Alasan meminjam harus diisi',
            'alasan_meminjamn.min' => 'Alasan meminjam minimal 10 karakter',
            'buku.required' => 'Minimal pilih 1 buku',
            'buku.*.jumlah.min' => 'Jumlah minimal 1'
        ]);

        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            // Cek ketersediaan stok
            foreach ($request->buku as $item) {
                $buku = Buku::find($item['buku_id']);
                if (!$buku) {
                    return redirect()->back()
                        ->with('error', 'Buku tidak ditemukan.')
                        ->withInput();
                }
                if ($buku->stok < $item['jumlah']) {
                    return redirect()->back()
                        ->with('error', "Stok {$buku->judul_buku} tidak mencukupi. Stok tersedia: {$buku->stok}")
                        ->withInput();
                }
            }

            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'anggota_id' => $anggota->id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'alasan_meminjamn' => $request->alasan_meminjamn,
                'status' => 'pending'
            ]);

            // Buat detail peminjaman
            foreach ($request->buku as $item) {
                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $item['buku_id'],
                    'jumlah' => $item['jumlah']
                ]);
            }

            DB::commit();
            return redirect()->route('siswa.peminjaman.index')
                ->with('success', 'Pengajuan peminjaman berhasil dibuat. Menunggu persetujuan petugas.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource with QR Code.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->with(['details.buku.kategori', 'anggota'])
            ->firstOrFail();

        $anggota = Auth::user()->anggota;

        // Pastikan user hanya bisa melihat peminjaman sendiri
        if ($peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        return view('siswa.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Remove the specified resource from storage (cancel peminjaman).
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->firstOrFail();

        $anggota = Auth::user()->anggota;

        // Pastikan user hanya bisa cancel peminjaman sendiri
        if ($peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        // Hanya bisa cancel jika masih pending
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya peminjaman dengan status pending yang dapat dibatalkan.');
        }

        $peminjaman->delete();

        return redirect()->route('siswa.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }

    /**
     * Upload bukti pengambilan - changes status to dipinjam
     */
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pengambilan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'bukti_pengambilan.required' => 'Bukti pengambilan harus diunggah',
            'bukti_pengambilan.image' => 'File harus berupa gambar',
            'bukti_pengambilan.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $anggota = Auth::user()->anggota;

        // Pastikan user hanya bisa upload bukti peminjaman sendiri
        if ($peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Unauthorized access');
        }

        // Hanya bisa upload jika status disetujui
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->back()
                ->with('error', 'Hanya peminjaman yang sudah disetujui yang dapat diunggah buktinya.');
        }

        // Upload file
        if ($request->hasFile('bukti_pengambilan')) {
            // Hapus file lama jika ada
            if ($peminjaman->bukti_pengambilan) {
                $oldPath = storage_path('app/public/' . $peminjaman->bukti_pengambilan);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('bukti_pengambilan');
            $filename = 'bukti_pengambilan_' . $peminjaman->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pengambilan', $filename, 'public');

            // Update peminjaman
            $peminjaman->update([
                'bukti_pengambilan' => $path,
                'status' => 'dipinjam'
            ]);

            return redirect()->route('siswa.peminjaman.index')
                ->with('success', 'Bukti pengambilan berhasil diunggah. Status berubah menjadi Dipinjam.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mengunggah bukti pengambilan.');
    }
}
