<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<header class="relative bg-gradient-to-br from-primary via-blue-500 to-blue-600 pt-12 md:pt-8 pb-12 md:pb-28 px-6 md:px-10 rounded-b-[2.5rem] md:rounded-none md:rounded-bl-[2.5rem] shadow-lg shadow-blue-100 dark:shadow-none overflow-hidden flex-shrink-0">
    <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute left-10 bottom-0 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
    <div class="relative z-10 flex items-center justify-between mb-2">
        <div class="flex items-center gap-4">
            <div class="size-14 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white overflow-hidden shadow-sm">
                <span class="material-symbols-outlined text-4xl font-variation-fill">face_3</span>
            </div>
            <div>
                <h1 class="text-white font-bold text-xl md:text-2xl leading-tight">Halo Bunda <?= esc($nama_ibu ?? 'Sarah') ?>,</h1>
                <p class="text-blue-50 text-sm md:text-base opacity-90">Bagaimana kabar si kecil hari ini?</p>
            </div>
        </div>
        <button class="size-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white hover:bg-white/30 transition">
            <span class="material-symbols-outlined text-2xl">notifications</span>
        </button>
    </div>
</header>

<div class="flex-1 mt-6 px-6 md:px-10 pb-32 md:pb-10 relative z-20"> 
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-[320px] md:max-w-none mx-auto mt-2 md:mt-0">
        
        <a href="<?= base_url('riwayat') ?>" class="group flex flex-col items-center justify-center p-4 md:p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center">
            <div class="w-14 h-14 md:w-16 md:h-16 mb-3 md:mb-4 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 transition-colors group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">history_edu</span>
            </div>
            <span class="text-sm md:text-base font-bold text-slate-700 dark:text-slate-100 leading-tight">Riwayat</span>
            <span class="text-[10px] md:text-xs text-slate-400 mt-1">Pra, Hamil & Salin</span>
        </a>

        <a href="<?= base_url('laktasi/cek') ?>" class="group flex flex-col items-center justify-center p-4 md:p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center">
            <div class="w-14 h-14 md:w-16 md:h-16 mb-3 md:mb-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 transition-colors group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">water_drop</span>
            </div>
            <span class="text-sm md:text-base font-bold text-slate-700 dark:text-slate-100 leading-tight">Cek Kelancaran</span>
            <span class="text-[10px] md:text-xs text-slate-400 mt-1">Evaluasi ASI</span>
        </a>

        <a href="<?= base_url('edukasi/video') ?>" class="group flex flex-col items-center justify-center p-4 md:p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center">
            <div class="w-14 h-14 md:w-16 md:h-16 mb-3 md:mb-4 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 transition-colors group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">smart_display</span>
            </div>
            <span class="text-sm md:text-base font-bold text-slate-700 dark:text-slate-100 leading-tight">Ruang Edukasi</span>
            <span class="text-[10px] md:text-xs text-slate-400 mt-1">Artikel & Video</span>
        </a>

        <a href="<?= base_url('statistik') ?>" class="group flex flex-col items-center justify-center p-4 md:p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center">
            <div class="w-14 h-14 md:w-16 md:h-16 mb-3 md:mb-4 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-500 transition-colors group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">bar_chart</span>
            </div>
            <span class="text-sm md:text-base font-bold text-slate-700 dark:text-slate-100 leading-tight">Statistik</span>
            <span class="text-[10px] md:text-xs text-slate-400 mt-1">Grafik Kelancaran</span>
        </a>

    </section>  

    <!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <section>
            <div class="flex items-center justify-between mb-4 px-1">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Update Terakhir</h3>
                <button class="text-sm font-semibold text-primary hover:underline">Lengkapnya</button>
            </div>
            <div class="bg-blue-50/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 rounded-3xl p-5 flex items-center gap-4 hover:bg-blue-50 transition-colors">
                <div class="size-14 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center shadow-sm text-primary">
                    <span class="material-symbols-outlined text-3xl font-variation-fill">check_circle</span>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Evaluasi ASI</p>
                    <h4 class="font-bold text-slate-900 dark:text-white text-base">Kebutuhan ASI Terpenuhi</h4>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        Hari ini, 08:30 WIB
                    </p>
                </div>
                <button class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </button>
            </div>
        </section>

        <section class="px-1 md:px-0">
            <div class="flex items-center justify-between mb-4 md:hidden">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Tips</h3>
            </div>
            <div class="bg-indigo-600 rounded-3xl p-6 md:p-8 text-white flex gap-4 items-center relative overflow-hidden h-full">
                <div class="absolute top-1/2 -translate-y-1/2 right-2 md:right-6 p-2 opacity-20">
                    <span class="material-symbols-outlined text-7xl md:text-8xl">lightbulb</span>
                </div>
                <div class="relative z-10">
                    <span class="bg-white/20 text-[10px] md:text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block">TIP EDUKASI</span>
                    <h4 class="font-bold text-xl md:text-2xl leading-snug mb-2">Jangan berkecil hati Bunda!</h4>
                    <p class="text-sm text-indigo-100 max-w-[80%]">Yuk cukupi kebutuhan ASI si kecil. Tonton video edukasi memperlancar ASI sekarang.</p>
                </div>
            </div>
        </section>
    </div> -->
</div>

<?= $this->endSection() ?>