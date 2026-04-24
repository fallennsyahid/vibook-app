<x-app-layout title="Data Peminjaman">
    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Data Peminjaman</h1>
                <p class="text-text font-lato">Lihat daftar peminjaman yang telah dilakukan.</p>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 ">
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Total Peminjaman
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-primary flex justify-center items-center">
                        <i class="fas fa-briefcase text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalPeminjaman ?? '-' }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Menunggu Persetujuan
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-orange-600 flex justify-center items-center">
                        <i class="fas fa-clock text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalPending ?? '0' }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Disetujui
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-green-600 flex justify-center items-center">
                        <i class="fas fa-circle-check text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalDisetujui ?? '0' }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Ditolak
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-red-600 flex justify-center items-center">
                        <i class="fas fa-times-circle text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalDitolak ?? '0' }}
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mt-8">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list text-gray-400"></i>
                    Daftar Pengajuan Peminjaman
                </h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                    Total: {{ $peminjamans->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table id="peminjaman-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                No</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                                Peminjam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal
                                Pinjam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku yang
                                Dipinjam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Batas
                                Kembali</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Status</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $index => $peminjaman)
                            <tr class="hover:bg-gray-50/80 transition-colors border-b border-gray-100">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-xs">
                                            <img src="{{ Avatar::create($peminjaman->anggota->nama_anggota ?? 'User')->toBase64() }}"
                                                alt="{{ $peminjaman->anggota->nama_anggota }}"
                                                class="rounded-full w-8 h-8">
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $peminjaman->anggota->nama_anggota ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $peminjaman->anggota->nis ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        @foreach ($peminjaman->details->take(2) as $detail)
                                            <span class="text-sm text-gray-700">
                                                • {{ $detail->buku->judul_buku }} ({{ $detail->jumlah }}x)
                                            </span>
                                        @endforeach
                                        @if ($peminjaman->details->count() > 2)
                                            <span class="text-xs text-primary">+{{ $peminjaman->details->count() - 2 }}
                                                lainnya</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                {{-- <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs truncate"
                                        title="{{ $peminjaman->alasan_meminjamn }}">
                                        {{ Str::limit($peminjaman->alasan_meminjamn, 30) }}
                                    </div>
                                </td> --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-orange-100',
                                                'text' => 'text-orange-700',
                                                'icon' => 'fa-hourglass-half',
                                                'label' => 'Menunggu',
                                            ],
                                            'disetujui' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-700',
                                                'icon' => 'fa-check-circle',
                                                'label' => 'Disetujui',
                                            ],
                                            'ditolak' => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-700',
                                                'icon' => 'fa-times-circle',
                                                'label' => 'Ditolak',
                                            ],
                                            'dipinjam' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-700',
                                                'icon' => 'fa-book',
                                                'label' => 'Dipinjam',
                                            ],
                                            'dikembalikan' => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'icon' => 'fa-undo',
                                                'label' => 'Dikembalikan',
                                            ],
                                        ];
                                        $status = $statusConfig[$peminjaman->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                        <i class="fas {{ $status['icon'] }}"></i>
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.peminjaman.show', $peminjaman->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-3"></i>
                                        <p class="text-lg font-medium">Belum ada pengajuan peminjaman</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
