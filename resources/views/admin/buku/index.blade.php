<x-app-layout title="Manajemen Buku">
    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Daftar Buku</h1>
                <p class="text-text font-lato">Lihat Daftar Buku di Sini.</p>
            </div>
            <div>
                <button type="button" id="open-modal"
                    class="flex items-center gap-4 text-white font-medium px-5 py-3 rounded-lg bg-linear-to-r from-primary to-secondary cursor-pointer hover:from-secondary hover:to-primary">
                    <i class="fas fa-plus"></i>
                    Tambahkan Buku Baru
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Total Buku
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-primary flex justify-center items-center">
                        <i class="fas fa-briefcase text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $totalBuku }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Jumlah Buku Tersedia
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-green-600 flex justify-center items-center">
                        <i class="fas fa-circle-check text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $bukuTersedia }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Jumlah Stock Buku Menipis
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-orange-600 flex justify-center items-center">
                        <i class="fas fa-exclamation-triangle text-white text-base"></i>
                    </div>

                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $bukuMenipis }}
                </div>
            </div>
            <div class="bg-white shadow-md p-4 rounded-xl geometric-shape hover:shadow-lg">
                <div class="flex flex-row justify-between items-center space-y-0 pb-2">
                    <h1 class="text-sm font-medium text-text">
                        Jumlah Buku Tidak Tersedia
                    </h1>
                    <div class="w-8 h-8 rounded-lg bg-red-600 flex justify-center items-center">
                        <i class="fas fa-circle-xmark text-white text-base"></i>
                    </div>
                </div>
                <div class="text-2xl text-primary mt-1 font-bold">
                    {{ $bukuTidakTersedia }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @foreach ($bukus as $buku)
                <div
                    class="bg-white rounded-2xl shadow-lg p-5 geometric-shape hover:shadow-xl relative overflow-hidden">

                    <div class="absolute top-4 right-4 z-10">
                        @if ($buku->stok > 10)
                            <span
                                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200 shadow-sm">
                                Tersedia
                            </span>
                        @elseif($buku->stok > 0)
                            <span
                                class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full border border-orange-200 shadow-sm">
                                Stok Menipis
                            </span>
                        @else
                            <span
                                class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200 shadow-sm">
                                Habis
                            </span>
                        @endif
                    </div>

                    @if ($buku->foto_buku)
                        <div class="w-full h-48 overflow-hidden rounded-lg mb-4">
                            <img src="{{ Storage::url($buku->foto_buku) }}" alt="{{ $buku->nama_buku }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    <div class="flex flex-col">
                        <h1 class="text-heading font-bold text-xl mb-2 truncate">{{ $buku->nama_buku }}</h1>

                        <div class="flex flex-col gap-1">
                            <span class="text-text text-sm opacity-75">
                                <i class="fas fa-tag mr-2 w-4"></i>
                                {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>

                            <span class="text-text text-sm font-medium">
                                <i class="fas fa-boxes mr-2 w-4"></i>
                                Stok: <span
                                    class="{{ $buku->stok > 10 ? 'text-green-600' : ($buku->stok > 0 ? 'text-orange-600' : 'text-red-600') }} font-bold">
                                    {{ $buku->stok }} Unit
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-text/25 pt-4 mt-4">
                        <div class="flex items-center space-x-3">
                            <button type="button" data-id="{{ $buku->buku_id }}"
                                class="edit-buku flex-1 flex items-center justify-center gap-2 text-white bg-amber-400 px-3 py-2 rounded-lg cursor-pointer hover:bg-amber-500 transition-colors">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <form action="{{ route('admin.buku.destroy', $buku->buku_id) }}" method="post"
                                class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 text-white bg-red-400 px-3 py-2 rounded-lg cursor-pointer hover:bg-red-500 transition-colors">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-4">
            {{ $bukus->links() }}
        </div>
    </div>
</x-app-layout>

<div id="create-new-buku" class="fixed inset-0 z-99999 hidden items-center justify-center p-4 animate-fade-in">
    <div class="close-modal absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="bg-white max-w-lg w-full rounded-xl shadow-2xl relative border border-white/20 overflow-hidden">
        <div class="bg-linear-to-r from-heading via-primary to-secondary p-8 text-center overflow-hidden relative">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center text-white mx-auto mb-4 backdrop-blur-sm">
                    <i class="fas fa-tools text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Tambah Buku Baru</h1>
                <p class="text-white/90 text-base font-lato">Tambahkan buku baru ke inventaris</p>
            </div>

            <button
                class="close-modal absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white cursor-pointer transition-all duration-300 hover:rotate-90">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="p-8 max-h-96 overflow-y-auto custom-scrollbar">
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <div class="group">
                    <label for="nama_buku"
                        class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                        <i class="fas fa-wrench"></i>
                        Nama Buku <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="nama_buku" name="nama_buku" required
                        class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white"
                        placeholder="Nama Buku">
                </div>

                <div class="group">
                    <label for="kategori_id"
                        class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                        <i class="fas fa-tag"></i>
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="group">
                    <label for="stok"
                        class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                        <i class="fas fa-boxes"></i>
                        Stok <span class="text-red-400">*</span>
                    </label>
                    <input type="number" id="stok" name="stok" required min="1"
                        class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white"
                        placeholder="0">
                </div>

                <div class="upload-group">
                    <label
                        class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                        <i class="fas fa-image"></i>
                        Upload Foto Buku
                    </label>

                    <input type="file" name="foto_buku" class="file-input hidden"
                        accept="image/png,image/jpeg,image/jpg">

                    <label
                        class="drop-area p-6 flex flex-col items-center justify-center text-center border border-text border-dashed rounded-lg cursor-pointer hover:bg-text/5 transition-colors duration-100 ease-in-out">
                        <div class="mb-4">
                            <i class="fas fa-cloud-arrow-up text-2xl text-darkChoco"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-medium text-darkChoco">
                                Choose a file or drag & drop it here
                            </h1>
                            <p class="text-text text-sm font-medium font-lato">
                                JPEG, PNG, JPG format, max. 2MB
                            </p>
                        </div>
                    </label>

                    <!-- preview -->
                    <div class="preview hidden bg-text/10 p-4 mt-2 rounded-lg items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img class="preview-image w-16 h-16 object-cover rounded-lg" alt="Preview">
                            <div>
                                <h1 class="file-name text-base text-darkChoco font-semibold">title.jpg</h1>
                                <div class="flex items-center gap-2 text-xs text-text">
                                    <span class="file-size"></span>
                                    <span>•</span>
                                    <span>
                                        <i class="fa-solid fa-circle-check text-green-400"></i>
                                        Completed
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="remove-file">
                            <i class="fa-solid fa-circle-xmark text-lg text-darkChoco"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button"
                        class="close-modal flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 cursor-pointer">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Create End --}}

{{-- Modal Edit Start --}}
@foreach ($bukus as $buku)
    <div id="edit-buku-{{ $buku->buku_id }}"
        class="fixed inset-0 z-99999 hidden items-center justify-center p-4 animate-fade-in">
        <div class="close-modal absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <div class="bg-white max-w-lg w-full rounded-xl shadow-2xl relative border border-white/20 overflow-hidden">
            <div class="bg-linear-to-r from-heading via-primary to-secondary p-8 text-center overflow-hidden relative">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center text-white mx-auto mb-4 backdrop-blur-sm">
                        <i class="fas fa-edit text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">Edit Data Buku</h1>
                    <p class="text-white/90 text-base font-lato">Perbaiki data buku</p>
                </div>

                <button
                    class="close-modal absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white cursor-pointer transition-all duration-300 hover:rotate-90">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="p-8 max-h-96 overflow-y-auto custom-scrollbar">
                <form action="{{ route('admin.buku.update', $buku->buku_id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="group">
                        <label for="nama_buku_{{ $buku->buku_id }}"
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                            <i class="fas fa-wrench"></i>
                            Nama Buku <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="nama_buku_{{ $buku->buku_id }}" name="nama_buku" required
                            class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white"
                            value="{{ $buku->nama_buku }}" placeholder="Nama Buku">
                    </div>

                    <div class="group">
                        <label for="kategori_id_{{ $buku->buku_id }}"
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                            <i class="fas fa-tag"></i>
                            Kategori <span class="text-red-400">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id_{{ $buku->buku_id }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white cursor-pointer">
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}"
                                    {{ $kategori->kategori_id === $buku->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="group">
                        <label for="stok_{{ $buku->buku_id }}"
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                            <i class="fas fa-boxes"></i>
                            Stok <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="stok_{{ $buku->buku_id }}" name="stok" required min="0"
                            class="w-full px-4 py-3 bg-slate-50 border border-text/25 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent transition-all duration-200 hover:bg-white"
                            value="{{ $buku->stok }}" placeholder="0">
                    </div>

                    <div class="upload-group">
                        <label
                            class="flex items-center gap-2 text-sm font-medium text-darkChoco mb-2 group-hover:text-heading transform-colors">
                            <i class="fas fa-image"></i>
                            Upload Foto Buku
                        </label>

                        <input type="file" name="foto_buku" class="file-input hidden"
                            accept="image/png,image/jpeg,image/jpg">

                        <label
                            class="drop-area p-6 flex flex-col items-center justify-center text-center border border-text border-dashed rounded-lg cursor-pointer hover:bg-text/5 transition-colors duration-100 ease-in-out">
                            <div class="mb-4">
                                <i class="fas fa-cloud-arrow-up text-2xl text-darkChoco"></i>
                            </div>
                            <div>
                                <h1 class="text-base font-medium text-darkChoco">
                                    Choose a file or drag & drop it here
                                </h1>
                                <p class="text-text text-sm font-medium font-lato">
                                    JPEG, PNG, JPG format, max. 2MB
                                </p>
                            </div>
                        </label>
                        @if ($buku->foto_buku)
                            <div class="border-b border-text/25 pb-2">
                                <div class="flex justify-between bg-text/10 p-4 mt-2 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <img src="{{ Storage::url($buku->foto_buku) }}" alt=""
                                                class="w-16 h-16 object-cover rounded-lg">
                                        </div>
                                        <a href="{{ Storage::url($buku->foto_buku) }}" target="_blank"
                                            class="text-base text-darkChoco font-semibold">
                                            Foto Sebelumnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- preview -->
                        <div class="preview hidden bg-text/10 p-4 mt-2 rounded-lg items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img class="preview-image w-16 h-16 object-cover rounded-lg" alt="Preview">
                                <div>
                                    <h1 class="file-name text-base text-darkChoco font-semibold">title.jpg</h1>
                                    <div class="flex items-center gap-2 text-xs text-text">
                                        <span class="file-size"></span>
                                        <span>•</span>
                                        <span>
                                            <i class="fa-solid fa-circle-check text-green-400"></i>
                                            Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="remove-file">
                                <i class="fa-solid fa-circle-xmark text-lg text-darkChoco"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="close-modal flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 cursor-pointer">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
{{-- Modal Edit End --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus',
                text: 'Data yang sudah dihapus tidak dapat dipulihkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500,
        });
    @endif
</script>

<script src="{{ asset('asset-admin/js/buku/index.js') }}"></script>
