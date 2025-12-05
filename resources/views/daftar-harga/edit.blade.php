<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Daftar Harga') }}
            </h2>
            <a href="{{ route('daftarharga.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('daftarharga.update', $daftarHarga->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <x-text-input id="type" class="block mt-1 w-full uppercase" 
                                    type="text" name="type" :value="old('type', $daftarHarga->type)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- KW -->
                            <div>
                                <x-input-label for="kw" :value="__('KW')" />
                                <x-text-input id="kw" class="block mt-1 w-full uppercase" 
                                    type="text" name="kw" :value="old('kw', $daftarHarga->kw)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('kw')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" class="block mt-1 w-full uppercase" 
                                    type="text" name="brand" :value="old('brand', $daftarHarga->brand)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Ukuran -->
                            <div>
                                <x-input-label for="ukuran" :value="__('Ukuran')" />
                                <x-text-input id="ukuran" class="block mt-1 w-full uppercase" 
                                    type="text" name="ukuran" :value="old('ukuran', $daftarHarga->ukuran)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('ukuran')" class="mt-2" />
                            </div>

                            <!-- Karton -->
                            <div>
                                <x-input-label for="karton" :value="__('Karton')" />
                                <x-text-input id="karton" class="block mt-1 w-full uppercase" 
                                    type="text" name="karton" :value="old('karton', $daftarHarga->karton)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('karton')" class="mt-2" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori')" />
                                <x-text-input id="kategori" class="block mt-1 w-full uppercase" 
                                    type="text" name="kategori" :value="old('kategori', $daftarHarga->kategori)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>

                            <!-- Kelompok Harga MISS2 -->
                            <div>
                                <x-input-label for="kel_harga_miss2" :value="__('Kelompok Harga MISS2')" />
                                <x-text-input id="kel_harga_miss2" class="block mt-1 w-full uppercase" 
                                    type="text" name="kel_harga_miss2" :value="old('kel_harga_miss2', $daftarHarga->kel_harga_miss2)" required 
                                    oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('kel_harga_miss2')" class="mt-2" />
                            </div>

                            <!-- Harga Franco -->
                            <div>
                                <x-input-label for="harga_franco" :value="__('Harga Franco')" />
                                <x-text-input id="harga_franco" class="block mt-1 w-full" 
                                    type="number" name="harga_franco" :value="old('harga_franco', $daftarHarga->harga_franco)" 
                                    step="0.01" min="0" required />
                                <x-input-error :messages="$errors->get('harga_franco')" class="mt-2" />
                            </div>

                            <!-- Harga Loco -->
                            <div>
                                <x-input-label for="harga_loco" :value="__('Harga Loco')" />
                                <x-text-input id="harga_loco" class="block mt-1 w-full" 
                                    type="number" name="harga_loco" :value="old('harga_loco', $daftarHarga->harga_loco)" 
                                    step="0.01" min="0" required />
                                <x-input-error :messages="$errors->get('harga_loco')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>