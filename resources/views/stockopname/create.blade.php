<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Stock Opname Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="opnameForm" method="POST" action="{{ route('stockopname.store') }}">
                        @csrf
                        
                        <!-- Header Information -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 p-4 bg-gray-50 rounded-lg">
                            <!-- Pilih Toko -->
                            <div>
                                <x-input-label for="toko_id" :value="__('Pilih Toko')" />
                                <select id="toko_id" name="toko_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Toko</option>
                                    @foreach($tokoList as $toko)
                                        <option value="{{ $toko->id }}" 
                                            {{ old('toko_id', $initialData['toko_id'] ?? '') == $toko->id ? 'selected' : '' }}>
                                            {{ $toko->nama_toko }} - {{ $toko->kota }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('toko_id')" class="mt-2" />
                            </div>
                            
                            <!-- Tahun -->
                            <div>
                                <x-input-label for="tahun" :value="__('Tahun')" />
                                <select id="tahun" name="tahun" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @for($year = date('Y') - 1; $year <= date('Y') + 1; $year++)
                                        <option value="{{ $year }}" 
                                            {{ old('tahun', $initialData['tahun'] ?? date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                            </div>
                            
                            <!-- Bulan -->
                            <div>
                                <x-input-label for="bulan" :value="__('Bulan')" />
                                <select id="bulan" name="bulan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach([
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ] as $num => $name)
                                        <option value="{{ $num }}" 
                                            {{ old('bulan', $initialData['bulan'] ?? date('n')) == $num ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('bulan')" class="mt-2" />
                            </div>
                            
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Stock Opname')" />
                                <x-text-input id="tanggal" 
                                            class="block mt-1 w-full" 
                                            type="date" 
                                            name="tanggal" 
                                            :value="old('tanggal', now()->toDateString())" 
                                            required />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Detail Stock</h3>
                                <div class="flex items-center space-x-4">
                                    <!-- <span class="text-sm text-gray-600">
                                        Total Item: <span id="itemCount">0</span>
                                    </span> -->
                                    <button type="button" id="addItemBtn" 
                                            class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                        + Tambah Item
                                    </button>
                                </div>
                            </div>

                            <!-- Container untuk tabel dengan scroll horizontal -->
                            <div class="table-container">
                                <div class="overflow-x-scroll">
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th class="column-nama">Nama Barang</th>
                                                <th class="column-kode">Kode Item</th>
                                                <th class="column-ukuran">Ukuran</th>
                                                <th class="column-stock">Stock</th>
                                                <th class="column-keterangan">Keterangan</th>
                                                <th class="column-aksi">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                                            <!-- Items will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="noItemsMessage" class="text-center py-8 text-gray-500">
                                Belum ada item. Klik "Tambah Item" untuk menambahkan.
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('stockopname.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                                Batal
                            </a>
                            <x-primary-button type="button" id="submitBtn">
                                {{ __('Simpan Stock Opname') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Select2 Styling */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 0.75rem;
            color: #374151;
            font-size: 0.875rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 0.5rem;
        }
        
        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        /* Table Container Styling */
        .table-container {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            overflow: hidden;
        }

        .overflow-x-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .overflow-x-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-scroll::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }

        .overflow-x-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .overflow-x-scroll::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Responsive Table Styling */
        .responsive-table {
            width: 100%;
            min-width: 1000px;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 0.75rem 0.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .responsive-table th {
            background-color: #f9fafb;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .responsive-table td {
            font-size: 0.875rem;
            color: #374151;
        }

        .responsive-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Lebar kolom spesifik */
        .column-nama { 
            width: 300px; 
            min-width: 300px; 
        }
        .column-kode { 
            width: 120px; 
            min-width: 120px; 
        }
        .column-ukuran { 
            width: 100px; 
            min-width: 100px; 
        }
        .column-stock { 
            width: 100px; 
            min-width: 100px; 
        }
        .column-keterangan { 
            width: 200px; 
            min-width: 200px; 
        }
        .column-aksi { 
            width: 80px; 
            min-width: 80px; 
            text-align: center;
        }

        /* Styling untuk input dan select dalam tabel */
        .responsive-table input,
        .responsive-table select {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            width: 100%;
            box-sizing: border-box;
        }

        .responsive-table input[type="number"] {
            text-align: center;
        }

        .responsive-table .bg-gray-100 {
            background-color: #f9fafb;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .table-container {
                margin: 0;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
            
            .responsive-table {
                min-width: 1000px;
            }
            
            .max-w-9xl {
                max-width: 100%;
                padding: 0 0.5rem;
            }
            
            .p-6 {
                padding: 1rem;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        let itemCounter = 0;
        let selectedItems = new Set();

        // Tambah row pertama
        addNewRow();
        
        // Function untuk update item count
        function updateItemCount() {
            const count = $('#itemsBody tr').length;
            $('#itemCount').text(count);
        }
        
        // Fungsi untuk menambah row baru
        function addNewRow(itemData = null) {
            itemCounter++;
            
            let itemCode = itemData ? itemData.item_code : '';
            let itemName = itemData ? itemData.nama_barang : '';
            let ukuran = itemData ? itemData.ukuran : '';
            let stock = itemData ? itemData.stock : 0;
            let keterangan = itemData && itemData.keterangan !== null && itemData.keterangan !== undefined ? itemData.keterangan : '';
            let selectedOption = itemData ? `<option value="${itemCode}" selected>${itemCode} - ${itemName} - ${ukuran}</option>` : '';
            
            const newRow = `
                <tr class="item-row" id="row-${itemCounter}">
                    <td class="column-nama">
                        <select class="item-select w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                name="items[${itemCounter}][item_code]" required>
                            <option value="">Pilih Barang</option>
                            ${selectedOption}
                        </select>
                    </td>
                    <td class="column-kode">
                        <input type="text" class="itemcode-input w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" 
                            name="items[${itemCounter}][item_code_display]" value="${itemCode}" readonly>
                    </td>
                    <td class="column-ukuran">
                        <input type="text" class="ukuran-input w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" 
                            name="items[${itemCounter}][ukuran]" value="${ukuran}" readonly>
                    </td>
                    <td class="column-stock">
                        <input type="number" class="stock-input w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                            name="items[${itemCounter}][stock]" min="0" value="${stock}" required
                            onfocus="if(this.value=='0') this.value='';"
                            onblur="if(this.value=='') this.value='0';">
                    </td>
                    <td class="column-keterangan">
                        <input type="text" class="keterangan-input w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                            name="items[${itemCounter}][keterangan]" value="${keterangan}" maxlength="500">
                    </td>
                    <td class="column-aksi">
                        <button type="button" class="remove-row-btn text-red-600 hover:text-red-900 text-sm" data-row="${itemCounter}">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
            
            $('#itemsBody').append(newRow);
            $('#noItemsMessage').hide();
            
            // Initialize Select2 untuk select baru
            const selectElement = $(`#row-${itemCounter} .item-select`);
            
            initSelect2(selectElement);
            
            updateItemCount();
        }
        
        // Initialize Select2
        function initSelect2(selectElement) {
            selectElement.select2({
                placeholder: 'Cari barang...',
                allowClear: true,
                width: '100%',
                dropdownParent: selectElement.closest('.table-container'),
                ajax: {
                    url: '{{ route("api.stockopname-items") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(item => ({
                                id: item.item_code,
                                text: item.text,
                                item_code: item.item_code,
                                item_name: item.item_name,
                                ukuran: item.ukuran
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: formatItem,
                templateSelection: formatItemSelection
            }).on('select2:select', function(e) {
                const data = e.params.data;
                const row = $(this).closest('tr');
                
                // Check for duplicates
                if (selectedItems.has(data.item_code)) {
                    alert('Item ini sudah ada dalam daftar. Harap pilih item yang berbeda.');
                    $(this).val('').trigger('change');
                    return;
                }
                
                // Update Item Code dan Ukuran fields
                row.find('.itemcode-input').val(data.item_code);
                row.find('.ukuran-input').val(data.ukuran || '-');
                
                // Tambah ke selected items
                selectedItems.add(data.item_code);
            }).on('select2:unselect', function() {
                const row = $(this).closest('tr');
                const itemCode = row.find('.itemcode-input').val();
                
                // Clear Item Code dan Ukuran fields
                row.find('.itemcode-input').val('');
                row.find('.ukuran-input').val('');
                
                // Remove dari selected items
                if (itemCode) {
                    selectedItems.delete(itemCode);
                }
            });
        }
        
        function formatItem(item) {
            if (item.loading) return item.text;
            return $(`<div class="py-1">${item.text}</div>`);
        }
        
        function formatItemSelection(item) {
            return item.text || item.item_name || item.item_code || 'Pilih Barang';
        }
        
        // Tombol tambah item
        $('#addItemBtn').on('click', function() {
            addNewRow();
        });
        
        // Event delegation untuk tombol hapus
        $(document).on('click', '.remove-row-btn', function() {
            const rowId = $(this).data('row');
            const row = $(`#row-${rowId}`);
            const itemCode = row.find('.item-select').val();
            
            if (itemCode) {
                selectedItems.delete(itemCode);
            }
            
            row.remove();
            checkEmptyTable();
            updateItemCount();
        });
        
        // Check if table is empty
        function checkEmptyTable() {
            if ($('#itemsBody tr').length === 0) {
                $('#noItemsMessage').show();
            }
        }
        
        // Form submission
        $('#submitBtn').on('click', async function(e) {
            e.preventDefault(); // Mencegah submit langsung
            
            // Validasi 1: Cek toko sudah dipilih
            const tokoId = $('#toko_id').val();
            if (!tokoId || tokoId === '') {
                alert('Harap pilih toko terlebih dahulu.');
                $('#toko_id').focus();
                return false;
            }
            
            // Validasi 2: Cek duplicate stock opname
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            const bulanNames = {
                1: 'Januari', 2: 'Februari', 3: 'Maret', 4: 'April',
                5: 'Mei', 6: 'Juni', 7: 'Juli', 8: 'Agustus',
                9: 'September', 10: 'Oktober', 11: 'November', 12: 'Desember'
            };
            
            // Tampilkan loading
            const submitBtn = $(this);
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html(`
                <span class="flex items-center justify-center">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memvalidasi...
                </span>
            `);
            
            try {
                // AJAX request untuk cek duplicate
                const response = await $.ajax({
                    url: '{{ route("stockopname.check-duplicate") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        toko_id: tokoId,
                        tahun: tahun,
                        bulan: bulan
                    },
                    dataType: 'json'
                });
                
                if (response.error) {
                    alert(response.message || 'Terjadi kesalahan validasi data.');
                    submitBtn.prop('disabled', false).html(originalText);
                    return false;
                }
                
                if (response.exists) {
                    alert(`Stock opname untuk toko ini pada:\n${bulanNames[bulan]} ${tahun}\nsudah ada. 1 bulan hanya boleh ada 1 data stock opname per toko.`);
                    submitBtn.prop('disabled', false).html(originalText);
                    return false;
                }
                
                // Validasi 3: Cek minimal ada satu item
                submitBtn.html('Memvalidasi item...');
                
                if ($('#itemsBody tr').length === 0) {
                    alert('Harap tambahkan minimal satu item.');
                    submitBtn.prop('disabled', false).html(originalText);
                    return false;
                }
                
                // Validasi 4: Cek semua item sudah lengkap
                let allValid = true;
                let errorRows = [];
                
                $('#itemsBody tr').each(function(index) {
                    const row = $(this);
                    const itemId = row.find('.item-select').val();
                    const stock = row.find('.stock-input').val();
                    
                    if (!itemId || stock === '') {
                        allValid = false;
                        errorRows.push(index + 1);
                        row.addClass('bg-red-50');
                    } else {
                        row.removeClass('bg-red-50');
                    }
                });
                
                if (!allValid) {
                    alert('Harap lengkapi semua data item (pilih barang dan isi stock untuk baris: ' + errorRows.join(', ') + ').');
                    submitBtn.prop('disabled', false).html(originalText);
                    return false;
                }
                
                // Validasi 5: Cek tidak ada item duplikat
                const itemCodes = [];
                let hasDuplicates = false;
                
                $('#itemsBody tr').each(function() {
                    const itemCode = $(this).find('.item-select').val();
                    if (itemCode && itemCodes.includes(itemCode)) {
                        hasDuplicates = true;
                        $(this).addClass('bg-red-50');
                    } else if (itemCode) {
                        itemCodes.push(itemCode);
                    }
                });
                
                if (hasDuplicates) {
                    alert('Terdapat item yang duplikat. Harap hapus item yang sama.');
                    submitBtn.prop('disabled', false).html(originalText);
                    return false;
                }
                
                // Jika semua validasi lolos, submit form
                submitBtn.html('Menyimpan...');
                
                // Beri jeda sebentar sebelum submit
                setTimeout(() => {
                    $('#opnameForm').submit();
                }, 500);
                
            } catch (error) {
                console.error('Validation error:', error);
                submitBtn.prop('disabled', false).html(originalText);
                
                if (error.status === 500) {
                    alert('Terjadi kesalahan server. Silakan coba lagi atau hubungi administrator.');
                } else if (error.responseJSON?.error) {
                    alert(error.responseJSON.message || 'Terjadi kesalahan validasi.');
                } else {
                    alert('Gagal memvalidasi data. Silakan coba lagi.');
                }
                return false;
            }
        });
    });
    </script>
</x-app-layout>