<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Daftar Harga') }}
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Produk</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">KW</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->kw }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Brand</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->brand }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ukuran</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->ukuran }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Karton</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->karton }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Harga</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->kategori }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelompok Harga MISS2</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->kel_harga_miss2 }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga Franco</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($daftarHarga->harga_franco, 2, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga Loco</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($daftarHarga->harga_loco, 2, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Diupdate Pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $daftarHarga->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <a href="{{ route('daftarharga.edit', $daftarHarga->id) }}" 
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form action="{{ route('daftarharga.destroy', $daftarHarga->id) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>