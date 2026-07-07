<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'SI CUBIT') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <script>
        // Konfigurasi warna kustom SI CUBIT
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4A90E2',
                        'warm-gray': '#94a3b8',
                    }
                }
            }
        }
    </script>
    
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box;
            background-color: #f8fafc !important;
            color: #1e293b !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <?= $this->renderSection('content') ?>

    <div id="page-loader" style="position: fixed; inset: 0; background: #ffffff; z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.3s ease;">
        <div style="text-align: center; font-family: 'Plus Jakarta Sans', sans-serif;">
            <p style="color: #4A90E2; font-weight: 900; font-size: 1.5rem; letter-spacing: 0.2em; margin: 0;">SI CUBIT</p>
            <p style="color: #94a3b8; font-size: 0.75rem; margin-top: 4px;">Memuat kebahagiaan Bunda...</p>
        </div>
    </div>

    <script>
        window.addEventListener("load", () => {
            const loader = document.getElementById("page-loader");
            if (loader) {
                loader.style.opacity = "0";
                setTimeout(() => { loader.style.display = "none"; }, 300);
            }
        });
    </script>
</body>
</html>