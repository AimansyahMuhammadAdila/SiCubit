<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'SI CUBIT') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#162065",
                        "primary-navy": "#101850",
                        "primary-blue": "#1e2b80",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url('<?= base_url('uploads/Background.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .app-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="text-slate-800 antialiased min-h-screen w-full">

    <!-- ADAPTIVE FULL SCREEN CONTAINER (MOBILE, TABLET, DESKTOP, ULTRA WIDE) -->
    <div class="app-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-6">

        <!-- TOP HEADER LOGO & DESKTOP ADAPTIVE NAV BAR -->
        <header class="w-full pt-2 flex items-center justify-between z-30 flex-shrink-0 mb-6 gap-4">
            
            <!-- Left: Logo Pill Kemenkes (DIPERBESAR) -->
            <div class="bg-white/95 backdrop-blur-md px-5 sm:px-6 py-2.5 rounded-full shadow-lg border border-white/80 flex items-center gap-2.5">
                <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes Banjarmasin" class="h-10 sm:h-12 md:h-14 object-contain max-w-[240px] sm:max-w-[280px] md:max-w-[320px]">
            </div>
            
            <!-- Center: Desktop & Tablet Inline Navigation (>= 768px) -->
            <?php 
                $isBeranda = url_is('/') || url_is('dashboard*'); 
                $isKunjungan = url_is('laktasi*') || url_is('form-bayi*') || url_is('assessment-kejiwaan*'); 
                $isRiwayat = url_is('riwayat*') || url_is('statistik*'); 
                $isProfil = url_is('profil*'); 
            ?>
            <nav class="hidden md:flex items-center gap-2 bg-[#162065] text-white px-4 py-2 rounded-full shadow-lg border border-white/10 backdrop-blur-md">
                <a href="<?= base_url('dashboard') ?>" 
                   class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold transition-all <?= $isBeranda ? 'bg-white/20 text-white shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' ?>">
                    <img src="<?= base_url('uploads/Home.png') ?>" alt="Beranda" class="size-4 object-contain">
                    <span>Beranda</span>
                </a>
                <a href="<?= base_url('laktasi/cek') ?>" 
                   class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold transition-all <?= $isKunjungan ? 'bg-white/20 text-white shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' ?>">
                    <img src="<?= base_url('uploads/Kunjungan.png') ?>" alt="Kunjungan" class="size-4 object-contain">
                    <span>Kunjungan</span>
                </a>
                <a href="<?= base_url('riwayat') ?>" 
                   class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold transition-all <?= $isRiwayat ? 'bg-white/20 text-white shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' ?>">
                    <img src="<?= base_url('uploads/Riwayat.png') ?>" alt="Riwayat" class="size-4 object-contain">
                    <span>Riwayat</span>
                </a>
                <a href="<?= base_url('profil') ?>" 
                   class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold transition-all <?= $isProfil ? 'bg-white/20 text-white shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' ?>">
                    <img src="<?= base_url('uploads/Profil.png') ?>" alt="Profil" class="size-4 object-contain">
                    <span>Profil</span>
                </a>
            </nav>

            <!-- Right: Notification Bell & Action -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button class="size-10 sm:size-11 rounded-full bg-[#162065] text-white flex items-center justify-center shadow-lg shadow-indigo-900/30 hover:bg-[#101850] transition">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">notifications</span>
                    </button>
                    <span class="absolute top-0 right-0 size-2.5 sm:size-3 bg-rose-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT SECTION -->
        <main class="flex-1 w-full relative z-20 flex flex-col justify-start pb-24 md:pb-12">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- MOBILE BOTTOM NAVIGATION BAR (< 768px) -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 max-w-md mx-auto px-4 pb-4">
            <div class="bg-[#162065] text-white rounded-3xl p-2.5 shadow-2xl shadow-indigo-950/60 border border-white/10 flex items-center justify-around backdrop-blur-lg">
                
                <a href="<?= base_url('dashboard') ?>" 
                   class="flex flex-col items-center justify-center py-1.5 px-3 rounded-2xl transition-all duration-200 <?= $isBeranda ? 'bg-white/20 font-bold scale-105' : 'opacity-80 hover:opacity-100' ?>">
                    <img src="<?= base_url('uploads/Home.png') ?>" alt="Beranda" class="size-6 object-contain mb-0.5 filter drop-shadow">
                    <span class="text-[10px] font-bold tracking-tight">Beranda</span>
                </a>

                <a href="<?= base_url('laktasi/cek') ?>" 
                   class="flex flex-col items-center justify-center py-1.5 px-3 rounded-2xl transition-all duration-200 <?= $isKunjungan ? 'bg-white/20 font-bold scale-105' : 'opacity-80 hover:opacity-100' ?>">
                    <img src="<?= base_url('uploads/Kunjungan.png') ?>" alt="Kunjungan" class="size-6 object-contain mb-0.5 filter drop-shadow">
                    <span class="text-[10px] font-bold tracking-tight">Kunjungan</span>
                </a>

                <a href="<?= base_url('riwayat') ?>" 
                   class="flex flex-col items-center justify-center py-1.5 px-3 rounded-2xl transition-all duration-200 <?= $isRiwayat ? 'bg-white/20 font-bold scale-105' : 'opacity-80 hover:opacity-100' ?>">
                    <img src="<?= base_url('uploads/Riwayat.png') ?>" alt="Riwayat" class="size-6 object-contain mb-0.5 filter drop-shadow">
                    <span class="text-[10px] font-bold tracking-tight">Riwayat</span>
                </a>

                <a href="<?= base_url('profil') ?>" 
                   class="flex flex-col items-center justify-center py-1.5 px-3 rounded-2xl transition-all duration-200 <?= $isProfil ? 'bg-white/20 font-bold scale-105' : 'opacity-80 hover:opacity-100' ?>">
                    <img src="<?= base_url('uploads/Profil.png') ?>" alt="Profil" class="size-6 object-contain mb-0.5 filter drop-shadow">
                    <span class="text-[10px] font-bold tracking-tight">Profil</span>
                </a>

            </div>
        </nav>

    </div>

</body>
</html>