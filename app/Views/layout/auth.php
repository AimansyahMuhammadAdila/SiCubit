<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'SI CUBIT') ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        /* Memastikan tidak ada sisa margin bawaan browser */
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
    </style>
</head>

<body class="bg-white antialiased">

    <?= $this->renderSection('content') ?>
    <div id="page-loader"
        class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-500"
        style="opacity: 1; display: flex;">

        <div class="flex flex-col items-center justify-center">
            <div class="relative flex items-center justify-center w-28 h-28">
                <div class="absolute inset-0 bg-blue-100 rounded-full animate-pulse opacity-60"></div>

                <svg class="w-16 h-16 text-primary relative z-10 animate-bounce" viewBox="0 0 24 24" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2.5-9c.83 0 1.5-.67 1.5-1.5S10.33 8 9.5 8 8 8.67 8 9.5 8.83 11 9.5 11zm5 0c.83 0 1.5-.67 1.5-1.5S15.83 8 15 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 4c-2.28 0-4.22-1.66-5-4h10c-.78 2.34-2.72 4-5 4z" />
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

            // Fade out TANPA delay tambahan
            window.addEventListener("load", () => {
                loader.style.opacity = "0";
                setTimeout(() => {
                    loader.style.display = "none";
                }, 200); // lebih cepat
            });

            // Klik link TANPA delay 300ms
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", function (e) {
                    const href = this.getAttribute("href");

                    if (!href || href.startsWith("#") || href.startsWith("javascript") || this.target === "_blank") {
                        return;
                    }

                    e.preventDefault();

                    loader.style.display = "flex";
                    loader.style.opacity = "1";

                    // langsung pindah, jangan tunggu 300ms
                    window.location.assign(href);
                });
            });
        });
    </script>
</body>

</html>