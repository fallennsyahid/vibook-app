<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@400,401,500,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body
    class="min-h-screen bg-linear-to-br from-indigo-50 to-cyan-50 flex items-center justify-center overflow-x-hidden relative p-4 sm:p-8">

    <div class="absolute inset-0 -z-50 login-bg pointer-events-none"></div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-lg">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            {{ $errors->first() }}
                        </p>
                    </div>
                    <button type="button"
                        class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-100 inline-flex h-8 w-8 items-center justify-center"
                        onclick="this.parentElement.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="w-full flex items-center justify-center relative">
        <div
            class="bg-white/50 w-full max-w-4xl p-6 md:p-10 backdrop-blur-md border-0 rounded-3xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">

            <div class="text-center mb-8">
                <div
                    class="flex justify-center items-center bg-linear-to-tr from-primary to-secondary w-16 h-16 md:w-20 md:h-20 rounded-2xl text-white text-3xl md:text-4xl mx-auto mb-4 shadow-lg">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-heading">
                    Daftar Akun Baru
                </h1>
                <p class="text-sm md:text-base text-text mt-2">
                    Lengkapi formulir di bawah ini untuk bergabung
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

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
                                type="text" name="nama_anggota" :value="old('nama_lengkap')" required autofocus
                                placeholder="Nama lengkap Anda" />
                        </div>
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
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
                                type="text" name="nis" :value="old('nis')" required
                                placeholder="Nomor Induk Siswa" />
                        </div>
                        <x-input-error :messages="$errors->get('nis')" class="mt-1" />
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
                                type="text" name="kelas" :value="old('kelas')" required
                                placeholder="Contoh: XII RPL 1" />
                        </div>
                        <x-input-error :messages="$errors->get('kelas')" class="mt-1" />
                    </div>



                    {{-- <div>
                        <label for="email" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-envelope mr-2 text-primary"></i>Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-text/40"></i>
                            </div>
                            <input id="email"
                                class="block pl-10 pr-4 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="email" name="email" :value="old('email')" required
                                placeholder="alamat@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div> --}}

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
                                type="text" name="no_telp" :value="old('no_telp')" placeholder="0812xxxx" />
                        </div>
                        <x-input-error :messages="$errors->get('no_telp')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-lock mr-2 text-primary"></i>Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-text/40"></i>
                            </div>
                            <input id="password"
                                class="block pl-10 pr-10 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="password" name="password" required placeholder="Minimal 8 karakter" />
                            <div id="show-password"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <i class="fas fa-eye text-text/40 hover:text-primary transition-colors"
                                    id="password-icon"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-text mb-2">
                            <i class="fas fa-lock-open mr-2 text-primary"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock-open text-text/40"></i>
                            </div>
                            <input id="password_confirmation"
                                class="block pl-10 pr-10 py-3 text-base text-text rounded-xl w-full border-2 border-gray-200 focus:border-primary focus:ring-0 transition-all duration-300 outline-none"
                                type="password" name="password_confirmation" required
                                placeholder="Ulangi password" />
                            <div id="show-password-confirm"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <i class="fas fa-eye text-text/40 hover:text-primary transition-colors"
                                    id="password-confirm-icon"></i>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
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
                                name="alamat" rows="2" placeholder="Alamat lengkap rumah Anda">{{ old('alamat') }}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="bg-linear-to-r from-primary to-secondary text-white flex items-center justify-center font-bold text-lg w-full py-4 rounded-xl hover:shadow-2xl transform hover:-translate-y-1 active:scale-95 transition-all duration-300 ease-in-out">
                        <i class="fas fa-user-check mr-2"></i>
                        {{ __('Daftar Sekarang') }}
                    </button>
                </div>

                <p class="text-center text-sm text-text">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        // Reusable function for toggle password
        function setupPasswordToggle(triggerId, inputId, iconId) {
            document.getElementById(triggerId).addEventListener('click', function() {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        }

        setupPasswordToggle('show-password', 'password', 'password-icon');
        setupPasswordToggle('show-password-confirm', 'password_confirmation', 'password-confirm-icon');
    </script>
</body>

</html>
