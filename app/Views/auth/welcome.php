<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
<body class="bg-white overflow-hidden">
    <div class="relative h-screen flex flex-col items-center justify-between p-8">
        
        <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-[-5%] left-[-5%] w-48 h-48 bg-blue-100 rounded-full blur-3xl opacity-40"></div>

        <div class="flex-1 flex flex-col items-center justify-center w-full max-w-md">
            <div class="fade-in-up relative">
                <div class="size-32 bg-primary/10 rounded-[2.5rem] flex items-center justify-center shadow-inner">
                    <span class="material-symbols-outlined text-primary text-7xl font-variation-fill">child_care</span>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white shadow-lg px-3 py-1 rounded-full border border-slate-50 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs text-blue-500">location_on</span>
                    <span class="text-[10px] font-bold text-slate-600 tracking-tight">Banjarbaru</span>
                </div>
            </div>
            
            <div class="mt-12 text-center space-y-3">
                <h1 class="fade-in-up delay-1 text-3xl font-black text-slate-800 tracking-tight leading-tight">
                    Cek Tumbuh Kembang <span class="text-primary">Si Kecil</span> Jadi Mudah
                </h1>
                <p class="fade-in-up delay-2 text-slate-400 text-sm leading-relaxed px-4">
                    Pendampingan kesehatan Ibu dan Anak terintegrasi untuk Bunda hebat di Kota Banjarbaru.
                </p>
            </div>
        </div>

        <div class="w-full max-w-md pb-10 space-y-4 fade-in-up delay-2">
            <a href="<?= base_url('login') ?>" 
               class="block w-full py-4 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold text-center shadow-xl shadow-blue-200 transition-all active:scale-95">
                Mulai Perjalanan Bunda
            </a>
            <div class="text-center">
                <p class="text-xs text-slate-400 font-medium">
                    Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary font-bold hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>