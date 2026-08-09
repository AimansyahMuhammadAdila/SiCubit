<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: { "primary": "#162065", "primary-navy": "#101850", "bg-soft": "#f8fafc" },
                    fontFamily: { "display": ["Plus Jakarta Sans", "sans-serif"] }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url('<?= base_url('uploads/Background.png') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        @keyframes slideUp {
            from { transform: translateY(16px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="font-display min-h-screen flex overflow-x-hidden text-slate-800">

    <?= $this->include('admin/layout/sidebar') ?>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 min-w-0 flex flex-col min-h-screen">

        <!-- HEADER TOPBAR -->
        <header class="bg-white/80 backdrop-blur-md border-b border-white/60 p-4 lg:p-6 sticky top-0 z-30 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 class="text-xl lg:text-2xl font-extrabold text-[#162065] tracking-tight">Kelola Artikel Edukasi</h1>
                    <p class="text-xs text-slate-500 font-medium">Manajemen artikel berita, tips kesehatan, dan artikel edukasi untuk ibu</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= base_url('admin/kategori-artikel') ?>" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-2xl font-extrabold text-xs transition">
                    <span class="material-symbols-outlined text-sm">folder_special</span> Kategori Artikel
                </a>
                <button onclick="openAddModal()" class="flex items-center gap-2 bg-[#162065] hover:bg-[#101850] text-white px-4 py-2.5 rounded-2xl font-extrabold text-xs shadow-lg shadow-[#162065]/20 transition transform active:scale-95">
                    <span class="material-symbols-outlined text-sm">add_circle</span> Tambah Artikel Baru
                </button>
            </div>
        </header>

        <div class="p-4 lg:p-8 space-y-6 flex-1">

            <!-- NOTIFIKASI -->
            <?php if (session()->getFlashdata('success')): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= esc(session()->getFlashdata('success')) ?>',
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-3xl' }
                    });
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '<?= esc(session()->getFlashdata('error')) ?>',
                        customClass: { popup: 'rounded-3xl' }
                    });
                </script>
            <?php endif; ?>

            <!-- CARDS STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 border border-white/60 shadow-lg flex items-center gap-4">
                    <div class="size-14 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-3xl">newspaper</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Artikel</p>
                        <h3 class="text-2xl font-black text-[#162065]"><?= count($artikels) ?></h3>
                    </div>
                </div>
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 border border-white/60 shadow-lg flex items-center gap-4">
                    <div class="size-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-3xl">visibility</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Published</p>
                        <h3 class="text-2xl font-black text-emerald-600">
                            <?= count(array_filter($artikels, fn($a) => ($a['status'] ?? 'published') === 'published')) ?>
                        </h3>
                    </div>
                </div>
                <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 border border-white/60 shadow-lg flex items-center gap-4">
                    <div class="size-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-3xl">draft</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Draft / Sembunyi</p>
                        <h3 class="text-2xl font-black text-amber-600">
                            <?= count(array_filter($artikels, fn($a) => ($a['status'] ?? '') === 'draft')) ?>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- TABLE DAFTAR ARTIKEL -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl border border-white/60 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-[#162065]">Daftar Artikel Edukasi</h2>
                        <p class="text-xs text-slate-500">Artikel berstatus published akan langsung tampil pada menu Ruang Edukasi pengguna.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- FORM PENCARIAN -->
                        <form action="<?= base_url('admin/artikel') ?>" method="GET" class="relative flex items-center">
                            <?php if (!empty($selectedKategori)): ?>
                                <input type="hidden" name="kategori" value="<?= esc($selectedKategori) ?>">
                            <?php endif; ?>
                            <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" placeholder="Cari judul artikel..." class="pl-9 pr-8 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:ring-0 focus:border-[#162065] w-48 sm:w-60">
                            <span class="material-symbols-outlined text-slate-400 text-sm absolute left-2.5 pointer-events-none">search</span>
                            <?php if (!empty($searchQuery)): ?>
                                <a href="<?= base_url('admin/artikel') ?><?= !empty($selectedKategori) ? '?kategori=' . esc($selectedKategori) : '' ?>" class="absolute right-2.5 text-slate-400 hover:text-slate-600">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </a>
                            <?php endif; ?>
                        </form>

                        <!-- FILTER KATEGORI -->
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-bold text-slate-500 whitespace-nowrap">Kategori:</label>
                            <select onchange="window.location.href='<?= base_url('admin/artikel') ?>?' + (this.value ? 'kategori=' + this.value + '&' : '') + '<?= !empty($searchQuery) ? 'q=' . urlencode($searchQuery) : '' ?>'" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:ring-0 focus:border-[#162065]">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($selectedKategori == $cat['id']) ? 'selected' : '' ?>>
                                        <?= esc($cat['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-400 font-extrabold uppercase tracking-wider">
                            <tr>
                                <th class="p-4 pl-6 w-12 text-center">No</th>
                                <th class="p-4 w-32">Gambar</th>
                                <th class="p-4">Judul & Isi Artikel</th>
                                <th class="p-4 w-36">Kategori</th>
                                <th class="p-4 w-36">Penulis (Author)</th>
                                <th class="p-4 w-28">Status</th>
                                <th class="p-4 w-36">Tanggal</th>
                                <th class="p-4 pr-6 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            <?php if (empty($artikels)): ?>
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400 italic font-semibold">
                                        Belum ada artikel yang ditambahkan<?= !empty($selectedKategori) ? ' untuk kategori ini' : '' ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($artikels as $idx => $art): ?>
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 pl-6 text-center font-bold text-slate-400"><?= $idx + 1 ?></td>
                                        <td class="p-4">
                                            <?php if (!empty($art['thumbnail_url'])): ?>
                                                <div class="w-24 h-16 bg-slate-900 rounded-xl overflow-hidden relative shadow-sm border border-slate-200">
                                                    <img src="<?= base_url(esc($art['thumbnail_url'])) ?>" alt="Gambar Artikel" class="w-full h-full object-cover">
                                                </div>
                                            <?php else: ?>
                                                <div class="w-24 h-16 bg-slate-100 rounded-xl flex flex-col items-center justify-center text-slate-400 border border-slate-200">
                                                    <span class="material-symbols-outlined text-xl">hide_image</span>
                                                    <span class="text-[9px] font-bold">No Image</span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4">
                                            <h4 class="font-extrabold text-slate-900 text-sm mb-1 line-clamp-1"><?= esc($art['judul']) ?></h4>
                                            <p class="text-xs text-slate-500 line-clamp-2"><?= strip_tags($art['isi_konten']) ?></p>
                                        </td>
                                        <td class="p-4">
                                            <?php if (!empty($art['nama_kategori'])): ?>
                                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 font-extrabold rounded-lg text-[10px] inline-block">
                                                    <?= esc($art['nama_kategori']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-slate-400 italic text-[11px]">Tanpa Kategori</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4">
                                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-extrabold rounded-lg text-[10px] inline-block">
                                                <?= esc($art['nama_penulis'] ?: 'Bidan Admin') ?>
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            <?php if (($art['status'] ?? 'published') === 'published'): ?>
                                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 font-extrabold rounded-full text-[10px] inline-flex items-center gap-1">
                                                    <span class="size-1.5 rounded-full bg-emerald-500"></span> Published
                                                </span>
                                            <?php else: ?>
                                                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-extrabold rounded-full text-[10px] inline-flex items-center gap-1">
                                                    <span class="size-1.5 rounded-full bg-amber-500"></span> Draft
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4 text-xs text-slate-500 font-semibold">
                                            <?= !empty($art['created_at']) ? date('d M Y, H:i', strtotime($art['created_at'])) : '-' ?>
                                        </td>
                                        <td class="p-4 pr-6 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <button onclick='openEditModal(<?= json_encode($art, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition" title="Edit Artikel">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button onclick="confirmDelete(<?= $art['id'] ?>, '<?= esc($art['judul'], 'js') ?>')" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition" title="Hapus Artikel">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <!-- MODAL TAMBAH ARTIKEL -->
    <div id="addModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-100 animate-slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">newspaper</span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#162065] text-lg">Tambah Artikel Edukasi Baru</h3>
                        <p class="text-xs text-slate-500">Isi judul, kategori, unggah gambar (opsional), dan isi artikel</p>
                    </div>
                </div>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1"><span class="material-symbols-outlined">close</span></button>
            </div>

            <form action="<?= base_url('admin/artikel/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Judul Artikel Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Pentingnya Inisiasi Menyusu Dini (IMD) Bagi Bayi Baru Lahir" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Artikel</label>
                    <select name="id_kategori" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                        <option value="">-- Pilih Kategori Artikel --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= esc($cat['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Gambar Pendukung (Opsional)</label>
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Isi Konten Artikel <span class="text-rose-500">*</span></label>
                    <textarea name="isi_konten" rows="8" required placeholder="Tuliskan isi berita atau panduan edukasi lengkap di sini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-medium text-slate-800 leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select name="status" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                        <option value="published">Published (Tampil di Ruang Edukasi User)</option>
                        <option value="draft">Draft (Sembunyikan Sementara)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold text-xs transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#162065] hover:bg-[#101850] text-white font-extrabold text-xs shadow-md transition">Simpan Artikel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ARTIKEL -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-100 animate-slide-up max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">edit</span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#162065] text-lg">Edit Artikel Edukasi</h3>
                        <p class="text-xs text-slate-500">Perbarui judul, kategori, gambar, atau isi konten artikel</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1"><span class="material-symbols-outlined">close</span></button>
            </div>

            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_judul" name="judul" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Artikel</label>
                    <select id="edit_id_kategori" name="id_kategori" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                        <option value="">-- Tanpa Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= esc($cat['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    <p id="current_image_text" class="text-[10px] text-slate-500 mt-1 italic"></p>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Isi Konten Artikel <span class="text-rose-500">*</span></label>
                    <textarea id="edit_isi_konten" name="isi_konten" rows="8" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-medium text-slate-800 leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select id="edit_status" name="status" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                        <option value="published">Published (Tampil di Ruang Edukasi User)</option>
                        <option value="draft">Draft (Sembunyikan Sementara)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold text-xs transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#162065] hover:bg-[#101850] text-white font-extrabold text-xs shadow-md transition">Update Artikel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(artikel) {
            document.getElementById('editForm').action = '<?= base_url('admin/artikel/update') ?>/' + artikel.id;
            document.getElementById('edit_judul').value = artikel.judul || '';
            document.getElementById('edit_id_kategori').value = artikel.id_kategori || '';
            document.getElementById('edit_isi_konten').value = artikel.isi_konten || '';
            document.getElementById('edit_status').value = artikel.status || 'published';

            const imgText = document.getElementById('current_image_text');
            if (artikel.thumbnail_url) {
                imgText.innerText = 'Gambar saat ini ada. Pilih file baru jika ingin menggantinya.';
            } else {
                imgText.innerText = 'Belum ada gambar yang diunggah untuk artikel ini.';
            }

            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id, judul) {
            Swal.fire({
                title: 'Hapus Artikel?',
                text: `Apakah Anda yakin ingin menghapus artikel "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/artikel/delete') ?>/' + id;
                }
            });
        }
    </script>
</body>
</html>
