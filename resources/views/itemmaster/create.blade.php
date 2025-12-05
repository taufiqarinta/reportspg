<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Item Master') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('itemmaster.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="item_code" :value="__('Kode Item')" />
                                <x-text-input id="item_code" 
                                              class="block mt-1 w-full" 
                                              type="text" 
                                              name="item_code" 
                                              :value="old('item_code')" 
                                              required 
                                              autofocus
                                              oninput="this.value = this.value.toUpperCase()"/>
                                <x-input-error :messages="$errors->get('item_code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="item_name" :value="__('Nama Item')" />
                                <x-text-input id="item_name" 
                                              class="block mt-1 w-full" 
                                              type="text" 
                                              name="item_name" 
                                              :value="old('item_name')" 
                                              required
                                              oninput="this.value = this.value.toUpperCase()"/>
                                <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ukuran" :value="__('Ukuran')" />
                                <x-text-input id="ukuran" 
                                              class="block mt-1 w-full" 
                                              type="text" 
                                              name="ukuran" 
                                              :value="old('ukuran')"
                                              oninput="this.value = this.value.toUpperCase()"/>
                                <x-input-error :messages="$errors->get('ukuran')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('itemmaster.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                    Batal
                                </a>
                                <x-primary-button>
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>