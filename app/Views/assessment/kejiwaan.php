<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden">
    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 py-6 px-6 md:px-10 flex-shrink-0">
        <div class="max-w-4xl mx-auto flex items-center gap-4">
            <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100">Evaluasi Ruang Tenang (Kondisi Kejiwaan)</h1>
                <p class="text-xs md:text-sm text-slate-400">Bunda, luangkan waktu sejenak untuk memahami kondisi emosional dan fisik Bunda saat ini.</p>
            </div>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 bg-slate-50/50 dark:bg-slate-900/40">
        <div class="max-w-4xl mx-auto pb-24">
            
            <form id="formKejiwaanIbu" action="<?= base_url('api/save-kejiwaan') ?>" method="POST" class="flex flex-col gap-6 md:gap-8">
                <?= csrf_field() ?>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-amber-50 dark:bg-slate-700 text-amber-500 rounded-xl font-bold text-sm">1</span>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Apakah ibu merasa khawatir yang berlebihan?</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Mencakup kecemasan akan kesehatan diri, bayi, atau hal-hal kecil sehari-hari.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="khawatir_berlebihan" value="Ya" required class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="khawatir_berlebihan" value="Tidak" class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Tidak</div>
                        </label>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                    <div class="flex items-start gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                        <span class="p-2 bg-rose-50 dark:bg-slate-700 text-rose-500 rounded-xl font-bold text-sm">2</span>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Apakah ibu merasakan ketegangan fisik berikut?</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Silakan pilih satu atau beberapa gejala fisik yang Bunda rasakan akhir-akhir ini (Bisa pilih lebih dari satu).</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                        <?php 
                        $gejalaFisik = [
                            'gelisah' => 'Gelisah',
                            'gemetar' => 'Gemetar',
                            'tidak_dapat_rileks' => 'Tidak dapat rileks',
                            'ketegangan_otot' => 'Ketegangan otot',
                            'sakit_kepala' => 'Sakit kepala',
                            'jantung_berdebar' => 'Jantung berdebar',
                            'berkeringat_berlebihan' => 'Berkeringat berlebihan',
                            'sesak_napas' => 'Sesak napas',
                            'kepala_terasa_ringan' => 'Kepala terasa ringan',
                            'nyeri_ulu_hati' => 'Keluhan tidak nyaman di perut (sekitar ulu hati)'
                        ];
                        foreach($gejalaFisik as $key => $label): 
                        ?>
                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/40 border border-slate-200/60 dark:border-slate-700/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-900 transition-colors">
                            <input type="checkbox" name="ketegangan_fisik[]" value="<?= $key ?>" 
                                class="w-5 h-5 rounded-md border-slate-300 dark:border-slate-600 text-primary focus:ring-primary bg-white dark:bg-slate-800 transition-all">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200"><?= $label ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-indigo-50 dark:bg-slate-700 text-indigo-500 rounded-xl font-bold text-sm">3</span>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Apakah ibu merasa lelah berkepanjangan, tapi sulit untuk tidur?</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Kondisi tubuh sangat lelah namun pikiran tetap aktif bekerja dan terjaga.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="lelah_sulit_tidur" value="Ya" required class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="lelah_sulit_tidur" value="Tidak" class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Tidak</div>
                        </label>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-teal-50 dark:bg-slate-700 text-teal-500 rounded-xl font-bold text-sm">4</span>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Apakah ibu mudah tersinggung dan marah?</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Merasa lebih sensitif terhadap respons orang sekitar atau situasi tertentu.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="mudah_tersinggung" value="Ya" required class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="mudah_tersinggung" value="Tidak" class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Tidak</div>
                        </label>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-purple-50 dark:bg-slate-700 text-purple-500 rounded-xl font-bold text-sm">5</span>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">Apakah ibu mengalami perubahan hubungan dengan suami?</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Adanya rasa renggang, berkurangnya komunikasi, atau dinamika baru pasca transisi kehamilan/kelahiran.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="perubahan_hubungan_suami" value="Ya" required class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="perubahan_hubungan_suami" value="Tidak" class="sr-only peer">
                            <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Tidak</div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 items-center">
                    <button type="reset" class="px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Reset
                    </button>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-colors shadow-md shadow-blue-100 dark:shadow-none flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">send</span> Kirim Hasil Assessment
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formKejiwaanIbu");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const loader = document.getElementById("page-loader");
        if (loader) {
            loader.style.display = "flex";
            loader.style.opacity = "1";
        }

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                alert("Terima kasih, Bunda! Data assessment berhasil disimpan.");
                window.location.href = "<?= base_url('dashboard') ?>";
            } else {
                alert("Gagal menyimpan assessment: " + (result.message || "Terjadi masalah di server backend."));
                if (loader) {
                    loader.style.opacity = "0";
                    setTimeout(() => loader.style.display = "none", 200);
                }
            }
        } catch (error) {
            console.error("Error submit assessment kejiwaan:", error);
            alert("Terjadi kendala saat menghubungi server. Periksa kembali jaringan Anda.");
            if (loader) {
                loader.style.opacity = "0";
                setTimeout(() => loader.style.display = "none", 200);
            }
        }
    });
});
</script>
<?= $this->endSection() ?>