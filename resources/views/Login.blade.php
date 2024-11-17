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

<body class="h-full">

    <main class="flex min-h-screen items-center justify-center bg-[#f1faff]">
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
                    <form class="space-y-6" action="{{ route('authenticate') }}" method="POST">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium leading-6 text-[#f6fafd]">
                                Login Sebagai
                            </label>
                            <select name="role" id="role-select" required onchange="updateInputField()"
                                class="block w-full rounded-md border-0 text-xs text-[#265166] shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#ffbd97] sm:py-1.5 sm:text-sm sm:leading-6">
                                <option value="laboran" {{ old('role') == 'laboran' ? 'selected' : '' }}>Laboran
                                </option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                </option>
                            </select>
                        </div>

                        <div id="input-field">
                            <label id="input-label" for="identifier"
                                class="block text-xs font-medium leading-6 text-[#f6fafd]">
                                {{ old('role') == 'laboran' ? 'Email' : 'NIM' }}
                            </label>
                            <div class="relative mt-2">
                                <input id="identifier-input" name="identifier" value="{{ old('identifier') }}"
                                    type="text"
                                    class="block w-full rounded-md border-0 text-xs text-[#265166] shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-[#ffbd97] sm:py-1.5 sm:text-sm sm:leading-6"
                                    required placeholder="">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="block text-xs font-medium leading-6 text-[#f6fafd] sm:text-sm">Password</label>
                                <div class="text-sm">
                                    <a href="#"
                                        class="text-xs font-semibold text-[#b5f9e2] transition duration-300 ease-in-out hover:text-[#70ffcf] sm:text-sm">Forgot
                                        password?</a>
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
    </main>

    {{-- //!SECTION Alert --}}
    @if (Session::has('failed'))
        <script>
            window.onload = function() {
                showAlert("Error", "{{ Session::get('failed') }}", "error");
            };
        </script>
    @endif
    <script>
        function updateInputField() {
            const roleSelect = document.getElementById('role-select');
            const inputLabel = document.getElementById('input-label');
            const inputField = document.getElementById('identifier-input');

            if (roleSelect.value === 'laboran') {
                inputLabel.textContent = 'Email';
                inputField.name = 'email';
                inputField.placeholder = 'Masukkan email';
            } else if (roleSelect.value === 'mahasiswa') {
                inputLabel.textContent = 'NIM';
                inputField.name = 'nim';
                inputField.placeholder = 'Masukkan NIM';
            }
        }

        // Panggil fungsi ini saat halaman dimuat untuk menjaga input sesuai pilihan sebelumnya
        window.onload = function() {
            updateInputField();
        }
    </script>

</body>

</html>
