<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Layanan Lab Fisika UAD</title>
</head>
@if (session('status'))
    <div x-data="{ showStatus: true }" x-show="showStatus" x-init="setTimeout(() => { showStatus = false }, 5000)" x-transition.duration.500ms
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded fixed mb-4" role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('status') }}</span>
    </div>
@endif

<body class="h-full">
    <main class="flex min-h-screen items-center justify-center bg-[#f1faff]" x-data="{ forgotPasswordModal: false, isLoading: false }"
        x-init="@if ($errors->has('email')) forgotPasswordModal = true; @endif">
        <div class="flex w-full justify-center gap-20 p-10 lg:max-w-4xl lg:p-0">

            <!-- ANCHOR Left Side: Image Section -->
            <aside class="hidden w-1/2 font-poppins lg:block">
                <div class="flex flex-col gap-12 text-center">
                    <div>
                        <h1 class="font-light">Selamat Datang di Website</h1>
                        <h1 class="text-xl font-semibold">Layanan Lab Fisika UAD</h1>
                    </div>
                    <img src="img/banner.png" alt="Desk setup" class="h-full w-full object-cover">
                    <div>
                        <h1 class="font-light">Fakultas sains dan Teknologi Terapan</h1>
                        <h1 class="text-xl font-semibold">Universitas Ahmad Dahlan</h1>
                    </div>
                </div>
            </aside>

            <!-- ANCHOR Right Side: Form Section -->
            <section
                class="flex min-h-full w-full flex-col justify-center rounded-2xl bg-[#265166] p-8 font-poppins shadow-lg lg:w-1/2 lg:px-8">
                <header class="flex w-full flex-col items-center gap-2 sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="h-20 w-20 invert filter" src="img/logo-uad-black-white-hitam-putih.png" alt="Logo UAD">
                    <h2 class="text-center text-lg font-bold leading-9 tracking-tight text-[#f6fafd] lg:text-xl">
                        Universitas Ahmad Dahlan
                    </h2>
                </header>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" id="sign-in">
                        @csrf
                        <div>
                            <label id="username" for="username"
                                class="block text-xs font-medium leading-6 text-[#f6fafd]">
                                Username
                            </label>
                            <div class="relative mt-2">
                                <input id="username" name="username" type="text"
                                    class="block w-full rounded-md border-0 text-xs text-[#265166] shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#ffbd97] sm:py-1.5 sm:text-sm sm:leading-6"
                                    required>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="block text-xs font-medium leading-6 text-[#f6fafd] sm:text-sm">Password</label>
                                <div>
                                    <button type="button" @click="forgotPasswordModal = true"
                                        class="text-xs font-semibold text-[#b5f9e2] transition duration-300 ease-in-out hover:text-[#70ffcf] sm:text-sm">
                                        Forgot Password
                                    </button>

                                </div>
                            </div>
                            <div class="relative mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    class="block w-full rounded-md border-0 text-xs text-[#265166] shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#ffbd97] sm:py-1.5 sm:text-sm sm:leading-6"
                                    required>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-[#d0f1e6] px-3 py-[5px] text-xs font-semibold leading-6 text-[#265166] shadow-sm transition duration-300 ease-in-out hover:bg-[#b5f9e2] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 sm:py-1.5 sm:text-sm">Sign
                                in</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div x-show="forgotPasswordModal" x-cloak x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <form action ="{{ route('forgot.password') }}" method="POST" id="forgot-password"
                @submit.prevent="isLoading = true; $el.submit()" x-bind:class="{ 'pointer-events-none': isLoading }">
                @csrf

                <section class="flex items-center justify-between rounded-t-lg border-b bg-[#d0f1e6] p-4">
                    <h2 class="text-sm font-semibold xl:text-lg">Lupa Kata Sandi</h2>
                    <button type="button" @click="forgotPasswordModal = false; clearInputs()"
                        class="text-red-400"><x-heroicon-m-x-mark class="size-5 xl:w-8" /></button>
                </section>
                <section class="bg-white rounded-b-lg p-5">
                    <div class="flex flex-col gap-2">
                        <span class="text-[13px] font-poppins fw-light">Silahkan masukan email
                            anda
                            untuk
                            mendapatkan
                            email reset
                            password</span>

                        <input id="email" name="email" type="text"
                            class="block w-full rounded-md border-0 text-xs text-[#265166] shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#ffbd97] sm:py-1.5 sm:text-sm sm:leading-6">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="mt-3 py-2 px-4 rounded-md text-sm transition duration-150 ease-in-out"
                        x-bind:class="{
                            'bg-[#265166] hover:bg-[#1a3845] text-white': !isLoading,
                            'bg-gray-400 text-gray-700 cursor-not-allowed': isLoading
                        }"
                        x-bind:disabled="isLoading">

                        <span x-show="!isLoading">Kirim ulang kata sandi</span>

                        <span x-show="isLoading" class="flex items-center justify-center gap-2" style="display: none;">
                            Sedang mengirim email
                            <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white inline"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </section>
            </form>
        </div>
    </main>

    {{-- //!SECTION Alert --}}
    @if (Session::has('failed'))
        <script>
            window.onload = function() {
                showAlert("Error", "{{ Session::get('failed') }}", "error");
            };
        </script>
    @endif

    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</body>

</html>

<script>
    document.getElementById('sign-in').onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        const res = await fetch("{{ route('authenticate') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        });

        const data = await res.json();

        if (res.ok) {
            location.href = data.route;
        } else {
            showAlert("Error", data.message || "Login gagal", "error");
        }
    }
</script>
