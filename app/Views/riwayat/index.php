<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden bg-slate-50/50 dark:bg-slate-900/40">
    
    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 py-6 px-6 md:px-10 flex items-center gap-4 flex-shrink-0 relative z-30 shadow-sm">
        <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition flex-shrink-0">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div class="min-w-0">
            <h1 class="font-bold text-lg md:text-xl text-slate-800 dark:text-white truncate">Riwayat Medis</h1>
            <p class="text-xs text-slate-500 truncate">Lengkapi data Pra-Kehamilan hingga Persalinan secara bertahap</p>
        </div>
    </header>

    <div id="scrollContainer" class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-10 relative z-10 scroll-smooth">
        <div class="max-w-4xl mx-auto pb-40">
            
            <div class="flex items-center justify-between mb-8 relative px-2 md:px-12">
                <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                <div id="progressLine" class="absolute left-6 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
                
                <div class="flex flex-col items-center gap-1.5 step-indicator" data-step="1">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md flex-shrink-0">1</div>
                    <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300 transition-colors whitespace-nowrap">Pra Kehamilan</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 step-indicator" data-step="2">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300 flex-shrink-0">2</div>
                    <span class="text-[10px] font-bold text-slate-400 transition-colors whitespace-nowrap">Saat Ini</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 step-indicator" data-step="3">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300 flex-shrink-0">3</div>
                    <span class="text-[10px] font-bold text-slate-400 transition-colors whitespace-nowrap">Persalinan</span>
                </div>
            </div>

            <form id="formRiwayat" class="space-y-6 md:space-y-8 relative w-full">
                <?= csrf_field() ?>
                <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

                <div id="step-1" class="form-step transition-all duration-500 scale-100 opacity-100 w-full">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                        <h2 class="font-bold text-base md:text-lg text-primary flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="material-symbols-outlined font-variation-fill text-2xl">pregnant_woman</span>
                            Riwayat Pra Kehamilan
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">BB Sebelum Hamil (kg)</label>
                                <input type="number" step="0.1" name="bb_sebelum_hamil" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400" placeholder="Misal: 55" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Riwayat Abortus (Keguguran)?</label>
                                <select name="riwayat_abortus" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" required>
                                    <option value="Tidak">Tidak</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Riwayat Penyakit (Pilih jika ada)</label>
                                <div class="flex flex-wrap gap-3 bg-slate-50/80 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-100 dark:border-slate-700/60">
                                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300"><input type="checkbox" name="riwayat_penyakit[]" value="Hipertensi" class="rounded text-primary focus:ring-primary size-4 border-slate-300"> <span>Hipertensi</span></label>
                                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300"><input type="checkbox" name="riwayat_penyakit[]" value="Diabetes" class="rounded text-primary focus:ring-primary size-4 border-slate-300"> <span>Diabetes</span></label>
                                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300"><input type="checkbox" name="riwayat_penyakit[]" value="Asma" class="rounded text-primary focus:ring-primary size-4 border-slate-300"> <span>Asma</span></label>
                                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300"><input type="checkbox" name="riwayat_penyakit[]" value="Jantung" class="rounded text-primary focus:ring-primary size-4 border-slate-300"> <span>Jantung</span></label>
                                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300"><input type="checkbox" name="riwayat_penyakit[]" value="Ginjal" class="rounded text-primary focus:ring-primary size-4 border-slate-300"> <span>Ginjal</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step-2" class="form-step transition-all duration-500 blur-sm opacity-40 pointer-events-none select-none scale-[0.98] w-full">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                        <h2 class="font-bold text-base md:text-lg text-rose-500 flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="material-symbols-outlined font-variation-fill text-2xl">monitor_heart</span>
                            Riwayat Kehamilan Saat Ini
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kehamilan Ke-</label>
                                <input type="number" name="kehamilan_ke" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="1" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Umur Kehamilan (Minggu)</label>
                                <input type="number" name="umur_kehamilan" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="Misal: 38" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Berat Badan Sekarang (kg)</label>
                                <input type="number" step="0.1" name="bb" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="0" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Ukuran LiLA (cm)</label>
                                <input type="number" step="0.1" name="ukuran_lila" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="0.0" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kadar Hb (g/dL)</label>
                                <input type="number" step="0.1" name="kadar_hb" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="0.0" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Kunjungan ANC (Kali)</label>
                                <input type="number" name="kunjungan_anc" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" placeholder="Misal: 4" required>
                            </div>
                            
                            <div class="sm:col-span-2 flex flex-col gap-3 pt-3 border-t border-slate-100 dark:border-slate-700/60">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-100 dark:border-slate-700/40 gap-3">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Consumsi Tablet Tambah Darah?</span>
                                    <select name="konsumsi_ttd" class="rounded-lg border-slate-200 dark:border-slate-700 text-sm w-full sm:w-auto bg-white dark:bg-slate-800 p-1.5"><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-100 dark:border-slate-700/40 gap-3">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sudah Pemeriksaan HIV?</span>
                                    <select name="periksa_hiv" class="rounded-lg border-slate-200 dark:border-slate-700 text-sm w-full sm:w-auto bg-white dark:bg-slate-800 p-1.5"><option value="Ya">Sudah</option><option value="Tidak">Belum</option></select>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-100 dark:border-slate-700/40 gap-3">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sudah Pemeriksaan HBSAG?</span>
                                    <select name="periksa_hbsag" class="rounded-lg border-slate-200 dark:border-slate-700 text-sm w-full sm:w-auto bg-white dark:bg-slate-800 p-1.5"><option value="Ya">Sudah</option><option value="Tidak">Belum</option></select>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-rose-50/60 dark:bg-rose-950/20 p-4 rounded-xl border border-rose-100/70 dark:border-rose-900/40 gap-3">
                                    <span class="text-sm font-bold text-rose-700 dark:text-rose-400">Apakah ibu bahagia dengan kehamilan sekarang?</span>
                                    <select name="status_bahagia" class="rounded-lg border-rose-200 dark:border-rose-900 text-sm text-rose-700 dark:text-rose-400 bg-white dark:bg-slate-800 w-full sm:w-auto p-1.5"><option value="Ya">Ya</option><option value="Tidak">Tidak</option></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step-3" class="form-step transition-all duration-500 blur-sm opacity-40 pointer-events-none select-none scale-[0.98] w-full">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 md:p-8">
                        <h2 class="font-bold text-lg text-teal-500 flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="material-symbols-outlined font-variation-fill text-2xl">child_friendly</span>
                            Riwayat Persalinan
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1.5">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Cara Persalinan</label>
                                <select name="cara_persalinan" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary" required>
                                    <option value="" disabled selected>Pilih Cara Persalinan</option>
                                    <option value="Normal">Normal (Pervaginam)</option>
                                    <option value="Sectio Caesarea">Sesar (SC)</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Umur Kehamilan Saat Lahir (Minggu)</label>
                                <input type="number" name="umur_kehamilan_salin" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary" placeholder="Misal: 39" required>
                            </div>
                            <div class="md:col-span-2 flex flex-col gap-2 pt-2">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Melakukan IMD (Inisiasi Menyusu Dini)?</label>
                                <div class="flex gap-6 bg-slate-50 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-200/60 dark:border-slate-700/60 w-full sm:w-max">
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium"><input type="radio" name="imd" value="Ya" class="text-primary size-4 border-slate-300 focus:ring-primary" required> <span>Ya, Melakukan</span></label>
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-medium"><input type="radio" name="imd" value="Tidak" class="text-primary size-4 border-slate-300 focus:ring-primary"> <span>Tidak</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fixed bottom-[84px] md:bottom-4 left-4 right-4 md:left-[270px] lg:left-[310px] z-40 transition-all duration-300">
                    <div class="max-w-4xl mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-md p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-[0_-10px_25px_-5px_rgba(0,0,0,0.08)] flex justify-between items-center">
                        <button type="button" id="btnPrev" class="hidden px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-xs md:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            Kembali
                        </button>
                        <div class="flex-1"></div>
                        <button type="button" id="btnNext" class="px-6 py-2.5 rounded-xl bg-primary text-white font-bold text-xs md:text-sm hover:bg-primary-dark transition-colors shadow-md shadow-primary/20">
                            Selanjutnya
                        </button>
                        <button type="submit" id="btnSubmit" class="hidden px-6 py-2.5 rounded-xl bg-green-500 text-white font-bold text-xs md:text-sm hover:bg-green-600 transition-colors shadow-md flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-lg">save</span> Simpan Riwayat
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

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
                if(hamil.konsumsi_ttd) document.querySelector('[name="konsumsi_ttd"]').value = hamil.konsumsi_ttd;
                if(hamil.periksa_hiv) document.querySelector('[name="periksa_hiv"]').value = hamil.periksa_hiv;
                if(hamil.periksa_hbsag) document.querySelector('[name="periksa_hbsag"]').value = hamil.periksa_hbsag;
                if(hamil.status_bahagia) document.querySelector('[name="status_bahagia"]').value = hamil.status_bahagia;
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

    // --- 2. LOGIC WIZARD MULTI-STEP WITH AUTO-SAVE ---
    const form = document.getElementById("formRiwayat");
    const steps = document.querySelectorAll(".form-step");
    const indicators = document.querySelectorAll(".step-indicator");
    const progressLine = document.getElementById("progressLine");
    
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

    async function saveStepDataSilent() {
        const formData = new FormData(form);

        const checkedPenyakit = form.querySelectorAll('input[name="riwayat_penyakit[]"]:checked');
        if (checkedPenyakit.length > 0) {
            const stringPenyakit = Array.from(checkedPenyakit).map(cb => cb.value).join(", ");
            formData.delete("riwayat_penyakit[]"); 
            formData.set("riwayat_penyakit", stringPenyakit);
        } else {
            formData.delete("riwayat_penyakit[]");
            formData.set("riwayat_penyakit", "Tidak Ada");
        }

        formData.append("frekuensi_menyusui", "0");
        formData.append("lama_menyusui", "0");
        formData.append("frekuensi_bab_bayi", "0");
        formData.append("frekuensi_bak_bayi", "0");
        formData.append("hasil_pumping", "0");

        try {
            const response = await fetch('<?= base_url('api/save-riwayat') ?>', {
                method: 'POST',
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: formData
            });
            const result = await response.json();
            return (result.status === 'success' || result.success === true);
        } catch (error) {
            console.error("Auto-save gagal:", error);
            return false;
        }
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

        if (currentStep === 1) btnPrev.classList.add("hidden"); else btnPrev.classList.remove("hidden");

        if (currentStep === totalSteps) {
            btnNext.classList.add("hidden"); btnSubmit.classList.remove("hidden");
        } else {
            btnNext.classList.remove("hidden"); btnSubmit.classList.add("hidden");
        }

        progressLine.style.width = `${((currentStep - 1) / (totalSteps - 1)) * 100}%`;

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

    btnNext.addEventListener("click", async () => {
        if (validateCurrentStep()) {
            btnNext.disabled = true;
            btnNext.innerHTML = 'Menyimpan...';

            const isSaved = await saveStepDataSilent();
            
            btnNext.disabled = false;
            btnNext.innerHTML = 'Selanjutnya';

            if (isSaved) {
                currentStep++;
                updateWizard();
            } else {
                Swal.fire({
                    icon: 'error', title: 'Gagal Menyimpan', text: 'Gagal mengamankan data langkah ini ke server.'
                });
            }
        }
    });

    btnPrev.addEventListener("click", () => {
        currentStep--; updateWizard();
    });

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!validateCurrentStep()) return;

        Swal.fire({
            title: 'Memfinalisasi Data...', text: 'Mohon tunggu sebentar', allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const isFinalSaved = await saveStepDataSilent();

        if (isFinalSaved) {
            Swal.fire({
                icon: 'success', title: 'Semua Terpanen!', text: 'Seluruh riwayat medis Bunda sukses diabadikan.', confirmButtonColor: '#2b7cee'
            }).then(() => {
                window.location.href = '<?= base_url('dashboard') ?>'; 
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal melakukan sinkronisasi final.' });
        }
    });
});
</script>
<?= $this->endSection() ?>