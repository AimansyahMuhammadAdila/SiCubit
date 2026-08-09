<?php
    $isDashboard       = url_is('admin/dashboard*');
    $isDataIbu         = url_is('admin/data-ibu*') || url_is('admin/detail*');

    $isVideoActive     = url_is('admin/video*') || url_is('admin/kategori-video*');
    $isKelolaVideo     = url_is('admin/video*');
    $isKategoriVideo   = url_is('admin/kategori-video*');

    $isArtikelActive   = (url_is('admin/artikel*') && !url_is('admin/kategori-artikel*')) || url_is('admin/kategori-artikel*');
    $isKelolaArtikel   = url_is('admin/artikel*') && !url_is('admin/kategori-artikel*');
    $isKategoriArtikel = url_is('admin/kategori-artikel*');
?>

<div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- SIDEBAR ADMIN -->
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white/95 backdrop-blur-md border-r border-white/60 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen shadow-xl">
    <div class="p-6 flex items-center justify-between">
        <div class="bg-white/90 px-3 py-1.5 rounded-full shadow border border-slate-200 flex items-center gap-2">
            <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes" class="h-8 object-contain">
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 p-2"><span class="material-symbols-outlined">close</span></button>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Portal Admin SiCubit</p>
        
        <!-- 1. DASHBOARD -->
        <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl font-extrabold text-xs transition-all <?= $isDashboard ? 'bg-[#162065] text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100' ?>">
            <span class="material-symbols-outlined text-xl">dashboard</span> Dashboard Utama
        </a>

        <!-- 2. DATA IBU & ANAK -->
        <a href="<?= base_url('admin/data-ibu') ?>" class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl font-extrabold text-xs transition-all <?= $isDataIbu ? 'bg-[#162065] text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100' ?>">
            <span class="material-symbols-outlined text-xl">groups</span> Data Ibu & Anak
        </a>

        <!-- 3. PARENT MENU: VIDEO EDUKASI -->
        <div class="space-y-1">
            <button type="button" onclick="toggleSubmenu('submenu-video', 'arrow-video')" 
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-2xl font-extrabold text-xs transition-all <?= $isVideoActive ? 'bg-indigo-50 text-[#162065] border border-indigo-100' : 'text-slate-700 hover:bg-slate-100' ?>">
                <div class="flex items-center gap-3.5">
                    <span class="material-symbols-outlined text-xl">smart_display</span>
                    <span>Video Edukasi</span>
                </div>
                <span id="arrow-video" class="material-symbols-outlined text-base transition-transform duration-200 <?= $isVideoActive ? 'rotate-180' : '' ?>">expand_more</span>
            </button>
            <div id="submenu-video" class="pl-4 pr-1 space-y-1.5 pt-1 <?= $isVideoActive ? '' : 'hidden' ?>">
                <a href="<?= base_url('admin/video') ?>" 
                   class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs transition-all <?= $isKelolaVideo ? 'bg-[#162065] text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-[#162065] font-bold' ?>">
                    <span class="size-2 rounded-full <?= $isKelolaVideo ? 'bg-white' : 'bg-slate-300' ?>"></span>
                    <span>Kelola Video</span>
                </a>
                <a href="<?= base_url('admin/kategori-video') ?>" 
                   class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs transition-all <?= $isKategoriVideo ? 'bg-[#162065] text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-[#162065] font-bold' ?>">
                    <span class="size-2 rounded-full <?= $isKategoriVideo ? 'bg-white' : 'bg-slate-300' ?>"></span>
                    <span>Kategori Video</span>
                </a>
            </div>
        </div>

        <!-- 4. PARENT MENU: ARTIKEL EDUKASI -->
        <div class="space-y-1">
            <button type="button" onclick="toggleSubmenu('submenu-artikel', 'arrow-artikel')" 
                    class="w-full flex items-center justify-between px-4 py-3.5 rounded-2xl font-extrabold text-xs transition-all <?= $isArtikelActive ? 'bg-indigo-50 text-[#162065] border border-indigo-100' : 'text-slate-700 hover:bg-slate-100' ?>">
                <div class="flex items-center gap-3.5">
                    <span class="material-symbols-outlined text-xl">newspaper</span>
                    <span>Artikel Edukasi</span>
                </div>
                <span id="arrow-artikel" class="material-symbols-outlined text-base transition-transform duration-200 <?= $isArtikelActive ? 'rotate-180' : '' ?>">expand_more</span>
            </button>
            <div id="submenu-artikel" class="pl-4 pr-1 space-y-1.5 pt-1 <?= $isArtikelActive ? '' : 'hidden' ?>">
                <a href="<?= base_url('admin/artikel') ?>" 
                   class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs transition-all <?= $isKelolaArtikel ? 'bg-[#162065] text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-[#162065] font-bold' ?>">
                    <span class="size-2 rounded-full <?= $isKelolaArtikel ? 'bg-white' : 'bg-slate-300' ?>"></span>
                    <span>Kelola Artikel</span>
                </a>
                <a href="<?= base_url('admin/kategori-artikel') ?>" 
                   class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs transition-all <?= $isKategoriArtikel ? 'bg-[#162065] text-white font-black shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-[#162065] font-bold' ?>">
                    <span class="size-2 rounded-full <?= $isKategoriArtikel ? 'bg-white' : 'bg-slate-300' ?>"></span>
                    <span>Kategori Artikel</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="p-6 border-t border-slate-100 bg-slate-50/50">
        <div class="flex items-center gap-3 p-2 bg-white rounded-2xl border border-slate-100 mb-4">
            <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold">BN</div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-slate-800 truncate">Bidan Nurul</p>
                <p class="text-[10px] text-slate-400 italic">Pusk. Banjarbaru</p>
            </div>
        </div>
        <a href="<?= base_url('admin/logout') ?>" class="flex items-center justify-center gap-2 w-full py-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl font-bold text-xs transition">
            <span class="material-symbols-outlined text-sm">logout</span> Keluar Sistem
        </a>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar) sidebar.classList.toggle('-translate-x-full');
        if (overlay) overlay.classList.toggle('hidden');
    }

    function toggleSubmenu(submenuId, arrowId) {
        const submenu = document.getElementById(submenuId);
        const arrow = document.getElementById(arrowId);
        if (submenu) {
            submenu.classList.toggle('hidden');
        }
        if (arrow) {
            arrow.classList.toggle('rotate-180');
        }
    }
</script>
