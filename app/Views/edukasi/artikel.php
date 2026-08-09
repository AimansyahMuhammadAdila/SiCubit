<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full gap-6">

    <!-- SUBPAGE HEADER -->
    <div class="mb-1">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">newspaper</span>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#162065] tracking-tight">Ruang Edukasi</h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium">Artikel berita, tips kesehatan, dan panduan gizi terpercaya untuk ibu & anak</p>
            </div>
        </div>
    </div>

    <!-- TAB SWITCHER: VIDEO VS ARTIKEL -->
    <div class="flex items-center justify-center gap-1.5 p-1.5 bg-white/90 backdrop-blur rounded-2xl border border-white/60 shadow-sm w-full max-w-md mx-auto">
        <a href="<?= base_url('edukasi/video') ?>" 
           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-black transition-all text-slate-600 hover:text-[#162065] hover:bg-slate-100 text-center">
            <span class="material-symbols-outlined text-lg">smart_display</span>
            <span>Video Edukasi</span>
        </a>
        <a href="<?= base_url('edukasi/artikel') ?>" 
           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-black transition-all bg-[#162065] text-white shadow-md text-center">
            <span class="material-symbols-outlined text-lg">article</span>
            <span>Artikel & Berita</span>
        </a>
    </div>

    <!-- SEARCH BAR -->
    <form action="<?= base_url('edukasi/artikel') ?>" method="GET" class="w-full">
        <?php if (!empty($activeKategori)): ?>
            <input type="hidden" name="kategori" value="<?= esc($activeKategori) ?>">
        <?php endif; ?>
        <div class="relative flex items-center">
            <input type="text" 
                   name="q" 
                   value="<?= esc($searchQuery ?? '') ?>" 
                   placeholder="Cari judul artikel, topik laktasi, atau tips kesehatan..." 
                   class="w-full pl-11 pr-10 py-3.5 rounded-2xl bg-white/90 backdrop-blur border border-white/60 text-slate-800 text-sm font-semibold shadow-sm focus:bg-white focus:border-[#162065] focus:ring-0 transition">
            <span class="material-symbols-outlined text-slate-400 absolute left-3.5 pointer-events-none text-xl">search</span>
            <?php if (!empty($searchQuery)): ?>
                <a href="<?= base_url('edukasi/artikel') ?><?= !empty($activeKategori) ? '?kategori=' . esc($activeKategori) : '' ?>" 
                   class="absolute right-3.5 p-1 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition" 
                   title="Reset Pencarian">
                    <span class="material-symbols-outlined text-lg">close</span>
                </a>
            <?php endif; ?>
        </div>
    </form>

    <!-- CATEGORY FILTER PILLS -->
    <?php if (!empty($categories)): ?>
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <a href="<?= base_url('edukasi/artikel') ?><?= !empty($searchQuery) ? '?q=' . urlencode($searchQuery) : '' ?>" 
               class="px-4 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap shadow-sm <?= empty($activeKategori) ? 'bg-[#162065] text-white shadow-md' : 'bg-white/80 backdrop-blur text-slate-700 hover:bg-white border border-white/60' ?>">
               Semua Artikel
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php $isActive = ($activeKategori === $cat['slug'] || $activeKategori == $cat['id']); ?>
                <a href="<?= base_url('edukasi/artikel?kategori=' . $cat['slug']) ?><?= !empty($searchQuery) ? '&q=' . urlencode($searchQuery) : '' ?>" 
                   class="px-4 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap shadow-sm <?= $isActive ? 'bg-[#162065] text-white shadow-md' : 'bg-white/80 backdrop-blur text-slate-700 hover:bg-white border border-white/60' ?>">
                   <?= esc($cat['nama_kategori']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- RESULT INDICATOR IF SEARCHING -->
    <?php if (!empty($searchQuery)): ?>
        <div class="flex items-center justify-between bg-blue-50/80 backdrop-blur px-4 py-2.5 rounded-2xl border border-blue-200 text-xs font-bold text-blue-900">
            <span>Menampilkan artikel untuk kata kunci: "<b class="font-extrabold"><?= esc($searchQuery) ?></b>"</span>
            <a href="<?= base_url('edukasi/artikel') ?><?= !empty($activeKategori) ? '?kategori=' . esc($activeKategori) : '' ?>" class="text-blue-600 hover:underline flex items-center gap-1 font-extrabold">
                Reset <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </div>
    <?php endif; ?>

    <div class="flex-1 w-full">
        <?php if (!empty($artikels)): ?>
            <?php 
                $heroArtikel = $artikels[0]; 
                $otherArtikels = array_slice($artikels, 1);
            ?>

            <!-- HERO FEATURED ARTIKEL CARD -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 overflow-hidden mb-8 p-4 sm:p-6 transition hover:shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    
                    <!-- THUMBNAIL/IMAGE -->
                    <div class="md:col-span-5 h-48 sm:h-56 md:h-64 rounded-2xl overflow-hidden bg-slate-100 relative border border-slate-200 flex items-center justify-center">
                        <?php if (!empty($heroArtikel['thumbnail_url'])): ?>
                            <img src="<?= base_url(esc($heroArtikel['thumbnail_url'])) ?>" alt="<?= esc($heroArtikel['judul']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                <span class="material-symbols-outlined text-5xl mb-2 text-indigo-300">article</span>
                                <span class="text-xs font-bold">SiCubit Edukasi</span>
                            </div>
                        <?php endif; ?>
                        <div class="absolute top-3 left-3 bg-[#162065] text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">star</span> Artikel Utama
                        </div>
                    </div>

                    <!-- CONTENT INFO -->
                    <div class="md:col-span-7 flex flex-col justify-between h-full">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 font-bold mb-2">
                                <?php if (!empty($heroArtikel['nama_kategori'])): ?>
                                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">
                                        <?= esc($heroArtikel['nama_kategori']) ?>
                                    </span>
                                <?php endif; ?>
                                <span class="flex items-center gap-1 text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    <?= esc($heroArtikel['nama_penulis'] ?: 'Bidan Admin SI CUBIT') ?>
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    <?= date('d M Y', strtotime($heroArtikel['created_at'])) ?>
                                </span>
                            </div>
                            
                            <h2 class="text-xl sm:text-2xl font-black text-[#162065] leading-tight mb-3 line-clamp-2">
                                <?= esc($heroArtikel['judul']) ?>
                            </h2>
                            
                            <p class="text-slate-600 text-xs sm:text-sm font-medium line-clamp-3 mb-4 leading-relaxed">
                                <?= strip_tags($heroArtikel['isi_konten']) ?>
                            </p>
                        </div>

                        <div>
                            <a href="<?= base_url('edukasi/artikel/' . ($heroArtikel['slug'] ?: $heroArtikel['id'])) ?>" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-[#162065] text-white font-extrabold text-xs shadow-md hover:bg-[#101850] transition group">
                                <span>Baca Selengkapnya</span>
                                <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- GRID OTHER ARTIKELS -->
            <?php if (!empty($otherArtikels)): ?>
                <div class="mb-4">
                    <h3 class="text-lg font-black text-[#162065] mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">grid_view</span> Artikel Lainnya
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <?php foreach ($otherArtikels as $art): ?>
                            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-lg border border-white/80 overflow-hidden flex flex-col justify-between transition hover:-translate-y-1 hover:shadow-xl">
                                <div>
                                    <!-- THUMBNAIL -->
                                    <div class="h-40 bg-slate-100 border-b border-slate-100 relative overflow-hidden flex items-center justify-center">
                                        <?php if (!empty($art['thumbnail_url'])): ?>
                                            <img src="<?= base_url(esc($art['thumbnail_url'])) ?>" alt="<?= esc($art['judul']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="flex flex-col items-center justify-center text-slate-400 p-4">
                                                <span class="material-symbols-outlined text-4xl mb-1 text-indigo-300">article</span>
                                                <span class="text-[10px] font-bold">SiCubit Artikel</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($art['nama_kategori'])): ?>
                                            <span class="absolute bottom-2 left-2 bg-[#162065]/90 backdrop-blur text-white text-[9px] font-extrabold px-2.5 py-0.5 rounded-full shadow">
                                                <?= esc($art['nama_kategori']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- CARD CONTENT -->
                                    <div class="p-5">
                                        <div class="flex items-center justify-between text-[11px] text-slate-500 font-bold mb-2">
                                            <span class="text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md truncate max-w-[150px]">
                                                <?= esc($art['nama_penulis'] ?: 'Admin SI CUBIT') ?>
                                            </span>
                                            <span><?= date('d M Y', strtotime($art['created_at'])) ?></span>
                                        </div>

                                        <h4 class="font-extrabold text-[#162065] text-sm sm:text-base leading-snug mb-2 line-clamp-2">
                                            <?= esc($art['judul']) ?>
                                        </h4>

                                        <p class="text-slate-600 text-xs font-medium line-clamp-3 mb-4 leading-relaxed">
                                            <?= strip_tags($art['isi_konten']) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="px-5 pb-5">
                                    <a href="<?= base_url('edukasi/artikel/' . ($art['slug'] ?: $art['id'])) ?>" class="inline-flex items-center justify-center gap-1.5 w-full py-2.5 rounded-xl bg-slate-100 hover:bg-[#162065] hover:text-white text-[#162065] font-extrabold text-xs transition">
                                        <span>Baca Artikel</span>
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- EMPTY STATE -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-12 text-center border border-white/60 shadow-lg my-6">
                <div class="size-20 bg-indigo-50 text-indigo-600 rounded-3xl mx-auto flex items-center justify-center mb-4 shadow-sm">
                    <span class="material-symbols-outlined text-4xl">menu_book</span>
                </div>
                <h3 class="text-lg font-black text-[#162065] mb-2">Belum Ada Artikel</h3>
                <p class="text-slate-500 text-xs sm:text-sm font-medium max-w-md mx-auto mb-6">
                    <?= !empty($searchQuery) ? 'Tidak ditemukan artikel dengan kata kunci "' . esc($searchQuery) . '". Coba kata kunci lain.' : 'Artikel edukasi kesehatan ibu & anak akan segera ditambahkan oleh Bidan.' ?>
                </p>
                <?php if (!empty($searchQuery)): ?>
                    <a href="<?= base_url('edukasi/artikel') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#162065] text-white font-extrabold text-xs shadow transition">
                        <span class="material-symbols-outlined text-sm">refresh</span> Lihat Semua Artikel
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>
