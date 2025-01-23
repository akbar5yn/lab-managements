<div x-data="{ open: false, isMounted: false }" class="" x-init="open = false">
    <!-- Trigger Button -->
    <button @click="open = true;"
        x-bind:class="{
            'border-[#559f86] border bg-[#d0f1e6] px-5 py-2 rounded-lg': '{{ $button }}'
            === 'Tambah Alat' || '{{ $button }}'
            === 'Tambahkan Ruangan' || '{{ $button }}'
            === 'Tambah Mahasiswa',
            'bg-green-600 text-white px-2 rounded ': '{{ $button }}'
            === 'Edit',
            'absolute bottom-10 left-1/2 -translate-x-1/2 transform rounded-lg border-[#559f86] bg-[#d0f1e6] px-5 py-2 text-base border': '{{ $button }}'
            === 'Tambah Unit',
            'rounded-md bg-blue-400 px-2 text-white shadow-md': '{{ $button }}'
            === 'Verifikasi Pengembalian',
            'w-fit rounded-lg bg-[#2D3648] px-2 py-1 text-sm xl:text-lg font-medium text-white shadow-sm': '{{ $button }}'
            === 'Ubah Password',
        
        }">
        {{ $button }}
    </button>


    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <main x-show="open" x-transition:enter="transition transform duration-300"
            x-transition:enter-start="scale-75 opacity-0" x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-75 opacity-0"
            class="flex flex-col gap-4 rounded-lg bg-white p-6 shadow-lg xl:w-1/3">
            <section class="flex items-center justify-between rounded-lg border-b bg-[#d0f1e6] p-4">
                <h2 class="text-sm font-semibold xl:text-lg">{{ $title }}</h2>
                <button @click="open = false; clearInputs()" class="text-red-400"><x-heroicon-m-x-mark
                        class="size-5 xl:w-8" /></button>
            </section>
            <section class="">
                {{ $slot }}
            </section>

        </main>
    </div>
    <script>
        function clearInputs() {
            const elements = ['nama_alat', 'lokasi', 'tahun_pengadaan', 'fungsi', 'jumlah'];

            elements.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.value = '';
                }
            });
        }

        function capitalizeFirstLetter(input) {
            const value = input.value;
            if (value.length > 0) {
                input.value = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
            }
        }
    </script>
</div>
