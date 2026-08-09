<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
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

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white/95 backdrop-blur-md border-r border-white/60 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen shadow-xl">
        <div class="p-6 flex items-center justify-between">
            <div class="bg-white/90 px-4 py-2 rounded-full shadow border border-slate-200 flex items-center gap-2">
                <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes" class="h-10 object-contain">
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 p-2"><span class="material-symbols-outlined">close</span></button>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Portal Admin SiCubit</p>
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-4 px-4 py-3.5 bg-[#162065] text-white rounded-2xl font-bold shadow-lg transition">
                <span class="material-symbols-outlined">dashboard</span> Dashboard Utama
            </a>
            <a href="<?= base_url('admin/data-ibu') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-700 hover:bg-slate-100 rounded-2xl font-bold transition">
                <span class="material-symbols-outlined">groups</span> Data Ibu & Anak
            </a>
            <a href="<?= base_url('admin/video') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-700 hover:bg-slate-100 rounded-2xl font-bold transition">
                <span class="material-symbols-outlined">smart_display</span> Kelola Video Edukasi
            </a>
            <a href="<?= base_url('admin/kategori-video') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-700 hover:bg-slate-100 rounded-2xl font-bold transition">
                <span class="material-symbols-outlined">category</span> Kategori Video
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
            <span class="font-black text-primary italic">SI CUBIT</span>
            <div class="size-10 rounded-xl bg-slate-100"></div>
        </div>

        <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase italic">Panel Kendali Bidan</h1>
                <p class="text-slate-400 font-medium mt-1">Pemantauan Terpadu Puskesmas Banjarbaru, Kabupaten Banjarbaru.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?= base_url('admin/export-spreadsheet') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">table_view</span> Download Excel
                </a>
                <a href="<?= base_url('admin/data-ibu') ?>?openSheetsModal=1" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">sync</span> Sync Google Sheets
                </a>
                <div class="bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">calendar_month</span>
                    <span class="text-xs font-bold text-slate-700 italic"><?= date('d F Y') ?></span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100 group">
                <div class="size-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Ibu Terdaftar</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter"><?= number_format($totalIbu) ?></h3>
            </div>

            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100 group">
                <div class="size-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined">assignment_late</span>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Perlu Validasi</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter"><?= $perluCek ?></h3>
            </div>

            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100 group">
                <div class="size-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined">heart_broken</span>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Resiko Tinggi</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter"><?= $resikoTinggi ?></h3>
            </div>

            <div class="bg-primary p-7 rounded-[2.5rem] text-white relative overflow-hidden group">
                <span class="material-symbols-outlined absolute -right-4 -top-4 text-[120px] opacity-10">water_drop</span>
                <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-1">Google Sheets Sync</p>
                <h3 class="text-2xl font-black tracking-tighter italic uppercase"><?= date('F Y') ?></h3>
                <p class="text-[10px] text-blue-100 font-bold mt-2 italic truncate">Terakhir: <?= esc($last_synced_at) ?></p>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="font-black text-slate-800 italic flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary font-variation-fill">monitoring</span>
                    PEMANTAUAN DATA MASUK
                </h3>
                <div class="flex gap-2">
                    <a href="<?= base_url('admin/export-spreadsheet') ?>" class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-emerald-100">
                        <span class="material-symbols-outlined text-sm">table_view</span> Ekspor Bulanan (.xls)
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-slate-400 text-[10px] font-black tracking-[0.1em] uppercase">
                        <tr>
                            <th class="px-10 py-6">IDENTITAS BUNDA</th>
                            <th class="px-10 py-6">STATUS GIZI</th>
                            <th class="px-10 py-6 text-center">KELANCARAN ASI</th>
                            <th class="px-10 py-6">PROGRESS DATA</th>
                            <th class="px-10 py-6">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-slate-50/50 transition duration-300 user-row">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-primary">
                                            <?= strtoupper(substr($u['nama'], 0, 2)) ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm italic uppercase tracking-tighter">
                                                <?= esc($u['nama']) ?></p>
                                            <p class="text-[10px] text-slate-400"><?= esc($u['nama_puskesmas'] ?? '-') ?> • <?= esc($u['umur'] ?? '-') ?> Thn</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-2 text-xs font-bold text-green-600">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span> NORMAL
                                    </div>
                                </td>
                                <td class="px-10 py-7 text-center">
                                    <?php if ($u['status_asi'] === 'Cukup'): ?>
                                        <span class="bg-green-100 text-green-700 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider">CUKUP</span>
                                    <?php elseif (in_array($u['status_asi'], ['Kurang', 'Tidak Cukup'])): ?>
                                        <span class="bg-rose-600 text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider">KURANG</span>
                                    <?php else: ?>
                                        <span class="bg-slate-100 text-slate-400 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider">BELUM ISI</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-10 py-7 text-xs font-bold text-slate-500">
                                    <?= date('d/m/Y', strtotime($u['created_at'])) ?>
                                </td>
                                <td class="px-10 py-7">
                                    <a href="<?= base_url('admin/detail/' . $u['id']) ?>" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl text-[10px] font-black hover:bg-primary transition uppercase tracking-widest italic">DETAIL</a>
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

        <footer class="mt-20 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-slate-100 pt-10 pb-10 opacity-60">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill">school</span>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] italic">POLTEKKES</p>
            </div>
            <p class="text-[10px] font-bold text-slate-400 italic">Project Investigasi Kesehatan Ibu & Anak</p>
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

        const rowsPerPage = 5;
        let currentPage = 1;

        function renderPagination(totalRows, totalPages) {
            const container = document.getElementById('pagination');
            container.innerHTML = '';
            
            if (totalPages <= 1) return;
            
            const prevBtn = document.createElement('button');
            prevBtn.className = `size-8 rounded-lg border border-slate-200 flex items-center justify-center transition ${currentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-slate-500 hover:bg-white cursor-pointer'}`;
            prevBtn.innerHTML = '<span class="material-symbols-outlined text-sm">chevron_left</span>';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => changePage(currentPage - 1);
            container.appendChild(prevBtn);
            
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
            const rows = document.querySelectorAll('.user-row');
            const totalVisible = rows.length;
            const totalPages = Math.ceil(totalVisible / rowsPerPage);
            if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
            if (totalPages === 0) currentPage = 1;

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            
            rows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('showingCount').textContent = `Menampilkan ${Math.min(endIndex, totalVisible)} dari ${totalVisible} Bunda`;
            renderPagination(totalVisible, totalPages);
        }

        filterData();
    </script>
</body>

</html>