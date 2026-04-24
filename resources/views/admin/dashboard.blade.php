<x-app-layout title="Halaman Dashboard">

    <div class="bg-linear-to-r from-secondary to-primary rounded-2xl p-8 text-text geometric-shape">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl text-text font-bold mb-2">
                    Selamat Datang, {{ Auth::check() ? Auth::user()->username : 'Admin' }}
                </h1>
                <p class="font-lato text-lg">Lihat apa yang terjadi hari ini di aplikasi Anda.</p>
            </div>
            <div class="hidden md:block relative z-10 float-animation">
                <div class="w-24 h-24 bg-white rounded-full flex justify-center items-center">
                    <i class="fa-solid fa-rocket text-text text-5xl"></i>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
