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
            <button class="w-fit rounded-lg bg-[#2D3648] px-2 py-1 text-lg font-medium text-white shadow-sm">Ubah
                Password</button>
        </section>
        <section class="flex max-w-full justify-between gap-4 rounded-xl bg-white p-4 shadow-md">
            @foreach ($dataUsers as $dataUser)
                <form action="{{ route('update.profile.mhs', $dataUser->id) }}" method="POST"
                    class="flex w-full flex-col gap-4">
                    @csrf
                    @method('PUT')
                    <table class="w-full border-separate border-spacing-2">
                        <tbody>

                            <tr>
                                <td class="rounded-md border border-slate-700 p-2">Nama</td>
                                <td class="rounded-md border border-slate-700 bg-gray-100 p-2">{{ $name }}</td>
                            </tr>
                            <tr>
                                <td class="rounded-md border border-slate-700 p-2">NIM</td>
                                <td class="rounded-md border border-slate-700 bg-gray-100 p-2">{{ $dataUser->username }}
                                </td>
                            </tr>
                            <tr>
                                <td class="rounded-md border border-slate-700 p-2">Program Studi</td>
                                <td class="rounded-md border border-slate-700 bg-gray-100 p-2 capitalize">
                                    {{ $dataUser->prodi }}
                                </td>
                            </tr>

                            <tr>
                                <td class="rounded-md border border-slate-700 p-2">Email</td>
                                <td class="flex w-full items-center rounded-md border border-slate-700">
                                    <input type="text" name="email" id="email"
                                        class="{{ $dataUser->email }} w-full rounded-md border-none focus:outline-none focus:ring-0"
                                        value="{{ $dataUser->email ? substr($dataUser->email, 0, strpos($dataUser->email, '@')) : '' }}"
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
                                        class="w-full rounded-md border-none bg-none focus:outline-none focus:ring-0"
                                        placeholder="Silahkan masukan nomor handphone anda"
                                        value="{{ $dataUser->phone_number }}"
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
            @endforeach

        </section>
    </main>
</x-layout>
