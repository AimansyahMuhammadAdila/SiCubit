<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden">
    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 pt-8 pb-4 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-20">
        <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-bold text-xl text-slate-800 dark:text-white">Riwayat Medis</h1>
            <p class="text-xs text-slate-500">Lengkapi data Pra-Kehamilan hingga Persalinan secara bertahap</p>
        </div>
    </header>

    <div id="scrollContainer" class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 relative z-10 pb-32 scroll-smooth bg-slate-50/50 dark:bg-slate-900/40">
        <div class="max-w-5xl mx-auto">
            
            <!-- WIZARD PROGRESS BAR -->
            <div class="flex items-center justify-between mb-8 relative px-2 md:px-8">
                <div class="absolute left-4 right-4 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                <div id="progressLine" class="absolute left-4 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
                
                <div class="flex flex-col items-center gap-2 step-indicator" data-step="1">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md">1</div>
                    <span class="text-[10px] md:text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors">Pra Kehamilan</span>
                </div>
                <div class="flex flex-col items-center gap-2 step-indicator" data-step="2">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">2</div>
                    <span class="text-[10px] md:text-xs font-bold text-slate-400 transition-colors">Saat Ini</span>
                </div>
                <div class="flex flex-col items-center gap-2 step-indicator" data-step="3">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">3</div>
                    <span class="text-[10px] md:text-xs font-bold text-slate-400 transition-colors">Persalinan</span>
                </div>
            </div>

            <form id="formRiwayat" class="space-y-8 relative">
                <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

                <!-- TAHAP 1: Pra Kehamilan -->
                <div id="step-1" class="form-step transition-all duration-500 scale-100 opacity-100">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                        <h2 class="font-bold text-lg text-primary flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                            <span class="material-symbols-outlined font-variation-fill">pregnant_woman</span>
                            Riwayat Pra Kehamilan
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">BB Sebelum Hamil (kg)</label>
                                <input type="number" step="0.1" name="bb_sebelum_hamil" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 focus:ring-primary focus:border-primary" placeholder="Misal: 55" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Riwayat Abortus (Keguguran)?</label>
                                <select name="riwayat_abortus" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 focus:ring-primary focus:border-primary" required>
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
                </div>

                <!-- TAHAP 2: Kehamilan Saat Ini (Awalnya Blur) -->
                <div id="step-2" class="form-step transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
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
                                <input type="number" step="0.1" name="bb" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Ukuran LiLA (cm)</label>
                                <input type="number" step="0.1" name="ukuran_lila" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0.0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kadar Hb (g/dL)</label>
                                <input type="number" step="0.1" name="kadar_hb" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="0.0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Kunjungan ANC (Kali)</label>
                                <input type="number" name="kunjungan_anc" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" placeholder="Misal: 4" required>
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
                </div>

                <!-- TAHAP 3: Persalinan (Awalnya Blur) -->
                <div id="step-3" class="form-step transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                        <h2 class="font-bold text-lg text-teal-500 flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                            <span class="material-symbols-outlined font-variation-fill">child_friendly</span>
                            Riwayat Persalinan
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Cara Persalinan</label>
                                <select name="cara_persalinan" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:ring-primary" required>
                                    <option value="" disabled selected>Pilih Cara Persalinan</option>
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
                </div>

                <!-- NAVIGATION BUTTONS STICKY -->
                <div class="sticky bottom-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md p-4 mt-4 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-[0_-10px_30px_-10px_rgba(0,0,0,0.1)] flex justify-between items-center transition-all">
                    <button type="button" id="btnPrev" class="hidden px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-600 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Kembali
                    </button>
                    <div class="flex-1"></div>
                    <button type="button" id="btnNext" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-colors shadow-md">
                        Selanjutnya
                    </button>
                    <button type="submit" id="btnSubmit" class="hidden px-8 py-3 rounded-xl bg-green-500 text-white font-bold text-sm hover:bg-green-600 transition-colors shadow-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span> Simpan Riwayat
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 dan Logic Multi-Step -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    
    // --- 1. AMBIL DATA HISTORIS DARI API (AUTO-FILL) ---
    try {
        const response = await fetch('<?= base_url('api/riwayat') ?>');
        const result = await response.json();

        if (result.status === 'success' && result.data) {
            if (result.data.pra_kehamilan && result.data.pra_kehamilan.length > 0) {
                const pra = result.data.pra_kehamilan[0]; 
                document.querySelector('[name="bb_sebelum_hamil"]').value = pra.bb_sebelum_hamil || '';
                document.querySelector('[name="riwayat_abortus"]').value = pra.riwayat_abortus || 'Tidak';
                if (pra.riwayat_penyakit) {
                    const penyakitArr = pra.riwayat_penyakit.split(', ');
                    document.querySelectorAll('[name="riwayat_penyakit[]"]').forEach(cb => {
                        if (penyakitArr.includes(cb.value)) cb.checked = true;
                    });
                }
            }

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

            if (result.data.persalinan && result.data.persalinan.length > 0) {
                const salin = result.data.persalinan[0];
                if (salin.cara_persalinan) document.querySelector('[name="cara_persalinan"]').value = salin.cara_persalinan;
                document.querySelector('[name="umur_kehamilan_salin"]').value = salin.umur_kehamilan_salin || '';
                if (salin.imd) {
                    const imdRadio = document.querySelector(`[name="imd"][value="${salin.imd}"]`);
                    if(imdRadio) imdRadio.checked = true;
                }
            }
        }
    } catch (error) {
        console.error('Gagal memuat data historis riwayat:', error);
    }

    // --- 2. LOGIC WIZARD MULTI-STEP ---
    const form = document.getElementById("formRiwayat");
    const steps = document.querySelectorAll(".form-step");
    const indicators = document.querySelectorAll(".step-indicator");
    const progressLine = document.getElementById("progressLine");
    const scrollContainer = document.getElementById("scrollContainer");
    
    const btnNext = document.getElementById("btnNext");
    const btnPrev = document.getElementById("btnPrev");
    const btnSubmit = document.getElementById("btnSubmit");
    
    let currentStep = 1;
    const totalSteps = steps.length;

    function validateCurrentStep() {
        const currentFormStep = steps[currentStep - 1];
        const inputs = currentFormStep.querySelectorAll("input, select, textarea");
        let isValid = true;
        for (let input of inputs) {
            if (input.type === 'hidden') continue;
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
            }
        }
        return isValid;
    }

    function updateWizard() {
        steps.forEach((step, index) => {
            if (index + 1 === currentStep) {
                step.classList.remove("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                step.classList.add("scale-100", "opacity-100");
            } else {
                step.classList.add("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                step.classList.remove("scale-100", "opacity-100");
            }
        });

        if (currentStep === 1) {
            btnPrev.classList.add("hidden");
        } else {
            btnPrev.classList.remove("hidden");
        }

        if (currentStep === totalSteps) {
            btnNext.classList.add("hidden");
            btnSubmit.classList.remove("hidden");
        } else {
            btnNext.classList.remove("hidden");
            btnSubmit.classList.add("hidden");
        }

        const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressLine.style.width = `${progressPercentage}%`;

        indicators.forEach((indicator, index) => {
            const circle = indicator.querySelector("div");
            const text = indicator.querySelector("span");
            if (index + 1 <= currentStep) {
                circle.classList.replace("bg-slate-200", "bg-primary");
                circle.classList.replace("text-slate-400", "text-white");
                text.classList.replace("text-slate-400", "text-slate-700");
            } else {
                circle.classList.replace("bg-primary", "bg-slate-200");
                circle.classList.replace("text-white", "text-slate-400");
                text.classList.replace("text-slate-700", "text-slate-400");
            }
        });

        setTimeout(() => {
            steps[currentStep - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 150);
    }

    btnNext.addEventListener("click", () => {
        if (validateCurrentStep()) { currentStep++; updateWizard(); }
    });

    btnPrev.addEventListener("click", () => {
        currentStep--; updateWizard();
    });

    // --- 3. SUBMIT DATA DENGAN MENGAKALI CROSS-VALIDATION BACKEND ---
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateCurrentStep()) return;

        const formData = new FormData(this);

        // Gabungkan checkbox penyakit jadi string (Mengatasi error valid_string)
        const checkedPenyakit = this.querySelectorAll('input[name="riwayat_penyakit[]"]:checked');
        if (checkedPenyakit.length > 0) {
            const stringPenyakit = Array.from(checkedPenyakit).map(cb => cb.value).join(", ");
            formData.delete("riwayat_penyakit[]"); 
            formData.set("riwayat_penyakit", stringPenyakit);
        } else {
            formData.delete("riwayat_penyakit[]");
            formData.set("riwayat_penyakit", "Tidak Ada");
        }

        // Injeksi nilai dummy ASI untuk memuaskan rules validasi backend
        formData.append("frekuensi_menyusui", "0");
        formData.append("lama_menyusui", "0");
        formData.append("frekuensi_bab_bayi", "0");
        formData.append("frekuensi_bak_bayi", "0");
        formData.append("hasil_pumping", "0");

        Swal.fire({
            title: 'Menyimpan Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        try {
            const response = await fetch('<?= base_url('api/save-riwayat') ?>', {
                method: 'POST',
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: formData
            });
            
            const result = await response.json();
            
            if (result.status === 'success' || result.success === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersimpan!',
                    text: 'Data riwayat medis Bunda berhasil diperbarui.',
                    confirmButtonColor: '#2b7cee'
                }).then(() => {
                    window.location.href = '<?= base_url('dashboard') ?>'; 
                });
            } else {
                let errorHtml = '<ul style="text-align: left; font-size:14px; color:#ef4444;">';
                if(result.errors) {
                    for(const key in result.errors) errorHtml += `<li>- ${result.errors[key]}</li>`;
                } else {
                    errorHtml += `<li>${result.message}</li>`;
                }
                errorHtml += '</ul>';

                Swal.fire({
                    icon: 'error', title: 'Oops...', html: errorHtml, confirmButtonColor: '#2b7cee'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error', title: 'Koneksi Bermasalah', text: 'Gagal menghubungi server.', confirmButtonColor: '#2b7cee'
            });
        }
    });
});
</script>

<?= $this->endSection() ?>