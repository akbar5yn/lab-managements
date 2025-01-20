<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:name>{{ $name }}</x-slot:name>
    <x-slot:role>{{ $role }}</x-slot:role>
    @if (Session::has('success'))
        <script>
            window.onload = function() {
                showAlert("Berhasil", "{{ Session::get('success') }}", "success");
                const swalBody = document.querySelector('body.swal2-height-auto');
                if (swalBody) {
                    swalBody.style.minHeight = '100vh';
                    swalBody.style.maxHeight = '100vh';
                    swalBody.style.overflowY = 'auto';
                }
            };
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            window.onload = function() {
                showAlert("Ups", "{{ Session::get('error') }}", "error");
                const swalBody = document.querySelector('body.swal2-height-auto');
                if (swalBody) {
                    swalBody.style.minHeight = '100vh';
                    swalBody.style.maxHeight = '100vh';
                    swalBody.style.overflowY = 'auto';
                }
            };
        </script>
    @endif
    <main class="inventaris flex h-full flex-col gap-4">
        <section class="flex max-w-full">
            <x-modal attributeTitle="Ubah Password" attributeButton="Ubah Password">
                <form action="{{ route('update.password', $dataUsers->username) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-6 rounded-lg border p-4" x-data="{ showPassword: false }">

                        <div
                            class="flex flex-col gap-2 border-b-2 border-gray-300 focus-within:border-[#559f86] focus:border-[#8af8d4]">
                            <label class="font-semibold" id="password" for="password">Password Baru</label>
                            <div class="flex w-full">
                                <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                                    required
                                    class="w-full border-none bg-none p-0 capitalize focus:outline-none focus:ring-0">
                                <x-heroicon-c-eye-slash @click="showPassword = !showPassword" class="w-5 cursor-pointer"
                                    x-show="!showPassword" />
                                <x-heroicon-m-eye class="w-5 cursor-pointer" @click="showPassword = !showPassword"
                                    x-show="showPassword" />

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 w-full rounded bg-[#84AFA2] px-4 py-2 text-white">Simpan</button>
                </form>
            </x-modal>
        </section>
        <section class="flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <form action="{{ route('update.profile.mhs', $dataUsers->id) }}" method="POST"
                class="flex w-full flex-col gap-4">
                @csrf
                @method('PUT')
                <table class="w-full border-separate border-spacing-2">
                    <tbody>

                        <tr>
                            <td class="rounded-md border border-slate-700 p-2">Nama</td>
                            <td class="rounded-md border border-slate-700 bg-gray-100 p-2">{{ $dataUsers->name }}</td>
                        </tr>
                        <tr>
                            <td class="rounded-md border border-slate-700 p-2">NIM</td>
                            <td class="rounded-md border border-slate-700 bg-gray-100 p-2">{{ $dataUsers->username }}
                            </td>
                        </tr>
                        <tr>
                            <td class="rounded-md border border-slate-700 p-2">Program Studi</td>
                            <td class="rounded-md border border-slate-700 bg-gray-100 p-2 capitalize">
                                {{ $dataUsers->prodi }}
                            </td>
                        </tr>

                        <tr>
                            <td class="rounded-md border border-slate-700 p-2">Email</td>
                            <td class="flex w-full items-center rounded-md border border-slate-700">
                                <input type="text" name="email" id="email"
                                    class="{{ $dataUsers->email }} w-full rounded-md border-none"
                                    value="{{ $dataUsers->email ? substr($dataUsers->email, 0, strpos($dataUsers->email, '@')) : '' }}"
                                    placeholder="Silahkan masukan email depan anda" />
                                <span class="pr-2 text-gray-500">
                                    @webmail.uad.ac.id
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="rounded-md border border-slate-700 p-2">Nomor Handphone</td>
                            <td class="flex w-full rounded-md border border-slate-700">
                                <input type="text" name="phone_number" id="phone_number"
                                    class="w-full rounded-md border-none bg-none"
                                    placeholder="Silahkan masukan nomor handphone anda"
                                    value="{{ $dataUsers->phone_number }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit"
                    class="flex items-center justify-center gap-2 rounded-md bg-green-200 p-2 text-center">
                    Simpan
                    <x-heroicon-c-pencil-square class="w-5" />
                </button>
            </form>

        </section>
    </main>
    <style>
        input:-webkit-autofill {
            background-color: white !important;
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: black !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const emailInput = document.getElementById("email");
            const phoneInput = document.getElementById("phone_number");

            if (!emailInput.value.trim()) {
                emailInput.focus();
            } else if (!phoneInput.value.trim()) {
                phoneInput.focus();
            }
        });
    </script>
</x-layout>
