<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Welcome</h2>
    </x-slot>

    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Flash Message --}}
        @if (session('status'))
            <div id="flash-message"
                class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>

            <script>
                setTimeout(() => {
                    const flash = document.getElementById('flash-message');
                    if (flash) flash.remove();
                }, 5000);
            </script>
        @endif

        {{-- Search Form --}}
        {{-- <input type="text" id="search" placeholder="Cari nama PT / Project..." value="{{ $search ?? '' }}"
            class="w-full px-4 py-2 mb-6 border rounded sm:w-1/3"> --}}

        {{-- Tabel SubProjects --}}
        {{-- <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" id="table-container">
            @include('partials.subproject-table', ['subProjects' => $subProjects])
        </div> --}}
    </div>

    <script>
        const searchInput = document.getElementById('search');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const query = this.value;

                fetch(`{{ route('welcome') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('table-container').innerHTML = html;
                    });
            }, 300); // debounce 300ms
        });
    </script>
</x-app-layout>
