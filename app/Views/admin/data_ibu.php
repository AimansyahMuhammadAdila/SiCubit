<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: { "primary": "#1a1ab7", "bg-soft": "#f8fafc" },
                    fontFamily: { "display": ["Plus Jakarta Sans", "sans-serif"] }
                }
            }
        }
    </script>
    <style>
        @keyframes slideUp {
            from { transform: translateY(16px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-bg-soft font-display min-h-screen flex overflow-x-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-200 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen">
        <div class="p-8 flex items-center justify-between">
            <div class="flex items-center gap-3 text-primary">
                <span class="material-symbols-outlined text-3xl font-variation-fill">child_care</span>
                <span class="font-black text-xl tracking-tighter uppercase">SI CUBIT</span>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 p-2"><span class="material-symbols-outlined">close</span></button>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Layanan Utama</p>
            
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-500 hover:bg-slate-50 rounded-2xl font-semibold transition">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            
            <a href="<?= base_url('admin/data-ibu') ?>" class="flex items-center gap-4 px-4 py-3.5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 transition">
                <span class="material-symbols-outlined font-variation-fill">groups</span> Data Ibu & Anak
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3 p-2 bg-white rounded-2xl border border-slate-100 mb-4">
                <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold">BN</div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-800 truncate">Bidan Nurul</p>
                    <p class="text-[10px] text-slate-400 italic">Pusk. Banjarbaru</p>
                </div>
            </div>
            <a href="<?= base_url('admin/logout') ?>" class="flex items-center justify-center gap-2 py-3 w-full bg-rose-50 text-rose-600 font-bold text-xs rounded-xl hover:bg-rose-100 transition">
                <span class="material-symbols-outlined text-sm">logout</span> KELUAR SISTEM
            </a>
        </div>
    </aside>

    <main class="flex-1 min-w-0 p-4 lg:p-10 animate-slide-up">
        <div class="lg:hidden flex items-center justify-between mb-8 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="toggleSidebar()" class="size-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <span class="font-black text-primary italic uppercase">SI CUBIT</span>
            <div class="size-10 rounded-xl bg-slate-100"></div>
        </div>

        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase italic">Database Ibu & Anak</h1>
                <p class="text-slate-400 font-medium mt-1">Daftar Rekam Medis Pasien Poltekkes / Puskesmas Terintegrasi.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="bg-primary text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:bg-blue-800 transition italic">
                    Tambah Bunda Baru +
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
                            <th class="px-10 py-6">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody" class="divide-y divide-slate-50 text-slate-700">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="px-10 py-10 text-center text-slate-400 italic">Belum ada data ibu terdaftar.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $u): ?>
                                <tr class="user-row hover:bg-slate-50/50 transition duration-300" data-kabkota="<?= esc($u['id_kabkota']) ?>" data-puskesmas="<?= esc($u['id_puskesmas']) ?>">
                                    <td class="px-10 py-7">
                                        <div class="flex items-center gap-4">
                                            <div class="size-10 rounded-xl bg-blue-100 flex items-center justify-center font-bold text-primary">
                                                <?= strtoupper(substr($u['nama'], 0, 2)) ?>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm italic uppercase tracking-tighter user-name"><?= esc($u['nama']) ?></p>
                                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">WhatsApp: <?= esc($u['no_telp']) ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-7 text-xs font-semibold italic text-slate-500 user-domisili">
                                        <?= esc($u['nama_puskesmas']) ?>, <?= esc($u['nama_kabkota']) ?>
                                    </td>
                                    <td class="px-10 py-7 text-center">
                                        <span class="bg-blue-50 text-primary text-[9px] font-black px-3 py-1.5 rounded-lg uppercase italic">
                                            <?= str_replace('_', ' ', strtoupper($u['status_kehamilan'] ?? 'PRANIKAH')) ?>
                                        </span>
                                    </td>
                                    <td class="px-10 py-7 text-center">
                                        <?php if ($u['status_asi'] === 'Ya'): ?>
                                            <span class="bg-green-100 text-green-700 text-[9px] font-black px-3 py-1.5 rounded-lg uppercase italic">ASI CUKUP</span>
                                        <?php elseif ($u['status_asi'] === 'Tidak'): ?>
                                            <span class="bg-rose-600 text-white text-[9px] font-black px-3 py-1.5 rounded-lg uppercase italic shadow-sm">ASI KURANG</span>
                                        <?php else: ?>
                                            <span class="bg-slate-100 text-slate-400 text-[9px] font-black px-3 py-1.5 rounded-lg uppercase italic">BELUM ISI</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-10 py-7">
                                        <a href="<?= base_url('admin/detail/' . $u['id']) ?>" class="text-[10px] font-black text-primary hover:underline italic tracking-widest uppercase">Lihat Rekam Medis</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-8 bg-slate-50/30 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-slate-50">
                <div class="flex items-center gap-3">
                    <p id="showingCount" class="text-[10px] font-bold text-slate-400 uppercase italic">Menampilkan <?= count($users) ?> Bunda</p>
                    <div class="w-px h-4 bg-slate-200 hidden md:block"></div>
                    <select id="perPage" class="bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-500 py-1.5 pl-3 pr-8 focus:ring-2 focus:ring-primary/20">
                        <option value="5">5 / Halaman</option>
                        <option value="10">10 / Halaman</option>
                        <option value="20" selected>20 / Halaman</option>
                        <option value="50">50 / Halaman</option>
                    </select>
                </div>
                <div id="paginationControls" class="flex gap-2">
                    <!-- Pagination buttons injected via JS -->
                </div>
            </div>
        </div>

        <footer class="mt-20 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-slate-100 pt-10 pb-10 opacity-60">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill">school</span>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] italic">POLTEKKES • COMPUTER SCIENCE ULM</p>
            </div>
            <p class="text-[10px] font-bold text-slate-400 italic italic">Sistem Informasi Monitoring Kesehatan Terpadu</p>
        </footer>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Live Search, Dropdown Filter, & Pagination
        const searchInput = document.getElementById('searchInput');
        const filterKabkota = document.getElementById('filterKabkota');
        const filterPuskesmas = document.getElementById('filterPuskesmas');
        const perPageSelect = document.getElementById('perPage');
        
        let currentPage = 1;
        let rowsPerPage = parseInt(perPageSelect.value) || 20;

        perPageSelect.addEventListener('change', function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            filterData();
        });

        function changePage(page) {
            currentPage = page;
            filterData();
        }

        function renderPagination(totalVisible, totalPages) {
            const container = document.getElementById('paginationControls');
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
                    pageBtn.className = `size-8 rounded-lg text-xs font-bold transition flex items-center justify-center ${currentPage === i ? 'bg-primary text-white shadow-md' : 'border border-slate-200 text-slate-500 hover:bg-white'}`;
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

        // Initialize display
        filterData();

        searchInput.addEventListener('input', () => { currentPage = 1; filterData(); });
        filterPuskesmas.addEventListener('change', () => { currentPage = 1; filterData(); });
        
        // Cascade dropdown: When KabKota changes, filter Puskesmas options
        filterKabkota.addEventListener('change', function() {
            currentPage = 1;
            
            // Show/hide options in Puskesmas dropdown
            const puskesmasOptions = filterPuskesmas.querySelectorAll('option');
            
            puskesmasOptions.forEach(opt => {
                if (opt.value === "") {
                    opt.style.display = ''; // Always show "SEMUA PUSKESMAS"
                } else if (!kabkotaId || opt.getAttribute('data-kabkota') === kabkotaId) {
                    opt.style.display = '';
                } else {
                    opt.style.display = 'none';
                }
            });
            
            // Reset puskesmas selection
            filterPuskesmas.value = "";
            filterData();
        });
    </script>
</body>
</html>