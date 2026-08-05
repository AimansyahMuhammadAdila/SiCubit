<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full gap-6">

    <!-- SUBPAGE HEADER (ADAPTIVE BACK BUTTON & TITLE) -->
    <div class="mb-2">
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

    <div class="flex-1 w-full">
        <div class="w-full">
            
            <?php if (!empty($videos)): ?>
                
                <?php 
                    $heroVideo = $videos[0]; 
                    $otherVideos = array_slice($videos, 1);
                ?>

                <!-- HERO FEATURED VIDEO CARD -->
                <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 overflow-hidden mb-8">
                    <a href="<?= esc($heroVideo['url_video'] ?? '#') ?>" target="_blank" class="block w-full aspect-video bg-slate-900 relative group flex items-center justify-center cursor-pointer">
                        <img src="https://img.youtube.com/vi/<?= esc($heroVideo['youtube_id'] ?? '') ?>/maxresdefault.jpg" 
                             onerror="this.src='https://img.youtube.com/vi/<?= esc($heroVideo['youtube_id'] ?? '') ?>/hqdefault.jpg'"
                             alt="Thumbnail" 
                             class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-500 group-hover:scale-105" />
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                        <div class="size-16 sm:size-20 rounded-full bg-[#162065]/90 text-white flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300 z-10 border-2 border-white/40">
                            <span class="material-symbols-outlined text-3xl sm:text-4xl">play_arrow</span>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 z-10 text-white">
                            <span class="bg-[#162065] text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full mb-2 inline-block shadow">Rekomendasi Utama</span>
                            <h2 class="text-base sm:text-xl font-extrabold drop-shadow-md line-clamp-2"><?= esc($heroVideo['judul'] ?? 'Video Edukasi') ?></h2>
                        </div>
                    </a>
                </div>

                <!-- OTHER VIDEOS GRID (ADAPTIVE 1 COL MOBILE -> 2 COLS TABLET -> 3 COLS DESKTOP) -->
                <?php if (!empty($otherVideos)): ?>
                    <h3 class="font-black text-[#162065] text-lg mb-4">Video Edukasi Lainnya</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($otherVideos as $vid): ?>
                            <a href="<?= esc($vid['url_video'] ?? '#') ?>" target="_blank" class="bg-white/95 backdrop-blur-md rounded-3xl shadow-lg border border-white/80 overflow-hidden group flex flex-col justify-between hover:-translate-y-1 transition duration-300">
                                <div class="aspect-video bg-slate-800 relative overflow-hidden">
                                    <img src="https://img.youtube.com/vi/<?= esc($vid['youtube_id'] ?? '') ?>/hqdefault.jpg" 
                                         alt="Thumbnail" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center group-hover:bg-black/10 transition">
                                        <div class="size-12 rounded-full bg-[#162065]/90 text-white flex items-center justify-center shadow-md">
                                            <span class="material-symbols-outlined text-2xl">play_arrow</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <h4 class="font-bold text-slate-800 text-sm line-clamp-2 mb-2 group-hover:text-[#162065] transition"><?= esc($vid['judul'] ?? '') ?></h4>
                                    <span class="text-[11px] font-extrabold text-[#162065] flex items-center gap-1 mt-auto">
                                        Tonton Sekarang <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-8 text-center border border-white/60 shadow-lg">
                    <span class="material-symbols-outlined text-5xl text-slate-400 mb-2">videocam_off</span>
                    <h3 class="font-black text-[#162065] text-lg">Belum Ada Video Edukasi</h3>
                    <p class="text-xs text-slate-500 mt-1">Video edukasi kesehatan akan segera ditambahkan.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<?= $this->endSection() ?>