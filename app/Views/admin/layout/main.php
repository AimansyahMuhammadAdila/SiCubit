<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: { extend: { colors: { "primary": "#1e40af", "secondary": "#64748b" }, fontFamily: { sans: ["Plus Jakarta Sans", "sans-serif"] } } }
        }
    </script>
</head>

<body class="bg-slate-50 font-sans antialiased flex">

    <aside class="w-64 h-screen bg-slate-900 text-slate-300 flex-shrink-0 sticky top-0 hidden md:flex flex-col">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <span class="material-symbols-outlined text-blue-400 text-3xl">child_care</span>
            <span class="font-bold text-xl text-white tracking-tight">SI CUBIT <span
                    class="text-[10px] block font-normal text-slate-500 uppercase">Admin Panel</span></span>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Layanan Utama</p>

            <?php $isDashboard = url_is('admin/dashboard*'); ?>
            <a href="<?= base_url('admin/dashboard') ?>"
                class="flex items-center gap-4 px-4 py-3.5 transition-all duration-300 rounded-2xl 
       <?= $isDashboard ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-slate-500 hover:bg-slate-50 font-semibold' ?>">
                <span
                    class="material-symbols-outlined <?= $isDashboard ? 'font-variation-fill' : '' ?>">dashboard</span>
                Dashboard
            </a>

            <?php $isDataIbu = url_is('admin/data-ibu*') || url_is('admin/detail*'); ?>
            <a href="<?= base_url('admin/data-ibu') ?>"
                class="flex items-center gap-4 px-4 py-3.5 transition-all duration-300 rounded-2xl 
       <?= $isDataIbu ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-slate-500 hover:bg-slate-50 font-semibold' ?>">
                <span class="material-symbols-outlined <?= $isDataIbu ? 'font-variation-fill' : '' ?>">groups</span>
                Data Ibu & Anak
            </a>

            <?php $isVideo = url_is('admin/video*'); ?>
            <a href="<?= base_url('admin/video') ?>"
                class="flex items-center gap-4 px-4 py-3.5 transition-all duration-300 rounded-2xl 
       <?= $isVideo ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-slate-500 hover:bg-slate-50 font-semibold' ?>">
                <span class="material-symbols-outlined <?= $isVideo ? 'font-variation-fill' : '' ?>">smart_display</span>
                Kelola Video Edukasi
            </a>

            <?php $isKategori = url_is('admin/kategori-video*'); ?>
            <a href="<?= base_url('admin/kategori-video') ?>"
                class="flex items-center gap-4 px-4 py-3.5 transition-all duration-300 rounded-2xl 
       <?= $isKategori ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-slate-500 hover:bg-slate-50 font-semibold' ?>">
                <span class="material-symbols-outlined <?= $isKategori ? 'font-variation-fill' : '' ?>">category</span>
                Kategori Video
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a href="<?= base_url('admin/logout') ?>"
                class="flex items-center gap-3 px-4 py-3 text-rose-400 hover:bg-rose-900/20 rounded-xl transition"><span
                    class="material-symbols-outlined">logout</span> Keluar</a>
        </div>
    </aside>

    <main class="flex-1 p-8 h-screen overflow-y-auto">
        <?= $this->renderSection('content') ?>
    </main>

</body>

</html>