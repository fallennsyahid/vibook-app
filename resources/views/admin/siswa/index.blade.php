<x-app-layout title="Manajemen User">


    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Manajemen Siswa</h1>
                <p class="text-text font-lato">Kelola akun siswa di sini</p>
            </div>
            <div>
                <button type="button" id="open-modal"
                    class="flex items-center gap-4 text-white font-medium px-5 py-3 rounded-lg bg-linear-to-r from-primary to-secondary cursor-pointer hover:from-secondary hover:to-primary">
                    <i class="fas fa-plus"></i>
                    Tambahkan Siswa Baru
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div
                class="bg-white shadow-lg p-6 rounded-xl hover:shadow-2xl transition-shadow duration-300 border-l-4 border-primary">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="text-sm font-medium text-gray-600 mb-2">
                            Total Akun Siswa
                        </h1>
                        <div class="text-3xl text-primary font-bold">
                            {{ $userSiswa->count() ?? '-' }}
                        </div>
                    </div>
                    <div
                        class="w-16 h-16 rounded-full bg-linear-to-br from-primary to-secondary flex justify-center items-center shadow-lg">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div
                class="bg-white shadow-lg p-6 rounded-xl hover:shadow-2xl transition-shadow duration-300 border-l-4 border-green-500">
                <div class="flex flex-row justify-between items-center">
                    <div>
                        <h1 class="text-sm font-medium text-gray-600 mb-2">
                            Siswa Aktif
                        </h1>
                        <div class="text-3xl text-green-600 font-bold">
                            {{ $siswaAktif ?? '-' }}
                        </div>
                    </div>
                    <div
                        class="w-16 h-16 rounded-full bg-linear-to-br from-green-400 to-green-600 flex justify-center items-center shadow-lg">
                        <i class="fas fa-user-check text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-gray-400"></i>
                    Daftar Siswa
                </h2>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                    {{-- Total: {{ count($userSiswa) }} --}}
                    Aktif: {{ $siswaAktif ?? '-' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table id="petugas-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                No</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Foto Profil
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                                Lengkap
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Username
                            </th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Status</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($userSiswa as $index => $siswa)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-100">
                                            {{ strtoupper(substr($siswa->anggota->nama_anggota, 0, 1)) ?? 'U' }}
                                        </div>
                                        {{-- <span
                                            class="text-sm font-medium text-gray-900">{{ $siswa->anggota->nama_lengkap ?? 'N/A' }}</span> --}}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-gray-600 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded">
                                        {{ $siswa->anggota->nama_anggota ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-gray-600 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded">
                                        {{ $siswa->username ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        {{-- <span class="text-sm text-gray-700">{{ $siswa->email ?? 'N/A' }}</span> --}}
                                        <span
                                            class="text-xs text-gray-700">{{ $siswa->anggota->no_telp ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($siswa->is_active === 1)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        {{-- @if ($siswa->is_active === 0)
                                            <form action="{{ route('admin.siswa.toggleStatus', $siswa->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-green-600 transition-colors"
                                                    title="Aktifkan">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.siswa.toggleStatus', $siswa->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-green-600 transition-colors"
                                                    title="Non-Aktifkan">
                                                    <i class="fas fa-user-times"></i>
                                                </button>
                                            </form>
                                        @endif --}}
                                        <button type="button"
                                            class="edit-siswa text-gray-400 hover:text-blue-600 transition-colors"
                                            data-id="{{ $siswa->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                            class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<div id="create-new-peminjam" class="fixed inset-0 z-50 hidden items-center justify-center p-4 animate-fade-in">
    <div class="close-modal absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="bg-white max-w-lg w-full rounded-xl shadow-2xl relative border border-white/20 overflow-hidden">
        <div class="bg-linear-to-r from-heading via-primary to-secondary p-8 text-center overflow-hidden relative">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center text-white mx-auto mb-4 backdrop-blur-sm">
                    <i class="fas fa-user-plus text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Tambah Siswa Baru</h1>
                <p class="text-white/90 text-base font-lato">Akun akan otomatis aktif dengan password default</p>
            </div>

            <button
                class="close-modal absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white cursor-pointer transition-all duration-300 hover:rotate-90">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="p-8 max-h-96 overflow-y-auto custom-scrollbar">
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div>
                        <label for="nama_anggota" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-user mr-2 text-primary"></i>Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-text/40"></i>
                            </div>
                            <input id="nama_anggota"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="text" name="nama_anggota" value="{{ old('nama_anggota') }}" required
                                placeholder="Nama lengkap siswa" />
                        </div>
                    </div>

                    <div>
                        <label for="nis" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-hashtag mr-2 text-primary"></i>NIS
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-text/40"></i>
                            </div>
                            <input id="nis"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="text" name="nis" value="{{ old('nis') }}" required
                                placeholder="Nomor Induk Siswa" />
                        </div>
                    </div>

                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-chalkboard mr-2 text-primary"></i>Kelas
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-book text-text/40"></i>
                            </div>
                            <input id="kelas"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="text" name="kelas" value="{{ old('kelas') }}" required
                                placeholder="Contoh: XII RPL 1" />
                        </div>
                    </div>

                    <div>
                        <label for="no_telp" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-phone mr-2 text-primary"></i>No. Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-mobile-screen text-text/40"></i>
                            </div>
                            <input id="no_telp"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="text" name="no_telp" value="{{ old('no_telp') }}" required
                                placeholder="0812xxxx" />
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-map-pin mr-2 text-primary"></i>Alamat
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                <i class="fas fa-location-dot text-text/40"></i>
                            </div>
                            <textarea id="alamat"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                name="alamat" rows="2" placeholder="Alamat lengkap rumah">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Password otomatis:</strong> Sistem akan generate password secara otomatis dan
                        mengirimnya ke WhatsApp
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button"
                        class="close-modal flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit"
                        class="px-4 flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 shadow-lg shadow-primary/30 cursor-pointer transition-all">
                        <i class="fas fa-save mr-2"></i> Buat Akun Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($userSiswa as $peminjam)
    @if ($peminjam->anggota)
        <div id="edit-peminjam-{{ $peminjam->id }}"
            class="fixed inset-0 z-50 hidden items-center justify-center p-4 animate-fade-in">
            <div class="close-modal absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            <div
                class="bg-white max-w-lg w-full rounded-xl shadow-2xl relative border border-white/20 overflow-hidden">
                <div
                    class="bg-linear-to-r from-heading via-primary to-secondary p-8 text-center overflow-hidden relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center text-white mx-auto mb-4 backdrop-blur-sm">
                            <i class="fas fa-user-edit text-3xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-2">Edit Data Siswa</h1>
                        <p class="text-white/90 text-base font-lato">Perbaiki informasi siswa jika diperlukan</p>
                    </div>

                    <button
                        class="close-modal absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white cursor-pointer transition-all duration-300 hover:rotate-90">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="p-8 max-h-96 overflow-y-auto custom-scrollbar">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-800 font-medium">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.siswa.update', $peminjam->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label for="edit_nama_anggota_{{ $peminjam->id }}"
                                    class="block text-sm font-semibold text-text mb-2">
                                    <i class="fas fa-user mr-2 text-primary"></i>Nama Lengkap
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-text/40"></i>
                                    </div>
                                    <input id="edit_nama_anggota_{{ $peminjam->id }}"
                                        class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                        type="text" name="nama_anggota" required placeholder="Nama lengkap siswa"
                                        value="{{ $peminjam->anggota?->nama_anggota ?? '' }}" />
                                </div>
                            </div>

                            <div>
                                <label for="edit_nis_{{ $peminjam->id }}"
                                    class="block text-sm font-semibold text-text mb-2">
                                    <i class="fas fa-hashtag mr-2 text-primary"></i>NIS
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-barcode text-text/40"></i>
                                    </div>
                                    <input id="edit_nis_{{ $peminjam->id }}"
                                        class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                        type="text" name="nis" required placeholder="Nomor Induk Siswa"
                                        value="{{ $peminjam->anggota?->nis ?? '' }}" />
                                </div>
                            </div>

                            <div>
                                <label for="edit_kelas_{{ $peminjam->id }}"
                                    class="block text-sm font-semibold text-text mb-2">
                                    <i class="fas fa-chalkboard mr-2 text-primary"></i>Kelas
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-book text-text/40"></i>
                                    </div>
                                    <input id="edit_kelas_{{ $peminjam->id }}"
                                        class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                        type="text" name="kelas" required placeholder="Contoh: XII RPL 1"
                                        value="{{ $peminjam->anggota?->kelas ?? '' }}" />
                                </div>
                            </div>

                            <div>
                                <label for="edit_no_telp_{{ $peminjam->id }}"
                                    class="block text-sm font-semibold text-text mb-2">
                                    <i class="fas fa-phone mr-2 text-primary"></i>No. Telepon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-mobile-screen text-text/40"></i>
                                    </div>
                                    <input id="edit_no_telp_{{ $peminjam->id }}"
                                        class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                        type="text" name="no_telp" required placeholder="0812xxxx"
                                        value="{{ $peminjam->anggota?->no_telp ?? '' }}" />
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="edit_alamat_{{ $peminjam->id }}"
                                    class="block text-sm font-semibold text-text mb-2">
                                    <i class="fas fa-map-pin mr-2 text-primary"></i>Alamat
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                        <i class="fas fa-location-dot text-text/40"></i>
                                    </div>
                                    <textarea id="edit_alamat_{{ $peminjam->id }}"
                                        class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                        name="alamat" rows="2" placeholder="Alamat lengkap rumah">{{ $peminjam->anggota?->alamat ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="button"
                                    class="close-modal flex-1 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">
                                    <i class="fas fa-times mr-2"></i> Batal
                                </button>
                                <button type="submit"
                                    class="px-4 flex-1 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 shadow-lg shadow-primary/30 cursor-pointer transition-all">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
    <script>
        const credentials = @json(session('credentials'));

        if (credentials) {
            Swal.fire({
                icon: 'success',
                title: 'Akun Berhasil Dibuat!',
                html: `
                    <div class="text-left space-y-3">
                        <p class="text-gray-700"><strong>Nama:</strong> ${credentials.nama_anggota}</p>
                        <p class="text-gray-700"><strong>Username:</strong> <span class="font-mono bg-gray-100 px-2 py-1 rounded">${credentials.username}</span></p>
                        <p class="text-gray-700"><strong>Password:</strong> <span class="font-mono bg-gray-100 px-2 py-1 rounded">${credentials.password}</span></p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <strong>Silahkan kirim ke nomor</strong> <span class="font-mono">${credentials.no_telp}</span>
                                <strong>untuk informasi akun di atas</strong>
                            </p>
                        </div>
                    </div>
                `,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: null,
                timerProgressBar: false,
                didClose: function() {}
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonColor: '#10b981',
                timer: null,
                timerProgressBar: false,
                didClose: function() {}
            });
        }
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            confirmButtonColor: '#10b981',
        });
    </script>
@endif

<script>
    // Event delegation untuk delete form dengan debugging
    document.addEventListener('submit', function(e) {
        if (!e.target.classList.contains('delete-form')) {
            return;
        }

        e.preventDefault();
        const form = e.target;

        console.log('Delete form submitted:', form);
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);

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
                console.log('Confirmed - submitting form...');
                form.submit();
            }
        });
    });
</script>

<script src="{{ asset('asset-admin/js/siswa/index.js') }}"></script>
