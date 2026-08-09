<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full gap-6">

    <!-- SUBPAGE HEADER (ADAPTIVE BACK BUTTON & TITLE) -->
    <div class="mb-1">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">menu_book</span>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#162065] tracking-tight">Ruang Edukasi & Video Tips</h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium">Panduan praktis dan video interaktif kesehatan ibu & anak</p>
            </div>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <form action="<?= base_url('edukasi/video') ?>" method="GET" class="w-full">
        <?php if (!empty($activeKategori)): ?>
            <input type="hidden" name="kategori" value="<?= esc($activeKategori) ?>">
        <?php endif; ?>
        <div class="relative flex items-center">
            <input type="text" 
                   name="q" 
                   value="<?= esc($searchQuery ?? '') ?>" 
                   placeholder="Cari kata kunci video, judul, atau tips kesehatan..." 
                   class="w-full pl-11 pr-10 py-3.5 rounded-2xl bg-white/90 backdrop-blur border border-white/60 text-slate-800 text-sm font-semibold shadow-sm focus:bg-white focus:border-[#162065] focus:ring-0 transition">
            <span class="material-symbols-outlined text-slate-400 absolute left-3.5 pointer-events-none text-xl">search</span>
            <?php if (!empty($searchQuery)): ?>
                <a href="<?= base_url('edukasi/video') ?><?= !empty($activeKategori) ? '?kategori=' . esc($activeKategori) : '' ?>" 
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
            <a href="<?= base_url('edukasi/video') ?><?= !empty($searchQuery) ? '?q=' . urlencode($searchQuery) : '' ?>" 
               class="px-4 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap shadow-sm <?= empty($activeKategori) ? 'bg-[#162065] text-white shadow-md' : 'bg-white/80 backdrop-blur text-slate-700 hover:bg-white border border-white/60' ?>">
               Semua Video
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php $isActive = ($activeKategori === $cat['slug'] || $activeKategori == $cat['id']); ?>
                <a href="<?= base_url('edukasi/video?kategori=' . $cat['slug']) ?><?= !empty($searchQuery) ? '&q=' . urlencode($searchQuery) : '' ?>" 
                   class="px-4 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap shadow-sm <?= $isActive ? 'bg-[#162065] text-white shadow-md' : 'bg-white/80 backdrop-blur text-slate-700 hover:bg-white border border-white/60' ?>">
                   <?= esc($cat['nama_kategori']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- STATUS FILTER & RESULTS INDICATOR -->
    <?php if (!empty($searchQuery)): ?>
        <div class="flex items-center justify-between bg-blue-50/80 backdrop-blur px-4 py-2.5 rounded-2xl border border-blue-200 text-xs font-bold text-blue-900">
            <span>Menampilkan hasil pencarian untuk: "<b class="font-extrabold"><?= esc($searchQuery) ?></b>"</span>
            <a href="<?= base_url('edukasi/video') ?><?= !empty($activeKategori) ? '?kategori=' . esc($activeKategori) : '' ?>" class="text-blue-600 hover:underline flex items-center gap-1 font-extrabold">
                Reset <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </div>
    <?php endif; ?>

    <div class="flex-1 w-full">
        <div class="w-full">
            
            <?php if (!empty($videos)): ?>
                
                <?php 
                    $heroVideo = $videos[0]; 
                    $otherVideos = array_slice($videos, 1);
                ?>

                <!-- HERO FEATURED EMBEDDED VIDEO CARD -->
                <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 overflow-hidden mb-8 p-4 sm:p-6">
                    <div class="mb-3 flex items-center justify-between flex-wrap gap-2">
                        <div class="flex items-center gap-2">
                            <span class="bg-[#162065] text-white text-[10px] font-black uppercase tracking-widest px-3.5 py-1 rounded-full shadow inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">star</span> Rekomendasi Utama
                            </span>
                            <?php if (!empty($heroVideo['nama_kategori'])): ?>
                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-extrabold px-3 py-1 rounded-full">
                                    <?= esc($heroVideo['nama_kategori']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($heroVideo['created_at'])): ?>
                            <span class="text-xs text-slate-400 font-bold">
                                <?= date('d M Y', strtotime($heroVideo['created_at'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="w-full aspect-video bg-slate-900 rounded-2xl overflow-hidden shadow-lg border border-slate-200 mb-4">
                        <?php if (!empty($heroVideo['youtube_id'])): ?>
                            <iframe class="w-full h-full" 
                                    src="https://www.youtube.com/embed/<?= esc($heroVideo['youtube_id']) ?>?rel=0" 
                                    title="<?= esc($heroVideo['judul'] ?? 'Video Edukasi') ?>" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen></iframe>
                        <?php else: ?>
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                <span class="material-symbols-outlined text-4xl mb-2">videocam_off</span>
                                <p class="text-xs font-bold">URL Video Tidak Valid</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-black text-[#162065] mb-2"><?= esc($heroVideo['judul'] ?? 'Video Edukasi') ?></h2>
                        <?php if (!empty($heroVideo['deskripsi'])): ?>
                            <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed"><?= esc($heroVideo['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- OTHER EMBEDDED VIDEOS GRID -->
                <?php if (!empty($otherVideos)): ?>
                    <h3 class="font-black text-[#162065] text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl text-[#162065]">video_library</span> Video Edukasi Lainnya
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($otherVideos as $vid): ?>
                            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-lg border border-white/80 overflow-hidden flex flex-col justify-between p-4 hover:shadow-xl transition duration-300">
                                <div class="w-full aspect-video bg-slate-900 rounded-2xl overflow-hidden shadow border border-slate-200 mb-4 relative">
                                    <?php if (!empty($vid['youtube_id'])): ?>
                                        <iframe class="w-full h-full" 
                                                src="https://www.youtube.com/embed/<?= esc($vid['youtube_id']) ?>?rel=0" 
                                                title="<?= esc($vid['judul'] ?? '') ?>" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                allowfullscreen></iframe>
                                    <?php else: ?>
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                            <span class="material-symbols-outlined text-3xl mb-1">videocam_off</span>
                                            <p class="text-xs font-bold">URL Video Tidak Valid</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <?php if (!empty($vid['nama_kategori'])): ?>
                                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 font-extrabold rounded-md text-[10px] inline-block mb-1.5">
                                                <?= esc($vid['nama_kategori']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <h4 class="font-black text-[#162065] text-base mb-1.5 line-clamp-2"><?= esc($vid['judul'] ?? '') ?></h4>
                                        <?php if (!empty($vid['deskripsi'])): ?>
                                            <p class="text-xs text-slate-600 font-medium line-clamp-3 mb-2"><?= esc($vid['deskripsi']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-12 text-center border border-white/60 shadow-lg">
                    <span class="material-symbols-outlined text-6xl text-slate-400 mb-3">search_off</span>
                    <h3 class="font-black text-[#162065] text-xl">Video Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        <?= !empty($searchQuery) ? 'Tidak ada video yang cocok dengan kata kunci "' . esc($searchQuery) . '".' : 'Belum ada video edukasi yang ditambahkan.' ?>
                    </p>
                    <?php if (!empty($searchQuery) || !empty($activeKategori)): ?>
                        <a href="<?= base_url('edukasi/video') ?>" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-2xl bg-[#162065] text-white font-extrabold text-xs shadow hover:bg-[#101850] transition">
                            <span class="material-symbols-outlined text-sm">refresh</span> Lihat Semua Video
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<?= $this->endSection() ?>