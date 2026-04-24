<x-app-layout title="Detail Peminjaman">

    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-2xl text-heading font-bold">Detail Peminjaman Buku</h1>
                </div>
                <p class="text-text font-lato">Lihat detail dan approve/tolak pengajuan peminjaman buku.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Peminjam -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-user text-gray-400"></i>
                            Informasi Peminjam
                        </h2>
                    </div>

                    <div class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ Avatar::create($peminjaman->anggota->nama_anggota ?? 'User')->toBase64() }}"
                                alt="{{ $peminjaman->anggota->nama_anggota }}" class="rounded-full w-16 h-16">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $peminjaman->anggota->nama_anggota ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $peminjaman->anggota->email ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Kelas: {{ $peminjaman->anggota->kelas ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Detail Peminjaman -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-calendar text-gray-400"></i>
                            Detail Peminjaman
                        </h2>
                    </div>

                    <div class="px-6 py-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Pinjam
                                </p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Batas Kembali</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Buku yang Dipinjam -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-book text-gray-400"></i>
                            Buku yang Dipinjam ({{ $peminjaman->details->count() }})
                        </h2>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse ($peminjaman->details as $detail)
                            <div class="px-6 py-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $detail->buku->judul_buku ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Kategori: <span
                                                class="font-medium">{{ $detail->buku->kategori->nama_kategori ?? 'N/A' }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900">{{ $detail->jumlah }}x</p>
                                        <p class="text-xs text-gray-500">Quantity</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-4 text-center text-gray-500">
                                <p>Tidak ada buku yang dipinjam</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Card Alasan Peminjaman -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-comment-dots text-gray-400"></i>
                            Alasan Peminjaman
                        </h2>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-gray-700 leading-relaxed">{{ $peminjaman->alasan_meminjamn }}</p>
                    </div>
                </div>

                <!-- Card Bukti Pengambilan -->
                @if ($peminjaman->bukti_pengambilan)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-image text-gray-400"></i>
                                Bukti Pengambilan
                            </h2>
                        </div>

                        <div class="px-6 py-4">
                            <img src="{{ asset('storage/' . $peminjaman->bukti_pengambilan) }}" alt="Bukti Pengambilan"
                                class="rounded-lg max-w-full h-auto max-h-96 mx-auto">
                        </div>
                    </div>
                @endif

            </div>

            <!-- Sidebar - Actions -->
            <div class="lg:col-span-1">
                <!-- Status Card -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-6">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Status</h2>
                    </div>

                    <div class="px-6 py-4">
                        @php
                            $statusConfig = [
                                'pending' => [
                                    'bg' => 'bg-orange-100',
                                    'text' => 'text-orange-700',
                                    'icon' => 'fa-hourglass-half',
                                    'label' => 'Menunggu Persetujuan',
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
                                    'label' => 'Sedang Dipinjam',
                                ],
                                'dikembalikan' => [
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-700',
                                    'icon' => 'fa-undo',
                                    'label' => 'Sudah Dikembalikan',
                                ],
                            ];
                            $status = $statusConfig[$peminjaman->status] ?? $statusConfig['pending'];
                        @endphp

                        <div class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full {{ $status['bg'] }} mb-3">
                                <i class="fas {{ $status['icon'] }} text-2xl {{ $status['text'] }}"></i>
                            </div>
                            <p class="font-semibold text-gray-900 text-lg">{{ $status['label'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Approval Actions -->
                @if ($peminjaman->status === 'pending')
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm space-y-3">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Tindakan</h2>
                        </div>

                        <div class="px-6 py-4 space-y-3">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    Setujui Peminjaman
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button type="button" onclick="openRejectModal()"
                                class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-times-circle"></i>
                                Tolak Peminjaman
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

    <!-- Modal Reject -->
    <div id="reject-modal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Tolak Peminjaman</h2>
                <button type="button" onclick="closeRejectModal()"
                    class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}" method="POST">
                @csrf

                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="note" name="note" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Tuliskan alasan penolakan..." required></textarea>
                        @error('note')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('reject-modal').classList.remove('hidden');
            document.getElementById('reject-modal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
            document.getElementById('reject-modal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('reject-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>

</x-app-layout>
