<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-12 rounded-2xl bg-[#162065] p-1.5 flex items-center justify-center shadow-md">
                    <img src="<?= base_url('uploads/Profil.png') ?>" alt="Profil" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Profil Bunda</h1>
                    <p class="text-xs text-slate-600 font-medium">Informasi data diri dan pengaturan akun</p>
                </div>
            </div>
            <a href="<?= base_url('profil/edit') ?>" class="bg-[#162065] hover:bg-[#101850] text-white px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider shadow-md transition flex items-center gap-1">
                <span class="material-symbols-outlined text-base">edit</span> Edit
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-20 pb-24">
    <div class="max-w-4xl mx-auto">

        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 mb-8">
            <div class="relative">
                <div
                    class="size-24 md:size-28 rounded-full bg-slate-100 border-4 border-white dark:border-slate-800 shadow-md overflow-hidden flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined text-6xl font-variation-fill">face_3</span>
                </div>
                <a href="<?= base_url('profil/edit') ?>"
                    class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg hover:bg-primary-dark transition active:scale-90 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </a>
            </div>

            <div class="text-center md:text-left flex-1">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-1">
                    Bunda <?= esc($ibu['nama'] ?? 'Pengguna') ?>
                </h2>
                <p class="text-slate-500 text-sm mb-3">
                    <?= esc($ibu['pekerjaan'] ?? 'Ibu Rumah Tangga') ?> • <?= esc($ibu['umur'] ?? '0') ?> Tahun
                </p>
                <div
                    class="inline-flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold px-3 py-1.5 rounded-full border border-green-100 dark:border-green-800/50">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                    Akun Aktif Terverifikasi
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <div
                    class="flex items-center justify-between mb-5 border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary font-variation-fill">person</span> Data Diri
                    </h3>
                    <a href="<?= base_url('profil/edit') ?>"
                        class="text-primary text-xs font-bold hover:underline transition-colors">Edit</a>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Nomor Telepon / WhatsApp</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200"><?= esc($ibu['no_telp']) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Alamat Lengkap</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            <?= !empty($ibu['alamat']) ? esc($ibu['alamat']) : '<span class="text-slate-400 italic">Belum diisi</span>' ?>
                        </p>
                    </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Jumlah Anak</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                <?= esc($ibu['jumlah_anak']) ?> Orang
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Status Kehamilan</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 uppercase text-xs">
                                <?= str_replace('_', ' ', esc($ibu['status_kehamilan'] ?? 'pasca_melahirkan')) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <div
                    class="flex items-center justify-between mb-5 border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-500 font-variation-fill">favorite</span> Info
                        Terdaftar
                    </h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Kabupaten / Kota</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            <?= esc($ibu['tipe_kabkota'] ?? '') ?> <?= esc($ibu['nama_kabkota'] ?? 'Belum diatur') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Puskesmas Rujukan (ID)</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            <?= esc($ibu['nama_puskesmas'] ?? 'Belum diatur') ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Bergabung Sejak</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            <?= !empty($ibu['created_at']) ? date('d F Y', strtotime($ibu['created_at'])) : 'Baru saja' ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8">
            <button id="btnLogout"
                class="w-full md:w-auto md:min-w-[200px] md:float-right bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold py-4 px-8 rounded-2xl shadow-sm transition-transform active:scale-95 flex items-center justify-center gap-2 border border-rose-100 dark:border-rose-900/50">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar Akun</span>
            </button>
            <div class="clear-both"></div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnLogout').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Keluar Aplikasi?',
            text: "Sesi Bunda akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then(async (result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Logging out...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                try {
                    // Panggil API logout yang sudah kamu buat
                    const response = await fetch('<?= base_url('api/logout') ?>', {
                        method: 'POST'
                    });
                    const resData = await response.json();

                    if (resData.status === 'success') {
                        window.location.href = '<?= base_url('login') ?>';
                    } else {
                        Swal.fire('Oops', 'Gagal logout.', 'error');
                    }
                } catch (err) {
                    // Fallback jika terjadi error fetch, tetap paksa pindah ke halaman login
                    window.location.href = '<?= base_url('login') ?>';
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>