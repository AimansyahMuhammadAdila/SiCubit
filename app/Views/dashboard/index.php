<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php 
$statusKehamilan = session()->get('status_kehamilan') ?? $status_kehamilan ?? 'pasca_melahirkan'; 
?>

<div class="w-full flex flex-col gap-6 md:gap-8">

    <!-- GREETING & AVATAR HEADER (ADAPTIVE MOBILE & DESKTOP) -->
    <div class="relative bg-white/40 backdrop-blur-md p-5 sm:p-6 md:p-8 rounded-3xl border border-white/60 shadow-sm flex items-center justify-between gap-4 overflow-hidden">
        <!-- Sparkle BG Decorative Icons -->
        <span class="material-symbols-outlined absolute -right-3 -top-3 text-7xl text-white/50 animate-pulse pointer-events-none">auto_awesome</span>
        
        <div class="flex items-center gap-4 sm:gap-6 z-10">
            <div class="size-16 sm:size-20 md:size-24 rounded-full bg-white p-1 border-2 border-[#162065] shadow-md flex-shrink-0 overflow-hidden">
                <img src="<?= base_url('uploads/Logo.png') ?>" alt="Avatar Bunda" class="w-full h-full object-contain">
            </div>

            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#162065]/10 text-[#162065] text-[11px] font-black uppercase tracking-wider mb-1">
                    <span class="size-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <?= esc(str_replace('_', ' ', strtoupper($statusKehamilan))) ?>
                </div>
                <h2 class="text-[#162065] font-black text-xl sm:text-2xl md:text-3xl leading-tight">
                    Halo Bunda.......
                </h2>
                <p class="text-slate-800 font-bold text-xs sm:text-sm md:text-base mt-0.5">
                    Selamat datang di <span class="text-[#162065] font-black">SiCubit</span>
                </p>
            </div>
        </div>

        <a href="<?= base_url('profil') ?>" class="hidden sm:flex items-center gap-2 bg-white/80 hover:bg-white text-[#162065] px-4 py-2.5 rounded-2xl text-xs font-black shadow-sm transition border border-white/80 whitespace-nowrap">
            <span class="material-symbols-outlined text-lg">person</span> Lihat Profil
        </a>
    </div>

    <!-- MAIN MENU CONTAINER (ADAPTIVE GRID: 3 COLS MOBILE -> 6 COLS DESKTOP) -->
    <div class="bg-[#162065] text-white p-5 sm:p-6 md:p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-950/40 border border-white/10 relative overflow-hidden">
        <!-- Decorative Glow -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4 md:gap-6 text-center relative z-10">
            
            <!-- 1. Riwayat Pra Kehamilan -->
            <a href="<?= base_url('riwayat?step=1') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                    <img src="<?= base_url('uploads/Riwayat_Pra_Kehamilan.png') ?>" alt="Riwayat Pra Kehamilan" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Riwayat<br>Pra Kehamilan
                </span>
            </a>

            <!-- 2. Riwayat Kehamilan -->
            <a href="<?= base_url('riwayat?step=2') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                    <img src="<?= base_url('uploads/Riwayat_Kehamilan.png') ?>" alt="Riwayat Kehamilan" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Riwayat<br>Kehamilan
                </span>
            </a>

            <!-- 3. Riwayat Persalinan -->
            <a href="<?= base_url('riwayat?step=3') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                    <img src="<?= base_url('uploads/Riwayat_Persalinan.png') ?>" alt="Riwayat Persalinan" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Riwayat<br>Persalinan
                </span>
            </a>

            <!-- 4. Ruang Edukasi -->
            <a href="<?= base_url('edukasi/video') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                    <img src="<?= base_url('uploads/Ruang_Edukasi.png') ?>" alt="Ruang Edukasi" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Ruang Edukasi
                </span>
            </a>

            <!-- 5. Bidan Pintar (Chat AI) -->
            <a href="<?= base_url('chat') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                    <img src="<?= base_url('uploads/Bidan_Pintar.png') ?>" alt="Bidan Pintar" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Bidan Pintar
                </span>
            </a>

            <!-- 6. Cek Kelancaran ASI & Assessment -->
            <a href="<?= base_url('laktasi/cek') ?>" 
               class="group flex flex-col items-center justify-center p-3 sm:p-4 rounded-2xl hover:bg-white/10 transition-all duration-300 active:scale-95">
                <div class="size-14 sm:size-16 md:size-20 mb-2 rounded-2xl bg-white/10 flex items-center justify-center text-amber-300 border border-white/20 transition-transform group-hover:scale-110">
                    <span class="material-symbols-outlined text-3xl sm:text-4xl">water_drop</span>
                </div>
                <span class="text-[11px] sm:text-xs md:text-sm font-bold leading-tight text-white group-hover:text-blue-200">
                    Kalkulator<br>Kecukupan ASI
                </span>
            </a>

        </div>
    </div>

    <!-- QUICK ACTIONS & CARDS GRID (ADAPTIVE 2-COLUMN DESKTOP GRID) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        
        <!-- CARD 1: PANTAU TUMBUH KEMBANG -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl p-5 border border-white/60 shadow-lg flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">medical_services</span>
                </div>
                <div>
                    <h4 class="font-black text-[#162065] text-sm sm:text-base">Pantau Tumbuh Kembang</h4>
                    <p class="text-[11px] text-slate-500 font-medium leading-tight">Pemeriksaan berkala si kecil & Bunda</p>
                </div>
            </div>
            <a href="<?= base_url('laktasi/cek') ?>" 
               class="bg-[#162065] hover:bg-[#101850] text-white px-4 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-wider transition shadow-md whitespace-nowrap">
                Mulai Cek
            </a>
        </div>

        <!-- CARD 2: KONDISI KEJIWAAN EPDS -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl p-5 border border-white/60 shadow-lg flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <div>
                    <h4 class="font-black text-[#162065] text-sm sm:text-base">Screening EPDS</h4>
                    <p class="text-[11px] text-slate-500 font-medium leading-tight">Cek kondisi emosional & mental Bunda</p>
                </div>
            </div>
            <a href="<?= base_url('assessment-kejiwaan') ?>" 
               class="bg-[#162065] hover:bg-[#101850] text-white px-4 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-wider transition shadow-md whitespace-nowrap">
                Cek EPDS
            </a>
        </div>

    </div>

</div>

<?= $this->endSection() ?>