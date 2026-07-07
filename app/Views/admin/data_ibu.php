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
            <a href="<?= base_url('admin/login') ?>" class="flex items-center justify-center gap-2 py-3 w-full bg-rose-50 text-rose-600 font-bold text-xs rounded-xl hover:bg-rose-100 transition">
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
            <div class="flex gap-2">
                <select class="bg-slate-50 border-none rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 px-6 py-4 focus:ring-2 focus:ring-primary/20">
                    <option>Semua Wilayah</option>
                    <option>Banjarbaru Selatan</option>
                    <option>Rantau</option>
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
                                <tr class="user-row hover:bg-slate-50/50 transition duration-300">
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
            
            <div class="p-8 bg-slate-50/30 flex items-center justify-between border-t border-slate-50">
                <p id="showingCount" class="text-[10px] font-bold text-slate-400 uppercase italic">Menampilkan <?= count($users) ?> Bunda</p>
                <div class="flex gap-2">
                    <button class="size-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-white transition"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                    <button class="size-8 rounded-lg bg-primary text-white flex items-center justify-center text-xs font-bold">1</button>
                    <button class="size-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-white transition"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
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

        // Live Search Filter
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.user-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.user-name').textContent.toLowerCase();
                const domisili = row.querySelector('.user-domisili').textContent.toLowerCase();
                
                if (name.includes(query) || domisili.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('showingCount').textContent = `Menampilkan ${visibleCount} Bunda`;
        });
    </script>
</body>
</html>