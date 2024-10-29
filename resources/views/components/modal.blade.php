<div x-data="{ open: false, isMounted: false }" class="">
    <!-- Trigger Button -->
    <button @click="open = true; setTimeout(() => { document.getElementById('nama_alat').focus(); }, 100)"
        x-bind:class="{
            ' border': true,
            'border-[#559f86] bg-[#d0f1e6] px-5 py-2 rounded-lg': '{{ $button }}'
            === 'Tambah Alat' || '{{ $button }}'
            === 'Tambahkan Ruangan',
            'bg-green-600 text-white px-2 rounded ': '{{ $button }}'
            === 'Edit',
            'absolute bottom-10 left-1/2 -translate-x-1/2 transform rounded-lg border-[#559f86] bg-[#d0f1e6] px-5 py-2 text-base': '{{ $button }}'
            === 'Tambah Unit',
        }">
        {{ $button }}
    </button>


    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <main x-show="open" x-transition:enter="transition transform duration-300"
            x-transition:enter-start="scale-75 opacity-0" x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-75 opacity-0"
            class="flex w-1/3 flex-col gap-4 rounded-lg bg-white p-6 shadow-lg">
            <section class="flex items-center justify-between rounded-lg border-b bg-[#d0f1e6] p-4">
                <h2 class="text-lg font-semibold">{{ $title }}</h2>
                <button @click="open = false; clearInputs()" class="text-red-400"><x-heroicon-m-x-mark
                        class="w-8" /></button>
            </section>
            <section class="">
                {{ $slot }}
            </section>

        </main>
    </div>
    <script>
        function clearInputs() {
            document.getElementById('nama_alat').value = '';
            document.getElementById('lokasi').value = '';
            document.getElementById('tahun_pengadaan').value = '';
            document.getElementById('fungsi').value = '';
            document.getElementById('jumlah').value = '';
        }

        function capitalizeFirstLetter(input) {
            const value = input.value;
            if (value.length > 0) {
                input.value = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
            }
        }
    </script>
</div>
