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

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- ADMIN SIDEBAR -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white/95 backdrop-blur-md border-r border-white/60 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen shadow-xl">
        <div class="p-6 flex items-center justify-between">
            <div class="bg-white/90 px-3 py-1.5 rounded-full shadow border border-slate-200 flex items-center gap-2">
                <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes" class="h-8 object-contain">
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 p-2"><span class="material-symbols-outlined">close</span></button>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Portal Admin SiCubit</p>
            
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-700 hover:bg-slate-100 rounded-2xl font-bold transition">
                <span class="material-symbols-outlined">dashboard</span> Dashboard Utama
            </a>
            <a href="<?= base_url('admin/data-ibu') ?>" class="flex items-center gap-4 px-4 py-3.5 text-slate-700 hover:bg-slate-100 rounded-2xl font-bold transition">
                <span class="material-symbols-outlined">groups</span> Data Ibu & Anak
            </a>
            <a href="<?= base_url('admin/pengolahan') ?>" class="flex items-center gap-4 px-4 py-3.5 bg-[#162065] text-white rounded-2xl font-bold shadow-lg transition">
                <span class="material-symbols-outlined">analytics</span> Pengolahan Data & Sync
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

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 min-w-0 p-4 lg:p-10 animate-slide-up">
        
        <div class="lg:hidden flex items-center justify-between mb-8 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="toggleSidebar()" class="size-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <span class="font-black text-primary italic uppercase">SI CUBIT ADMIN</span>
            <div class="size-10 rounded-xl bg-slate-100"></div>
        </div>

        <!-- HEADER TITLE & ACTIONS -->
        <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase italic">Pengolahan Data & Rujukan</h1>
                <p class="text-slate-500 font-medium mt-1">Analisis Risiko Kejiwaan EPDS, Evaluasi Kelancaran ASI, & Sinkronisasi Google Sheets.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?= base_url('admin/export-spreadsheet') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">table_view</span> Download Excel Multi-Tab (.xls)
                </a>
                <button onclick="openSheetsModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/20 transition italic flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">sync</span> Sync Google Sheets
                </button>
            </div>
        </header>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Terdaftar</span>
                    <div class="size-10 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">groups</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tighter"><?= $summary_stats['total_ibu'] ?> <span class="text-xs font-bold text-slate-400">Bunda</span></h3>
                <p class="text-[10px] text-slate-400 mt-2">Terhubung di database</p>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Memerlukan Rujukan</span>
                    <div class="size-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center animate-pulse">
                        <span class="material-symbols-outlined text-xl font-variation-fill">warning</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-rose-600 tracking-tighter"><?= $summary_stats['kejiwaan_berisiko'] ?> <span class="text-xs font-bold text-slate-400">Kasus</span></h3>
                <p class="text-[10px] text-rose-500 font-semibold mt-2">Indikasi EPDS ≥ 10 / Q10 > 0</p>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">ASI Terpenuhi</span>
                    <div class="size-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl font-variation-fill">verified</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tighter"><?= $summary_stats['asi_lancar'] ?> <span class="text-xs font-bold text-slate-400">Ibu</span></h3>
                <p class="text-[10px] text-emerald-600 font-bold mt-2">Kecukupan ASI normal</p>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">ASI Perlu Evaluasi</span>
                    <div class="size-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">opacity</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tighter"><?= $summary_stats['asi_perlu_evaluasi'] ?> <span class="text-xs font-bold text-slate-400">Ibu</span></h3>
                <p class="text-[10px] text-amber-600 font-bold mt-2">Membutuhkan edukasi laktasi</p>
            </div>
        </div>

        <!-- PENGOLAHAN TABS SECTION -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden mb-12">
            
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button onclick="switchTab('epdsTab')" id="btnEpdsTab" class="px-5 py-3 rounded-2xl text-xs font-bold transition flex items-center gap-2 bg-[#162065] text-white shadow-md">
                        <span class="material-symbols-outlined text-base">psychology</span> Screening EPDS & Rujukan
                    </button>
                    <button onclick="switchTab('asiTab')" id="btnAsiTab" class="px-5 py-3 rounded-2xl text-xs font-bold transition flex items-center gap-2 text-slate-600 hover:bg-slate-200/60">
                        <span class="material-symbols-outlined text-base">monitor_heart</span> Evaluasi Kelancaran ASI
                    </button>
                    <button onclick="switchTab('sheetTab')" id="btnSheetTab" class="px-5 py-3 rounded-2xl text-xs font-bold transition flex items-center gap-2 text-slate-600 hover:bg-slate-200/60">
                        <span class="material-symbols-outlined text-base">table_view</span> Live Spreadsheet Database
                    </button>
                </div>
                <div class="text-[11px] text-slate-400 italic">
                    Pengolahan Terpadu Sesuai Database & Spreadsheet
                </div>
            </div>

            <!-- TAB 1: SCREENING EPDS & RUJUKAN MEDIS -->
            <div id="epdsTabSection" class="p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-black text-slate-800 text-lg uppercase italic tracking-tight">Hasil Screening EPDS Kejiwaan Ibu</h3>
                        <p class="text-xs text-slate-500">Daftar riwayat pemeriksaan Edinburgh Postnatal Depression Scale pasien.</p>
                    </div>
                </div>

                <div class="overflow-x-auto no-scrollbar border border-slate-100 rounded-3xl">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 text-white text-[10px] font-black tracking-wider uppercase">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Tgl Screening</th>
                                <th class="px-6 py-4">Nama Ibu</th>
                                <th class="px-6 py-4">Puskesmas</th>
                                <th class="px-6 py-4 text-center">Skor EPDS</th>
                                <th class="px-6 py-4 text-center">Pikiran Sakiti Diri (Q10)</th>
                                <th class="px-6 py-4">Status EPDS</th>
                                <th class="px-6 py-4 text-center">Status Rujukan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <?php if (!empty($epdsLogs)): ?>
                                <?php foreach ($epdsLogs as $idx => $e): ?>
                                    <?php 
                                        $q10 = (int)($e['epds_q10'] ?? 0);
                                        $skor = (int)($e['epds_skor'] ?? 0);
                                        $isUrgent = ($skor >= 10 || $q10 > 0);
                                    ?>
                                    <tr class="hover:bg-slate-50 transition <?= $isUrgent ? 'bg-rose-50/40' : '' ?>">
                                        <td class="px-6 py-4 font-bold text-slate-400"><?= $idx + 1 ?></td>
                                        <td class="px-6 py-4 font-semibold text-slate-600"><?= date('d/m/Y H:i', strtotime($e['tgl_pengisian'])) ?></td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-slate-800"><?= esc($e['nama_ibu']) ?></p>
                                            <p class="text-[10px] text-slate-400"><?= esc($e['no_telp'] ?? '-') ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 font-medium"><?= esc($e['nama_puskesmas'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-center font-black text-slate-800 text-sm"><?= $skor ?> Poin</td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($q10 > 0): ?>
                                                <span class="px-3 py-1 bg-rose-600 text-white rounded-lg font-black text-[10px] uppercase animate-pulse">YA (Skor <?= $q10 ?>)</span>
                                            <?php else: ?>
                                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg font-bold text-[10px]">Tidak (0)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-slate-700">
                                            <?= esc($e['epds_status'] ?? ($e['status_kejiwaan'] ?? '-')) ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($isUrgent): ?>
                                                <span class="px-3 py-1.5 bg-rose-100 text-rose-700 border border-rose-200 rounded-xl font-black text-[10px] uppercase tracking-wider">MEMERLUKAN RUJUKAN SEGERA</span>
                                            <?php else: ?>
                                                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl font-bold text-[10px] uppercase">Normal / Aman</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $e['no_telp'] ?? '') ?>" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[10px] shadow transition">
                                                <span class="material-symbols-outlined text-xs">chat</span> WA Bunda
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="p-8 text-center text-slate-400 italic">Belum ada data riwayat screening EPDS.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: EVALUASI KELANCARAN ASI -->
            <div id="asiTabSection" class="p-6 md:p-8 space-y-6 hidden">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-black text-slate-800 text-lg uppercase italic tracking-tight">Evaluasi Kelancaran ASI Harian</h3>
                        <p class="text-xs text-slate-500">Daftar riwayat kecukupan dan durasi menyusui bayi.</p>
                    </div>
                </div>

                <div class="overflow-x-auto no-scrollbar border border-slate-100 rounded-3xl">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 text-white text-[10px] font-black tracking-wider uppercase">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Tgl Pengisian</th>
                                <th class="px-6 py-4">Nama Ibu</th>
                                <th class="px-6 py-4">Puskesmas</th>
                                <th class="px-6 py-4 text-center">Frekuensi Menyusui</th>
                                <th class="px-6 py-4 text-center">Lama Menyusui</th>
                                <th class="px-6 py-4 text-center">Payudara Penuh</th>
                                <th class="px-6 py-4 text-center">Bayi Tenang</th>
                                <th class="px-6 py-4 text-center">Status Kecukupan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <?php if (!empty($asiLogs)): ?>
                                <?php foreach ($asiLogs as $idx => $a): ?>
                                    <?php $isCukup = ($a['status_kecukupan_asi'] === 'Ya' || $a['status_kecukupan_asi'] === 'Cukup'); ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 font-bold text-slate-400"><?= $idx + 1 ?></td>
                                        <td class="px-6 py-4 font-semibold text-slate-600"><?= date('d/m/Y H:i', strtotime($a['tgl_pengisian'])) ?></td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-slate-800"><?= esc($a['nama_ibu']) ?></p>
                                            <p class="text-[10px] text-slate-400"><?= esc($a['no_telp'] ?? '-') ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 font-medium"><?= esc($a['nama_puskesmas'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-center font-bold text-slate-800"><?= esc($a['frekuensi_menyusui'] ?? '0') ?> kali/hari</td>
                                        <td class="px-6 py-4 text-center font-bold text-slate-800"><?= esc($a['lama_menyusui'] ?? '0') ?> menit</td>
                                        <td class="px-6 py-4 text-center font-semibold text-slate-700"><?= esc($a['payudara_penuh'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-center font-semibold text-slate-700"><?= esc($a['bayi_tenang_setelah_menyusu'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($isCukup): ?>
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl font-bold text-[10px] uppercase">Terpenuhi / Cukup</span>
                                            <?php else: ?>
                                                <span class="px-3 py-1 bg-rose-100 text-rose-700 border border-rose-200 rounded-xl font-black text-[10px] uppercase">Perlu Evaluasi</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="p-8 text-center text-slate-400 italic">Belum ada data riwayat evaluasi ASI.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            <!-- TAB 3: LIVE SPREADSHEET DATABASE (MASTER IBU & DATA PASIEN) -->
            <div id="sheetTabSection" class="p-6 md:p-8 space-y-6 hidden">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="font-black text-slate-800 text-lg uppercase italic tracking-tight">Master Data Spreadsheet (Mirroring Database)</h3>
                        <p class="text-xs text-slate-500">Tampilan tabel live spreadsheet utuh yang siap digunakan dan diunduh tanpa perlu konfigurasi external.</p>
                    </div>
                    <a href="<?= base_url('admin/export-spreadsheet') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider shadow-md transition flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">download</span> Unduh Excel Spreadsheet (.xls)
                    </a>
                </div>

                <div class="overflow-x-auto no-scrollbar border border-slate-100 rounded-3xl">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 text-white text-[10px] font-black tracking-wider uppercase">
                            <tr>
                                <th class="px-5 py-4">No</th>
                                <th class="px-5 py-4">Tgl Daftar</th>
                                <th class="px-5 py-4">Nama Ibu</th>
                                <th class="px-5 py-4">Umur</th>
                                <th class="px-5 py-4">No. Telepon</th>
                                <th class="px-5 py-4">Puskesmas</th>
                                <th class="px-5 py-4">Kab/Kota</th>
                                <th class="px-5 py-4">Status Kehamilan</th>
                                <th class="px-5 py-4 text-center">Kelancaran ASI</th>
                                <th class="px-5 py-4 text-center">Kondisi Kejiwaan</th>
                                <th class="px-5 py-4">Alamat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $idx => $u): ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-4 font-bold text-slate-400"><?= $idx + 1 ?></td>
                                        <td class="px-5 py-4 font-semibold text-slate-600"><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></td>
                                        <td class="px-5 py-4 font-bold text-slate-800"><?= esc($u['nama']) ?></td>
                                        <td class="px-5 py-4 font-semibold text-slate-700"><?= esc($u['umur'] ?? '-') ?> thn</td>
                                        <td class="px-5 py-4 font-semibold text-slate-700"><?= esc($u['no_telp'] ?? '-') ?></td>
                                        <td class="px-5 py-4 text-slate-600 font-medium"><?= esc($u['nama_puskesmas'] ?? '-') ?></td>
                                        <td class="px-5 py-4 text-slate-600 font-medium"><?= esc($u['nama_kabkota'] ?? '-') ?></td>
                                        <td class="px-5 py-4 font-bold text-slate-700 uppercase text-[10px]"><?= str_replace('_', ' ', esc($u['status_kehamilan'] ?? '-')) ?></td>
                                        <td class="px-5 py-4 text-center">
                                            <?php if ($u['status_asi'] === 'Cukup'): ?>
                                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg font-black text-[10px] uppercase">Cukup</span>
                                            <?php elseif (in_array($u['status_asi'], ['Kurang', 'Tidak Cukup'])): ?>
                                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-lg font-black text-[10px] uppercase">Kurang</span>
                                            <?php else: ?>
                                                <span class="px-2.5 py-1 bg-slate-100 text-slate-400 rounded-lg font-bold text-[10px]">Belum Isi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="px-2.5 py-1 bg-blue-50 text-primary rounded-lg font-bold text-[10px] uppercase">Aktif</span>
                                        </td>
                                        <td class="px-5 py-4 text-slate-500 italic max-w-xs truncate"><?= esc($u['alamat'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="p-8 text-center text-slate-400 italic">Belum ada data ibu terdaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <!-- MODAL GOOGLE SHEETS SINKRONISASI -->
    <div id="sheetsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 w-full max-w-3xl overflow-hidden max-h-[90vh] flex flex-col">
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

            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-slate-700 text-xs">
                
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

                <form id="formSheetsConfig" onsubmit="saveSheetsConfig(event)" class="bg-white p-5 rounded-2xl border border-slate-200 space-y-4">
                    <h4 class="font-black text-slate-800 text-sm uppercase italic tracking-tight flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">settings</span> Pengaturan URL Spreadsheet & Webhook
                    </h4>
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-500 mb-1">URL Webhook Google Apps Script</label>
                        <input type="url" id="google_webhook_url" name="google_webhook_url" value="<?= esc($google_webhook_url) ?>" placeholder="https://script.google.com/macros/s/.../exec" class="w-full bg-slate-50 border-slate-200 rounded-xl text-xs py-2.5 px-3 focus:ring-2 focus:ring-primary/20"/>
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

                <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/50">
                    <button onclick="toggleAppsScriptGuide()" class="w-full p-4 bg-slate-100 hover:bg-slate-200/60 transition flex items-center justify-between font-bold text-slate-800 text-xs">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">code</span>
                            Panduan Setup Google Apps Script Multi-Tab (Otomatis Buat 3 Sheet Tab)
                        </span>
                        <span id="guideChevron" class="material-symbols-outlined text-slate-500">expand_more</span>
                    </button>
                    <div id="appsScriptGuide" class="p-5 space-y-4 hidden bg-white">
                        <ol class="list-decimal list-inside space-y-2 text-slate-600 text-[11px] leading-relaxed">
                            <li>Buka <b>Google Sheets</b> baru atau yang sudah ada di akun Google Anda.</li>
                            <li>Pada menu atas, klik <b>Extensions (Ekstensi)</b> &rarr; <b>Apps Script</b>.</li>
                            <li>Hapus seluruh kode default di editor Apps Script.</li>
                            <li>Salin (Copy) kode Apps Script di bawah ini dan **Paste** ke editor:</li>
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
                            <li>Set <b>Who has access</b> ke: <b>Anyone (Siapa saja)</b>.</li>
                            <li>Klik <b>Deploy</b>, izinkan akses, lalu tempel URL Webhook pada input di atas.</li>
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
                    text: 'Kode Apps Script telah disalin ke clipboard Anda.',
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        }

        function switchTab(tabName) {
            const btnEpds = document.getElementById('btnEpdsTab');
            const btnAsi = document.getElementById('btnAsiTab');
            const btnSheet = document.getElementById('btnSheetTab');
            
            const secEpds = document.getElementById('epdsTabSection');
            const secAsi = document.getElementById('asiTabSection');
            const secSheet = document.getElementById('sheetTabSection');

            // Reset classes
            const inactiveClass = "px-5 py-3 rounded-2xl text-xs font-bold transition flex items-center gap-2 text-slate-600 hover:bg-slate-200/60";
            const activeClass = "px-5 py-3 rounded-2xl text-xs font-bold transition flex items-center gap-2 bg-[#162065] text-white shadow-md";

            btnEpds.className = inactiveClass;
            btnAsi.className = inactiveClass;
            if (btnSheet) btnSheet.className = inactiveClass;

            secEpds.classList.add('hidden');
            secAsi.classList.add('hidden');
            if (secSheet) secSheet.classList.add('hidden');

            if (tabName === 'epdsTab') {
                btnEpds.className = activeClass;
                secEpds.classList.remove('hidden');
            } else if (tabName === 'asiTab') {
                btnAsi.className = activeClass;
                secAsi.classList.remove('hidden');
            } else if (tabName === 'sheetTab') {
                if (btnSheet) btnSheet.className = activeClass;
                if (secSheet) secSheet.classList.remove('hidden');
            }
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
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menyimpan.' });
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
                        confirmButtonColor: '#162065'
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: data.message,
                        confirmButtonColor: '#162065'
                    });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menyambung ke server.' });
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }
    </script>
</body>
</html>
