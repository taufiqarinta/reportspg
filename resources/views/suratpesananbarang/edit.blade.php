<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Surat Pesanan Barang') }}
        </h2>
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
                <div class="p-6 text-gray-900">
                    <form action="{{ route('suratpesananbarang.update', $suratpesananbarang->id) }}" method="POST" id="spbForm">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="total_jumlah_box" id="totalJumlahBoxHidden" value="{{ $suratpesananbarang->total_jumlahbox }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Surat</label>
                                <input type="text" value="{{ $suratpesananbarang->nomor_surat }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Surat</label>
                                <input type="date" value="{{ $suratpesananbarang->tanggal_surat->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pesanan Dari <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" 
                                        name="pengirim" 
                                        id="pengirim"
                                        value="{{ old('pengirim', $suratpesananbarang->pengirim) }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase-field pr-24"
                                        style="text-transform: uppercase"
                                        list="agen-list"
                                        autocomplete="off"
                                        required
                                        oninput="handleAgenInput(this)">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-1">
                                        <button type="button" onclick="clearAgenSelection()" class="reset-button">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                                <div id="agen-suggestions" class="hidden absolute z-10 w-full max-w-md mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto"></div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sales</label>
                                <input type="text" name="penerima" value="{{ old('penerima', $suratpesananbarang->penerima) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dikirim Ke <span class="text-red-500">*</span></label>
                                <input type="text" id="dikirim_ke" name="dikirim_ke" value="{{ old('dikirim_ke', $suratpesananbarang->dikirim_ke) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kirim <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_kirim" value="{{ old('tanggal_kirim', $suratpesananbarang->tanggal_kirim->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div class = "hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pemesan <span class="text-red-500">*</span></label>
                                <input type="text"  id="pemesan" name="pemesan" value="{{ old('pemesan', $suratpesananbarang->pemesan) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Header untuk pilihan harga -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Harga yang Digunakan <span class="text-red-500">*</span></label>
                                <select name="jenis_harga" id="jenisHarga" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="franco" {{ $suratpesananbarang->jenis_harga == 'franco' ? 'selected' : '' }}>Harga Franco</option>
                                    <option value="loco" {{ $suratpesananbarang->jenis_harga == 'loco' ? 'selected' : '' }}>Harga Loco</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor DO <span class="text-red-500">*</span></label>
                                <input type="text"  id="nomor_do" name="nomor_do" value="{{ old('nomor_do', $suratpesananbarang->nomor_do) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <input type="text" value="{{ ucfirst($suratpesananbarang->status) }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                            </div>

                            @if($suratpesananbarang->approved_by)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Approved By</label>
                                <input type="text" value="{{ $suratpesananbarang->approver->name ?? '-' }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                            </div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                                <button type="button" onclick="addDetailRow()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Baris
                                </button>
                            </div>

                            <br>

                            <!-- Container untuk tabel dengan scroll horizontal -->
                            <div class="table-container">
                                <div class="overflow-x-scroll">
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th class="column-no">No</th>
                                                <th class="column-ukuran">Ukuran<span class="text-red-500">*</span></th>
                                                <th class="column-product">Nama Product<span class="text-red-500">*</span></th>
                                                <th class="column-brand">Brand<span class="text-red-500">*</span></th>
                                                <th class="column-kw">KW<span class="text-red-500">*</span></th>
                                                <th class="column-jumlah">Jumlah/Box<span class="text-red-500">*</span></th>
                                                <th class="column-harga">Harga Satuan/Box<span class="text-red-500">*</span></th>
                                                <th class="column-disc">Disc (Rp)</th>
                                                <th class="column-biaya">Biaya Tambahan Ekspedisi</th>
                                                <th class="column-total">Total Rp<span class="text-red-500">*</span></th>
                                                <th class="column-keterangan">Keterangan</th>
                                                <th class="column-aksi">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailTableBody">
                                            @foreach($suratpesananbarang->details as $index => $detail)
                                            <tr class="detail-row">
                                                <td class="column-no">{{ $index + 1 }}</td>
                                                <td class="column-ukuran">
                                                    <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail->id }}">
                                                    <select name="details[{{ $index }}][ukuran]" class="w-full border-gray-300 rounded-md text-sm ukuran-select" onchange="loadProducts(this)" required>
                                                        <option value="">Pilih Ukuran</option>
                                                        @foreach($ukuranList as $ukuran)
                                                            <option value="{{ $ukuran }}" {{ $detail->ukuran == $ukuran ? 'selected' : '' }}>{{ $ukuran }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="column-product">
                                                    <select name="details[{{ $index }}][nama_product]" class="w-full border-gray-300 rounded-md text-sm product-select" onchange="loadBrands(this)" required>
                                                        <option value="">Pilih Product</option>
                                                        @if($detail->nama_product)
                                                            <option value="{{ $detail->nama_product }}" selected>{{ $detail->nama_product }}</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td class="column-brand">
                                                    <select name="details[{{ $index }}][brand]" class="w-full border-gray-300 rounded-md text-sm brand-select" onchange="loadKw(this)" required>
                                                        <option value="">Pilih Brand</option>
                                                        @if($detail->brand)
                                                            <option value="{{ $detail->brand }}" selected>{{ $detail->brand }}</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td class="column-kw">
                                                    <select name="details[{{ $index }}][kw]" class="w-full border-gray-300 rounded-md text-sm kw-select" onchange="loadHarga(this)" required>
                                                        <option value="">Pilih KW</option>
                                                        @if($detail->kw)
                                                            <option value="{{ $detail->kw }}" selected>{{ $detail->kw }}</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td class="column-jumlah">
                                                    <input type="number" step="1" name="details[{{ $index }}][jumlah_box]" value="{{ $detail->jumlah_box }}" class="w-full border-gray-300 rounded-md text-sm jumlah-box" oninput="calculateRowTotal(this)" required>
                                                </td>
                                                <td class="column-harga">
                                                    <input type="number" step="0.01" name="details[{{ $index }}][harga_satuan_box]" value="{{ $detail->harga_satuan_box }}" class="w-full border-gray-300 rounded-md text-sm harga-satuan" readonly>
                                                </td>
                                                <td class="column-disc">
                                                    <input type="number" step="1" name="details[{{ $index }}][disc]" value="{{ $detail->disc ?? 0 }}" class="w-full border-gray-300 rounded-md text-sm disc" oninput="calculateRowTotal(this)" value="0">
                                                </td>
                                                <td class="column-biaya">
                                                    <input type="number" step="1" name="details[{{ $index }}][biaya_tambahan_ekspedisi]" value="{{ $detail->biaya_tambahan_ekspedisi ?? 0 }}" class="w-full border-gray-300 rounded-md text-sm biaya-ekspedisi" oninput="calculateRowTotal(this)" value="0">
                                                </td>
                                                <td class="column-total">
                                                    <input type="text" class="w-full border-gray-300 rounded-md text-sm bg-gray-100 total-rp" readonly value="{{ number_format($detail->total_rp, 0, ',', '.') }}">
                                                </td>
                                                <td class="column-keterangan">
                                                    <input type="text" name="details[{{ $index }}][keterangan]" value="{{ $detail->keterangan }}" class="w-full border-gray-300 rounded-md text-sm">
                                                </td>
                                                <td class="column-aksi">
                                                    <button type="button" onclick="removeDetailRow(this)" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-50 font-bold">
                                                <td colspan="5" class="px-4 py-3 text-right">Total Jumlah Box:</td>
                                                <td class="px-4 py-3"><input type="text" id="totalJumlahBox" class="w-full border-gray-300 rounded-md text-sm bg-gray-100" readonly value="{{ $suratpesananbarang->total_jumlahbox }}"></td>
                                                <td colspan="3"></td>
                                                <td class="column-total"><input type="text" id="totalKeseluruhan" class="w-full border-gray-300 rounded-md text-sm bg-gray-100" readonly value="{{ number_format($suratpesananbarang->total_keseluruhan, 0, ',', '.') }}"></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('suratpesananbarang.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .reset-button {
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
            top: 8px;
        }

        .reset-button:hover {
            background-color: #991b1b;
        }

        #agen-suggestions {
            z-index: 50;
            width: calc(100% - 20px);
        }

        .suggestion-item {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.875rem;
        }

        .suggestion-item:hover {
            background-color: #f3f4f6;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .pr-24 {
            padding-right: 6rem;
        }

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

        .responsive-table {
            width: 100%;
            min-width: 1400px;
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
        .column-no { width: 50px; min-width: 50px; }
        .column-ukuran { width: 150px; min-width: 150px; }
        .column-product { width: 250px; min-width: 250px; }
        .column-brand { width: 150px; min-width: 150px; }
        .column-kw { width: 120px; min-width: 120px; }
        .column-jumlah { width: 100px; min-width: 100px; }
        .column-harga { width: 140px; min-width: 140px; }
        .column-disc { width: 100px; min-width: 100px; }
        .column-biaya { width: 140px; min-width: 140px; }
        .column-total { width: 120px; min-width: 120px; }
        .column-keterangan { width: 150px; min-width: 150px; }
        .column-aksi { width: 80px; min-width: 80px; }

        /* Styling untuk input dan select dalam tabel */
        .responsive-table input,
        .responsive-table select {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        @media (max-width: 768px) {
            .table-container {
                margin: 0; /* hilangkan margin negatif */
                padding: 0 1rem; /* tambahkan padding kiri-kanan */
                border-radius: 0;
                border-left: none;
                border-right: none;
            }
            
            .responsive-table {
                min-width: 1400px;
            }
        }
    </style>

    <script>
        // Data agen dari PHP
        const daftarAgens = @json($daftarAgens);

        function handleAgenInput(input) {
            const value = input.value.toUpperCase();
            input.value = value;
            
            const suggestionsContainer = document.getElementById('agen-suggestions');
            suggestionsContainer.innerHTML = '';
            
            if (value.length < 2) {
                suggestionsContainer.classList.add('hidden');
                return;
            }
            
            const filteredAgens = daftarAgens.filter(agen => 
                agen.nama_agen.toUpperCase().includes(value)
            );
            
            if (filteredAgens.length > 0) {
                filteredAgens.forEach(agen => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = agen.nama_agen;
                    div.onclick = () => selectAgen(agen);
                    suggestionsContainer.appendChild(div);
                });
                suggestionsContainer.classList.remove('hidden');
            } else {
                suggestionsContainer.classList.add('hidden');
            }
        }

        function selectAgen(agen) {
            document.getElementById('pengirim').value = agen.nama_agen;
            document.getElementById('dikirim_ke').value = agen.alamat || '';
            document.getElementById('pemesan').value = agen.nama_agen;
            document.getElementById('agen-suggestions').classList.add('hidden');
        }

        function clearAgenSelection() {
            document.getElementById('pengirim').value = '';
            document.getElementById('dikirim_ke').value = '';
            document.getElementById('pemesan').value = '';
            document.getElementById('agen-suggestions').classList.add('hidden');
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#pengirim') && !e.target.closest('#agen-suggestions')) {
                document.getElementById('agen-suggestions').classList.add('hidden');
            }
        });

        // Uppercase functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uppercaseFields = document.querySelectorAll('.uppercase-field');
            
            uppercaseFields.forEach(field => {
                field.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
                
                if (field.value) {
                    field.value = field.value.toUpperCase();
                }
            });
        });

        let detailIndex = {{ count($suratpesananbarang->details) }};

        function addDetailRow() {
            const tbody = document.getElementById('detailTableBody');
            const rowCount = tbody.getElementsByClassName('detail-row').length + 1;
            
            const newRow = `
                <tr class="detail-row">
                    <td class="column-no">${rowCount}</td>
                    <td class="column-ukuran">
                        <select name="details[${detailIndex}][ukuran]" class="w-full border-gray-300 rounded-md text-sm ukuran-select" onchange="loadProducts(this)" required>
                            <option value="">Pilih Ukuran</option>
                            @foreach($ukuranList as $ukuran)
                                <option value="{{ $ukuran }}">{{ $ukuran }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="column-product">
                        <select name="details[${detailIndex}][nama_product]" class="w-full border-gray-300 rounded-md text-sm product-select" onchange="loadBrands(this)" required>
                            <option value="">Pilih Product</option>
                        </select>
                    </td>
                    <td class="column-brand">
                        <select name="details[${detailIndex}][brand]" class="w-full border-gray-300 rounded-md text-sm brand-select" onchange="loadKw(this)" required>
                            <option value="">Pilih Brand</option>
                        </select>
                    </td>
                    <td class="column-kw">
                        <select name="details[${detailIndex}][kw]" class="w-full border-gray-300 rounded-md text-sm kw-select" onchange="loadHarga(this)" required>
                            <option value="">Pilih KW</option>
                        </select>
                    </td>
                    <td class="column-jumlah">
                        <input type="number" step="1" name="details[${detailIndex}][jumlah_box]" class="w-full border-gray-300 rounded-md text-sm jumlah-box" oninput="calculateRowTotal(this)" required>
                    </td>
                    <td class="column-harga">
                        <input type="number" step="0.01" name="details[${detailIndex}][harga_satuan_box]" class="w-full border-gray-300 rounded-md text-sm harga-satuan" readonly>
                    </td>
                    <td class="column-disc">
                        <input type="number" step="1" name="details[${detailIndex}][disc]" class="w-full border-gray-300 rounded-md text-sm disc" oninput="calculateRowTotal(this)" value="0">
                    </td>
                    <td class="column-biaya">
                        <input type="number" step="1" name="details[${detailIndex}][biaya_tambahan_ekspedisi]" class="w-full border-gray-300 rounded-md text-sm biaya-ekspedisi" oninput="calculateRowTotal(this)" value="0">
                    </td>
                    <td class="column-total">
                        <input type="text" class="w-full border-gray-300 rounded-md text-sm bg-gray-100 total-rp" readonly value="0">
                    </td>
                    <td class="column-keterangan">
                        <input type="text" name="details[${detailIndex}][keterangan]" class="w-full border-gray-300 rounded-md text-sm">
                    </td>
                    <td class="column-aksi">
                        <button type="button" onclick="removeDetailRow(this)" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                    </td>
                </tr>
            `;
            
            tbody.insertAdjacentHTML('beforeend', newRow);
            detailIndex++;
            updateRowNumbers();
            calculateTotalJumlahBox();
        }

        function removeDetailRow(button) {
            const tbody = document.getElementById('detailTableBody');
            if (tbody.getElementsByClassName('detail-row').length > 1) {
                button.closest('tr').remove();
                updateRowNumbers();
                calculateGrandTotal();
                calculateTotalJumlahBox();
            } else {
                alert('Minimal harus ada 1 detail barang');
            }
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('.detail-row');
            rows.forEach((row, index) => {
                row.querySelector('.column-no').textContent = index + 1;
            });
        }

        // Dynamic dropdown functions
        async function loadProducts(select) {
            const row = select.closest('tr');
            const ukuran = select.value;
            const productSelect = row.querySelector('.product-select');
            const brandSelect = row.querySelector('.brand-select');
            const kwSelect = row.querySelector('.kw-select');
            const hargaInput = row.querySelector('.harga-satuan');

            // Reset dependent fields
            productSelect.innerHTML = '<option value="">Pilih Product</option>';
            brandSelect.innerHTML = '<option value="">Pilih Brand</option>';
            kwSelect.innerHTML = '<option value="">Pilih KW</option>';
            hargaInput.value = '';

            if (!ukuran) return;

            try {
                const response = await fetch(`/get-products/${encodeURIComponent(ukuran)}`);
                const products = await response.json();
                
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product;
                    option.textContent = product;
                    productSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading products:', error);
            }
        }

        async function loadBrands(select) {
            const row = select.closest('tr');
            const ukuran = row.querySelector('.ukuran-select').value;
            const product = select.value;
            const brandSelect = row.querySelector('.brand-select');
            const kwSelect = row.querySelector('.kw-select');
            const hargaInput = row.querySelector('.harga-satuan');

            // Reset dependent fields
            brandSelect.innerHTML = '<option value="">Pilih Brand</option>';
            kwSelect.innerHTML = '<option value="">Pilih KW</option>';
            hargaInput.value = '';

            if (!ukuran || !product) return;

            try {
                const response = await fetch(`/get-brands/${encodeURIComponent(ukuran)}/${encodeURIComponent(product)}`);
                const brands = await response.json();
                
                brands.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand;
                    option.textContent = brand;
                    brandSelect.appendChild(option);
                });

                // Auto-select first brand if available
                if (brands.length > 0) {
                    brandSelect.value = brands[0];
                    loadKw(brandSelect);
                }
            } catch (error) {
                console.error('Error loading brands:', error);
            }
        }

        async function loadKw(select) {
            const row = select.closest('tr');
            const ukuran = row.querySelector('.ukuran-select').value;
            const product = row.querySelector('.product-select').value;
            const brand = select.value;
            const kwSelect = row.querySelector('.kw-select');
            const hargaInput = row.querySelector('.harga-satuan');

            // Reset dependent fields
            kwSelect.innerHTML = '<option value="">Pilih KW</option>';
            hargaInput.value = '';

            if (!ukuran || !product || !brand) return;

            try {
                const response = await fetch(`/get-kw/${encodeURIComponent(ukuran)}/${encodeURIComponent(product)}/${encodeURIComponent(brand)}`);
                const kwList = await response.json();
                
                kwList.forEach(kw => {
                    const option = document.createElement('option');
                    option.value = kw;
                    option.textContent = kw;
                    kwSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading KW:', error);
            }
        }

        async function loadHarga(select) {
            const row = select.closest('tr');
            const ukuran = row.querySelector('.ukuran-select').value;
            const product = row.querySelector('.product-select').value;
            const brand = row.querySelector('.brand-select').value;
            const kw = select.value;
            const jenisHarga = document.getElementById('jenisHarga').value;
            const hargaInput = row.querySelector('.harga-satuan');

            if (!ukuran || !product || !brand || !kw) return;

            try {
                const response = await fetch(`/get-harga/${encodeURIComponent(ukuran)}/${encodeURIComponent(product)}/${encodeURIComponent(brand)}/${encodeURIComponent(kw)}/${jenisHarga}`);
                const data = await response.json();
                
                hargaInput.value = data.harga || 0;
                calculateRowTotal(hargaInput);
            } catch (error) {
                console.error('Error loading harga:', error);
            }
        }

        // Update harga when jenis harga changes
        document.getElementById('jenisHarga').addEventListener('change', function() {
            document.querySelectorAll('.kw-select').forEach(select => {
                if (select.value) {
                    loadHarga(select);
                }
            });
        });

        function calculateTotalJumlahBox() {
            const jumlahBoxInputs = document.querySelectorAll('.jumlah-box');
            let totalJumlahBox = 0;
            
            jumlahBoxInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                totalJumlahBox += value;
            });
            
            document.getElementById('totalJumlahBox').value = totalJumlahBox;
            document.getElementById('totalJumlahBoxHidden').value = totalJumlahBox;
        }


        function calculateRowTotal(input) {
            const row = input.closest('tr');
            const jumlahBox = parseFloat(row.querySelector('.jumlah-box').value) || 0;
            const hargaSatuan = parseFloat(row.querySelector('.harga-satuan').value) || 0;
            const discRupiah = parseFloat(row.querySelector('.disc').value) || 0;
            const biayaEkspedisi = parseFloat(row.querySelector('.biaya-ekspedisi').value) || 0;
            
            // PERBAIKAN: Hitung harga satuan setelah diskon dan biaya tambahan
            const hargaSatuanSetelahAdjustment = hargaSatuan - discRupiah + biayaEkspedisi;
            
            // Total = jumlah box × harga satuan yang sudah disesuaikan
            const total = jumlahBox * hargaSatuanSetelahAdjustment;
            
            row.querySelector('.total-rp').value = formatRupiah(total);
            
            calculateGrandTotal();
            calculateTotalJumlahBox();
        }

        function calculateGrandTotal() {
            const totalInputs = document.querySelectorAll('.total-rp');
            let grandTotal = 0;
            
            totalInputs.forEach(input => {
                const cleanValue = input.value.replace(/\./g, '').replace(/,/g, '');
                const value = parseFloat(cleanValue) || 0;
                grandTotal += value;
            });
            
            document.getElementById('totalKeseluruhan').value = formatRupiah(grandTotal);
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateGrandTotal();
            calculateTotalJumlahBox();
        });
    </script>
</x-app-layout>