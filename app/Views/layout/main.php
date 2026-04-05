<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'SI CUBIT') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet" />
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

    <style type="text/tailwindcss">
        @layer base {
            html, body {
                @apply m-0 p-0 overflow-x-hidden;
            }
        }
        @layer utilities {
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            
            #page-loader {
                @apply fixed inset-0 flex items-center justify-center;
            }
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display antialiased flex flex-col md:flex-row h-screen overflow-hidden">

    <nav class="order-last md:order-first w-full md:w-24 lg:w-64 bg-white/80 md:bg-white dark:bg-slate-900/80 backdrop-blur-xl md:backdrop-blur-none border-t md:border-t-0 md:border-r border-slate-100 dark:border-slate-800 p-4 md:py-8 flex md:flex-col justify-around md:justify-start items-center lg:items-start gap-4 z-30 flex-shrink-0">

        <div class="hidden lg:flex items-center gap-2 mb-8 px-4 w-full">
            <span class="material-symbols-outlined text-primary text-3xl font-variation-fill">child_care</span>
            <span class="font-bold text-xl text-primary">SI CUBIT</span>
        </div>

        <?php $isBeranda = url_is('/') || url_is('dashboard*'); ?>
        <a class="flex flex-col lg:flex-row items-center lg:justify-start gap-1 lg:gap-3 group w-full lg:px-4 lg:py-3 lg:rounded-xl transition-colors <?= $isBeranda ? 'text-primary lg:bg-primary-light dark:lg:bg-primary-900/30' : 'text-slate-400 hover:text-primary lg:hover:bg-primary-light dark:lg:hover:bg-primary-900/20' ?>"
            href="<?= base_url('dashboard') ?>">
            <span class="material-symbols-outlined text-[28px] lg:text-2xl <?= $isBeranda ? 'font-variation-fill' : '' ?>">grid_view</span>
            <span class="text-[10px] lg:text-sm <?= $isBeranda ? 'font-bold' : 'font-medium' ?>">Beranda</span>
        </a>

        <?php $isChat = url_is('chat*'); ?>
        <a class="flex flex-col lg:flex-row items-center lg:justify-start gap-1 lg:gap-3 group w-full lg:px-4 lg:py-3 lg:rounded-xl transition-colors <?= $isChat ? 'text-primary lg:bg-primary-light dark:lg:bg-primary-900/30' : 'text-slate-400 hover:text-primary lg:hover:bg-primary-light dark:lg:hover:bg-primary-900/20' ?>"
            href="<?= base_url('chat') ?>">
            <span class="material-symbols-outlined text-[28px] lg:text-2xl <?= $isChat ? 'font-variation-fill' : '' ?>">chat_bubble</span>
            <span class="text-[10px] lg:text-sm <?= $isChat ? 'font-bold' : 'font-medium' ?>">Chat AI</span>
        </a>

        <?php $isEdukasi = url_is('edukasi*'); ?>
        <a class="flex flex-col lg:flex-row items-center lg:justify-start gap-1 lg:gap-3 group w-full lg:px-4 lg:py-3 lg:rounded-xl transition-colors <?= $isEdukasi ? 'text-primary lg:bg-primary-light dark:lg:bg-primary-900/30' : 'text-slate-400 hover:text-primary lg:hover:bg-primary-light dark:lg:hover:bg-primary-900/20' ?>"
            href="<?= base_url('edukasi/video') ?>">
            <span class="material-symbols-outlined text-[28px] lg:text-2xl <?= $isEdukasi ? 'font-variation-fill' : '' ?>">menu_book</span>
            <span class="text-[10px] lg:text-sm <?= $isEdukasi ? 'font-bold' : 'font-medium' ?>">Edukasi</span>
        </a>

        <?php $isProfil = url_is('profil*'); ?>
        <a class="flex flex-col lg:flex-row items-center lg:justify-start gap-1 lg:gap-3 group w-full lg:px-4 lg:py-3 lg:rounded-xl transition-colors <?= $isProfil ? 'text-primary lg:bg-primary-light dark:lg:bg-primary-900/30' : 'text-slate-400 hover:text-primary lg:hover:bg-primary-light dark:lg:hover:bg-primary-900/20' ?>"
            href="<?= base_url('profil') ?>">
            <span class="material-symbols-outlined text-[28px] lg:text-2xl <?= $isProfil ? 'font-variation-fill' : '' ?>">person</span>
            <span class="text-[10px] lg:text-sm <?= $isProfil ? 'font-bold' : 'font-medium' ?>">Profil</span>
        </a>

    </nav>

    <main class="flex-1 flex flex-col h-full overflow-hidden relative z-20">
        <?= $this->renderSection('content') ?>
    </main>

    <div id="page-loader" class="fixed top-0 left-0 w-full h-full z-[9999] bg-white dark:bg-slate-900 flex items-center justify-center transition-opacity duration-500" style="opacity: 1; display: flex;">
        <div class="flex flex-col items-center justify-center">
            <div class="relative flex items-center justify-center w-28 h-28">
                <div class="absolute inset-0 bg-blue-100 dark:bg-slate-800 rounded-full animate-pulse opacity-60"></div>
                <svg class="w-16 h-16 text-primary relative z-10 animate-bounce" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2.5-9c.83 0 1.5-.67 1.5-1.5S10.33 8 9.5 8 8 8.67 8 9.5 8.83 11 9.5 11zm5 0c.83 0 1.5-.67 1.5-1.5S15.83 8 15 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 4c-2.28 0-4.22-1.66-5-4h10c-.78 2.34-2.72 4-5 4z" />
                </svg>
            </div>
            <div class="mt-6 text-center">
                <p class="text-primary font-black text-xl tracking-[0.2em] animate-pulse">SI CUBIT</p>
                <p class="text-slate-400 text-[10px] mt-1 font-medium">Memuat kebahagiaan Bunda...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const loader = document.getElementById("page-loader");

            if (!loader) return;

            // Fade out saat halaman selesai dimuat
            window.addEventListener("load", () => {
                loader.style.opacity = "0";
                setTimeout(() => {
                    loader.style.display = "none";
                }, 200); 
            });

            // Tampilkan loader saat link diklik (kecuali link kosong/tab baru)
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", function (e) {
                    const href = this.getAttribute("href");

                    if (!href || href.startsWith("#") || href.startsWith("javascript") || this.target === "_blank") {
                        return;
                    }

                    e.preventDefault();
                    loader.style.display = "flex";
                    // Sedikit delay agar display:flex ter-render sebelum opacity berubah
                    requestAnimationFrame(() => {
                        loader.style.opacity = "1";
                    });

                    window.location.assign(href);
                });
            });
        });
    </script>
</body>
</html>