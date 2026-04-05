<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-20">
    <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition">
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
                <div class="text-2xl font-bold text-primary"><span id="avgFreq">0</span> <span class="text-sm font-normal text-slate-500">kali/hari</span></div>
            </div>
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
                <div class="text-slate-400 text-xs font-bold mb-1">Rata-rata Durasi</div>
                <div class="text-2xl font-bold text-teal-500"><span id="avgDur">0</span> <span class="text-sm font-normal text-slate-500">menit</span></div>
            </div>
            <div id="statusBg" class="col-span-2 bg-gradient-to-r from-blue-500 to-primary rounded-3xl p-5 shadow-sm text-white flex items-center justify-between transition-colors">
                <div>
                    <div class="text-blue-100 text-xs font-bold mb-1">Status ASI Terakhir</div>
                    <div id="statusText" class="text-xl font-bold">Memuat...</div>
                </div>
                <span id="statusIcon" class="material-symbols-outlined text-4xl opacity-50 font-variation-fill">sync</span>
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
            <div id="recentLogs" class="space-y-0">
                <div class="text-center py-4 text-slate-400 text-sm">Memuat data...</div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    // 1. Inisialisasi Chart Kosong
    const ctx = document.getElementById('asiChart').getContext('2d');
    const asiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Akan diisi dinamis
            datasets: [{
                label: 'Frekuensi Menyusui (kali/hari)',
                data: [], // Akan diisi dinamis
                borderColor: '#2b7cee',
                backgroundColor: 'rgba(43, 124, 238, 0.1)',
                borderWidth: 3,
                tension: 0.4,
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
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, min: 0, suggestedMax: 15, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    try {
        // 2. Tarik Data dari API
        const response = await fetch('<?= base_url('api/cek-asi') ?>');
        const result = await response.json();

        if (result.status === 'success' && result.data.length > 0) {
            const dataAsi = result.data; // Data sudah urut DESC (terbaru di index 0)

            // --- A. Hitung Rata-rata ---
            let totalFreq = 0;
            let totalDur = 0;
            dataAsi.forEach(item => {
                totalFreq += parseInt(item.frekuensi_menyusui) || 0;
                totalDur += parseInt(item.lama_menyusui) || 0;
            });
            document.getElementById('avgFreq').innerText = Math.round(totalFreq / dataAsi.length);
            document.getElementById('avgDur').innerText = Math.round(totalDur / dataAsi.length);

            // --- B. Update Status Terakhir (Card Besar) ---
            const latest = dataAsi[0];
            const statusBg = document.getElementById('statusBg');
            const statusText = document.getElementById('statusText');
            const statusIcon = document.getElementById('statusIcon');
            
            if (latest.status_kecukupan_asi === 'Ya') {
                statusText.innerText = 'Terpenuhi (Normal)';
                statusIcon.innerText = 'verified';
                statusBg.className = 'col-span-2 bg-gradient-to-r from-blue-500 to-primary rounded-3xl p-5 shadow-sm text-white flex items-center justify-between';
            } else {
                statusText.innerText = 'Perlu Perhatian / Konsultasi';
                statusIcon.innerText = 'warning';
                statusBg.className = 'col-span-2 bg-gradient-to-r from-rose-500 to-rose-400 rounded-3xl p-5 shadow-sm text-white flex items-center justify-between';
            }

            // --- C. Update Grafik (Max 7 Hari Terakhir) ---
            // Ambil 7 data terbaru, lalu reverse agar di chart urutannya dari Kiri (Lama) ke Kanan (Baru)
            const chartData = dataAsi.slice(0, 7).reverse(); 
            
            const labels = chartData.map(item => {
                // Ubah format YYYY-MM-DD jadi DD MMM (contoh: 12 Okt)
                const date = new Date(item.tgl_pengisian);
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            });
            const values = chartData.map(item => item.frekuensi_menyusui);

            asiChart.data.labels = labels;
            asiChart.data.datasets[0].data = values;
            asiChart.update();

            // --- D. Render List Catatan Harian Terakhir (Max 3 data) ---
            const logsContainer = document.getElementById('recentLogs');
            logsContainer.innerHTML = ''; // Kosongkan state 'Memuat...'
            
            const recentData = dataAsi.slice(0, 3);
            recentData.forEach((item, index) => {
                const isCukup = item.status_kecukupan_asi === 'Ya';
                const bgColor = isCukup ? 'bg-green-100 text-green-600' : 'bg-rose-100 text-rose-600';
                const badgeColor = isCukup ? 'text-green-600 bg-green-50' : 'text-rose-600 bg-rose-50';
                const icon = isCukup ? 'check' : 'close';
                const statusLabel = isCukup ? 'Cukup' : 'Kurang';
                
                // Pesan dinamis berdasarkan input
                let pesan = '';
                if (item.payudara_penuh === 'Ya') pesan += 'Payudara terasa penuh sblm menyusui. ';
                if (item.bayi_tenang_setelah_menyusu === 'Ya') pesan += 'Bayi tampak tenang.';
                if (pesan === '') pesan = 'Evaluasi ASI harian telah dicatat.';

                // Format Tanggal
                const dateObj = new Date(item.tgl_pengisian);
                const tglFormat = dateObj.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long' });

                const borderTop = index > 0 ? 'border-t border-slate-50' : '';

                logsContainer.innerHTML += `
                    <div class="flex justify-between items-center p-3 hover:bg-slate-50 rounded-xl transition ${borderTop}">
                        <div class="flex items-center gap-3">
                            <div class="size-10 ${bgColor} rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">${icon}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">${tglFormat}</p>
                                <p class="text-xs text-slate-500">${pesan}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold ${badgeColor} px-2 py-1 rounded">${statusLabel}</span>
                    </div>
                `;
            });

        } else {
            // State jika data kosong
            document.getElementById('recentLogs').innerHTML = '<div class="text-center py-4 text-slate-400 text-sm">Belum ada data evaluasi ASI.</div>';
            document.getElementById('statusText').innerText = 'Belum Ada Data';
        }
    } catch (error) {
        console.error('Gagal memuat statistik:', error);
        document.getElementById('recentLogs').innerHTML = '<div class="text-center py-4 text-rose-500 text-sm">Gagal mengambil data dari server.</div>';
    }
});
</script>

<?= $this->endSection() ?>