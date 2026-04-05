<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-20">
    <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <div>
        <h1 class="font-bold text-xl text-slate-800 dark:text-white">Cek Kelancaran ASI</h1>
        <p class="text-xs text-slate-500">Evaluasi harian untuk si kecil</p>
    </div>
</header>

<div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 relative z-10 pb-32">
    <div class="max-w-4xl mx-auto">
        <form id="formCekAsi" class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
            <div class="mb-6 pb-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                <h2 class="font-bold text-lg text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">assignment</span>
                    Kondisi Ibu & Bayi
                </h2>
                <input type="date" name="tgl_pengisian" class="rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary" required value="<?= date('Y-m-d') ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Kondisi Puting</label>
                    <select name="kondisi_puting" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary" required>
                        <option value="">Pilih kondisi...</option>
                        <option value="Normal">Normal (Menonjol)</option>
                        <option value="Datar">Datar</option>
                        <option value="Tenggelam">Tenggelam</option>
                        <option value="Lecet">Pecah / Lecet</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Frekuensi Menyusui</label>
                    <div class="relative">
                        <input type="number" name="frekuensi_menyusui" min="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary pr-20" placeholder="0" required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">kali/hari</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Rata-rata Lama Menyusui</label>
                    <div class="relative">
                        <input type="number" name="lama_menyusui" min="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary pr-20" placeholder="0" required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">menit</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Frekuensi BAB</label>
                        <div class="relative">
                            <input type="number" name="frekuensi_bab_bayi" min="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary pr-12" placeholder="0" required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">kali</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Frekuensi BAK</label>
                        <div class="relative">
                            <input type="number" name="frekuensi_bak_bayi" min="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary pr-12" placeholder="0" required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">kali</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Warna Urin Bayi</label>
                    <select name="warna_urin_bayi" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary" required>
                        <option value="">Pilih warna...</option>
                        <option value="Jernih">Jernih</option>
                        <option value="Kuning Muda">Kuning Muda</option>
                        <option value="Kuning Pekat">Kuning Pekat / Gelap</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Bayi tenang setelah menyusu?</label>
                    <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="bayi_tenang_setelah_menyusu" class="text-primary focus:ring-primary" value="Ya" required>
                            <span class="text-sm text-slate-600 dark:text-slate-300">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="bayi_tenang_setelah_menyusu" class="text-primary focus:ring-primary" value="Tidak">
                            <span class="text-sm text-slate-600 dark:text-slate-300">Tidak</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Payudara terasa penuh sblm menyusui?</label>
                    <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="payudara_penuh" class="text-primary focus:ring-primary" value="Ya" required>
                            <span class="text-sm text-slate-600 dark:text-slate-300">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="payudara_penuh" class="text-primary focus:ring-primary" value="Tidak">
                            <span class="text-sm text-slate-600 dark:text-slate-300">Tidak</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Volume ASI (Jika Pumping)</label>
                    <div class="relative">
                        <input type="number" name="volume_pumping" min="0" step="0.1" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:ring-primary focus:border-primary pr-12" placeholder="opsional">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">ml</span>
                    </div>
                </div>

            </div>

            <div class="mt-8 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-bold text-lg text-rose-500 flex items-center gap-2">
                    <span class="material-symbols-outlined">favorite</span>
                    Dukungan Suami
                </h2>
            </div>

            <div class="space-y-4">
                <label class="flex items-start gap-3 p-4 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer transition">
                    <input type="checkbox" name="support_suami_menyusui" value="Ya" class="mt-1 rounded text-primary focus:ring-primary">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Suami mengingatkan menyusui tiap 2 jam</p>
                        <p class="text-xs text-slate-400 mt-0.5">Dukungan ini sangat penting untuk rutinitas bayi.</p>
                    </div>
                </label>
                
                <label class="flex items-start gap-3 p-4 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer transition">
                    <input type="checkbox" name="support_suami_gizi" value="Ya" class="mt-1 rounded text-primary focus:ring-primary">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Suami mengingatkan makan bergizi / suplemen ASI</p>
                        <p class="text-xs text-slate-400 mt-0.5">Nutrisi ibu mempengaruhi kualitas dan kuantitas ASI.</p>
                    </div>
                </label>
                
                <input type="hidden" name="bayi_tidur_12jam" value="Ya">
            </div>

            <div class="mt-10">
                <button type="submit" id="btnSubmit" class="w-full md:w-auto md:min-w-[200px] float-right bg-primary hover:bg-primary-dark text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-blue-200 dark:shadow-blue-900/40 transition-transform active:scale-95 flex items-center justify-center gap-2">
                    <span>Simpan Evaluasi</span>
                    <span class="material-symbols-outlined text-xl">send</span>
                </button>
                <div class="clear-both"></div>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formCekAsi').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const formData = new FormData(this);

    // SweetAlert Loading
    Swal.fire({
        title: 'Menyimpan Data...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const response = await fetch('<?= base_url('api/save-asi') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Hebat Bunda!',
                text: result.message + ' Status Kecukupan: ' + result.data.status_kecukupan_asi,
                confirmButtonColor: '#2b7cee'
            }).then(() => {
                window.location.href = '<?= base_url('dashboard') ?>'; 
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: 'Pastikan semua kolom yang wajib sudah terisi.',
                confirmButtonColor: '#2b7cee'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Koneksi Bermasalah',
            text: 'Gagal menghubungi server.',
            confirmButtonColor: '#2b7cee'
        });
    }
});
</script>

<?= $this->endSection() ?>