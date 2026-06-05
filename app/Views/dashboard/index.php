<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php 
// Mengambil status kehamilan dari session atau fallback ke variabel data backend
$statusKehamilan = session()->get('status_kehamilan') ?? $status_kehamilan ?? 'pasca_melahirkan'; 
?>

<div class="flex flex-col h-full w-full overflow-hidden">
    <header
        class="relative bg-gradient-to-br from-primary via-blue-500 to-blue-600 pt-12 md:pt-10 pb-12 md:pb-16 px-6 md:px-10 rounded-b-[2.5rem] md:rounded-none md:rounded-bl-[2.5rem] shadow-lg shadow-blue-100 dark:shadow-none flex-shrink-0">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute left-10 bottom-0 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>

        <div class="relative z-10 flex items-center justify-between max-w-6xl mx-auto">
            <div class="flex items-center gap-4">
                <div
                    class="size-14 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white overflow-hidden shadow-sm">
                    <span class="material-symbols-outlined text-4xl font-variation-fill">face_3</span>
                </div>
                <div>
                    <h1 class="text-white font-bold text-xl md:text-2xl leading-tight">Halo Bunda
                        <?= esc(strtok($nama_ibu, " ")) ?>,</h1>
                    <?php if ($statusKehamilan === 'hamil'): ?>
                        <p class="text-blue-50 text-sm md:text-base opacity-90">Bagaimana kondisi kandungan Bunda hari ini?</p>
                    <?php else: ?>
                        <p class="text-blue-50 text-sm md:text-base opacity-90">Bagaimana kabar si kecil hari ini?</p>
                    <?php endif; ?>
                </div>
            </div>
            <button
                class="size-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white hover:bg-white/30 transition shadow-sm">
                <span class="material-symbols-outlined text-2xl">notifications</span>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-20 w-full">
        <div class="max-w-6xl mx-auto px-6 md:px-10 py-6 md:py-10 flex flex-col gap-8 md:gap-10 pb-32 md:pb-10 min-h-full">

            <!-- <?php if ($statusKehamilan !== 'hamil'): ?>
                <section class="w-full bg-gradient-to-r from-amber-50 to-orange-50 dark:from-slate-800 dark:to-slate-800/80 border border-amber-100 dark:border-slate-700 rounded-3xl p-5 md:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-start gap-4">
                        <div class="size-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-2xl font-variation-fill">notifications_active</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Pengingat Menyusui Otomatis (2 Jam)</h3>
                            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Membantu Bunda menjadwalkan pemberian ASI berkala bagi si kecil secara konsisten.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end sm:self-center bg-white dark:bg-slate-700 px-4 py-2 rounded-2xl shadow-inner border border-slate-100 dark:border-slate-600">
                        <span id="alarmStatusText" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mati</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggleAlarmMenyusui" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </section>
            <?php endif; ?> -->

            <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 w-full">
                <a href="<?= base_url('riwayat') ?>"
                    class="group flex flex-col items-center justify-center p-5 md:p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center h-full">
                    <div
                        class="w-14 h-14 md:w-20 md:h-20 mb-3 md:mb-5 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 transition-colors group-hover:scale-110 duration-300">
                        <span
                            class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">history_edu</span>
                    </div>
                    <span
                        class="text-sm md:text-lg font-bold text-slate-700 dark:text-slate-100 leading-tight">Riwayat</span>
                    <span class="text-[10px] md:text-sm text-slate-400 mt-1">Pra, Hamil & Salin</span>
                </a>

                <?php if ($statusKehamilan === 'hamil'): ?>
                    <a href="<?= base_url('assessment-kejiwaan') ?>"
                        class="group flex flex-col items-center justify-center p-5 md:p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center h-full">
                        <div
                            class="w-14 h-14 md:w-20 md:h-20 mb-3 md:mb-5 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 transition-colors group-hover:scale-110 duration-300">
                            <span
                                class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">psychology</span>
                        </div>
                        <span class="text-sm md:text-lg font-bold text-slate-700 dark:text-slate-100 leading-tight">Kondisi Kejiwaan</span>
                        <span class="text-[10px] md:text-sm text-slate-400 mt-1">Assessment Ibu</span>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('laktasi/cek') ?>"
                        class="group flex flex-col items-center justify-center p-5 md:p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center h-full">
                        <div
                            class="w-14 h-14 md:w-20 md:h-20 mb-3 md:mb-5 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-500 transition-colors group-hover:scale-110 duration-300">
                            <span
                                class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">water_drop</span>
                        </div>
                        <span class="text-sm md:text-lg font-bold text-slate-700 dark:text-slate-100 leading-tight">Cek Kelancaran</span>
                        <span class="text-[10px] md:text-sm text-slate-400 mt-1">Evaluasi ASI</span>
                    </a>
                <?php endif; ?>

                <a href="<?= base_url('edukasi/video') ?>"
                    class="group flex flex-col items-center justify-center p-5 md:p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center h-full">
                    <div
                        class="w-14 h-14 md:w-20 md:h-20 mb-3 md:mb-5 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 transition-colors group-hover:scale-110 duration-300">
                        <span
                            class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">smart_display</span>
                    </div>
                    <span class="text-sm md:text-lg font-bold text-slate-700 dark:text-slate-100 leading-tight">Ruang Edukasi</span>
                    <span class="text-[10px] md:text-sm text-slate-400 mt-1">Artikel & Video</span>
                </a>
                
                <a href="<?= base_url('statistik') ?>"
                    class="group flex flex-col items-center justify-center p-5 md:p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 text-center h-full">
                    <div
                        class="w-14 h-14 md:w-20 md:h-20 mb-3 md:mb-5 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-500 transition-colors group-hover:scale-110 duration-300">
                        <span
                            class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill">bar_chart</span>
                    </div>
                    <span
                        class="text-sm md:text-lg font-bold text-slate-700 dark:text-slate-100 leading-tight">Statistik</span>
                    <span class="text-[10px] md:text-sm text-slate-400 mt-1">Grafik Kelancaran</span>
                </a>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 flex-1 mt-auto">
                <section class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4 px-1">
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Update Terakhir</h3>
                        <a href="<?= base_url('statistik') ?>"
                            class="text-sm font-semibold text-primary hover:underline">Lengkapnya</a>
                    </div>

                    <?php if (!empty($latestAsi)): ?>
                        <?php
                        $isCukup = ($latestAsi['status_kecukupan_asi'] === 'Ya');
                        $statusText = $isCukup ? 'Kebutuhan ASI Terpenuhi' : 'Perhatian: ASI Kurang Lancar';
                        $iconColor = $isCukup ? 'text-primary' : 'text-rose-500';
                        $iconSymbol = $isCukup ? 'check_circle' : 'warning';
                        ?>
                        <div
                            class="bg-blue-50/50 dark:bg-slate-800/50 border border-blue-100 dark:border-slate-700 rounded-3xl p-5 md:p-6 flex items-center gap-4 hover:bg-blue-50 transition-colors flex-1 shadow-sm">
                            <div
                                class="size-14 md:size-16 bg-white dark:bg-slate-700 rounded-2xl flex flex-shrink-0 items-center justify-center shadow-sm <?= $iconColor ?>">
                                <span
                                    class="material-symbols-outlined text-3xl md:text-4xl font-variation-fill"><?= $iconSymbol ?></span>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-0.5">Evaluasi ASI</p>
                                <h4
                                    class="font-bold text-slate-900 dark:text-white text-base md:text-lg leading-tight mb-1">
                                    <?= $statusText ?></h4>
                                <p class="text-xs md:text-sm text-slate-500 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                    <?= date('d M Y', strtotime($latestAsi['tgl_pengisian'])) ?>
                                </p>
                            </div>
                            <a href="<?= base_url('laktasi/cek') ?>"
                                class="size-10 md:size-12 rounded-full flex-shrink-0 bg-primary/10 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-xl md:text-2xl">edit</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <div
                            class="bg-slate-50 dark:bg-slate-800 border border-dashed border-slate-300 dark:border-slate-600 rounded-3xl p-5 md:p-6 flex items-center gap-4 flex-1 shadow-sm">
                            <div
                                class="size-14 md:size-16 bg-slate-200 dark:bg-slate-700 rounded-2xl flex flex-shrink-0 items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-3xl md:text-4xl">inventory_2</span>
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="font-bold text-slate-700 dark:text-slate-300 text-base md:text-lg leading-tight mb-1">
                                    Belum Ada Data</h4>
                                <p class="text-xs md:text-sm text-slate-500">Bunda belum pernah mengisi evaluasi ASI.</p>
                            </div>
                            <a href="<?= base_url('laktasi/cek') ?>"
                                class="px-4 py-2 text-sm rounded-xl bg-primary text-white font-bold hover:bg-primary-dark transition-colors shadow-sm">
                                Mulai Isi
                            </a>
                        </div>
                    <?php endif; ?>
                </section>

                <section class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-4 px-1 lg:hidden">
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Tips Edukasi</h3>
                    </div>
                    <div class="hidden lg:flex items-center justify-between mb-4 px-1 opacity-0 pointer-events-none">
                        <h3 class="font-bold text-lg">Spacer</h3>
                    </div>

                    <a href="<?= base_url('edukasi/video') ?>" class="block h-full group">
                        <div style="background-color:#2b7cee;"
                            class="rounded-3xl p-6 md:p-8 text-white flex gap-4 items-center relative overflow-hidden h-full flex-1 shadow-md group-hover:shadow-lg transition-all active:scale-[0.98]">
                            <div
                                class="absolute top-1/2 -translate-y-1/2 right-2 md:right-8 p-2 opacity-20 transition-transform group-hover:scale-110 group-hover:rotate-12 duration-500">
                                <span class="material-symbols-outlined text-[80px] md:text-[120px]">lightbulb</span>
                            </div>
                            <div class="relative z-10">
                                <span
                                    class="bg-white/20 text-[10px] md:text-xs font-bold px-3 py-1.5 rounded-full mb-3 md:mb-4 inline-block tracking-wide">TIP
                                    EDUKASI</span>
                                <h4 class="font-bold text-xl md:text-2xl leading-snug mb-2"><?= esc($tip['judul']) ?></h4>
                                <p
                                    class="text-sm md:text-base text-indigo-100 max-w-[85%] md:max-w-[75%] leading-relaxed">
                                    <?= esc($tip['isi']) ?></p>
                            </div>
                        </div>
                    </a>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleAlarm = document.getElementById("toggleAlarmMenyusui");
    const statusText = document.getElementById("alarmStatusText");
    let intervalAlarm = null;

    if (!toggleAlarm) return;

    const alarmState = localStorage.getItem("sicubit_alarm_asi") === "true";
    toggleAlarm.checked = alarmState;
    updateStatusLabel(alarmState);

    if (alarmState) {
        startAlarmCycle();
    }

    toggleAlarm.addEventListener("change", function () {
        if (this.checked) {
            if (!("Notification" in window)) {
                alert("Browser ini tidak mendukung sistem push notification.");
                this.checked = false;
                return;
            }

            if (Notification.permission !== "granted") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        activateAlarm();
                    } else {
                        alert("Bunda perlu mengizinkan akses notifikasi agar pengingat aktif.");
                        this.checked = false;
                        updateStatusLabel(false);
                    }
                });
            } else {
                activateAlarm();
            }
        } else {
            deactivateAlarm();
        }
    });

    function activateAlarm() {
        localStorage.setItem("sicubit_alarm_asi", "true");
        updateStatusLabel(true);
        startAlarmCycle();
        new Notification("SiCubit", {
            body: "Pengingat menyusui setiap 2 jam berhasil aktif! ✨",
            icon: "<?= base_url('assets/img/icons/breastfeeding.png') ?>"
        });
    }

    function deactivateAlarm() {
        localStorage.setItem("sicubit_alarm_asi", "false");
        updateStatusLabel(false);
        if (intervalAlarm) clearInterval(intervalAlarm);
    }

    function updateStatusLabel(isActive) {
        if (isActive) {
            statusText.innerText = "Aktif";
            statusText.classList.remove("text-slate-400");
            statusText.classList.add("text-primary");
        } else {
            statusText.innerText = "Mati";
            statusText.classList.remove("text-primary");
            statusText.classList.add("text-slate-400");
        }
    }

    function startAlarmCycle() {
        if (intervalAlarm) clearInterval(intervalAlarm);
        
        const DUA_JAM_MS = 2 * 60 * 60 * 1000; // Rentang waktu 2 jam

        intervalAlarm = setInterval(() => {
            if (Notification.permission === "granted") {
                new Notification("Waktunya Menyusu, Bunda! 🍼", {
                    body: "Sudah 2 jam sejak jadwal terakhir bunda. Yuk berikan ASI terbaik bagi perkembangan si kecil.",
                    icon: "<?= base_url('assets/img/icons/breastfeeding.png') ?>",
                    tag: "sicubit-reminder"
                });
            }
        }, DUA_JAM_MS);
    }
});
</script>

<?= $this->endSection() ?>