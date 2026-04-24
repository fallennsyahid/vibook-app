<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengembalian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userSiswa = User::where('role', 'siswa')->with('anggota')->latest()->get();
        $siswaAktif = User::where('role', 'siswa')->where('is_active', true)->count();
        return view('admin.siswa.index', compact('userSiswa', 'siswaAktif'));
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
        // Validate input
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'nis' => 'required|string|unique:anggotas,nis',
            'kelas' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Generate random password
                $generatedPassword = 'password123';

                // Generate username from name
                $usernameBase = Str::slug($request->nama_anggota, '_');
                $username = $usernameBase;
                $count = 1;

                while (User::where('username', $username)->exists()) {
                    $username = $usernameBase . '-' . $count;
                    $count++;
                }

                // Create User
                $user = User::create([
                    'username' => $username,
                    'password' => Hash::make($generatedPassword),
                    'role' => 'siswa',
                    'is_active' => true,
                ]);

                // Create Anggota (student profile)
                $anggota = Anggota::create([
                    'user_id' => $user->id,
                    'nama_anggota' => $request->nama_anggota,
                    'nis' => $request->nis,
                    'kelas' => $request->kelas,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                ]);

                Log::info('Anggota created successfully', [
                    'user_id' => $user->id,
                    'anggota_id' => $anggota->id,
                    'nama_anggota' => $request->nama_anggota
                ]);

                // Send WhatsApp notification
                $this->sendWhatsAppNotification($request->no_telp, $username, $generatedPassword, $request->nama_anggota);

                return redirect()->route('admin.siswa.index')
                    ->with('success', "Akun berhasil dibuat")
                    ->with('credentials', [
                        'nama_anggota' => $request->nama_anggota,
                        'username' => $username,
                        'password' => $generatedPassword,
                        'no_telp' => $request->no_telp,
                    ]);
            });
        } catch (\Exception $e) {
            Log::error('Error creating siswa account', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage());
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $anggota = Anggota::where('user_id', $id)->firstOrFail();

        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                Rule::unique('anggotas', 'nis')->ignore($anggota->id)
            ],
            'kelas' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        try {
            $anggota->update([
                'nama_anggota' => $request->nama_anggota,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ]);

            return redirect()->route('admin.siswa.index')
                ->with('success', "Data siswa {$request->nama_anggota} berhasil diperbarui.");
        } catch (\Exception $e) {
            Log::error('Error updating siswa: ' . $e->getMessage());
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $siswa)
    {
        try {
            $userId = $siswa->id;
            $username = $siswa->username;

            Log::info('Destroy method called', ['user_id' => $userId, 'username' => $username]);

            DB::transaction(function () use ($siswa) {
                // Get anggota associated with user
                $anggota = Anggota::where('user_id', $siswa->id)->first();

                if ($anggota) {
                    // Get all peminjamans for this anggota
                    $peminjamans = Peminjaman::where('anggota_id', $anggota->id)->get();

                    // Delete all pengembalians first (they reference peminjamans)
                    foreach ($peminjamans as $peminjaman) {
                        Pengembalian::where('peminjaman_id', $peminjaman->id)->delete();
                    }

                    // Delete all peminjaman_details
                    foreach ($peminjamans as $peminjaman) {
                        PeminjamanDetail::where('peminjaman_id', $peminjaman->id)->delete();
                    }

                    // Delete all peminjamans
                    Peminjaman::where('anggota_id', $anggota->id)->delete();

                    // Delete anggota
                    $anggota->delete();
                }

                // Delete user
                $siswa->delete();
            });

            Log::info('Student account deleted successfully', [
                'user_id' => $userId,
                'username' => $username
            ]);

            return redirect()->route('admin.siswa.index')
                ->with('success', 'Akun siswa berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting siswa: ' . $e->getMessage(), [
                'error' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Terjadi kesalahan saat menghapus akun: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active = !$user->is_active;
            $user->save();

            return redirect()->back()->with('success', 'Status siswa berhasil diubah!');
        } catch (\Exception $e) {
            Log::error('Error toggling status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status.');
        }
    }

    /**
     * Send WhatsApp notification with credentials
     */
    private function sendWhatsAppNotification($phoneNumber, $username, $password, $studentName)
    {
        try {
            // Normalize phone number (remove 0 prefix, add country code 62 for Indonesia)
            $normalizedPhone = $this->normalizePhoneNumber($phoneNumber);

            // Send via WhatsApp service
            \App\Services\WhatsAppService::sendCredentials($normalizedPhone, $username, $password, $studentName);

            Log::info('WhatsApp notification sent successfully', [
                'phone' => $phoneNumber,
                'student' => $studentName
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification: ' . $e->getMessage(), [
                'phone' => $phoneNumber,
                'student' => $studentName
            ]);
            // Don't fail the account creation if notification fails
        }
    }

    /**
     * Normalize phone number format for Twilio
     * Converts 0812xxxxx to 62812xxxxx format
     */
    private function normalizePhoneNumber($phone)
    {
        // Remove any non-numeric characters except +
        $phone = preg_replace('/[^\d+]/', '', $phone);

        // If starts with 0, replace with 62
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with 62 or +, add 62
        if (strpos($phone, '62') !== 0 && strpos($phone, '+') !== 0) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
