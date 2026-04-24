<x-app-layout title="Data Pengembalian">

    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Data Pengembalian Buku</h1>
                <p class="text-text font-lato">Lihat status pengembalian buku yang Anda pinjam.</p>
            </div>
        </div>

        <!-- Info Cara Pengembalian -->
        <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 text-xl mt-1 mr-3"></i>
                <div>
                    <h3 class="text-blue-800 font-bold mb-2">Cara Pengembalian Buku</h3>
                    <ol class="text-blue-700 text-sm space-y-1 list-decimal list-inside">
                        <li>Datang ke ruang petugas dengan membawa buku yang dipinjam</li>
                        <li>Sebutkan tanggal peminjaman atau nomor peminjaman Anda</li>
                        <li>Petugas akan mengecek kondisi buku dan mencatat pengembalian Anda</li>
                        <li>Pengembalian selesai dan status Anda akan diperbarui di halaman ini</li>
                    </ol>
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-yellow-800 text-xs font-semibold flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Perhatian: Pengembalian yang terlambat akan mengakibatkan akun Anda ditangguhkan
                                sesuai dengan jumlah hari keterlambatan.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Status Blokir -->
        @if (Auth::user()->status_blokir && Auth::user()->durasi_blokir)
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl mt-1 mr-3"></i>
                    <div>
                        <h3 class="text-red-800 font-bold mb-1">Akun Anda Ditangguhkan</h3>
                        <p class="text-red-700 text-sm">
                            Akun Anda ditangguhkan hingga
                            <strong>{{ \Carbon\Carbon::parse(Auth::user()->durasi_blokir)->format('d M Y, H:i') }}</strong>
                            karena keterlambatan pengembalian buku.
                        </p>
                        <p class="text-red-600 text-xs mt-1">
                            Anda tidak dapat mengajukan peminjaman baru selama masa penangguhan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Belum Dikembalikan
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-orange-600 flex justify-center items-center">
                        <i class="fas fa-clock text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalBelumKembali }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Sudah Dikembalikan
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-green-600 flex justify-center items-center">
                        <i class="fas fa-check-circle text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalSudahKembali }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Total Terlambat
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-red-600 flex justify-center items-center">
                        <i class="fas fa-exclamation-circle text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalTerlambat }}
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex space-x-4">
                <button
                    class="tab-btn active px-4 py-2 font-semibold text-gray-700 border-b-2 border-blue-600 text-blue-600"
                    data-tab="content-belum-kembali">
                    <i class="fas fa-hourglass-half mr-2"></i>Belum Dikembalikan
                </button>
                <button
                    class="tab-btn px-4 py-2 font-semibold text-gray-700 border-b-2 border-transparent hover:border-gray-300"
                    data-tab="content-sudah-kembali">
                    <i class="fas fa-history mr-2"></i>Riwayat Pengembalian
                </button>
            </div>
        </div>

        <!-- DataTable Belum Dikembalikan -->
        <div id="content-belum-kembali" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-gray-400"></i>
                        Daftar Peminjaman Aktif
                    </h2>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                        Total: {{ $peminjamans->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    No</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal Dipinjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku
                                    yang Dipinjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Batas
                                    Pengembalian</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $index => $peminjaman)
                                @php
                                    $batasKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana);
                                    $sekarang = \Carbon\Carbon::now();
                                    $isTerlambat = $sekarang->gt($batasKembali);
                                    $hariTerlambat = $isTerlambat ? abs((int) $sekarang->diffInDays($batasKembali)) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50/80 transition-colors border-b border-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @foreach ($peminjaman->details as $detail)
                                                <div class="text-sm text-gray-700">
                                                    <span class="font-medium">{{ $detail->buku->judul_buku }}</span>
                                                    <span class="text-gray-500">({{ $detail->jumlah }}x)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div
                                            class="{{ $isTerlambat ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                            {{ $batasKembali->format('d M Y') }}
                                            @if ($isTerlambat)
                                                <div class="text-xs text-red-500 mt-1">
                                                    <i class="fas fa-exclamation-triangle"></i> Terlambat
                                                    {{ $hariTerlambat }} hari
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($isTerlambat)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                <i class="fas fa-exclamation-circle"></i>
                                                Terlambat
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i class="fas fa-hand-holding"></i>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-check-circle text-4xl mb-2 text-gray-300"></i>
                                        <p>Semua buku sudah dikembalikan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- DataTable Riwayat Pengembalian -->
        <div id="content-sudah-kembali" class="tab-content hidden">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-history text-gray-400"></i>
                        Riwayat Pengembalian
                    </h2>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                        Total: {{ $pengembalians->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    No</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal Pengembalian</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kondisi</th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalians as $index => $pengembalian)
                                @php
                                    $batasKembali = \Carbon\Carbon::parse(
                                        $pengembalian->peminjaman->tanggal_kembali_rencana,
                                    );
                                    $tanggalKembaliAsli = \Carbon\Carbon::parse($pengembalian->tanggal_kembali_asli);
                                    $isTerlambat = $tanggalKembaliAsli->gt($batasKembali);
                                    $hariTerlambat = $isTerlambat
                                        ? (int) $batasKembali->diffInDays($tanggalKembaliAsli)
                                        : 0;
                                @endphp
                                <tr class="hover:bg-gray-50/80 transition-colors border-b border-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $tanggalKembaliAsli->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @foreach ($pengembalian->peminjaman->details as $detail)
                                                <div class="text-sm text-gray-700">
                                                    <span class="font-medium">{{ $detail->buku->judul_buku }}</span>
                                                    <span class="text-gray-500">({{ $detail->jumlah }}x)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $kondisiColors = [
                                                'baik' => 'bg-green-100 text-green-700',
                                                'rusak' => 'bg-yellow-100 text-yellow-700',
                                                'hilang' => 'bg-red-100 text-red-700',
                                            ];
                                            $kondisiIcons = [
                                                'baik' => 'fa-check-circle',
                                                'rusak' => 'fa-exclamation-circle',
                                                'hilang' => 'fa-times-circle',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $kondisiColors[$pengembalian->kondisi] ?? 'bg-gray-100 text-gray-700' }}">
                                            <i
                                                class="fas {{ $kondisiIcons[$pengembalian->kondisi] ?? 'fa-question-circle' }}"></i>
                                            {{ ucfirst($pengembalian->kondisi) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($isTerlambat)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $hariTerlambat }} hari
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i>
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                        <p>Belum ada riwayat pengembalian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Tab Navigation
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');

                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.add('hidden');
                });

                // Remove active state from all buttons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('text-blue-600', 'border-blue-600');
                    b.classList.add('text-gray-700', 'border-transparent', 'hover:border-gray-300');
                });

                // Show selected tab
                document.getElementById(tabName).classList.remove('hidden');

                // Add active state to clicked button
                this.classList.remove('text-gray-700', 'border-transparent', 'hover:border-gray-300');
                this.classList.add('text-blue-600', 'border-blue-600');
            });
        });
    </script>

</x-app-layout>
