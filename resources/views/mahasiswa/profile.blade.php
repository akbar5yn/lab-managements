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
                            <label class="text-sm font-semibold xl:text-base" id="password" for="password">Password
                                Baru</label>
                            <div class="flex w-full">
                                <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                                    required
                                    class="w-full border-none bg-none p-0 text-xs capitalize focus:outline-none focus:ring-0 xl:text-base">
                                <x-heroicon-c-eye-slash @click="showPassword = !showPassword" class="w-5 cursor-pointer"
                                    x-show="!showPassword" />
                                <x-heroicon-m-eye class="w-5 cursor-pointer" @click="showPassword = !showPassword"
                                    x-show="showPassword" />

                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="mt-2 w-full rounded bg-[#84AFA2] px-2 py-1 text-sm text-white xl:px-4 xl:py-2 xl:text-base">Simpan</button>
                </form>
            </x-modal>
        </section>
        <section class="flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            <form action="{{ route('update.profile.mhs', $dataUsers->id) }}" method="POST"
                class="flex w-full flex-col items-center gap-4">
                @csrf
                @method('PUT')
                <div class="w-fit rounded-full border-2 border-[#2D3648] p-[1px] md:hidden">
                    <x-heroicon-c-user-circle class="size-20 text-[#2D3648] md:hidden" />
                </div>
                <section class="flex w-full border-separate border-spacing-2 flex-col">
                    <div class="flex flex-col gap-2">
                        <div class="flex w-full flex-col md:flex-row md:gap-2">
                            <div
                                class="w-[40%] rounded-md p-2 text-xs font-medium md:border md:border-slate-700 xl:text-base xl:font-normal">
                                Nama
                            </div>
                            <div class="w-full rounded-md border border-slate-700 bg-gray-100 p-2 text-xs xl:text-base">
                                {{ $dataUsers->name }}</div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row md:gap-2">
                            <div
                                class="w-[40%] rounded-md p-2 text-xs font-medium md:border md:border-slate-700 xl:text-base xl:font-normal">
                                NIM
                            </div>
                            <div class="w-full rounded-md border border-slate-700 bg-gray-100 p-2 text-xs xl:text-base">
                                {{ $dataUsers->username }}
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row md:gap-2">
                            <div
                                class="w-[40%] rounded-md p-2 text-xs font-medium md:border md:border-slate-700 xl:text-base xl:font-normal">
                                Program
                                Studi</div>
                            <div
                                class="w-full rounded-md border border-slate-700 bg-gray-100 p-2 text-xs capitalize xl:text-base">
                                {{ $dataUsers->prodi }}
                            </div>
                        </div>

                        <div class="flex w-full flex-col md:flex-row md:gap-2">
                            <div
                                class="w-[40%] rounded-md p-2 text-xs font-medium md:border md:border-slate-700 xl:text-base xl:font-normal">
                                Email
                            </div>
                            <div
                                class="flex w-full items-center rounded-md border border-slate-700 text-xs xl:text-base">
                                <input type="text" name="email" id="email"
                                    class="{{ $dataUsers->email }} w-full rounded-md border-none text-xs xl:text-base"
                                    value="{{ $dataUsers->email ? substr($dataUsers->email, 0, strpos($dataUsers->email, '@')) : '' }}"
                                    placeholder="Silahkan masukan email depan anda" />
                                <span class="pr-2 text-gray-500">
                                    @webmail.uad.ac.id
                                </span>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row md:gap-2">
                            <div
                                class="w-[40%] rounded-md p-2 text-xs font-medium md:border md:border-slate-700 xl:text-base xl:font-normal">
                                Nomor
                                Handphone
                            </div>
                            <div class="flex w-full rounded-md border border-slate-700 text-xs xl:text-base">
                                <input type="text" name="phone_number" id="phone_number"
                                    class="w-full rounded-md border-none bg-none text-xs xl:text-base"
                                    placeholder="Silahkan masukan nomor handphone anda"
                                    value="{{ $dataUsers->phone_number }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            </div>
                        </div>
                        </table>
                        <button type="submit"
                            class="flex items-center justify-center gap-2 rounded-md bg-green-200 p-2 text-center text-sm xl:text-base">
                            Simpan
                            <x-heroicon-c-pencil-square class="size-4 xl:w-5" />
                        </button>
                    </div>
                </section>
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
