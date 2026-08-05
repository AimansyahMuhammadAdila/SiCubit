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

    <!-- SIDEBAR -->
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
            <a href="<?= base_url('admin/data-ibu') ?>" class="flex items-center gap-4 px-4 py-3.5 bg-[#162065] text-white rounded-2xl font-bold shadow-lg transition">
                <span class="material-symbols-outlined">groups</span> Data Ibu & Anak
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 min-w-0 p-4 lg:p-10 space-y-8 animate-slide-up">
        <div class="lg:hidden flex items-center justify-between mb-8 bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            <button onclick="toggleSidebar()" class="size-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            <span class="font-black text-primary italic uppercase">SI CUBIT</span>
            <div class="size-10 rounded-xl bg-slate-100"></div>
        </div>

        <!-- HEADER -->
        <header class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <a href="<?= base_url('admin/data-ibu') ?>" class="size-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">Rekam Medis Terintegrasi</h1>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Detail informasi medis, screening kejiwaan, dan laktasi Bunda.</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- GRID DETAIL UTAMA -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- BIODATA IBU -->
            <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm flex flex-col gap-5 h-fit">
                <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                    <div class="size-14 rounded-2xl bg-blue-50 text-primary flex items-center justify-center font-black text-xl">
                        <?= strtoupper(substr($user['nama'], 0, 2)) ?>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800 text-lg italic uppercase tracking-tighter"><?= esc($user['nama']) ?></h3>
                        <span class="px-2.5 py-1 rounded bg-blue-100 text-primary font-bold text-[9px] uppercase tracking-widest">
                            <?= str_replace('_', ' ', strtoupper($user['status_kehamilan'] ?? 'PRANIKAH')) ?>
                        </span>
                    </div>
                </div>

                <div class="space-y-4 text-xs font-semibold text-slate-700">
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Umur</span>
                        <span><?= esc($user['umur']) ?> Tahun</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">WhatsApp</span>
                        <span><?= esc($user['no_telp']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Pekerjaan</span>
                        <span><?= esc($user['pekerjaan'] ?: '-') ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Jumlah Anak</span>
                        <span><?= esc($user['jumlah_anak']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Puskesmas</span>
                        <span><?= esc($user['nama_puskesmas']) ?></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Kabupaten/Kota</span>
                        <span><?= esc($user['nama_kabkota']) ?></span>
                    </div>
                    <div class="flex flex-col gap-1 py-1">
                        <span class="text-slate-400 uppercase tracking-wider text-[9px]">Alamat</span>
                        <span class="text-[11px] leading-relaxed text-slate-600 font-medium"><?= esc($user['alamat'] ?: '-') ?></span>
                    </div>
                </div>
            </div>

            <!-- TABS RIWAYAT KESEHATAN -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD RIWAYAT MEDIS -->
                <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-sm space-y-6">
                    <h3 class="font-black text-slate-800 italic uppercase flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <span class="material-symbols-outlined text-primary font-variation-fill">history_edu</span>
                        RIWAYAT KEHAMILAN & PERSALINAN
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Pra Kehamilan -->
                        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pra Kehamilan</span>
                            <?php if (!empty($pra_kehamilan)): ?>
                                <p class="text-xs font-bold text-slate-700">BB Sebelum: <span class="text-primary"><?= (float)$pra_kehamilan['bb_sebelum_hamil'] ?> kg</span></p>
                                <p class="text-[11px] text-slate-500 font-medium">Keguguran: <?= esc($pra_kehamilan['riwayat_abortus']) ?></p>
                                <p class="text-[11px] text-slate-500 font-medium">Penyakit: <?= esc($pra_kehamilan['riwayat_penyakit'] ?: 'Tidak ada') ?></p>
                            <?php else: ?>
                                <span class="text-xs text-slate-400 italic">Belum ada data</span>
                            <?php endif; ?>
                        </div>

                        <!-- Masa Kehamilan -->
                        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Masa Kehamilan</span>
                            <?php if (!empty($kehamilan)): ?>
                                <p class="text-xs font-bold text-slate-700">Kehamilan Ke: <span class="text-primary"><?= $kehamilan['kehamilan_ke'] ?></span></p>
                                <p class="text-[11px] text-slate-500 font-medium">Kadar Hb: <?= (float)$kehamilan['kadar_hb'] ?> g/dL</p>
                                <p class="text-[11px] text-slate-500 font-medium">Ukuran LiLA: <?= (float)$kehamilan['ukuran_lila'] ?> cm</p>
                                <p class="text-[11px] text-slate-500 font-medium">ANC: <?= $kehamilan['kunjungan_anc'] ?> Kali</p>
                            <?php else: ?>
                                <span class="text-xs text-slate-400 italic">Belum ada data</span>
                            <?php endif; ?>
                        </div>

                        <!-- Persalinan -->
                        <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100 flex flex-col gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Persalinan</span>
                            <?php if (!empty($persalinan)): ?>
                                <p class="text-xs font-bold text-slate-700">Metode: <span class="text-primary"><?= esc($persalinan['cara_persalinan']) ?></span></p>
                                <p class="text-[11px] text-slate-500 font-medium">Umur Lahir: <?= $persalinan['umur_kehamilan_salin'] ?> Minggu</p>
                                <p class="text-[11px] text-slate-500 font-medium">Inisiasi IMD: <?= esc($persalinan['imd']) ?></p>
                            <?php else: ?>
                                <span class="text-xs text-slate-400 italic">Belum ada data</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- CARD DETAIL BAYI -->
                <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-sm space-y-6">
                    <h3 class="font-black text-slate-800 italic uppercase flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <span class="material-symbols-outlined text-teal-500 font-variation-fill">child_care</span>
                        INFORMASI DIMENSI & REFLEKS BAYI
                    </h3>

                    <?php if (empty($riwayat_bayi)): ?>
                        <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data tumbuh kembang bayi.</p>
                    <?php else: 
                        $b = $riwayat_bayi[0]; // Ambil data terupdate
                    ?>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs font-semibold">
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Berat Badan</span>
                                <span class="text-sm font-bold text-slate-800"><?= number_format($b['bb']) ?> gram</span>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Panjang Badan</span>
                                <span class="text-sm font-bold text-slate-800"><?= (float)$b['pb'] ?> cm</span>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Suhu Tubuh</span>
                                <span class="text-sm font-bold text-slate-800"><?= (float)$b['suhu'] ?> °C</span>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl">
                                <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Gol. Darah</span>
                                <span class="text-sm font-bold text-slate-800"><?= esc($b['golongan_darah'] ?: 'N/A') ?></span>
                            </div>
                        </div>

                        <!-- Refleks Primitif -->
                        <div class="bg-slate-50/50 rounded-2xl p-5 border border-slate-100 space-y-3">
                            <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">Respons Refleks Tumbuh Kembang</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                    <span>Rooting (Mencari)</span>
                                    <span class="font-bold text-green-600"><?= esc($b['reflek_mencari_puting'] ?? 'Ya') ?></span>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                    <span>Sucking (Mengisap)</span>
                                    <span class="font-bold text-green-600"><?= esc($b['reflek_mengisap'] ?? 'Ya') ?></span>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                    <span>Swallowing (Menelan)</span>
                                    <span class="font-bold text-green-600"><?= esc($b['reflek_menelan'] ?? 'Ya') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- EVALUASI MENTAL & LAKTASI -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- EVALUASI KEJIWAAN (EPDS) -->
            <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-sm space-y-6">
                <h3 class="font-black text-slate-800 italic uppercase flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="material-symbols-outlined text-rose-500 font-variation-fill">psychology</span>
                    KONDISI MENTAL IBU (EPDS)
                </h3>

                <?php if (empty($riwayat_kejiwaan)): ?>
                    <p class="text-xs text-slate-400 italic text-center py-6">Belum ada data screening kejiwaan.</p>
                <?php else: 
                    $latestKejiwaan = $riwayat_kejiwaan[0];
                    $epdsSkor = isset($latestKejiwaan['epds_skor']) ? (int)$latestKejiwaan['epds_skor'] : null;
                    $epdsQ10 = isset($latestKejiwaan['epds_q10']) ? (int)$latestKejiwaan['epds_q10'] : 0;
                    
                    if ($epdsSkor !== null) {
                        if ($epdsSkor <= 9) {
                            $epdsStatus = 'Normal / adaptasi emosional ringan';
                        } elseif ($epdsSkor <= 12) {
                            $epdsStatus = 'Kemungkinan baby blues';
                        } else {
                            $epdsStatus = 'Kemungkinan depresi postpartum';
                        }
                    } else {
                        $epdsStatus = $latestKejiwaan['epds_status'] ?? null;
                    }
                    
                    // Somatic checklist
                    $somaticSkor = $latestKejiwaan['skor_kejiwaan'] ?? 0;
                ?>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50">
                            <span class="text-[9px] text-slate-400 uppercase tracking-widest block mb-1">Skor EPDS Terakhir</span>
                            <?php if ($epdsSkor !== null): ?>
                                <span class="text-lg font-black text-slate-800"><?= $epdsSkor ?> Poin</span>
                                <p class="text-[10px] font-semibold text-slate-500 mt-1"><?= esc($epdsStatus) ?></p>
                            <?php else: ?>
                                <span class="text-xs text-slate-400 italic">Hanya cemas biasa</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50">
                            <span class="text-[9px] text-slate-400 uppercase tracking-widest block mb-1">Gejala Somatik Cemas</span>
                            <span class="text-lg font-black text-slate-800"><?= $somaticSkor ?> / 14 Gejala</span>
                            <p class="text-[10px] font-semibold text-slate-500 mt-1"><?= esc($latestKejiwaan['status_kejiwaan'] ?? 'Normal') ?></p>
                        </div>
                    </div>

                    <?php if (($epdsSkor !== null && $epdsSkor >= 10) || $epdsQ10 > 0): ?>
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-rose-500 animate-pulse font-variation-fill">warning</span>
                            <div class="text-xs text-rose-700 font-bold leading-normal">
                                MEMERLUKAN PERHATIAN DAN RUJUKAN SEGERA! <?= $epdsSkor >= 10 ? 'Terindikasi ' . esc($epdsStatus) . '.' : '' ?> <?= $epdsQ10 > 0 ? 'Terdapat indikasi pikiran menyakiti diri sendiri (Pertanyaan No. 10).' : '' ?> Memerlukan rujukan ke psikolog/psikiater atau faskes terdekat.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-4 rounded-2xl bg-green-50 border border-green-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-green-600 font-variation-fill">check_circle</span>
                            <div class="text-xs text-green-700 font-medium">
                                Kondisi mental Bunda terpantau stabil dalam batas Normal / adaptasi emosional ringan.
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- History logs -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Riwayat Screening</h4>
                        <div class="divide-y divide-slate-50 text-[11px] leading-relaxed max-h-[150px] overflow-y-auto pr-1">
                            <?php foreach ($riwayat_kejiwaan as $rj): ?>
                                <div class="flex justify-between py-2.5">
                                    <span class="font-bold text-slate-700"><?= date('d/m/Y', strtotime($rj['tgl_pengisian'])) ?></span>
                                    <span class="text-slate-500">
                                        <?= isset($rj['epds_skor']) ? 'EPDS: ' . $rj['epds_skor'] : 'Gejala Cemas: ' . $rj['skor_kejiwaan'] ?>
                                    </span>
                                    <span class="font-bold text-primary"><?= esc($rj['epds_status'] ?? $rj['status_kejiwaan']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- EVALUASI LAKTASI (ASI) -->
            <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-sm space-y-6">
                <h3 class="font-black text-slate-800 italic uppercase flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="material-symbols-outlined text-primary font-variation-fill">water_drop</span>
                    EVALUASI KELANCARAN LAKTASI
                </h3>

                <?php if (empty($riwayat_asi)): ?>
                    <p class="text-xs text-slate-400 italic text-center py-6">Belum ada data evaluasi ASI.</p>
                <?php else: 
                    $latestAsi = $riwayat_asi[0];
                    $isCukup = ($latestAsi['status_kecukupan_asi'] === 'Ya');
                    $asiBg = $isCukup ? 'bg-green-100 text-green-700' : 'bg-rose-600 text-white shadow-sm';
                ?>
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <span class="text-[9px] text-slate-400 uppercase tracking-widest block mb-1">Status Kelancaran Terakhir</span>
                            <span class="text-sm font-bold text-slate-800"><?= date('d/m/Y', strtotime($latestAsi['tgl_pengisian'])) ?></span>
                        </div>
                        <span class="text-[10px] font-black px-3.5 py-2 rounded-xl uppercase <?= $asiBg ?>">
                            <?= $isCukup ? 'ASI CUKUP' : 'ASI KURANG' ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-700">
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Frekuensi Menyusui</span>
                            <span><?= $latestAsi['frekuensi_menyusui'] ?> kali/hari</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Lama Menyusui</span>
                            <span><?= $latestAsi['lama_menyusui'] ?> menit/sesi</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">Pumping/Perah</span>
                            <span><?= (float)$latestAsi['volume_pumping'] ?> ml/sesi</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <span class="text-[9px] text-slate-400 uppercase tracking-wider block mb-1">BAB & BAK Bayi</span>
                            <span>BAB: <?= $latestAsi['frekuensi_bab_bayi'] ?>x • BAK: <?= $latestAsi['frekuensi_bak_bayi'] ?>x</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Catatan Tambahan Laktasi</h4>
                        <div class="divide-y divide-slate-50 text-[11px] leading-relaxed max-h-[100px] overflow-y-auto pr-1">
                            <?php foreach ($riwayat_asi as $ra): ?>
                                <div class="flex justify-between py-2">
                                    <span class="font-bold text-slate-700"><?= date('d/m/Y', strtotime($ra['tgl_pengisian'])) ?></span>
                                    <span>Menyusui: <?= $ra['frekuensi_menyusui'] ?>x • Pumping: <?= (float)$ra['volume_pumping'] ?>ml</span>
                                    <span class="font-bold <?= $ra['status_kecukupan_asi'] === 'Ya' ? 'text-green-600' : 'text-rose-600' ?>">
                                        <?= $ra['status_kecukupan_asi'] === 'Ya' ? 'Cukup' : 'Kurang' ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>

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
    </script>
</body>
</html>
