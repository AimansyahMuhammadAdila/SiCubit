<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Selamat Datang di SiCubit') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
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

        .gold-border {
            border: 2.5px solid #D4AF37;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35);
        }

        .full-app-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
            padding: 1.25rem;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="text-slate-800 antialiased min-h-screen w-full flex flex-col justify-between">

    <div class="full-app-container max-w-6xl mx-auto w-full">

        <!-- TOP KEMENKES LOGO PILL (HEADER) -->
        <header class="w-full flex items-center justify-start z-30 pt-2 flex-shrink-0">
            <div class="bg-white/95 backdrop-blur-md px-5 sm:px-6 py-3 rounded-full shadow-lg border border-white/80 flex items-center gap-3">
                <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes Banjarmasin" class="h-10 sm:h-12 md:h-14 object-contain">
            </div>
        </header>

        <!-- MAIN HERO SECTION (BRANDING GROUP & ACTION BUTTONS) -->
        <main class="flex-1 flex flex-col items-center justify-center text-center z-20 w-full max-w-md mx-auto py-2 my-auto">
            
            <!-- SINGLE UNIFIED BRANDING GROUP (LOGO + TEXT TIGHTLY INTEGRATED AT ~10PX GAP) -->
            <div class="flex flex-col items-center justify-center text-center w-full mb-6">
                <!-- 3D Mother & Child Logo Illustration (Cropped tight to 1:1 aspect ratio) -->
                <img src="<?= base_url('uploads/Logo.png') ?>" 
                     alt="SiCubit Logo Maskot Ibu dan Anak" 
                     class="w-52 sm:w-60 md:w-68 h-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-300 pointer-events-none select-none">
                
                <!-- Brand Title (Sits exactly ~10px under logo) -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-[#162065] tracking-tight mt-2.5 drop-shadow-md">
                    SiCubit
                </h1>
            </div>

            <!-- ACTION BUTTONS: MASUK & DAFTAR -->
            <div class="w-full space-y-3.5 sm:space-y-4">
                <a href="<?= base_url('login') ?>" 
                   class="block w-full py-3.5 sm:py-4 bg-black hover:bg-slate-900 text-white font-black text-lg sm:text-xl rounded-2xl text-center gold-border uppercase tracking-wider transition-all active:scale-95 shadow-xl">
                    MASUK
                </a>
                
                <a href="<?= base_url('register') ?>" 
                   class="block w-full py-3.5 sm:py-4 bg-black hover:bg-slate-900 text-white font-black text-xl rounded-2xl text-center gold-border uppercase tracking-wider transition-all active:scale-95 shadow-xl">
                    DAFTAR
                </a>
            </div>

            <!-- SECONDARY LINK -->
            <p class="text-xs sm:text-sm font-bold text-slate-800 mt-4 sm:mt-5">
                Belum punya akun? <a href="<?= base_url('register') ?>" class="text-[#162065] font-black underline hover:text-blue-950 transition">Daftar</a>
            </p>

        </main>

        <footer class="text-center py-2 text-[11px] text-slate-500 font-medium flex-shrink-0">
            &copy; <?= date('Y') ?> SI CUBIT - Kemenkes Poltekkes Banjarmasin
        </footer>

    </div>

</body>
</html>