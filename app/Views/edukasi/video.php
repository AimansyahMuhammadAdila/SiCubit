<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center justify-between flex-shrink-0 relative z-20">
    <div class="flex items-center gap-4">
        <a href="<?= base_url('/') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-bold text-xl text-slate-800 dark:text-white">Video Edukasi</h1>
            <p class="text-xs text-slate-500">Tips & Panduan Memperlancar ASI</p>
        </div>
    </div>
    <button class="text-primary hover:bg-primary-light p-2 rounded-xl transition">
        <span class="material-symbols-outlined">search</span>
    </button>
</header>

<div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 relative z-10 pb-32">
    <div class="max-w-6xl mx-auto">
        
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
            <div class="w-full aspect-video bg-slate-800 relative group flex items-center justify-center cursor-pointer">
                <img src="https://images.unsplash.com/photo-1555252333-9f8e92e65df9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 transition-opacity duration-300">
                
                <div class="relative z-10 size-16 md:size-20 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 group-hover:bg-primary transition-all duration-300">
                    <span class="material-symbols-outlined text-4xl md:text-5xl text-white font-variation-fill">play_arrow</span>
                </div>
                
                <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur-md text-white text-xs font-bold px-2 py-1 rounded-md">
                    12:45
                </div>
            </div>

            <div class="p-5 md:p-8">
                <span class="bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-[10px] md:text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block uppercase tracking-wider">
                    Rekomendasi Hari Ini
                </span>
                <h2 class="font-bold text-xl md:text-3xl text-slate-800 dark:text-white mb-2 leading-tight">
                    Teknik Pijat Oksitosin untuk Memperlancar Produksi ASI
                </h2>
                <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 mb-4 line-clamp-2 md:line-clamp-none">
                    Pijat oksitosin sangat dianjurkan untuk Bunda yang merasa ASI-nya kurang lancar. Suami bisa membantu melakukan pijatan ini di area punggung untuk merangsang hormon oksitosin (hormon cinta) agar ASI keluar lebih deras.
                </p>
                <div class="flex items-center gap-4 text-xs font-medium text-slate-400">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">visibility</span> 1.2k ditonton</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">thumb_up</span> 345 suka</span>
                </div>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Video Terkait Lainnya</h3>
            <button class="text-sm font-semibold text-primary hover:underline">Lihat Semua</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <a href="#" class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="w-full aspect-video bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519689680058-324335c77eba?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Thumb" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">08:20</div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-white line-clamp-2 mb-1 group-hover:text-primary transition-colors">
                        Makanan Pendongkrak ASI (ASI Booster) Alami yang Mudah Didapat
                    </h4>
                    <p class="text-xs text-slate-500">Bidan Larasati</p>
                </div>
            </a>

            <a href="#" class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="w-full aspect-video bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544126592-807ade215a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Thumb" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">15:10</div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-white line-clamp-2 mb-1 group-hover:text-primary transition-colors">
                        Posisi Menyusui (Pelekatan) yang Benar Agar Puting Tidak Lecet
                    </h4>
                    <p class="text-xs text-slate-500">Klinik Laktasi</p>
                </div>
            </a>

            <a href="#" class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="w-full aspect-video bg-slate-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1627843818617-3801eaab801b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Thumb" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">05:45</div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-white line-clamp-2 mb-1 group-hover:text-primary transition-colors">
                        Cara Mengatasi Payudara Bengkak Saat Masa Menyusui
                    </h4>
                    <p class="text-xs text-slate-500">Bidan Larasati</p>
                </div>
            </a>

        </div>
    </div>
</div>

<?= $this->endSection() ?>