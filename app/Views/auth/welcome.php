<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Selamat Datang di SiCubit') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b7cee",
                        "primary-light": "#e0f2ff",
                        "primary-dark": "#1a5bb8",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        "display": ["Epilogue", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        body { font-family: 'Epilogue', sans-serif; }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-hidden selection:bg-primary selection:text-white">

    <div class="relative h-screen flex flex-col items-center justify-between p-8">
        
        <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-primary/20 dark:bg-primary/10 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-[-5%] left-[-5%] w-48 h-48 bg-blue-200/50 dark:bg-blue-900/20 rounded-full blur-3xl opacity-40 pointer-events-none"></div>

        <div class="flex-1 flex flex-col items-center justify-center w-full max-w-md relative z-10">
            <div class="fade-in-up relative">
                <div class="size-32 bg-primary/10 dark:bg-primary/20 rounded-[2.5rem] flex items-center justify-center shadow-inner border border-primary/20">
                    <span class="material-symbols-outlined text-primary text-7xl font-variation-fill">child_care</span>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white dark:bg-slate-800 shadow-md px-3 py-1.5 rounded-full border border-slate-100 dark:border-slate-700 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-primary text-sm font-variation-fill">verified</span>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Resmi</span>   
                </div>
            </div>
            
            <div class="mt-12 text-center space-y-3">
                <h1 class="fade-in-up delay-1 text-3xl font-black text-slate-800 dark:text-slate-100 tracking-tight leading-tight">
                    Cek Tumbuh Kembang <br> <span class="text-primary">Si Kecil</span> Jadi Mudah
                </h1>
                <p class="fade-in-up delay-2 text-slate-500 dark:text-slate-400 text-sm leading-relaxed px-4">
                    Pendampingan kesehatan Ibu dan Anak terintegrasi untuk Bunda hebat.
                </p>
            </div>
        </div>

        <div class="w-full max-w-md pb-10 space-y-4 fade-in-up delay-2 relative z-10">
            <a href="<?= base_url('login') ?>" 
               class="block w-full py-4 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold text-center shadow-lg shadow-primary/30 dark:shadow-none transition-all active:scale-95">
                Mulai Perjalanan Bunda
            </a>
            <div class="text-center">
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary font-bold hover:text-primary-dark transition-colors">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>