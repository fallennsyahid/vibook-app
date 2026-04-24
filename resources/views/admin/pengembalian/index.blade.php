<x-app-layout title="Data Pengembalian">
    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Data Pengembalian Buku</h1>
                <p class="text-text font-lato">Kelola pengembalian buku dari siswa.</p>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
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
                    {{ $totalPeminjaman }}
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
                    {{ $totalPengembalian }}
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
                                    Nama Siswa</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal Dipinjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku
                                    yang Dipinjam</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Batas
                                    Pengembalian</th>
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
                                @php
                                    $batasKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana);
                                    $sekarang = \Carbon\Carbon::now();
                                    $isTerlambat = $sekarang->gt($batasKembali);
                                    $hariTerlambat = $isTerlambat ? abs((int) $sekarang->diffInDays($batasKembali)) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50/80 transition-colors border-b border-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ Avatar::create($peminjaman->anggota->user->name ?? 'User')->toBase64() }}"
                                                alt="{{ $peminjaman->anggota->user->name }}"
                                                class="w-8 h-8 rounded-full">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $peminjaman->anggota->user->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $peminjaman->anggota->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
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
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" onclick="openReturnModal({{ $peminjaman->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-undo"></i>
                                            Kembalikan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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
                                    Nama Siswa</th>
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ Avatar::create($pengembalian->peminjaman->anggota->user->name ?? 'User')->toBase64() }}"
                                                alt="{{ $pengembalian->peminjaman->anggota->user->name }}"
                                                class="w-8 h-8 rounded-full">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $pengembalian->peminjaman->anggota->user->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $pengembalian->peminjaman->anggota->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
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

    <!-- Modal Pengembalian -->
    <div id="return-modal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-undo mr-2 text-blue-600"></i>Form Pengembalian Buku
                </h2>
                <button type="button" onclick="closeReturnModal()"
                    class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>
            </div>

            <form id="return-form" action="{{ route('admin.pengembalian.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="px-6 py-4 space-y-4">
                    <!-- Peminjaman ID -->
                    <input type="hidden" id="peminjaman_id" name="peminjaman_id" value="">

                    <!-- Tanggal Kembali Asli -->
                    <div>
                        <label for="tanggal_kembali_asli" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pengembalian <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kembali_asli" name="tanggal_kembali_asli"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        @error('tanggal_kembali_asli')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Pengambilan -->
                    <div>
                        <label for="bukti_pengambilan" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Pengembalian (Foto) <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <input type="file" id="bukti_pengambilan" name="bukti_pengambilan" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
                        @error('bukti_pengambilan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kondisi Buku -->
                    <div>
                        <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi Buku <span class="text-red-500">*</span>
                        </label>
                        <select id="kondisi" name="kondisi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                        @error('kondisi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Tuliskan catatan tambahan jika ada..."></textarea>
                        @error('catatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeReturnModal()"
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Pengembalian
                    </button>
                </div>
            </form>
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

        // Return Modal Functions
        function openReturnModal(peminjamanId) {
            document.getElementById('peminjaman_id').value = peminjamanId;
            document.getElementById('return-form').reset();
            document.getElementById('tanggal_kembali_asli').max = new Date().toISOString().split('T')[0];
            document.getElementById('return-modal').classList.remove('hidden');
            document.getElementById('return-modal').classList.add('flex');
        }

        function closeReturnModal() {
            document.getElementById('return-modal').classList.add('hidden');
            document.getElementById('return-modal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('return-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReturnModal();
            }
        });

        // Form submission with feedback
        document.getElementById('return-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            this.submit();
        });
    </script>

</x-app-layout>
