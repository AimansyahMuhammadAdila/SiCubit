<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: { "primary": "#162065", "primary-navy": "#101850", "bg-soft": "#f8fafc" },
                    fontFamily: { "display": ["Plus Jakarta Sans", "sans-serif"] }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url('<?= base_url('uploads/Background.png') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        @keyframes slideUp {
            from { transform: translateY(16px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="font-display min-h-screen flex overflow-x-hidden text-slate-800">

    <?= $this->include('admin/layout/sidebar') ?>

    <main class="flex-1 min-w-0 p-4 lg:p-10 animate-slide-up">
        <div class="lg:hidden flex items-center justify-between mb-8 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="toggleSidebar()" class="size-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <span class="font-black text-primary italic uppercase">SI CUBIT</span>
            <div class="size-10 rounded-xl bg-slate-100"></div>
        </div>

        <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase italic">Database Ibu & Anak</h1>
                <p class="text-slate-400 font-medium mt-1">Daftar Rekam Medis Pasien Poltekkes / Puskesmas Terintegrasi.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?= base_url('admin/export-spreadsheet') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">table_view</span> Download Excel (.xls)
                </a>
                <button onclick="openSheetsModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">sync</span> Google Sheets Sync
                </button>
            </div>
        </header>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8 flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" id="searchInput" placeholder="Cari berdasarkan NIK, Nama, atau No. Rekam Medis..." class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-xs italic focus:ring-2 focus:ring-primary/20 transition-all"/>
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            </div>
            <div class="flex flex-col md:flex-row gap-2">
                <select id="filterKabkota" class="bg-slate-50 border-none rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 px-6 py-4 focus:ring-2 focus:ring-primary/20 w-40 md:w-auto">
                    <option value="">SEMUA WILAYAH</option>
                    <?php foreach ($wilayah as $w): ?>
                        <option value="<?= esc($w['id']) ?>"><?= strtoupper(esc($w['nama'])) ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="filterPuskesmas" class="bg-slate-50 border-none rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 px-6 py-4 focus:ring-2 focus:ring-primary/20 w-40 md:w-auto">
                    <option value="" data-kabkota="">SEMUA PUSKESMAS</option>
                    <?php foreach ($puskesmas as $p): ?>
                        <option value="<?= esc($p['id']) ?>" data-kabkota="<?= esc($p['id_kabkota']) ?>"><?= strtoupper(esc($p['nama'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-slate-400 text-[10px] font-black tracking-[0.1em] uppercase">
                        <tr>
                            <th class="px-10 py-6">Informasi Pasien</th>
                            <th class="px-10 py-6">Domisili</th>
                            <th class="px-10 py-6 text-center">Status Gizi</th>
                            <th class="px-10 py-6">Kesehatan Janin</th>
                            <th class="px-10 py-6 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="divide-y divide-slate-50">
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-slate-50/50 transition duration-300 user-row" 
                                data-kabkota="<?= esc($u['id_kabkota']) ?>" 
                                data-puskesmas="<?= esc($u['id_puskesmas']) ?>">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="size-12 rounded-2xl bg-primary/10 flex items-center justify-center font-black text-primary text-base">
                                            <?= strtoupper(substr($u['nama'], 0, 2)) ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm italic uppercase tracking-tighter user-name"><?= esc($u['nama']) ?></p>
                                            <p class="text-[10px] text-slate-400 font-medium">Umur: <?= esc($u['umur'] ?? '-') ?> Thn • <?= esc($u['no_telp'] ?? '-') ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-7">
                                    <p class="font-bold text-slate-700 text-xs user-domisili"><?= esc($u['nama_puskesmas'] ?? '-') ?></p>
                                    <p class="text-[10px] text-slate-400 italic"><?= esc($u['nama_kabkota'] ?? '-') ?></p>
                                </td>
                                <td class="px-10 py-7 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-wider border border-green-100">
                                        <span class="size-1.5 rounded-full bg-green-500"></span> NORMAL
                                    </span>
                                </td>
                                <td class="px-10 py-7">
                                    <p class="text-xs font-bold text-slate-700">Status ASI: 
                                        <?php if ($u['status_asi'] === 'Cukup'): ?>
                                            <span class="text-emerald-600 font-black">Cukup</span>
                                        <?php elseif (in_array($u['status_asi'], ['Kurang', 'Tidak Cukup'])): ?>
                                            <span class="text-rose-600 font-black">Perlu Evaluasi</span>
                                        <?php else: ?>
                                            <span class="text-slate-400">Belum Mengisi</span>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-[10px] text-slate-400 italic">Anak ke-<?= esc($u['jumlah_anak'] ?? 0) ?></p>
                                </td>
                                <td class="px-10 py-7 text-center">
                                    <a href="<?= base_url('admin/detail/' . $u['id']) ?>" class="text-[10px] font-black text-primary hover:underline italic tracking-widest uppercase">Lihat Rekam Medis</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
                <p id="showingCount" class="text-xs font-bold text-slate-400 italic">Menampilkan <?= count($users) ?> Bunda</p>
                <div id="pagination" class="flex items-center gap-2"></div>
            </div>
        </div>
    </main>

    <!-- MODAL GOOGLE SHEETS SINKRONISASI -->
    <div id="sheetsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 w-full max-w-3xl overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 bg-slate-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">grid_on</span>
                    </div>
                    <div>
                        <h3 class="font-black text-lg uppercase italic tracking-tight">Integrasi Google Sheets Bulanan</h3>
                        <p class="text-[10px] text-slate-400">Continuous sync data admin dengan pemisahan sheet tab otomatis per bulan</p>
                    </div>
                </div>
                <button onclick="closeSheetsModal()" class="text-slate-400 hover:text-white transition p-2">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-slate-700 text-xs">
                
                <!-- Status Bar -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Status Sinkronisasi Real-time</p>
                        <p class="text-xs font-bold text-slate-800 mt-0.5">
                            Tab Sheet Aktif Bulan Ini: <span class="text-primary font-black"><?= date('F Y') ?></span>
                        </p>
                        <p class="text-[10px] text-slate-500 italic mt-0.5">Terakhir disinkronkan: <span id="lastSyncedText" class="font-bold text-slate-700"><?= esc($last_synced_at) ?></span></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php if (!empty($google_sheet_url)): ?>
                            <a href="<?= esc($google_sheet_url) ?>" target="_blank" class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-4 py-2 rounded-xl text-[10px] font-bold transition flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm">open_in_new</span> Buka Google Sheet
                            </a>
                        <?php endif; ?>
                        <button id="btnSyncNow" onclick="triggerSync()" class="bg-primary text-white hover:bg-blue-800 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition flex items-center gap-2 shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-sm">sync</span> Sync Sekarang
                        </button>
                    </div>
                </div>

                <!-- Form Configuration -->
                <form id="formSheetsConfig" onsubmit="saveSheetsConfig(event)" class="bg-white p-5 rounded-2xl border border-slate-200 space-y-4">
                    <h4 class="font-black text-slate-800 text-sm uppercase italic tracking-tight flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">settings</span> Pengaturan URL Spreadsheet & Webhook
                    </h4>
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">URL Webhook Google Apps Script</label>
                        <input type="url" id="google_webhook_url" name="google_webhook_url" value="<?= esc($google_webhook_url) ?>" placeholder="https://script.google.com/macros/s/.../exec" class="w-full bg-slate-50 border-slate-200 rounded-xl text-xs py-2.5 px-3 focus:ring-2 focus:ring-primary/20"/>
                        <p class="text-[10px] text-slate-400 mt-1 italic">Dapatkan URL ini setelah menerapkan kode Apps Script di Google Sheets Anda (lihat panduan di bawah).</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">Link Langsung Google Sheet Anda (Opsional)</label>
                        <input type="url" id="google_sheet_url" name="google_sheet_url" value="<?= esc($google_sheet_url) ?>" placeholder="https://docs.google.com/spreadsheets/d/..." class="w-full bg-slate-50 border-slate-200 rounded-xl text-xs py-2.5 px-3 focus:ring-2 focus:ring-primary/20"/>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-slate-900 text-white hover:bg-slate-800 px-5 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-wider transition">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>

                <!-- Panduan 1-Click Apps Script -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/50">
                    <button onclick="toggleAppsScriptGuide()" class="w-full p-4 bg-slate-100 hover:bg-slate-200/60 transition flex items-center justify-between font-bold text-slate-800 text-xs">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">code</span>
                            Panduan Setup Google Apps Script (Hanya Perlu 1 Kali)
                        </span>
                        <span id="guideChevron" class="material-symbols-outlined text-slate-500">expand_more</span>
                    </button>
                    <div id="appsScriptGuide" class="p-5 space-y-4 hidden bg-white">
                        <ol class="list-decimal list-inside space-y-2 text-slate-600 text-[11px] leading-relaxed">
                            <li>Buka <b>Google Sheets</b> baru atau yang sudah ada di akun Google Anda.</li>
                            <li>Pada menu atas, klik <b>Extensions (Ekstensi)</b> &rarr; <b>Apps Script</b>.</li>
                            <li>Hapus seluruh kode default yang ada di dalam editor Apps Script.</li>
                            <li>Salin (Copy) kode Apps Script di bawah ini dan **Paste** ke dalam editor:</li>
                        </ol>

                        <div class="relative bg-slate-900 text-slate-100 p-4 rounded-xl font-mono text-[10px] overflow-x-auto border border-slate-800 max-h-48">
                            <button onclick="copyAppsScriptCode()" class="absolute top-2 right-2 bg-primary hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-[9px] font-bold transition flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">content_copy</span> Salin Kode
                            </button>
                            <pre id="codeBlock"><?= esc($apps_script_code) ?></pre>
                        </div>

                        <ol start="5" class="list-decimal list-inside space-y-2 text-slate-600 text-[11px] leading-relaxed">
                            <li>Klik tombol <b>Deploy (Terapkan)</b> &rarr; <b>New deployment (Terapkan baru)</b>.</li>
                            <li>Pilih tipe: <b>Web app</b>. Isikan Description: <i>SiCubit Sync</i>.</li>
                            <li>Set **Who has access (Siapa yang memiliki akses)** ke: <b>Anyone (Siapa saja)</b>.</li>
                            <li>Klik <b>Deploy</b>, lalu **Authorize Access (Izinkan Akses)** dengan akun Google Anda.</li>
                            <li>Salin <b>Web App URL</b> yang dihasilkan, lalu tempel pada input Webhook di atas. Selesai!</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openSheetsModal() {
            document.getElementById('sheetsModal').classList.remove('hidden');
        }

        function closeSheetsModal() {
            document.getElementById('sheetsModal').classList.add('hidden');
        }

        function toggleAppsScriptGuide() {
            const guide = document.getElementById('appsScriptGuide');
            const chevron = document.getElementById('guideChevron');
            guide.classList.toggle('hidden');
            chevron.textContent = guide.classList.contains('hidden') ? 'expand_more' : 'expand_less';
        }

        function copyAppsScriptCode() {
            const code = document.getElementById('codeBlock').innerText;
            navigator.clipboard.writeText(code).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Kode Disalin!',
                    text: 'Kode Google Apps Script telah disalin ke clipboard Anda.',
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        }

        async function saveSheetsConfig(e) {
            e.preventDefault();
            const webhookUrl = document.getElementById('google_webhook_url').value;
            const sheetUrl = document.getElementById('google_sheet_url').value;

            const formData = new FormData();
            formData.append('google_webhook_url', webhookUrl);
            formData.append('google_sheet_url', sheetUrl);

            try {
                const res = await fetch('<?= base_url('admin/save-sheets-config') ?>', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pengaturan Disimpan!',
                        text: data.message,
                        timer: 1800,
                        showConfirmButton: false
                    });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menyimpan pengaturan.' });
            }
        }

        async function triggerSync() {
            const btn = document.getElementById('btnSyncNow');
            const origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Menyinkronkan...';

            try {
                const res = await fetch('<?= base_url('admin/sync-google-sheets') ?>', {
                    method: 'POST'
                });
                const data = await res.json();
                if (data.success) {
                    document.getElementById('lastSyncedText').textContent = data.timestamp || 'Baru Saja';
                    Swal.fire({
                        icon: 'success',
                        title: 'Sinkronisasi Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#1a1ab7'
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: data.message,
                        confirmButtonColor: '#1a1ab7'
                    });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menyambung ke server.' });
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }

        // Table Pagination & Filter Logic
        const rowsPerPage = 10;
        let currentPage = 1;
        
        const searchInput = document.getElementById('searchInput');
        const filterKabkota = document.getElementById('filterKabkota');
        const filterPuskesmas = document.getElementById('filterPuskesmas');
        
        function renderPagination(totalRows, totalPages) {
            const container = document.getElementById('pagination');
            container.innerHTML = '';
            
            if (totalPages <= 1) return;
            
            // Prev button
            const prevBtn = document.createElement('button');
            prevBtn.className = `size-8 rounded-lg border border-slate-200 flex items-center justify-center transition ${currentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-slate-500 hover:bg-white cursor-pointer'}`;
            prevBtn.innerHTML = '<span class="material-symbols-outlined text-sm">chevron_left</span>';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => changePage(currentPage - 1);
            container.appendChild(prevBtn);
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `size-8 rounded-lg font-bold text-xs flex items-center justify-center transition ${i === currentPage ? 'bg-primary text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => changePage(i);
                    container.appendChild(pageBtn);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    const dots = document.createElement('span');
                    dots.className = 'size-8 flex items-center justify-center text-slate-400 text-xs';
                    dots.textContent = '...';
                    container.appendChild(dots);
                }
            }
            
            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = `size-8 rounded-lg border border-slate-200 flex items-center justify-center transition ${currentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-slate-500 hover:bg-white cursor-pointer'}`;
            nextBtn.innerHTML = '<span class="material-symbols-outlined text-sm">chevron_right</span>';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => changePage(currentPage + 1);
            container.appendChild(nextBtn);
        }

        function changePage(page) {
            currentPage = page;
            filterData();
        }

        function filterData() {
            const query = searchInput.value.toLowerCase().trim();
            const kabkotaVal = filterKabkota.value;
            const puskesmasVal = filterPuskesmas.value;
            
            const rows = document.querySelectorAll('.user-row');
            let matchedRows = [];

            rows.forEach(row => {
                const name = row.querySelector('.user-name').textContent.toLowerCase();
                const domisili = row.querySelector('.user-domisili').textContent.toLowerCase();
                const rowKabkota = row.getAttribute('data-kabkota');
                const rowPuskesmas = row.getAttribute('data-puskesmas');
                
                const matchSearch = name.includes(query) || domisili.includes(query);
                const matchKabkota = kabkotaVal === '' || rowKabkota === kabkotaVal;
                const matchPuskesmas = puskesmasVal === '' || rowPuskesmas === puskesmasVal;
                
                if (matchSearch && matchKabkota && matchPuskesmas) {
                    matchedRows.push(row);
                } else {
                    row.style.display = 'none';
                }
            });

            const totalVisible = matchedRows.length;
            const totalPages = Math.ceil(totalVisible / rowsPerPage);
            if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
            if (totalPages === 0) currentPage = 1;

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            
            matchedRows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('showingCount').textContent = `Menampilkan ${totalVisible} Bunda`;
            renderPagination(totalVisible, totalPages);
        }

        filterData();

        searchInput.addEventListener('input', () => { currentPage = 1; filterData(); });
        filterPuskesmas.addEventListener('change', () => { currentPage = 1; filterData(); });
        filterKabkota.addEventListener('change', function() {
            currentPage = 1;
            const kabkotaId = this.value;
            const puskesmasOptions = filterPuskesmas.querySelectorAll('option');
            
            puskesmasOptions.forEach(opt => {
                if (opt.value === "") {
                    opt.style.display = '';
                } else if (!kabkotaId || opt.getAttribute('data-kabkota') === kabkotaId) {
                    opt.style.display = '';
                } else {
                    opt.style.display = 'none';
                }
            });
            
            filterPuskesmas.value = "";
            filterData();
        });
    </script>
</body>
</html>