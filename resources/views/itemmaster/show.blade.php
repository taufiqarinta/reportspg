<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Item Master') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Item</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Itemcode</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $itemMaster->item_code }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Motif</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $itemMaster->item_name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Ukuran</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $itemMaster->ukuran ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4">
                        <a href="{{ route('itemmaster.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                        <a href="{{ route('itemmaster.edit', $itemMaster) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>