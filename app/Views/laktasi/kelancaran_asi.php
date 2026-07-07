<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden bg-slate-50/50 dark:bg-slate-900/40">

    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 py-6 px-6 md:px-10 flex-shrink-0 z-20 shadow-sm">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary transition-colors flex-shrink-0">
                <span class="material-symbols-outlined select-none">arrow_back</span>
            </a>
            <div class="min-w-0">
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 truncate">Pantau Bayi & Kelancaran ASI</h1>
                <p class="text-xs md:text-sm text-slate-400 truncate">Perbarui data si kecil atau simpan evaluasi laktasi harian Bunda di sini.</p>
            </div>
        </div>
    </header>

    <div id="scrollContainer" class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-10 relative z-10 scroll-smooth animate-slide-up">
        <div class="max-w-4xl mx-auto pb-24">

            <div class="flex p-1 bg-slate-200/60 dark:bg-slate-800 rounded-2xl max-w-md mx-auto mb-10 shadow-inner border border-slate-200 dark:border-slate-700">
                <button id="tabBtnBayi" class="flex-1 py-3 text-sm font-bold rounded-xl bg-white dark:bg-slate-700 shadow-sm text-primary transition-all">
                    Data Bayi
                </button>
                <button id="tabBtnAsi" class="flex-1 py-3 text-sm font-bold rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all">
                    Evaluasi ASI
                </button>
            </div>

            <div id="containerBayi" class="block animate-fade-in">
                <div class="flex items-center justify-between mb-8 relative px-10 md:px-24">
                    <div class="absolute left-10 right-10 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                    <div id="progressLineBayi" class="absolute left-10 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>

                    <div class="flex flex-col items-center gap-2 indicator-bayi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md">1</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-700 dark:text-slate-300">Dimensi Fisik</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 indicator-bayi">
                        <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300">2</div>
                        <span class="text-[10px] md:text-xs font-bold text-slate-400">Refleks Primitif</span>
                    </div>
                </div>

                <form id="formBayi" action="<?= base_url('api/data-bayi') ?>" method="POST" class="space-y-6 relative">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

                    <div class="step-bayi transition-all duration-500 scale-100 opacity-100">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill select-none">child_care</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 1: Identitas & Fisik Bayi</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Golongan Darah</label>
                                    <select name="golongan_darah" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                                        <option value="" disabled selected>Pilih Gol. Darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="Belum Tahu">Belum Tahu</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Suhu Tubuh</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="suhu" min="30" required placeholder="36.5" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">°C</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Berat Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="bb" min="0" required placeholder="3.2" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kg</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Panjang Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="pb" min="0" required placeholder="50" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lingkar Kepala</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_kepala" min="0" required placeholder="34" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lingkar Dada</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_dada" min="0" required placeholder="33" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lingkar Lengan Atas (LiLA)</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="lingkar_lengan" min="0" required placeholder="11" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" id="btnNextBayi" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-bold text-sm rounded-xl shadow-md transition-all">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                    <div class="step-bayi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-rose-500 text-2xl font-variation-fill select-none">pulse</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 2: Refleks Primitif</h2>
                            </div>
                            <div class="flex flex-col gap-4 divide-y divide-slate-100 dark:divide-slate-700/60">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mencari Puting (Rooting)</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_mencari_puting" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_mencari_puting" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mengisap (Sucking)</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_mengisap" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_mengisap" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Menelan (Swallowing)</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_menelan" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="reflek_menelan" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white transition-all">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" id="btnPrevBayi" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-sm font-bold text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100">Kembali</button>
                                <button type="submit" id="btnSubmitBayi" class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-bold text-sm rounded-xl shadow-md flex items-center gap-2">
                                    <span class="material-symbols-outlined text-xl select-none">save</span> Simpan Data Bayi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="containerAsi" class="hidden animate-fade-in">
                <div class="flex items-center justify-between mb-8 relative px-2 md:px-8">
                    <div class="absolute left-4 right-4 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                    <div id="progressLineAsi" class="absolute left-4 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>

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

                <form id="formAsi" action="<?= base_url('api/save-asi') ?>" method="POST" class="space-y-6 relative">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="status_kecukupan_asi" value="Ya">
                    <input type="hidden" name="riwayat_penyakit" value="-">

                    <div class="step-asi transition-all duration-500 scale-100 opacity-100">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-primary text-2xl font-variation-fill select-none">equalizer</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 1: Indikator Kuantitatif</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Frekuensi BAB Bayi</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_bab_bayi" min="0" required placeholder="Target: 3 - 5" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Frekuensi BAK Bayi</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_bak_bayi" min="0" required placeholder="Target: 6 - 8" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Frekuensi Menyusui</label>
                                    <div class="relative">
                                        <input type="number" name="frekuensi_menyusui" min="0" required placeholder="Target: 8 - 12" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kali</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lama Menyusui</label>
                                    <div class="relative">
                                        <input type="number" name="lama_menyusui" min="0" required placeholder="Target: 5 - 10" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">menit</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:col-span-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hasil Pumping</label>
                                    <div class="relative">
                                        <input type="number" id="pumping_input" name="hasil_pumping" min="0" max="10000" required placeholder="Contoh: 1000" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder:text-slate-400">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">ml</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" id="btnNextAsi1" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-bold text-sm rounded-xl shadow-md transition-all">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                    <div class="step-asi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-rose-500 text-2xl font-variation-fill select-none">assignment_turned_in</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 2: Indikator Kualitatif</h2>
                            </div>
                            <div class="flex flex-col gap-4 divide-y divide-slate-100 dark:divide-slate-700/60">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Bayi tidur minimal 12 jam sehari</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bayi_tidur_12jam" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bayi_tidur_12jam" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Bayi terlihat puas & tenang setelah menyusu</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bayi_tenang_setelah_menyusu" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bayi_tenang_setelah_menyusu" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Warna urine bayi jernih / hidrasi cukup</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="warna_urin_bayi" value="Jernih" required class="sr-only peer">
                                            <div class="px-3 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Jernih</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="warna_urin_bayi" value="Kuning Muda" class="sr-only peer">
                                            <div class="px-3 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-amber-500 peer-checked:text-white">Muda</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="warna_urin_bayi" value="Kuning Pekat" class="sr-only peer">
                                            <div class="px-3 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Pekat</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Payudara terasa penuh sebelum menyusui</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="payudara_penuh" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="payudara_penuh" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Berat badan bayi naik sesuai usia</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200/60 w-full sm:w-auto">
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bb_naik_sesuai_usia" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                            <input type="radio" name="bb_naik_sesuai_usia" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" id="btnPrevAsi1" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-sm font-bold text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100">Kembali</button>
                                <button type="button" id="btnNextAsi2" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-bold text-sm rounded-xl shadow-md transition-all">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                    <div class="step-asi transition-all duration-500 blur-sm opacity-50 pointer-events-none select-none scale-[0.98]">
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                                <span class="material-symbols-outlined text-teal-500 text-2xl font-variation-fill select-none">diversity_1</span>
                                <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Langkah 3: Kondisi & Dukungan</h2>
                            </div>
                            <div class="grid grid-cols-1 gap-5">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kondisi Fisik Puting Ibu</label>
                                    <select name="kondisi_puting" required class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 text-sm focus:outline-none focus:border-primary text-slate-700 dark:text-slate-200">
                                        <option value="" disabled selected>Pilih Kondisi Puting</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Lecet">Lecet</option>
                                        <option value="Datar">Datar</option>
                                        <option value="Tenggelam">Tenggelam</option>
                                        <option value="Menonjol">Menonjol</option>
                                        <option value="Pecah">Pecah-pecah</option>
                                    </select>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-2 border-b border-slate-100 dark:border-slate-700/50 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Suami mengingatkan menyusui setiap 2 jam</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="support_suami_menyusui" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="support_suami_menyusui" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-2 border-b border-slate-100 dark:border-slate-700/50 gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Suami mengingatkan makan bergizi</h4>
                                    </div>
                                    <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/50 p-1 rounded-xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto">
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="support_suami_gizi" value="Ya" required class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white">Ya</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer text-center">
                                            <input type="radio" name="support_suami_gizi" value="Tidak" class="sr-only peer">
                                            <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white">Tidak</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                <button type="button" id="btnPrevAsi2" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-sm font-bold text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100">Kembali</button>
                                <button type="submit" id="btnSubmitAsi" class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-bold text-sm rounded-xl shadow-md flex items-center gap-2">
                                    <span class="material-symbols-outlined text-xl select-none">analytics</span> Simpan Evaluasi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

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
            tabBtnBayi.classList.replace("text-slate-500", "text-primary");
            tabBtnBayi.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
            tabBtnBayi.classList.remove("hover:text-slate-700", "dark:text-slate-400");
            tabBtnAsi.classList.replace("text-primary", "text-slate-500");
            tabBtnAsi.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
            tabBtnAsi.classList.add("hover:text-slate-700", "dark:text-slate-400");
            containerBayi.classList.replace("hidden", "block");
            containerAsi.classList.replace("block", "hidden");
        });

        tabBtnAsi.addEventListener("click", () => {
            tabBtnAsi.classList.replace("text-slate-500", "text-primary");
            tabBtnAsi.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
            tabBtnAsi.classList.remove("hover:text-slate-700", "dark:text-slate-400");
            tabBtnBayi.classList.replace("text-primary", "text-slate-500");
            tabBtnBayi.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
            tabBtnBayi.classList.add("hover:text-slate-700", "dark:text-slate-400");
            containerAsi.classList.replace("hidden", "block");
            containerBayi.classList.replace("block", "hidden");
        });

        // ==========================================
        // LOGIKA UMUM WIZARD ENGINE
        // ==========================================
        const inputsAngka = document.querySelectorAll("input[type='number']");
        inputsAngka.forEach(input => {
            input.addEventListener("input", function () { if (this.value < 0) this.value = 0; });
        });

        // FIX MODIFIKASI ALTERNATIF: Validasi step yang ramah terhadap input number browser
        function validateStep(steps, current) {
            const inputs = steps[current - 1].querySelectorAll("input, select, textarea");
            for (let input of inputs) {
                if (input.type === 'hidden') continue;
                
                // Jika bertipe number, pastikan terisi dan tidak minus (bypass pengecekan max kaku browser)
                if (input.type === 'number' && (input.value === '' || parseFloat(input.value) < 0)) {
                    input.reportValidity();
                    return false;
                }
                
                // Untuk input non-number tetap gunakan checkValidity bawaan browser
                if (input.type !== 'number' && !input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
            return true;
        }

        function updateUI(current, total, steps, indicators, line) {
            steps.forEach((step, index) => {
                if (index + 1 === current) {
                    step.classList.remove("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                    step.classList.add("scale-100", "opacity-100");
                } else {
                    step.classList.add("blur-sm", "opacity-50", "pointer-events-none", "select-none", "scale-[0.98]");
                    step.classList.remove("scale-100", "opacity-100");
                }
            });

            line.style.width = `${((current - 1) / (total - 1)) * 100}%`;

            indicators.forEach((indicator, index) => {
                const circle = indicator.querySelector("div");
                if (index + 1 <= current) {
                    circle.classList.remove("bg-slate-200", "text-slate-400", "dark:bg-slate-700");
                    circle.classList.add("bg-primary", "text-white");
                } else {
                    circle.classList.remove("bg-primary", "text-white");
                    circle.classList.add("bg-slate-200", "text-slate-400", "dark:bg-slate-700");
                }
            });

            setTimeout(() => { steps[current - 1].scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 150);
        }

        // ==========================================
        // FUNGSI AUTO-SAVE / SEND PARTIAL AJAX DATA
        // ==========================================
        async function sendPartialData(url, formElement) {
            const formData = new FormData(formElement);

            if (formElement.id === "formBayi") {
                const reflekFields = ["reflek_mencari_puting", "reflek_mengisap", "reflek_menelan"];
                reflekFields.forEach(field => {
                    if (!formData.get(field)) {
                        formData.delete(field);
                    }
                });
            }

            if (formElement.id === "formAsi") {
                let hasilPumpingRaw = formData.get("hasil_pumping");
                let volumePumpingNum = parseFloat(hasilPumpingRaw) || 0;
                
                // FIX ALTERNATIF: Kunci ke 10000 murni di input field agar sinkron dengan FormData
                if (volumePumpingNum > 10000) {
                    volumePumpingNum = 10000;
                    document.getElementById("pumping_input").value = 10000;
                }

                formData.set("volume_pumping", volumePumpingNum);
                formData.set("hasil_pumping", volumePumpingNum);

                const kualitatifFields = [
                    "kondisi_puting", "support_suami_menyusui", "support_suami_gizi",
                    "bayi_tidur_12jam", "bayi_tenang_setelah_menyusu", "warna_urin_bayi",
                    "payudara_penuh", "bb_naik_sesuai_usia"
                ];

                kualitatifFields.forEach(field => {
                    if (!formData.get(field) || formData.get(field) === "") {
                        formData.delete(field);
                    }
                });
            }

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: { "X-Requested-With": "XMLHttpRequest" },
                    body: formData
                });
                const result = await res.json();
                return (res.ok && (result.status === 'success' || result.success === true));
            } catch (error) {
                console.error("Koneksi Auto-save gagal:", error);
                return false;
            }
        }

        // ==========================================
        // MANAGEMENT WIZARD DATA BAYI (2 LANGKAH)
        // ==========================================
        const formBayi = document.getElementById("formBayi");
        const stepsBayi = document.querySelectorAll(".step-bayi");
        const indBayi = document.querySelectorAll(".indicator-bayi");
        const lineBayi = document.getElementById("progressLineBayi");
        const btnNextBayi = document.getElementById("btnNextBayi");
        const btnPrevBayi = document.getElementById("btnPrevBayi");
        let stepBayiCurrent = 1;

        btnNextBayi.addEventListener("click", async () => {
            if (validateStep(stepsBayi, stepBayiCurrent)) {
                btnNextBayi.disabled = true;
                btnNextBayi.innerHTML = 'Menyimpan...';

                const isSaved = await sendPartialData(formBayi.action, formBayi);

                btnNextBayi.disabled = false;
                btnNextBayi.innerHTML = 'Selanjutnya';

                if (isSaved) {
                    stepBayiCurrent++; 
                    updateUI(stepBayiCurrent, 2, stepsBayi, indBayi, lineBayi);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: 'Periksa kembali kesesuaian data fisik bayi Bunda.' });
                }
            }
        });

        btnPrevBayi.addEventListener("click", () => {
            stepBayiCurrent--; 
            updateUI(stepBayiCurrent, 2, stepsBayi, indBayi, lineBayi);
        });

        formBayi.addEventListener("submit", async (e) => {
            e.preventDefault();
            if (!validateStep(stepsBayi, stepBayiCurrent)) return;
            Swal.fire({ title: 'Memfinalisasi...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            const isFinalSaved = await sendPartialData(formBayi.action, formBayi);
            if (isFinalSaved) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Rekam fisik & refleks si kecil berhasil disimpan.', confirmButtonColor: '#2b7cee' })
                    .then(() => { window.location.href = "<?= base_url('dashboard') ?>"; });
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Sinkronisasi final data bayi terhambat.' });
            }
        });

        // ==========================================
        // MANAGEMENT WIZARD EVALUASI ASI (3 LANGKAH)
        // ==========================================
        const formAsi = document.getElementById("formAsi");
        const stepsAsi = document.querySelectorAll(".step-asi");
        const indAsi = document.querySelectorAll(".indicator-asi");
        const lineAsi = document.getElementById("progressLineAsi");
        const btnNextAsi1 = document.getElementById("btnNextAsi1");
        const btnNextAsi2 = document.getElementById("btnNextAsi2");
        const btnPrevAsi1 = document.getElementById("btnPrevAsi1");
        const btnPrevAsi2 = document.getElementById("btnPrevAsi2");
        let stepAsiCurrent = 1;

        btnNextAsi1.addEventListener("click", async () => {
            if (validateStep(stepsAsi, stepAsiCurrent)) {
                btnNextAsi1.disabled = true;
                btnNextAsi1.innerHTML = 'Menyimpan...';

                const isSaved = await sendPartialData(formAsi.action, formAsi);

                btnNextAsi1.disabled = false;
                btnNextAsi1.innerHTML = 'Selanjutnya';

                if (isSaved) {
                    stepAsiCurrent++; 
                    updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: 'Periksa rentang angka indikator kuantitatif ASI.' });
                }
            }
        });

        btnNextAsi2.addEventListener("click", async () => {
            if (validateStep(stepsAsi, stepAsiCurrent)) {
                btnNextAsi2.disabled = true;
                btnNextAsi2.innerHTML = 'Menyimpan...';

                const isSaved = await sendPartialData(formAsi.action, formAsi);

                btnNextAsi2.disabled = false;
                btnNextAsi2.innerHTML = 'Selanjutnya';

                if (isSaved) {
                    stepAsiCurrent++; 
                    updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal Menyimpan', text: 'Gagal menyelaraskan indikator kualitatif laktasi.' });
                }
            }
        });

        btnPrevAsi1.addEventListener("click", () => {
            stepAsiCurrent--; 
            updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi);
        });
        
        btnPrevAsi2.addEventListener("click", () => {
            stepAsiCurrent--; 
            updateUI(stepAsiCurrent, 3, stepsAsi, indAsi, lineAsi);
        });

        formAsi.addEventListener("submit", async (e) => {
            e.preventDefault();
            if (!validateStep(stepsAsi, stepAsiCurrent)) return;
            Swal.fire({ title: 'Memfinalisasi...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            const isFinalSaved = await sendPartialData(formAsi.action, formAsi);
            if (isFinalSaved) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Evaluasi kelancaran ASI harian Bunda aman disimpan.', confirmButtonColor: '#2b7cee' })
                    .then(() => { window.location.href = "<?= base_url('laktasi/hasil') ?>"; });
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Sinkronisasi final laporan ASI gagal.' });
            }
        });
    });
</script>
<?= $this->endSection() ?>