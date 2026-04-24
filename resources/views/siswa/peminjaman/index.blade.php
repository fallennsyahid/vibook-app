<x-app-layout title="Pengajuan Peminjaman Buku">

    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Pengajuan Peminjaman Buku</h1>
                <p class="text-text font-lato">Ajukan peminjaman buku di sini.</p>
            </div>
            <div>
                <button type="button" id="open-modal"
                    class="flex items-center gap-3 text-white font-medium px-6 py-3 rounded-lg bg-linear-to-r from-primary to-secondary cursor-pointer hover:from-secondary hover:to-primary shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-plus"></i>
                    Ajukan Peminjaman Buku
                </button>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Total Pengajuan Buku
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-primary flex justify-center items-center">
                        <i class="fas fa-briefcase text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalPengajuan }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Pengajuan Disetujui
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-green-600 flex justify-center items-center">
                        <i class="fas fa-circle-check text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $pengajuanDisetujui }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Pengajuan Pending
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-orange-600 flex justify-center items-center">
                        <i class="fas fa-exclamation-triangle text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $pengajuanPending }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Pengajuan Ditolak
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-red-600 flex justify-center items-center">
                        <i class="fas fa-circle-xmark text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $pengajuanDitolak }}
                </div>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list text-gray-400"></i>
                    Daftar Pengajuan Buku
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
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal
                                Pengajuan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Buku yang
                                Dipinjam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal
                                Rencana</th>
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
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $peminjaman->created_at->format('d M Y') }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            {{ $peminjaman->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        @forelse ($peminjaman->details->take(2) as $detail)
                                            <span class="text-sm text-gray-700">
                                                • {{ $detail->buku->judul_buku }} ({{ $detail->jumlah }}x)
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-500">-</span>
                                        @endforelse
                                        @if ($peminjaman->details->count() > 2)
                                            <span class="text-xs text-primary">+{{ $peminjaman->details->count() - 2 }}
                                                lainnya</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500">Pinjam:</span>
                                        <span
                                            class="text-sm text-gray-700">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-500 mt-1">Kembali:</span>
                                        <span
                                            class="text-sm text-gray-700">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-orange-50',
                                                'text' => 'text-orange-700',
                                                'border' => 'border-orange-100',
                                                'label' => 'Pending',
                                            ],
                                            'disetujui' => [
                                                'bg' => 'bg-green-50',
                                                'text' => 'text-green-700',
                                                'border' => 'border-green-100',
                                                'label' => 'Disetujui',
                                            ],
                                            'ditolak' => [
                                                'bg' => 'bg-red-50',
                                                'text' => 'text-red-700',
                                                'border' => 'border-red-100',
                                                'label' => 'Ditolak',
                                            ],
                                            'dipinjam' => [
                                                'bg' => 'bg-blue-50',
                                                'text' => 'text-blue-700',
                                                'border' => 'border-blue-100',
                                                'label' => 'Dipinjam',
                                            ],
                                            'dikembalikan' => [
                                                'bg' => 'bg-gray-50',
                                                'text' => 'text-gray-700',
                                                'border' => 'border-gray-100',
                                                'label' => 'Dikembalikan',
                                            ],
                                        ];
                                        $status = $statusConfig[$peminjaman->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }} border {{ $status['border'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        {{-- <a href="{{ route('siswa.peminjaman.show', $peminjaman->id) }}"
                                            class="text-primary hover:text-primary/80 transition-colors"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a> --}}
                                        @if ($peminjaman->status === 'pending')
                                            <form action="{{ route('siswa.peminjaman.destroy', $peminjaman->id) }}"
                                                method="POST" class="delete-form inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 transition-colors"
                                                    title="Batalkan">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @elseif ($peminjaman->status === 'disetujui')
                                            <button type="button" onclick="openUploadModal({{ $peminjaman->id }})"
                                                class="text-blue-600 hover:text-blue-800 transition-colors"
                                                title="Upload Bukti Pengambilan">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        @elseif ($peminjaman->status === 'dipinjam' || $peminjaman->status === 'dikembalikan')
                                            <button type="button" disabled
                                                class="text-gray-600 hover:text-gray-800 transition-colors cursor-not-allowed"
                                                title="Upload Bukti Pengambilan">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-3"></i>
                                        <p class="text-lg font-medium">Belum ada pengajuan buku</p>
                                        <p class="text-sm">Klik tombol "Ajukan Peminjaman Buku" untuk memulai</p>
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

<!-- Modal Create Peminjaman -->
<div id="create-new-petugas" class="fixed inset-0 z-99999 hidden items-center justify-center p-4 animate-fade-in">
    <div class="close-modal absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="bg-white max-w-4xl w-full rounded-xl shadow-2xl relative border border-white/20 overflow-hidden">
        <div class="bg-linear-to-r from-heading via-primary to-secondary p-8 text-center overflow-hidden relative">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center text-white mx-auto mb-4 backdrop-blur-sm">
                    <i class="fas fa-clipboard-list text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Ajukan Peminjaman Buku</h1>
                <p class="text-white/90 text-base font-lato">Isi form berikut untuk mengajukan peminjaman buku</p>
            </div>

            <button
                class="close-modal absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white cursor-pointer transition-all duration-300 hover:rotate-90">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="p-8 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form action="{{ route('siswa.peminjaman.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label for="tanggal_pinjam"
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transition-colors">
                            <i class="fas fa-calendar-check"></i>
                            Tanggal Peminjaman <span class="text-red-400">*</span>
                        </label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required
                            value="{{ old('tanggal_pinjam') }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200">
                        @error('tanggal_pinjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="tanggal_kembali_rencana"
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transition-colors">
                            <i class="fas fa-calendar-times"></i>
                            Tanggal Pengembalian <span class="text-red-400">*</span>
                        </label>
                        <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" required
                            value="{{ old('tanggal_kembali_rencana') }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200">
                        @error('tanggal_kembali_rencana')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="group">
                    <label for="alasan_meminjamn"
                        class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transition-colors">
                        <i class="fas fa-comment-alt"></i>
                        Alasan Meminjam <span class="text-red-400">*</span>
                    </label>
                    <textarea id="alasan_meminjamn" name="alasan_meminjamn" rows="3" required
                        class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200"
                        placeholder="Jelaskan alasan dan keperluan buku minimal 10 karakter">{{ old('alasan_meminjamn') }}</textarea>
                    @error('alasan_meminjamn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="group">
                    <label class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-3">
                        <i class="fas fa-book"></i>
                        Pilih Buku yang Dipinjam <span class="text-red-400">*</span>
                    </label>

                    <div id="buku-container" class="space-y-3">
                        <!-- Buku items will be added here -->
                    </div>

                    <button type="button" id="add-buku"
                        class="mt-3 w-full px-4 py-2 border-2 border-dashed border-primary/30 text-primary rounded-lg hover:bg-primary/5 transition-all">
                        <i class="fas fa-plus mr-2"></i>Tambah Buku
                    </button>
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="button"
                        class="close-modal flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit"
                        class="px-4 flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 shadow-lg shadow-primary/30 cursor-pointer transition-all">
                        <i class="fas fa-paper-plane mr-2"></i> Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: '{!! implode('<br>', $errors->all()) !!}',
            showConfirmButton: true,
        });
    </script>
@endif

<script>
    // Modal control
    document.getElementById('open-modal').addEventListener('click', function() {
        document.getElementById('create-new-petugas').classList.remove('hidden');
        document.getElementById('create-new-petugas').classList.add('flex');
    });

    const closeModals = document.querySelectorAll('.close-modal');
    closeModals.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('create-new-petugas').classList.add('hidden');
            document.getElementById('create-new-petugas').classList.remove('flex');
        });
    });

    // Delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin membatalkan?',
                text: 'Pengajuan buku akan dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Data buku dari backend
    const bukus = @json($bukus);
    let bukuCounter = 0;

    function createBukuItem() {
        const bukuItem = document.createElement('div');
        bukuItem.className = 'buku-item grid grid-cols-12 gap-3 p-4 bg-slate-50 rounded-lg border border-gray-200';
        bukuItem.innerHTML = `
            <div class="col-span-12 md:col-span-7">
                <select name="buku[${bukuCounter}][buku_id]" required 
                    class="w-full px-3 py-2 bg-white border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary text-sm">
                    <option value="">Pilih Buku</option>
                    ${bukus.map(buku => `
                        <option value="${buku.id}" data-stok="${buku.stok}">
                            ${buku.judul_buku} (Stok: ${buku.stok})
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-span-10 md:col-span-4">
                <input type="number" name="buku[${bukuCounter}][jumlah]" min="1" value="1" required
                    placeholder="Jumlah"
                    class="w-full px-3 py-2 bg-white border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary text-sm">
            </div>
            <div class="col-span-2 md:col-span-1 flex items-center justify-center">
                <button type="button" class="remove-buku text-red-600 hover:text-red-800 text-lg">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        bukuCounter++;
        return bukuItem;
    }

    document.getElementById('add-buku').addEventListener('click', function() {
        const container = document.getElementById('buku-container');
        const bukuItem = createBukuItem();
        container.appendChild(bukuItem);

        // Add remove event
        bukuItem.querySelector('.remove-buku').addEventListener('click', function() {
            if (container.children.length > 1) {
                bukuItem.remove();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Minimal harus ada 1 buku yang dipilih',
                    showConfirmButton: true,
                });
            }
        });
    });

    // Add first buku item on page load
    document.getElementById('add-buku').click();

    // Set minimum date for date inputs
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_pinjam').min = today;
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        document.getElementById('tanggal_kembali_rencana').min = this.value;
    });

    // Upload Bukti Pengambilan
    function openUploadModal(peminjamanId) {
        document.getElementById('peminjaman_id_upload').value = peminjamanId;
        const form = document.getElementById('bukti-upload-form');
        form.action = `{{ route('siswa.peminjaman.index') }}/${peminjamanId}/upload-bukti`;
        form.reset();
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('upload-bukti-modal').classList.remove('hidden');
        document.getElementById('upload-bukti-modal').classList.add('flex');
    }

    function updateFormAction(event) {
        // Action sudah diset di openUploadModal
    }

    function closeUploadModal() {
        document.getElementById('upload-bukti-modal').classList.add('hidden');
        document.getElementById('upload-bukti-modal').classList.remove('flex');
    }

    // Close modal when clicking outside
    const uploadModal = document.getElementById('upload-bukti-modal');
    if (uploadModal) {
        uploadModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeUploadModal();
            }
        });
    }

    // Preview image before upload
    const buktiInput = document.getElementById('bukti_pengambilan');
    if (buktiInput) {
        buktiInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML =
                        `<img src="${event.target.result}" class="rounded-lg max-h-64 mx-auto">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>

<!-- Modal Upload Bukti Pengambilan -->
<div id="upload-bukti-modal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-upload text-blue-600"></i>
                Upload Bukti Pengambilan
            </h2>
            <button type="button" onclick="closeUploadModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                &times;
            </button>
        </div>

        <form id="bukti-upload-form" action="" method="POST" enctype="multipart/form-data"
            onsubmit="updateFormAction(event)">
            @csrf

            <div class="px-6 py-4 space-y-4">
                <input type="hidden" id="peminjaman_id_upload" name="peminjaman_id" value="">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Bukti Pengambilan <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 transition-colors"
                        onclick="document.getElementById('bukti_pengambilan').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Klik atau seret gambar ke sini</p>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max 2MB)</p>
                    </div>
                    <input type="file" id="bukti_pengambilan" name="bukti_pengambilan" accept="image/*" required
                        style="display: none;">
                </div>

                <div id="image-preview" class="text-center"></div>

                @error('bukti_pengambilan')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeUploadModal()"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-upload"></i>
                    Upload & Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>
