<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #374151; line-height: 1.5;">
                {{ __('Import Data PL') }}
            </h2>
            <a href="{{ route('daftarharga.index') }}" 
               style="background-color: #6b7280; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                Kembali
            </a>
        </div>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 56rem; margin: 0 auto; padding: 0 1rem;">
            @if(session('error'))
            <div style="margin-bottom: 1rem; background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 0.75rem 1rem; border-radius: 0.375rem;">
                {{ session('error') }}
            </div>
            @endif

            <div style="background-color: white; overflow: hidden; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 500; color: #111827;">Petunjuk Import</h3>
                        <ul style="margin-top: 0.5rem; list-style-type: disc; list-style-position: inside; font-size: 0.875rem; color: #6b7280;">
                            <li>File harus dalam format Excel (.xlsx, .xls) atau CSV</li>
                            <li>Header kolom harus sesuai dengan template</li>
                            <li>Seluruh Data lama akan digantikan dengan data baru</li>
                            <li>Download template terlebih dahulu untuk memastikan format sesuai</li>
                        </ul>
                    </div>

                    <!-- Tombol Download Template -->
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.375rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 500; color: #0369a1; margin-bottom: 0.25rem;">Download Template</h4>
                                <p style="font-size: 0.875rem; color: #0c4a6e;">Gunakan template ini untuk memastikan format file sesuai</p>
                            </div>
                            <a href="{{ asset('Template-import-pl.xlsx') }}" download
                            style="background-color: #059669; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;"
                            onmouseover="this.style.backgroundColor='#047857'" 
                            onmouseout="this.style.backgroundColor='#059669'">
                                <svg style="height: 1rem; width: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Template
                            </a>
                        </div>
                    </div>

                    <form id="importForm" action="{{ route('daftarharga.import-preview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div style="margin-bottom: 1rem;">
                            <label for="file" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151;">
                                Pilih File Excel
                            </label>
                            <input type="file" name="file" id="file" 
                                style="margin-top: 0.25rem; display: block; width: 100%; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem;"
                                accept=".xlsx,.xls,.csv" required>
                            @error('file')
                                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                            <a href="{{ route('daftarharga.index') }}" 
                            style="background-color: #6b7280; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                    style="background-color: #3b82f6; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; min-width: 8rem;">
                                <span id="buttonText">Preview Data</span>
                                <div id="loadingSpinner" style="display: none; margin-left: 0.5rem;">
                                    <svg style="animation: spin 1s linear infinite; height: 1.25rem; width: 1.25rem; color: white;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(75, 85, 99, 0.5); z-index: 9999; overflow-y: auto;">
        <div style="position: relative; top: 5rem; margin: 0 auto; padding: 1.25rem; border: 1px solid #e5e7eb; width: 24rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-radius: 0.375rem; background-color: white;">
            <div style="margin-top: 0.75rem; text-align: center;">
                <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 3rem; width: 3rem; border-radius: 9999px; background-color: #dbeafe;">
                    <svg style="animation: spin 1s linear infinite; height: 2rem; width: 2rem; color: #2563eb;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; color: #111827; margin-top: 0.5rem;">Memproses File</h3>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">Sedang membaca dan memvalidasi data Excel...</p>
                <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem;">Harap tunggu, proses mungkin memakan waktu beberapa saat.</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        #loadingOverlay {
            backdrop-filter: blur(2px);
        }

        .min-width-32 {
            min-width: 8rem;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <script>
        document.getElementById('importForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const fileInput = document.getElementById('file');

            // Validasi file
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Pilih file terlebih dahulu');
                return;
            }

            // Tampilkan loading
            submitBtn.disabled = true;
            buttonText.textContent = 'Memproses...';
            loadingSpinner.style.display = 'block';
            loadingOverlay.style.display = 'block';
        });

        // Handle browser back button
        window.addEventListener('pageshow', function(event) {
            const submitBtn = document.getElementById('submitBtn');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loadingOverlay = document.getElementById('loadingOverlay');

            submitBtn.disabled = false;
            buttonText.textContent = 'Preview Data';
            loadingSpinner.style.display = 'none';
            loadingOverlay.style.display = 'none';
        });
    </script>
</x-app-layout>