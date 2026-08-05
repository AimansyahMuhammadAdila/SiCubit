<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('profil') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md">
                <span class="material-symbols-outlined text-2xl">edit_note</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Edit Profil Bunda</h1>
                <p class="text-xs text-slate-600 font-medium">Perbarui informasi data diri dan puskesmas domisili</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-10 pb-24">
    <div class="max-w-3xl mx-auto">
        <form id="formEditProfil" class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8 space-y-5">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" type="text" name="nama" value="<?= esc($ibu['nama'] ?? '') ?>" required />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Umur (Tahun)</label>
                        <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" type="number" name="umur" value="<?= esc($ibu['umur'] ?? '') ?>" required />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Anak</label>
                        <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" type="number" name="jumlah_anak" value="<?= esc($ibu['jumlah_anak'] ?? '') ?>" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan</label>
                    <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" type="text" name="pekerjaan" value="<?= esc($ibu['pekerjaan'] ?? '') ?>" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp</label>
                    <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" type="tel" name="no_telp" value="<?= esc($ibu['no_telp'] ?? '') ?>" required />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20 resize-none" rows="2" name="alamat"><?= esc($ibu['alamat'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kabupaten/Kota</label>
                    <div class="relative">
                        <select id="selectKabkota" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20 appearance-none" name="id_kabkota" required>
                            <option value="" disabled>Memuat Kab/Kota...</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Puskesmas</label>
                    <div class="relative">
                        <select id="selectPuskesmas" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20 appearance-none" name="id_puskesmas" required disabled>
                            <option value="" disabled>Memuat Puskesmas...</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Kehamilan</label>
                    <div class="relative">
                        <select class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20 appearance-none text-slate-600" name="status_kehamilan" required>
                            <option value="pra_kehamilan" <?= ($ibu['status_kehamilan'] ?? '') === 'pra_kehamilan' ? 'selected' : '' ?>>Pra Kehamilan (Pranikah)</option>
                            <option value="hamil" <?= ($ibu['status_kehamilan'] ?? '') === 'hamil' ? 'selected' : '' ?>>Masa Kehamilan (Hamil)</option>
                            <option value="pasca_melahirkan" <?= ($ibu['status_kehamilan'] ?? '') === 'pasca_melahirkan' ? 'selected' : '' ?>>Pasca Melahirkan (Menyusui)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <p class="text-xs text-rose-500 font-medium mb-3">* Kosongkan password jika tidak ingin mengubahnya.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" placeholder="Password Baru" type="password" name="password" />
                        <input class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary/20" placeholder="Konfirmasi Password Baru" type="password" name="konfirmasi_password" />
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <button id="btnSave" class="w-full md:w-auto bg-primary hover:bg-primary-dark text-white font-bold py-3.5 px-10 rounded-2xl shadow-lg shadow-primary/25 active:scale-95 transition-all flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined">save</span> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    
    const selKabkota = document.getElementById('selectKabkota');
    const selPuskesmas = document.getElementById('selectPuskesmas');
    
    // Data ID wilayah Bunda yang tersimpan di DB
    const currentKabkota = "<?= esc($ibu['id_kabkota'] ?? '') ?>";
    const currentPuskesmas = "<?= esc($ibu['id_puskesmas'] ?? '') ?>";

    // 1. Fetch Data Kab/Kota
    try {
        const res = await fetch('<?= base_url('api/wilayah/kabkota') ?>');
        const json = await res.json();
        if (json.status === 'success') {
            selKabkota.innerHTML = '<option value="" disabled>Pilih Kabupaten/Kota</option>';
            json.data.forEach(item => {
                const selected = (item.id === currentKabkota) ? 'selected' : '';
                selKabkota.innerHTML += `<option value="${item.id}" ${selected}>${item.tipe} ${item.nama}</option>`;
            });

            // Trigger fetch puskesmas jika kab/kota sudah ada datanya
            if (currentKabkota) {
                selKabkota.dispatchEvent(new Event('change'));
            }
        }
    } catch (err) {
        selKabkota.innerHTML = '<option value="" disabled>Gagal memuat wilayah</option>';
    }

    // 2. Fetch Data Puskesmas SAAT Kab/Kota dipilih
    selKabkota.addEventListener('change', async function() {
        const idKabkota = this.value;
        selPuskesmas.innerHTML = '<option value="" disabled selected>Memuat Puskesmas...</option>';
        selPuskesmas.disabled = true;

        try {
            const res = await fetch(`<?= base_url('api/wilayah/puskesmas/') ?>${idKabkota}`);
            const json = await res.json();
            
            if (json.status === 'success' && json.data.length > 0) {
                selPuskesmas.innerHTML = '<option value="" disabled>Pilih Puskesmas</option>';
                json.data.forEach(item => {
                    const selected = (item.id === currentPuskesmas) ? 'selected' : '';
                    selPuskesmas.innerHTML += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
                });
                selPuskesmas.disabled = false;
            } else {
                selPuskesmas.innerHTML = '<option value="" disabled selected>Tidak ada Puskesmas</option>';
            }
        } catch (err) {
            selPuskesmas.innerHTML = '<option value="" disabled selected>Gagal memuat puskesmas</option>';
        }
    });

    // 3. Proses Submit Form
    document.getElementById('formEditProfil').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSave');
        const formData = new FormData(this);

        Swal.fire({
            title: 'Menyimpan Perubahan...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        btn.disabled = true;

        try {
            const response = await fetch('<?= base_url('api/profil/update') ?>', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    confirmButtonColor: '#2b7cee'
                }).then(() => {
                    window.location.href = '<?= base_url('profil') ?>';
                });
            } else {
                let errorHtml = '<ul style="text-align: left; font-size:14px; color:#ef4444;">';
                if(result.errors) {
                    for (const key in result.errors) { errorHtml += `<li>- ${result.errors[key]}</li>`; }
                } else {
                    errorHtml += `<li>${result.message}</li>`;
                }
                errorHtml += '</ul>';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
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
        } finally {
            btn.disabled = false;
        }
    });
});
</script>

<?= $this->endSection() ?>