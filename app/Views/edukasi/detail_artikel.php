<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full gap-6 max-w-4xl mx-auto">

    <!-- SUBPAGE HEADER (BACK BUTTON & TITLE) -->
    <div>
        <a href="<?= base_url('edukasi/artikel') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-4">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Daftar Artikel
        </a>
    </div>

    <!-- MAIN ARTICLE CONTAINER CARD -->
    <article class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 overflow-hidden p-6 sm:p-10">
        
        <!-- META HEADER -->
        <div class="mb-6 border-b border-slate-100 pb-6">
            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 font-bold mb-3">
                <span class="flex items-center gap-1.5 text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    <span class="material-symbols-outlined text-sm">person</span>
                    <span><?= esc($artikel['nama_penulis'] ?: 'Admin SI CUBIT') ?></span>
                </span>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    <span><?= date('d F Y', strtotime($artikel['created_at'])) ?></span>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-[#162065] leading-tight">
                <?= esc($artikel['judul']) ?>
            </h1>
        </div>

        <!-- FEATURED IMAGE IF AVAILABLE -->
        <?php if (!empty($artikel['thumbnail_url'])): ?>
            <div class="w-full max-h-[420px] rounded-2xl overflow-hidden bg-slate-100 mb-8 border border-slate-200 shadow-sm">
                <img src="<?= base_url(esc($artikel['thumbnail_url'])) ?>" alt="<?= esc($artikel['judul']) ?>" class="w-full h-full object-cover">
            </div>
        <?php endif; ?>

        <!-- ARTICLE BODY CONTENT -->
        <div class="prose prose-slate max-w-none text-slate-800 text-sm sm:text-base leading-relaxed font-normal space-y-4">
            <?= nl2br(esc($artikel['isi_konten'])) ?>
        </div>

        <!-- FOOTER INFO & SHARE / BACK -->
        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-xs text-slate-500 font-bold">
                <span class="material-symbols-outlined text-indigo-600">verified</span>
                <span>Diterbitkan oleh Tim Medis SI CUBIT</span>
            </div>

            <a href="<?= base_url('edukasi/artikel') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#162065] hover:bg-[#101850] text-white font-extrabold text-xs shadow transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Artikel Lainnya
            </a>
        </div>

    </article>

</div>

<?= $this->endSection() ?>
