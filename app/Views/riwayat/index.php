<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-20">
    <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <div>
        <h1 class="font-bold text-xl text-slate-800 dark:text-white">Riwayat Medis</h1>
        <p class="text-xs text-slate-500">Lengkapi data Pra-Kehamilan hingga Persalinan</p>
    </div>
</header>

<div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 relative z-10 pb-32">
    <div class="max-w-5xl mx-auto">
        <form id="formRiwayat" class="space-y-8">
            
            <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                <h2 class="font-bold text-lg text-primary flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <span class="material-symbols-outlined font-variation-fill">pregnant_woman</span>
                    Riwayat Pra Kehamilan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">BB Sebelum Hamil (kg)</label>
                        <input type="number" step="0.1" name="bb_sebelum_hamil" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 focus:ring-primary focus:border-primary" placeholder="Misal: 55">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Riwayat Abortus (Keguguran)?</label>
                        <select name="riwayat_abortus" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 focus:ring-primary focus:border-primary">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Riwayat Penyakit (Pilih jika ada)</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-2"><input type="checkbox" name="riwayat_penyakit[]" value="Hipertensi" class="rounded text-primary focus:ring-primary"> <span class="text-sm">Hipertensi</span></label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="riwayat_penyakit[]" value="Diabetes" class="rounded text-primary focus:ring-primary"> <span class="text-sm">Diabetes</span></label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="riwayat_penyakit[]" value="Asma" class="rounded text-primary focus:ring-primary"> <span class="text-sm">Asma</span></label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="riwayat_penyakit[]" value="Jantung" class="rounded text-primary focus:ring-primary"> <span class="text-sm">Jantung</span></label>
                            <label class="flex items-center gap-2"><input type="checkbox" name="riwayat_penyakit[]" value="Ginjal" class="rounded text-primary focus:ring-primary"> <span class="text-sm">Ginjal</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                <h2 class="font-bold text-lg text-rose-500 flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <span class="material-symbols-outlined font-variation-fill">monitor_heart</span>
                    Riwayat Kehamilan Saat Ini
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kehamilan Ke-</label>
                        <input type="number" name="kehamilan_ke" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Umur Kehamilan (Minggu)</label>
                        <input type="number" name="umur_kehamilan" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="Misal: 38" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Berat Badan Sekarang (kg)</label>
                        <input type="number" step="0.1" name="bb" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ukuran LiLA (cm)</label>
                        <input type="number" step="0.1" name="ukuran_lila" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0.0">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kadar Hb (g/dL)</label>
                        <input type="number" step="0.1" name="kadar_hb" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0.0">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Kunjungan ANC (Kali)</label>
                        <input type="number" name="kunjungan_anc" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="Misal: 4">
                    </div>
                    
                    <div class="space-y-4 md:col-span-2 pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            <span class="text-sm font-medium">Konsumsi Tablet Tambah Darah?</span>
                            <select name="konsumsi_ttd" class="rounded-lg border-slate-200 text-sm"><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select>
                        </div>
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            <span class="text-sm font-medium">Sudah Pemeriksaan HIV?</span>
                            <select name="periksa_hiv" class="rounded-lg border-slate-200 text-sm"><option value="Ya">Sudah</option><option value="Tidak">Belum</option></select>
                        </div>
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            <span class="text-sm font-medium">Sudah Pemeriksaan HBSAG?</span>
                            <select name="periksa_hbsag" class="rounded-lg border-slate-200 text-sm"><option value="Ya">Sudah</option><option value="Tidak">Belum</option></select>
                        </div>
                        <div class="flex justify-between items-center bg-rose-50 p-3 rounded-xl border border-rose-100">
                            <span class="text-sm font-bold text-rose-700">Apakah ibu bahagia dengan kehamilan sekarang?</span>
                            <select name="status_bahagia" class="rounded-lg border-rose-200 text-sm text-rose-700"><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                <h2 class="font-bold text-lg text-teal-500 flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <span class="material-symbols-outlined font-variation-fill">child_friendly</span>
                    Riwayat Persalinan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Cara Persalinan</label>
                        <select name="cara_persalinan" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" required>
                            <option value="Normal">Normal (Pervaginam)</option>
                            <option value="Sectio Caesarea">Sesar (SC)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Umur Kehamilan Saat Lahir (Minggu)</label>
                        <input type="number" name="umur_kehamilan_salin" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="Misal: 39" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Melakukan IMD (Inisiasi Menyusu Dini)?</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="imd" value="Ya" class="text-primary" required> <span class="text-sm">Ya</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="imd" value="Tidak" class="text-primary"> <span class="text-sm">Tidak</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" id="btnSubmit" class="w-full md:w-auto bg-primary hover:bg-primary-dark text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span> Simpan Data Riwayat
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// =========================================================
// 1. OTOMATIS MENGISI FORM (GET DATA) SAAT HALAMAN DIBUKA
// =========================================================
document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Ambil data riwayat dari API
        const response = await fetch('<?= base_url('api/riwayat') ?>');
        const result = await response.json();

        if (result.status === 'success' && result.data) {
            
            // Isi Form Pra Kehamilan
            if (result.data.pra_kehamilan && result.data.pra_kehamilan.length > 0) {
                const pra = result.data.pra_kehamilan[0]; 
                document.querySelector('[name="bb_sebelum_hamil"]').value = pra.bb_sebelum_hamil || '';
                document.querySelector('[name="riwayat_abortus"]').value = pra.riwayat_abortus || 'Tidak';
                
                // Centang checkbox riwayat penyakit
                if (pra.riwayat_penyakit) {
                    const penyakitArr = pra.riwayat_penyakit.split(', ');
                    document.querySelectorAll('[name="riwayat_penyakit[]"]').forEach(cb => {
                        if (penyakitArr.includes(cb.value)) cb.checked = true;
                    });
                }
            }

            // Isi Form Kehamilan
            if (result.data.kehamilan && result.data.kehamilan.length > 0) {
                const hamil = result.data.kehamilan[0];
                document.querySelector('[name="kehamilan_ke"]').value = hamil.kehamilan_ke || '';
                document.querySelector('[name="umur_kehamilan"]').value = hamil.umur_kehamilan || '';
                document.querySelector('[name="bb"]').value = hamil.bb || '';
                document.querySelector('[name="ukuran_lila"]').value = hamil.ukuran_lila || '';
                document.querySelector('[name="kadar_hb"]').value = hamil.kadar_hb || '';
                document.querySelector('[name="kunjungan_anc"]').value = hamil.kunjungan_anc || '';
                document.querySelector('[name="konsumsi_ttd"]').value = hamil.konsumsi_ttd || 'Tidak';
                document.querySelector('[name="periksa_hiv"]').value = hamil.periksa_hiv || 'Tidak';
                document.querySelector('[name="periksa_hbsag"]').value = hamil.periksa_hbsag || 'Tidak';
                document.querySelector('[name="status_bahagia"]').value = hamil.status_bahagia || 'Ya';
            }

            // Isi Form Persalinan
            if (result.data.persalinan && result.data.persalinan.length > 0) {
                const salin = result.data.persalinan[0];
                document.querySelector('[name="cara_persalinan"]').value = salin.cara_persalinan || 'Normal';
                document.querySelector('[name="umur_kehamilan_salin"]').value = salin.umur_kehamilan_salin || '';
                
                // Pilih radio button IMD
                if (salin.imd) {
                    const imdRadio = document.querySelector(`[name="imd"][value="${salin.imd}"]`);
                    if(imdRadio) imdRadio.checked = true;
                }
            }
        }
    } catch (error) {
        console.error('Gagal memuat data historis riwayat:', error);
    }
});

// =========================================================
// 2. PROSES MENYIMPAN DATA (POST) SAAT TOMBOL DIKLIK
// =========================================================
document.getElementById('formRiwayat').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const formData = new FormData(this);

    Swal.fire({
        title: 'Menyimpan Data...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    try {
        const response = await fetch('<?= base_url('api/save-riwayat') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Tersimpan!',
                text: 'Data riwayat medis Bunda berhasil diperbarui.',
                confirmButtonColor: '#2b7cee'
            }).then(() => {
                window.location.href = '<?= base_url('dashboard') ?>'; 
            });
        } else {
            // Merangkai pesan error dari JSON
            let errorHtml = '<ul style="text-align: left; font-size:14px; color:#ef4444;">';
            if(result.errors) {
                for(const key in result.errors){
                    errorHtml += `<li>- ${result.errors[key]}</li>`;
                }
            } else {
                errorHtml += `<li>${result.message}</li>`;
            }
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: errorHtml,
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