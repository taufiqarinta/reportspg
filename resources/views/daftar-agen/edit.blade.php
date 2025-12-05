<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Agen') }}
            </h2>
            <a href="{{ route('daftar-agen.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('daftar-agen.update', $daftarAgen->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NPWP -->
                            <div>
                                <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
                                <input type="text" name="npwp" id="npwp" value="{{ old('npwp', $daftarAgen->npwp) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase-input">
                                @error('npwp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Agen -->
                            <div>
                                <label for="nama_agen" class="block text-sm font-medium text-gray-700">Nama Agen *</label>
                                <input type="text" name="nama_agen" id="nama_agen" value="{{ old('nama_agen', $daftarAgen->nama_agen) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase-input"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('nama_agen')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Sales -->
                            <div>
                                <label for="nama_sales" class="block text-sm font-medium text-gray-700">Nama Sales</label>
                                <input type="text" name="nama_sales" id="nama_sales" value="{{ old('nama_sales', $daftarAgen->nama_sales) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase-input"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('nama_sales')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase-input"
                                     oninput="this.value = this.value.toUpperCase()">{{ old('alamat', $daftarAgen->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>