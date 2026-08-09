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
                    <h1 class="text-xl lg:text-2xl font-extrabold text-[#162065] tracking-tight">Kategori Artikel Edukasi</h1>
                    <p class="text-xs text-slate-500 font-medium">Manajemen kategori untuk mengelompokkan artikel & berita kesehatan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= base_url('admin/artikel') ?>" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-2xl font-extrabold text-xs transition">
                    <span class="material-symbols-outlined text-sm">newspaper</span> Kelola Artikel
                </a>
                <button onclick="openAddModal()" class="flex items-center gap-2 bg-[#162065] hover:bg-[#101850] text-white px-4 py-2.5 rounded-2xl font-extrabold text-xs shadow-lg shadow-[#162065]/20 transition transform active:scale-95">
                    <span class="material-symbols-outlined text-sm">add_circle</span> Tambah Kategori
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

            <!-- TABLE DAFTAR KATEGORI -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl border border-white/60 shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-[#162065]">Daftar Kategori Artikel</h2>
                        <p class="text-xs text-slate-500">Kategori akan tampil sebagai tab filter pada halaman Ruang Edukasi artikel pengguna.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-400 font-extrabold uppercase tracking-wider">
                            <tr>
                                <th class="p-4 pl-6 w-12 text-center">No</th>
                                <th class="p-4">Nama Kategori</th>
                                <th class="p-4">Slug URL</th>
                                <th class="p-4">Deskripsi</th>
                                <th class="p-4 w-32 text-center">Jumlah Artikel</th>
                                <th class="p-4 pr-6 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400 italic font-semibold">
                                        Belum ada kategori artikel yang dibuat.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $idx => $cat): ?>
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 pl-6 text-center font-bold text-slate-400"><?= $idx + 1 ?></td>
                                        <td class="p-4 font-extrabold text-slate-900 text-sm">
                                            <?= esc($cat['nama_kategori']) ?>
                                        </td>
                                        <td class="p-4 font-mono text-[11px] text-indigo-600 bg-indigo-50/50 px-2 py-1 rounded w-fit">
                                            <?= esc($cat['slug']) ?>
                                        </td>
                                        <td class="p-4 text-xs text-slate-500">
                                            <?= esc($cat['deskripsi'] ?: '-') ?>
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="px-3 py-1 bg-blue-50 text-blue-700 font-extrabold rounded-full text-xs">
                                                <?= $cat['total_artikel'] ?> Artikel
                                            </span>
                                        </td>
                                        <td class="p-4 pr-6 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <button onclick='openEditModal(<?= json_encode($cat, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 transition" title="Edit Kategori">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button onclick="confirmDelete(<?= $cat['id'] ?>, '<?= esc($cat['nama_kategori'], 'js') ?>')" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 transition" title="Hapus Kategori">
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

    <!-- MODAL TAMBAH KATEGORI -->
    <div id="addModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 animate-slide-up">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">folder_special</span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#162065] text-lg">Tambah Kategori Artikel</h3>
                        <p class="text-xs text-slate-500">Buat topik pengelompokan artikel</p>
                    </div>
                </div>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1"><span class="material-symbols-outlined">close</span></button>
            </div>

            <form action="<?= base_url('admin/kategori-artikel/store') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_kategori" required placeholder="Contoh: Kesehatan Ibu & Kehamilan" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan jenis artikel yang termasuk dalam kategori ini..." class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold text-xs transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#162065] hover:bg-[#101850] text-white font-extrabold text-xs shadow-md transition">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KATEGORI -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 animate-slide-up">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">edit</span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#162065] text-lg">Edit Kategori Artikel</h3>
                        <p class="text-xs text-slate-500">Perbarui nama dan deskripsi kategori</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1"><span class="material-symbols-outlined">close</span></button>
            </div>

            <form id="editForm" action="" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_nama_kategori" name="nama_kategori" required class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-[#162065] focus:ring-0 text-sm font-semibold text-slate-800"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold text-xs transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#162065] hover:bg-[#101850] text-white font-extrabold text-xs shadow-md transition">Update Kategori</button>
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

        function openEditModal(cat) {
            document.getElementById('editForm').action = '<?= base_url('admin/kategori-artikel/update') ?>/' + cat.id;
            document.getElementById('edit_nama_kategori').value = cat.nama_kategori || '';
            document.getElementById('edit_deskripsi').value = cat.deskripsi || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: `Apakah Anda yakin ingin menghapus kategori "${nama}"? Artikel pada kategori ini tidak akan terhapus, namun kategorinya akan menjadi kosong.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/kategori-artikel/delete') ?>/' + id;
                }
            });
        }
    </script>
</body>
</html>
