<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Agen') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('daftar-agen.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
                @if(auth()->user()->department === 'FNC')
                <a href="{{ route('daftar-agen.edit', $daftarAgen->id) }}" 
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NPWP -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NPWP</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $daftarAgen->npwp ?? '-' }}</p>
                        </div>

                        <!-- Nama Agen -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Agen</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $daftarAgen->nama_agen }}</p>
                        </div>

                        <!-- Nama Sales -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Sales</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $daftarAgen->nama_sales ?? '-' }}</p>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $daftarAgen->alamat ?? '-' }}</p>
                        </div>

                        <!-- Timestamps -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dibuat Pada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $daftarAgen->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Diupdate Pada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $daftarAgen->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>