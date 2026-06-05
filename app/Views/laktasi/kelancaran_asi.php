<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden">
    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 py-6 px-6 md:px-10 flex-shrink-0 z-20">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100">Pantau Bayi & Kelancaran ASI</h1>
                <p class="text-xs md:text-sm text-slate-400">Pilih menu di bawah untuk memperbarui data si kecil atau evaluasi laktasi harian.</p>
            </div>
        </div>
    </header>

    <div id="scrollContainer" class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 bg-slate-50/50 dark:bg-slate-900/40 relative scroll-smooth">
        <div class="max-w-4xl mx-auto pb-32">

            <!-- TAB SWITCHER -->
            <div class="flex p-1 bg-slate-200/60 dark:bg-slate-800 rounded-2xl max-w-md mx-auto mb-10 shadow-inner border border-slate-200 dark:border-slate-700">
                <button id="tabBtnBayi" class="flex-1 py-3 text-sm font-bold rounded-xl bg-white dark:bg-slate-700 shadow-sm text-primary transition-all">
                    Data Bayi
                </button>
                <button id="tabBtnAsi" class="flex-1 py-3 text-sm font-bold rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all">
                    Evaluasi ASI
                </button>
            </div>

            <!-- ======================================================= -->
            <!-- CONTAINER 1: FORM DATA BAYI (AWALNYA AKTIF)             -->
            <!-- ======================================================= -->
            <div id="containerBayi" class="block animate-fade-in">
                <!-- Progress Bar Bayi -->
                <div class="flex items-center justify-between mb-8 relative px-10 md:px-24">
                    <div class="absolute left-10 right-10 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                    <div id="progressLineBayi" class="absolute left-10 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
                    
                    <div class="flex flex-col items-center gap-2 indicator-bayi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md">1</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors">Dimensi Fisik</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 indicator-bayi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">2</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-400 transition-colors">Refleks Primitif</span>
                    </div>
                </div>

                <form id="formBayi" action="<?= base_url('api/save-data-bayi') ?>" method="POST" class="flex flex-col gap-6 md:gap-8 relative">
                    <?= csrf_field() ?>

                    <!-- Bayi Step 1 -->
                    <div class="step-bayi transition-all duration-500 scale-100 opacity-100">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill">child_care</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 1: Identitas & Fisik Bayi</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Nama / Status Kelahiran Bayi</label>
                                    <input type="text" name="nama_bayi" required placeholder="Contoh: Muhammad Ghonni / Bayi 1" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Golongan Darah</label>
                                    <select name="golongan_darah" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <option value="" disabled selected>Pilih Gol. Darah</option>
                                        <option value="A">A</option><option value="B">B</option>
                                        <option value="AB">AB</option><option value="O">O</option>
                                        <option value="Belum Tahu">Belum Diketahui</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Suhu Bayi</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="suhu_bayi" min="30" required placeholder="36.5" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">°C</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Berat Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="berat_badan" min="0" required placeholder="3.2" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kg</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Panjang Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="panjang_badan" min="0" required placeholder="50" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Lingkar Kepala</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_kepala" min="0" required placeholder="34" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Lingkar Dada</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_dada" min="0" required placeholder="33" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Lingkar Lengan Atas (LiLA)</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_lengan" min="0" required placeholder="11" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bayi Step 2 -->
                    <div class="step-bayi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-rose-500 text-2xl font-variation-fill">pulse</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 2: Refleks Primitif</h2>
                            </div>
                            <div class="flex flex-col gap-4 divide-y divide-slate-100 dark:divide-slate-700/60">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div><h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mencari Puting (Rooting)</h4></div>
                                    <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_rooting" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_rooting" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div><h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mengisap (Sucking)</h4></div>
                                    <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_mengisap" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_mengisap" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div><h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Menelan (Swallowing)</h4></div>
                                    <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_menelan" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="reflek_menelan" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Bayi -->
                    <div class="sticky bottom-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md p-4 mt-4 rounded-3xl border border-slate-200/80 shadow-[0_-10px_30px_-10px_rgba(0,0,0,0.1)] flex justify-between items-center transition-all">
                        <button type="button" id="btnPrevBayi" class="hidden px-6 py-3 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Kembali</button>
                        <div class="flex-1"></div>
                        <button type="button" id="btnNextBayi" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark shadow-md">Selanjutnya</button>
                        <button type="submit" id="btnSubmitBayi" class="hidden px-8 py-3 rounded-xl bg-green-500 text-white font-bold text-sm hover:bg-green-600 shadow-md flex items-center gap-2"><span class="material-symbols-outlined text-xl">save</span> Simpan Data Bayi</button>
                    </div>
                </form>
            </div>

            <!-- ======================================================= -->
            <!-- CONTAINER 2: FORM KELANCARAN ASI (AWALNYA SEMBUNYI)     -->
            <!-- ======================================================= -->
            <div id="containerAsi" class="hidden animate-fade-in">
                <!-- Progress Bar ASI -->
                <div class="flex items-center justify-between mb-8 relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                    <div id="progressLineAsi" class="absolute left-0 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
                    
                    <div class="flex flex-col items-center gap-2 indicator-asi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md">1</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-700 dark:text-slate-300">Kuantitatif</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 indicator-asi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">2</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-400">Kualitatif</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 indicator-asi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">3</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-400">Dukungan</span>
                    </div>
                </div>

                <form id="formAsi" action="<?= base_url('api/save-asi') ?>" method="POST" class="flex flex-col gap-6 md:gap-8 relative">
                    <?= csrf_field() ?>
                    <input type="hidden" name="riwayat_penyakit" value="-">

                    <!-- ASI Step 1 -->
                    <div class="step-asi transition-all duration-500 scale-100 opacity-100">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill">equalizer</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 1: Indikator Kuantitatif</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Frekuensi BAB Bayi</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_bab_bayi" min="0" required placeholder="Target: 3 - 5" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Frekuensi BAK Bayi</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_bak_bayi" min="0" required placeholder="Target: 6 - 8" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Frekuensi Menyusui</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_menyusui" min="0" required placeholder="Target: 8 - 12" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Lama Menyusui</label>
                                    <div class="relative">
                                        <input type="number" name="lama_menyusui" min="0" required placeholder="Target: 5 - 10" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">menit</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Hasil Pumping</label>
                                    <div class="relative">
                                        <input type="number" name="hasil_pumping" min="0" required placeholder="Volume ml" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">ml</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ASI Step 2 -->
                    <div class="step-asi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-rose-500 text-2xl font-variation-fill">assignment_turned_in</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 2: Indikator Kualitatif</h2>
                            </div>
                            <div class="flex flex-col gap-4 divide-y divide-slate-100 dark:divide-slate-700/60">
                                <?php
                                $kualitatifFields = [
                                    'bayi_tidur_cukup' => ['Bayi tidur minimal 12 jam sehari', 'Memastikan kualitas istirahat bayi terpenuhi.'],
                                    'bayi_puas_tenang' => ['Bayi terlihat puas 2-3 jam setelah menyusu', 'Menandakan volume ASI mencukupi.'],
                                    'warna_urine_jernih' => ['Warna urine bayi pucat / jernih', 'Indikator hidrasi tubuh bayi.'],
                                    'payudara_penuh_merembes' => ['Payudara terasa penuh dan merembes', 'Produksi kelenjar ASI aktif.'],
                                    'berat_badan_naik' => ['Berat badan bayi naik', 'Parameter tumbuh kembang optimal.']
                                ];
                                foreach ($kualitatifFields as $key => $data):
                                    ?>
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                        <div><h4 class="text-sm font-bold text-slate-700 dark:text-slate-200"><?= $data[0] ?></h4><p class="text-xs text-slate-400"><?= $data[1] ?></p></div>
                                        <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                            <label class="flex-1 sm:flex-initial cursor-pointer text-center"><input type="radio" name="<?= $key ?>" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                            <label class="flex-1 sm:flex-initial cursor-pointer text-center"><input type="radio" name="<?= $key ?>" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ASI Step 3 -->
                    <div class="step-asi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-teal-500 text-2xl font-variation-fill">diversity_1</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 3: Kondisi & Dukungan</h2>
                            </div>
                            <div class="grid grid-cols-1 gap-5">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase">Kondisi Fisik Puting Ibu</label>
                                    <select name="kondisi_puting" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:border-primary">
                                        <option value="" disabled selected>Pilih Kondisi Puting</option>
                                        <option value="Menonjol">Menonjol</option><option value="Datar">Datar</option>
                                        <option value="Tenggelam">Tenggelam</option><option value="Pecah-pecah">Pecah-pecah</option>
                                    </select>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-2 border-b border-slate-100 gap-3">
                                    <div><h4 class="text-sm font-bold text-slate-700">Suami mengingatkan menyusui setiap 2 jam</h4></div>
                                    <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="suami_ingatkan_jadwal" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="suami_ingatkan_jadwal" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-2 border-b border-slate-100 gap-3">
                                    <div><h4 class="text-sm font-bold text-slate-700">Suami mengingatkan makan bergizi</h4></div>
                                    <div class="flex gap-2 bg-slate-50 p-1 rounded-xl border border-slate-200 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="suami_ingatkan_nutrisi" value="Ya" required class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div></label>
                                        <label class="flex-1 cursor-pointer text-center"><input type="radio" name="suami_ingatkan_nutrisi" value="Tidak" class="sr-only peer"><div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi ASI -->
                    <div class="sticky bottom-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md p-4 mt-4 rounded-3xl border border-slate-200/80 shadow-[0_-10px_30px_-10px_rgba(0,0,0,0.1)] flex justify-between items-center transition-all">
                        <button type="button" id="btnPrevAsi" class="hidden px-6 py-3 rounded-xl border border-slate-300 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Kembali</button>
                        <div class="flex-1"></div>
                        <button type="button" id="btnNextAsi" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark shadow-md">Selanjutnya</button>
                        <button type="submit" id="btnSubmitAsi" class="hidden px-8 py-3 rounded-xl bg-green-500 text-white font-bold text-sm hover:bg-green-600 shadow-md flex items-center gap-2"><span class="material-symbols-outlined text-xl">analytics</span> Simpan Evaluasi</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // ==========================================
    // LOGIKA TAB SWITCHER
    // ==========================================
    const tabBtnBayi = document.getElementById("tabBtnBayi");
    const tabBtnAsi = document.getElementById("tabBtnAsi");
    const containerBayi = document.getElementById("containerBayi");
    const containerAsi = document.getElementById("containerAsi");

    tabBtnBayi.addEventListener("click", () => {
        // Style Tab
        tabBtnBayi.classList.replace("text-slate-500", "text-primary");
        tabBtnBayi.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnBayi.classList.remove("hover:text-slate-700", "dark:text-slate-400");
        
        tabBtnAsi.classList.replace("text-primary", "text-slate-500");
        tabBtnAsi.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnAsi.classList.add("hover:text-slate-700", "dark:text-slate-400");

        // Toggle Container
        containerBayi.classList.remove("hidden");
        containerBayi.classList.add("block");
        containerAsi.classList.remove("block");
        containerAsi.classList.add("hidden");
    });

    tabBtnAsi.addEventListener("click", () => {
        // Style Tab
        tabBtnAsi.classList.replace("text-slate-500", "text-primary");
        tabBtnAsi.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnAsi.classList.remove("hover:text-slate-700", "dark:text-slate-400");
        
        tabBtnBayi.classList.replace("text-primary", "text-slate-500");
        tabBtnBayi.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnBayi.classList.add("hover:text-slate-700", "dark:text-slate-400");

        // Toggle Container
        containerAsi.classList.remove("hidden");
        containerAsi.classList.add("block");
        containerBayi.classList.remove("block");
        containerBayi.classList.add("hidden");
    });

    // ==========================================
    // LOGIKA UMUM WIZARD
    // ==========================================
    const inputsAngka = document.querySelectorAll("input[type='number']");
    inputsAngka.forEach(input => {
        input.addEventListener("input", function() { if (this.value < 0) this.value = 0; });
    });

    function validateStep(steps, current) {
        const inputs = steps[current - 1].querySelectorAll("input, select, textarea");
        for (let input of inputs) {
            if (input.type === 'hidden') continue;
            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }
        }
        return true;
    }

    function updateUI(current, total, steps, indicators, line, btnPrev, btnNext, btnSubmit) {
        steps.forEach((step, index) => {
            if (index + 1 === current) {
                step.classList.remove("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                step.classList.add("scale-100", "opacity-100");
            } else {
                step.classList.add("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                step.classList.remove("scale-100", "opacity-100");
            }
        });

        if (current === 1) btnPrev.classList.add("hidden"); else btnPrev.classList.remove("hidden");
        if (current === total) {
            btnNext.classList.add("hidden"); btnSubmit.classList.remove("hidden");
        } else {
            btnNext.classList.remove("hidden"); btnSubmit.classList.add("hidden");
        }

        line.style.width = `${((current - 1) / (total - 1)) * 100}%`;

        indicators.forEach((indicator, index) => {
            const circle = indicator.querySelector("div");
            const text = indicator.querySelector("span");
            if (index + 1 <= current) {
                circle.classList.replace("bg-slate-200", "bg-primary");
                circle.classList.replace("text-slate-400", "text-white");
                text.classList.replace("text-slate-400", "text-slate-700");
            } else {
                circle.classList.replace("bg-primary", "bg-slate-200");
                circle.classList.replace("text-white", "text-slate-400");
                text.classList.replace("text-slate-700", "text-slate-400");
            }
        });

        setTimeout(() => { steps[current - 1].scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 150);
    }

    // ==========================================
    // INIT WIZARD BAYI (2 Langkah)
    // ==========================================
    const formBayi = document.getElementById("formBayi");
    const stepsBayi = document.querySelectorAll(".step-bayi");
    const indBayi = document.querySelectorAll(".indicator-bayi");
    const lineBayi = document.getElementById("progressLineBayi");
    const btnNextBayi = document.getElementById("btnNextBayi");
    const btnPrevBayi = document.getElementById("btnPrevBayi");
    const btnSubmitBayi = document.getElementById("btnSubmitBayi");
    let stepBayiCurrent = 1;

    btnNextBayi.addEventListener("click", () => {
        if (validateStep(stepsBayi, stepBayiCurrent)) {
            stepBayiCurrent++; updateUI(stepBayiCurrent, 2, stepsBayi, indBayi, lineBayi, btnPrevBayi, btnNextBayi, btnSubmitBayi);
        }
    });
    btnPrevBayi.addEventListener("click", () => {
        stepBayiCurrent--; updateUI(stepBayiCurrent, 2, stepsBayi, indBayi, lineBayi, btnPrevBayi, btnNextBayi, btnSubmitBayi);
    });

    formBayi.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (!validateStep(stepsBayi, stepBayiCurrent)) return;
        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
        try {
            const res = await fetch(formBayi.action, { method: "POST", headers: { "X-Requested-With": "XMLHttpRequest" }, body: new FormData(formBayi) });
            const result = await res.json();
            if (res.ok && (result.status === 'success' || result.success === true)) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data Bayi disimpan.', confirmButtonColor: '#2b7cee' }).then(() => { window.location.href = "<?= base_url('dashboard') ?>"; });
            } else { Swal.fire({ icon: 'error', title: 'Oops...', text: result.message || "Gagal menyimpan." }); }
        } catch (error) { Swal.fire({ icon: 'error', title: 'Error', text: 'Koneksi gagal.' }); }
    });

    // ==========================================
    // INIT WIZARD ASI (3 Langkah)
    // ==========================================
    const formAsi = document.getElementById("formAsi");
    const stepsAsi = document.querySelectorAll(".step-asi");
    const indAsi = document.querySelectorAll(".indicator-asi");
    const lineAsi = document.getElementById("progressLineAsi");
    const btnNextAsi = document.getElementById("btnNextAsi");
    const btnPrevAsi = document.getElementById("btnPrevAsi");
    const btnSubmitAsi = document.getElementById("btnSubmitAsi");
    let stepAsiCurrent = 1;

    btnNextAsi.addEventListener("click", () => {
        if (validateStep(stepsAsi, stepAsiCurrent)) {
            stepAsiCurrent++; updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi, btnPrevAsi, btnNextAsi, btnSubmitAsi);
        }
    });
    btnPrevAsi.addEventListener("click", () => {
        stepAsiCurrent--; updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi, btnPrevAsi, btnNextAsi, btnSubmitAsi);
    });

    formAsi.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (!validateStep(stepsAsi, stepAsiCurrent)) return;
        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
        const formData = new FormData(formAsi);
        if (!formData.get("riwayat_penyakit")) formData.set("riwayat_penyakit", "-");
        try {
            const res = await fetch(formAsi.action, { method: "POST", headers: { "X-Requested-With": "XMLHttpRequest" }, body: formData });
            const result = await res.json();
            if (res.ok && (result.status === 'success' || result.success === true)) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Evaluasi disimpan.', confirmButtonColor: '#2b7cee' }).then(() => { window.location.href = "<?= base_url('dashboard') ?>"; });
            } else { Swal.fire({ icon: 'error', title: 'Oops...', text: result.message || "Gagal menyimpan." }); }
        } catch (error) { Swal.fire({ icon: 'error', title: 'Error', text: 'Koneksi gagal.' }); }
    });
});
</script>
<?= $this->endSection() ?>