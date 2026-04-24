<x-app-layout title="Daftar Buku">
    <div class="pt-3">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="space-y-2">
                <h1 class="text-2xl text-heading font-bold">Daftar Buku</h1>
                <p class="text-text font-lato">Lihat Daftar Buku di Sini.</p>
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
                            <img src="{{ Storage::url($buku->foto_buku) }}" alt="{{ $buku->nama_Buku }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    <div class="flex flex-col">
                        <h1 class="text-heading font-bold text-xl mb-2 truncate">{{ $buku->nama_Buku }}</h1>

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
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-4">
            {{ $bukus->links() }}
        </div>
    </div>
</x-app-layout>



<script src="{{ asset('asset-admin/js/buku/index.js') }}"></script>
