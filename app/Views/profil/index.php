<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full gap-6">

    <!-- SUBPAGE HEADER -->
    <div class="mb-2">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="size-12 rounded-2xl bg-[#162065] p-1.5 flex items-center justify-center shadow-md flex-shrink-0">
                    <img src="<?= base_url('uploads/Profil.png') ?>" alt="Profil" class="w-full h-full object-contain filter drop-shadow">
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#162065] tracking-tight">Profil Bunda</h1>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium">Informasi data diri dan pengaturan akun pengguna</p>
                </div>
            </div>
            <a href="<?= base_url('profil/edit') ?>" class="bg-[#162065] hover:bg-[#101850] text-white px-4 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider shadow-lg shadow-[#162065]/20 transition flex items-center gap-2 active:scale-95">
                <span class="material-symbols-outlined text-sm">edit</span> Edit Profil
            </a>
        </div>
    </div>

    <div class="flex-1 w-full pb-20">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- HERO PROFILE CARD -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 size-48 bg-[#162065]/5 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row items-center gap-6 relative z-10">
                    <!-- AVATAR CONTAINER -->
                    <div class="relative flex-shrink-0">
                        <div class="size-24 sm:size-28 rounded-3xl bg-gradient-to-tr from-[#162065] to-blue-500 p-1 shadow-xl">
                            <div class="w-full h-full bg-white rounded-[22px] overflow-hidden flex items-center justify-center text-[#162065]">
                                <span class="material-symbols-outlined text-6xl font-variation-fill">face_3</span>
                            </div>
                        </div>
                        <a href="<?= base_url('profil/edit') ?>" class="absolute -bottom-1 -right-1 bg-[#162065] hover:bg-[#101850] text-white p-2 rounded-2xl shadow-lg transition active:scale-90 flex items-center justify-center border-2 border-white" title="Ubah Foto / Data">
                            <span class="material-symbols-outlined text-xs">edit</span>
                        </a>
                    </div>

                    <!-- USER CORE INFO -->
                    <div class="text-center sm:text-left flex-1 space-y-2">
                        <div class="flex items-center justify-center sm:justify-start gap-2 flex-wrap">
                            <h2 class="text-xl sm:text-2xl font-black text-[#162065]">
                                Bunda <?= esc($ibu['nama'] ?? 'Pengguna') ?>
                            </h2>
                            <div class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold px-3 py-1 rounded-full border border-emerald-200 shadow-sm">
                                <span class="material-symbols-outlined text-xs">verified</span> Terverifikasi
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-500 font-bold flex items-center justify-center sm:justify-start gap-2">
                            <span><?= esc($ibu['pekerjaan'] ?? 'Ibu Rumah Tangga') ?></span>
                            <span>•</span>
                            <span><?= esc($ibu['umur'] ?? '0') ?> Tahun</span>
                        </p>

                        <div class="pt-1 flex items-center justify-center sm:justify-start gap-2 flex-wrap">
                            <?php 
                                $statusHamil = $ibu['status_kehamilan'] ?? 'pasca_melahirkan';
                                $statusBadgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                $statusLabel = 'Pra Kehamilan';

                                if ($statusHamil === 'hamil') {
                                    $statusBadgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    $statusLabel = 'Masa Kehamilan (Hamil)';
                                } elseif ($statusHamil === 'pasca_melahirkan') {
                                    $statusBadgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $statusLabel = 'Pasca Melahirkan (Menyusui)';
                                }
                            ?>
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-black border shadow-sm inline-flex items-center gap-1.5 <?= $statusBadgeClass ?>">
                                <span class="size-2 rounded-full bg-current"></span> Status: <?= $statusLabel ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA DETAILS GRID (2 COLUMNS ON DESKTOP, 1 COLUMN ON MOBILE) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- CARD 1: DATA DIRI -->
                <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 p-6 flex flex-col justify-between hover:shadow-2xl transition duration-300">
                    <div>
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                            <h3 class="font-black text-[#162065] text-base flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#162065] text-xl">person</span> Data Diri
                            </h3>
                            <a href="<?= base_url('profil/edit') ?>" class="text-xs font-extrabold text-blue-600 hover:text-blue-800 transition flex items-center gap-0.5">
                                Edit <span class="material-symbols-outlined text-xs">chevron_right</span>
                            </a>
                        </div>

                        <div class="space-y-4">
                            <!-- TELP -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-blue-100">
                                    <span class="material-symbols-outlined text-lg">call</span>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Nomor Telepon / WhatsApp</p>
                                    <p class="text-sm font-extrabold text-slate-800 truncate"><?= esc($ibu['no_telp'] ?? '-') ?></p>
                                </div>
                            </div>

                            <!-- ALAMAT -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-amber-100">
                                    <span class="material-symbols-outlined text-lg">home_pin</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Alamat Lengkap</p>
                                    <p class="text-sm font-extrabold text-slate-800 leading-snug">
                                        <?= !empty($ibu['alamat']) ? esc($ibu['alamat']) : '<span class="text-slate-400 italic font-semibold">Belum diisi</span>' ?>
                                    </p>
                                </div>
                            </div>

                            <!-- JUMLAH ANAK -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-purple-100">
                                    <span class="material-symbols-outlined text-lg">child_care</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Jumlah Anak</p>
                                    <p class="text-sm font-extrabold text-slate-800">
                                        <?= esc($ibu['jumlah_anak'] ?? 0) ?> Anak
                                    </p>
                                </div>
                            </div>

                            <!-- STATUS KEHAMILAN -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-rose-100">
                                    <span class="material-symbols-outlined text-lg">ecg_heart</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Status Kehamilan</p>
                                    <p class="text-sm font-extrabold text-slate-800">
                                        <?= str_replace('_', ' ', esc(strtoupper($ibu['status_kehamilan'] ?? 'pasca_melahirkan'))) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: INFO TERDAFTAR -->
                <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/80 p-6 flex flex-col justify-between hover:shadow-2xl transition duration-300">
                    <div>
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                            <h3 class="font-black text-[#162065] text-base flex items-center gap-2">
                                <span class="material-symbols-outlined text-rose-500 font-variation-fill">verified</span> Info Terdaftar
                            </h3>
                        </div>

                        <div class="space-y-4">
                            <!-- KABKOTA -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-teal-100">
                                    <span class="material-symbols-outlined text-lg">location_city</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Kabupaten / Kota</p>
                                    <p class="text-sm font-extrabold text-slate-800">
                                        <?= esc($ibu['tipe_kabkota'] ?? '') ?> <?= esc($ibu['nama_kabkota'] ?? 'Belum diatur') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- PUSKESMAS -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-indigo-100">
                                    <span class="material-symbols-outlined text-lg">local_hospital</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Puskesmas Rujukan</p>
                                    <p class="text-sm font-extrabold text-slate-800">
                                        <?= esc($ibu['nama_puskesmas'] ?? 'Belum diatur') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- TANGGAL DAFTAR -->
                            <div class="flex items-start gap-3">
                                <div class="size-9 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center flex-shrink-0 mt-0.5 border border-sky-100">
                                    <span class="material-symbols-outlined text-lg">calendar_month</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Bergabung Sejak</p>
                                    <p class="text-sm font-extrabold text-slate-800">
                                        <?= !empty($ibu['created_at']) ? date('d F Y', strtotime($ibu['created_at'])) : 'Baru saja' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- LOGOUT ACTION -->
            <div class="pt-4 flex justify-end">
                <button id="btnLogout" class="w-full sm:w-auto bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold py-3.5 px-8 rounded-2xl shadow-sm border border-rose-200 transition duration-300 active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">logout</span> Keluar Akun
                </button>
            </div>

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
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-3xl' }
        }).then(async (result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Logging out...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                try {
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
                    window.location.href = '<?= base_url('login') ?>';
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>