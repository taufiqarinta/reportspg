<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #374151; line-height: 1.5;">
                {{ __('Preview Import Data PL') }}
            </h2>
            <a href="{{ route('daftarharga.import-form') }}" 
               style="background-color: #6b7280; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                Kembali
            </a>
        </div>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 1rem;">
            <div style="background-color: white; overflow: hidden; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #fefce8; border: 1px solid #fef08a; border-radius: 0.375rem;">
                        <div style="display: flex;">
                            <div style="flex-shrink: 0;">
                                <svg style="height: 1.25rem; width: 1.25rem; color: #eab308;" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div style="margin-left: 0.75rem;">
                                <h3 style="font-size: 0.875rem; font-weight: 500; color: #92400e;">
                                    Peringatan
                                </h3>
                                <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #92400e;">
                                    <p>
                                        Setelah menekan tombol "Simpan Data", semua data harga yang lama akan dihapus dan digantikan dengan data baru ini.
                                        Total data yang akan diimport: <strong>{{ $totalRows }} records</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="min-width: 100%; border-collapse: collapse;">
                            <thead style="background-color: #f9fafb;">
                                <tr>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">TYPE</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">KW</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Brand</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Ukuran</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Karton</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Kategori</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Kel. Harga</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Harga Franco</th>
                                    <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Harga Loco</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: white; divide-y divide-gray-200;">
                                @foreach($previewData as $index => $row)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['type'] ?? $row['TYPE'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['kw'] ?? $row['KW'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['brand'] ?? $row['Brand'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['ukuran'] ?? $row['Ukuran'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['karton'] ?? $row['Karton'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['kategori'] ?? $row['Kategori'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">{{ $row['kel_harga_miss2'] ?? $row['KEL HARGA MISS2'] ?? '-' }}</td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">
                                        Rp 
                                        @php
                                            $hargaFranco = $row['pl_nett_franco'] ?? $row['PL Nett (Franco)'] ?? 0;
                                            try {
                                                echo number_format(floatval($hargaFranco), 2, ',', '.');
                                            } catch (\Exception $e) {
                                                echo '0,00';
                                            }
                                        @endphp
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #374151;">
                                        Rp 
                                        @php
                                            $hargaLoco = $row['pl_nett_loco'] ?? $row['PL Nett (Loco)'] ?? 0;
                                            try {
                                                echo number_format(floatval($hargaLoco), 2, ',', '.');
                                            } catch (\Exception $e) {
                                                echo '0,00';
                                            }
                                        @endphp
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($totalRows > 10)
                    <div style="margin-top: 1rem; font-size: 0.875rem; color: #6b7280;">
                        Menampilkan 10 data pertama dari total {{ $totalRows }} data.
                    </div>
                    @endif

                    <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                        <a href="{{ route('daftarharga.import-form') }}" 
                           style="background-color: #6b7280; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Batalkan
                        </a>
                        <form id="importProcessForm" action="{{ route('daftarharga.import-process') }}" method="POST">
                            @csrf
                            <button type="button" onclick="submitForm()" id="saveBtn"
                                    style="background-color: #10b981; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; min-width: 8rem;">
                                <span id="saveButtonText">Simpan Data</span>
                                <div id="saveLoadingSpinner" style="display: none; margin-left: 0.5rem;">
                                    <svg style="animation: spin 1s linear infinite; height: 1.25rem; width: 1.25rem; color: white;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay untuk Simpan Data -->
    <div id="saveLoadingOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(75, 85, 99, 0.5); z-index: 9999; overflow-y: auto;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 1.25rem; border: 1px solid #e5e7eb; width: 24rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-radius: 0.375rem; background-color: white;">
            <div style="text-align: center;">
                <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 3rem; width: 3rem; border-radius: 9999px; background-color: #d1fae5;">
                    <svg style="animation: spin 1s linear infinite; height: 2rem; width: 2rem; color: #059669;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; color: #111827; margin-top: 0.5rem;">Menyimpan Data</h3>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">Sedang memproses dan menyimpan {{ $totalRows }} records...</p>
                <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem;">Proses ini mungkin memakan waktu beberapa saat. Jangan tutup halaman ini.</p>
                <div style="margin-top: 1rem;">
                    <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 0.5rem;">
                        <div id="progressBar" style="background-color: #059669; height: 0.5rem; border-radius: 9999px; transition: width 0.3s ease-in-out; width: 0%;"></div>
                    </div>
                    <p id="progressText" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Memulai proses...</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        #saveLoadingOverlay, #loadingOverlay {
            backdrop-filter: blur(2px);
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .min-width-32 {
            min-width: 8rem;
        }
    </style>

    <script>
    function submitForm() {
        // Tampilkan confirm dialog
        const userConfirmed = confirm('Yakin ingin menyimpan data? Seluruh Data lama akan dihapus permanen.');
        
        if (!userConfirmed) {
            return false;
        }

        const saveBtn = document.getElementById('saveBtn');
        const saveButtonText = document.getElementById('saveButtonText');
        const saveLoadingSpinner = document.getElementById('saveLoadingSpinner');
        const saveLoadingOverlay = document.getElementById('saveLoadingOverlay');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        // Tampilkan loading
        saveBtn.disabled = true;
        saveButtonText.textContent = 'Menyimpan...';
        saveLoadingSpinner.style.display = 'block';
        saveLoadingOverlay.style.display = 'block';

        // Simulasi progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 10;
            if (progress > 90) progress = 90;
            progressBar.style.width = progress + '%';
            progressText.textContent = `Proses: ${Math.round(progress)}%`;
        }, 500);

        // Submit form secara programmatic
        document.getElementById('importProcessForm').submit();

        // Clear interval setelah beberapa waktu
        setTimeout(() => {
            clearInterval(progressInterval);
        }, 10000);

        return false;
    }
</script>
</x-app-layout>