<?php

// Simple test script to verify delete works
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Create a test User (student) if not exists
$user = \App\Models\User::where('username', 'test_delete_student')->first();

if (!$user) {
    $user = \App\Models\User::create([
        'username' => 'test_delete_student',
        'password' => bcrypt('password'),
        'role' => 'siswa',
        'is_active' => 1,
    ]);

    // Create corresponding anggota
    \App\Models\Anggota::create([
        'user_id' => $user->id,
        'nama_anggota' => 'Test Delete Student',
        'nis' => '999999',
        'kelas' => '12',
        'no_telp' => '081234567890',
        'alamat' => 'Test Address',
    ]);

    echo "✓ Created test student with ID: {$user->id}\n";
} else {
    echo "✓ Found existing test student with ID: {$user->id}\n";
}

echo "\nAttempting to delete user ID: {$user->id}\n";

try {
    // Attempt delete using same logic as controller
    \Illuminate\Support\Facades\DB::transaction(function () use ($user) {
        $anggota = \App\Models\Anggota::where('user_id', $user->id)->first();

        if ($anggota) {
            $peminjamans = \App\Models\Peminjaman::where('anggota_id', $anggota->id)->get();

            foreach ($peminjamans as $peminjaman) {
                \App\Models\Pengembalian::where('peminjaman_id', $peminjaman->id)->delete();
            }

            foreach ($peminjamans as $peminjaman) {
                \App\Models\PeminjamanDetail::where('peminjaman_id', $peminjaman->id)->delete();
            }

            \App\Models\Peminjaman::where('anggota_id', $anggota->id)->delete();
            $anggota->delete();

            echo "✓ Deleted anggota\n";
        }

        $user->delete();
        echo "✓ Deleted user\n";
    });

    // Verify deletion
    $exists = \App\Models\User::where('id', $user->id)->exists();
    if (!$exists) {
        echo "\n✅ SUCCESS: User has been deleted from database\n";
    } else {
        echo "\n❌ FAILED: User still exists in database\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
