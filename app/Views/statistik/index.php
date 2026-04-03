<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-20">
    <a href="<?= base_url('/') ?>" class="size-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <div>
        <h1 class="font-bold text-xl text-slate-800 dark:text-white">Statistik Laktasi</h1>
        <p class="text-xs text-slate-500">Pantauan grafik kelancaran ASI 7 hari terakhir</p>
    </div>
</header>

<div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 relative z-10 pb-32">
    <div class="max-w-5xl mx-auto space-y-6">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
                <div class="text-slate-400 text-xs font-bold mb-1">Rata-rata Frekuensi</div>
                <div class="text-2xl font-bold text-primary">8 <span class="text-sm font-normal text-slate-500">kali/hari</span></div>
            </div>
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
                <div class="text-slate-400 text-xs font-bold mb-1">Durasi Menyusui</div>
                <div class="text-2xl font-bold text-teal-500">15 <span class="text-sm font-normal text-slate-500">menit</span></div>
            </div>
            <div class="col-span-2 bg-gradient-to-r from-blue-500 to-primary rounded-3xl p-5 shadow-sm text-white flex items-center justify-between">
                <div>
                    <div class="text-blue-100 text-xs font-bold mb-1">Status Kebutuhan ASI</div>
                    <div class="text-xl font-bold">Terpenuhi (Normal)</div>
                </div>
                <span class="material-symbols-outlined text-4xl opacity-50 font-variation-fill">verified</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">bar_chart</span>
                Grafik Frekuensi Menyusui Harian
            </h3>
            
            <div class="relative h-[300px] w-full">
                <canvas id="asiChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Catatan Harian Terakhir</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 hover:bg-slate-50 rounded-xl transition">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-sm">check</span></div>
                        <div>
                            <p class="text-sm font-bold text-slate-700">Hari ini</p>
                            <p class="text-xs text-slate-500">Bayi tampak tenang, tidur minimal 12 jam.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Cukup</span>
                </div>
                <div class="flex justify-between items-center p-3 hover:bg-slate-50 rounded-xl transition border-t border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center"><span class="material-symbols-outlined text-sm">check</span></div>
                        <div>
                            <p class="text-sm font-bold text-slate-700">Kemarin</p>
                            <p class="text-xs text-slate-500">Payudara terasa penuh sebelum menyusui.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Cukup</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const ctx = document.getElementById('asiChart').getContext('2d');
    const asiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Frekuensi Menyusui (kali/hari)',
                data: [6, 7, 8, 7, 9, 8, 10],
                borderColor: '#2b7cee', // Warna primary Tailwind
                backgroundColor: 'rgba(43, 124, 238, 0.1)',
                borderWidth: 3,
                tension: 0.4, // Membuat garis melengkung (smooth)
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2b7cee',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 15,
                    grid: { borderDash: [5, 5] }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>