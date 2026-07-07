<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full overflow-hidden">
    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 py-6 px-6 md:px-10 flex-shrink-0 relative overflow-hidden z-20">
        <div class="absolute right-0 top-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="max-w-4xl mx-auto flex items-center gap-4 relative z-10">
            <a href="<?= base_url('dashboard') ?>" class="size-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-slate-100">Evaluasi Ruang Tenang (Kondisi Kejiwaan)</h1>
                <p class="text-xs md:text-sm text-slate-400 mt-1">Bunda, luangkan waktu sejenak untuk memahami kondisi emosional dan fisik Bunda saat ini.</p>
            </div>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto no-scrollbar p-6 md:p-10 bg-slate-50/50 dark:bg-slate-900/40 animate-slide-up">
        <div class="max-w-4xl mx-auto pb-24">
            
            <!-- Tab Switcher -->
            <div class="flex p-1 bg-slate-200/60 dark:bg-slate-800 rounded-2xl max-w-md mx-auto mb-10 shadow-inner border border-slate-200 dark:border-slate-700">
                <button id="tabBtnEpds" class="flex-1 py-3 text-sm font-bold rounded-xl bg-white dark:bg-slate-700 shadow-sm text-primary transition-all">
                    Screening EPDS
                </button>
                <button id="tabBtnKecemasan" class="flex-1 py-3 text-sm font-bold rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all">
                    Gejala Cemas & Fisik
                </button>
            </div>

            <!-- VIEW 1: EPDS FORM -->
            <div id="containerEpds" class="block animate-fade-in">
                <div class="bg-blue-50/50 dark:bg-slate-800/40 border border-blue-100 dark:border-slate-700 rounded-3xl p-5 md:p-6 mb-8 text-sm text-slate-600 dark:text-slate-300 leading-relaxed shadow-sm">
                    <p class="font-bold text-primary mb-1">Petunjuk Pengisian:</p>
                    <p>Pilihlah satu jawaban yang paling mendekati dengan apa yang Bunda rasakan selama <strong>3-7 hari setelah melahirkan</strong>.</p>
                </div>

                <form id="formEpds" action="<?= base_url('api/kondisi-kejiwaan') ?>" method="POST" class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

                    <?php
                    $epdsQuestions = [
                        1 => [
                            "q" => "Saya masih dapat tertawa dan melihat hal-hal lucu",
                            "opts" => [
                                0 => "Sama seperti biasanya",
                                1 => "Tidak sebanyak biasanya",
                                2 => "Jelas lebih sedikit dari biasanya",
                                3 => "Sama sekali tidak dapat"
                            ]
                        ],
                        2 => [
                            "q" => "Saya masih menantikan sesuatu dengan perasaan senang",
                            "opts" => [
                                0 => "Sama seperti biasanya",
                                1 => "Sedikit berkurang dari biasanya",
                                2 => "Sangat berkurang",
                                3 => "Hampir tidak sama sekali"
                            ]
                        ],
                        3 => [
                            "q" => "Saya menyalahkan diri sendiri bila sesuatu berjalan tidak semestinya",
                            "opts" => [
                                3 => "Ya, hampir setiap saat",
                                2 => "Ya, kadang-kadang",
                                1 => "Tidak terlalu sering",
                                0 => "Tidak pernah"
                            ]
                        ],
                        4 => [
                            "q" => "Saya merasa cemas atau khawatir tanpa alasan jelas",
                            "opts" => [
                                0 => "Tidak pernah",
                                1 => "Hampir tidak pernah",
                                2 => "Ya, kadang-kadang",
                                3 => "Ya, sangat sering"
                            ]
                        ],
                        5 => [
                            "q" => "Saya merasa takut atau panik tanpa alasan jelas",
                            "opts" => [
                                3 => "Ya, sangat sering",
                                2 => "Ya, kadang-kadang",
                                1 => "Tidak terlalu sering",
                                0 => "Tidak pernah"
                            ]
                        ],
                        6 => [
                            "q" => "Banyak hal terasa menumpuk sehingga saya sulit mengatasinya",
                            "opts" => [
                                3 => "Ya, hampir tidak mampu mengatasinya",
                                2 => "Ya, kadang sulit mengatasinya",
                                1 => "Kadang terasa berat",
                                0 => "Tidak, saya dapat mengatasinya dengan baik"
                            ]
                        ],
                        7 => [
                            "q" => "Saya merasa sangat tidak bahagia sehingga sulit tidur",
                            "opts" => [
                                3 => "Ya, hampir setiap saat",
                                2 => "Ya, kadang-kadang",
                                1 => "Jarang",
                                0 => "Tidak pernah"
                            ]
                        ],
                        8 => [
                            "q" => "Saya merasa sedih atau sengsara",
                            "opts" => [
                                3 => "Ya, hampir setiap saat",
                                2 => "Ya, cukup sering",
                                1 => "Tidak terlalu sering",
                                0 => "Tidak pernah"
                            ]
                        ],
                        9 => [
                            "q" => "Saya merasa sangat tidak bahagia sehingga menangis",
                            "opts" => [
                                3 => "Ya, hampir setiap saat",
                                2 => "Ya, cukup sering",
                                1 => "Hanya sesekali",
                                0 => "Tidak pernah"
                            ]
                        ],
                        10 => [
                            "q" => "Pikiran untuk menyakiti diri sendiri pernah muncul pada saya",
                            "opts" => [
                                3 => "Ya, cukup sering",
                                2 => "Kadang-kadang",
                                1 => "Hampir tidak pernah",
                                0 => "Tidak pernah"
                            ]
                        ]
                    ];

                    foreach ($epdsQuestions as $num => $item):
                    ?>
                    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-4">
                        <div class="flex items-start gap-3 border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="flex-shrink-0 size-8 rounded-xl bg-blue-50 dark:bg-slate-700 text-primary flex items-center justify-center font-bold text-sm">
                                <?= $num ?>
                            </span>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-sm md:text-base leading-snug mt-1"><?= esc($item['q']) ?></h3>
                        </div>
                        <div class="flex flex-col gap-2 mt-2">
                            <?php foreach ($item['opts'] as $score => $text): ?>
                            <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-700/60 cursor-pointer hover:bg-slate-100/50 dark:hover:bg-slate-900/50 transition-colors">
                                <input type="radio" name="epds_q<?= $num ?>" value="<?= $score ?>" required
                                    class="w-5 h-5 border-slate-300 dark:border-slate-600 text-primary focus:ring-primary bg-white dark:bg-slate-800 transition-all">
                                <span class="text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200"><?= esc($text) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="flex justify-end gap-4 items-center mt-6">
                        <button type="reset" class="px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            Reset
                        </button>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-colors shadow-md shadow-blue-100 dark:shadow-none flex items-center gap-2">
                            <span class="material-symbols-outlined text-xl">send</span> Kirim Screening EPDS
                        </button>
                    </div>
                </form>
            </div>

            <!-- VIEW 2: ORIGINAL SOMATIC ANXIETY FORM -->
            <div id="containerKecemasan" class="hidden animate-fade-in">
                <form id="formKejiwaanIbu" action="<?= base_url('api/kondisi-kejiwaan') ?>" method="POST" class="flex flex-col gap-6 md:gap-8">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

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
                                <input type="radio" name="khawatir_berlebihan" value="Ya" class="sr-only peer">
                                <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="khawatir_berlebihan" value="Tidak" checked class="sr-only peer">
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
                                'keluhan_ulu_hati' => 'Keluhan tidak nyaman di perut (sekitar ulu hati)'
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
                                <input type="radio" name="lelah_sulit_tidur" value="Ya" class="sr-only peer">
                                <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="lelah_sulit_tidur" value="Tidak" checked class="sr-only peer">
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
                                <input type="radio" name="mudah_tersinggung" value="Ya" class="sr-only peer">
                                <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="mudah_tersinggung" value="Tidak" checked class="sr-only peer">
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
                                <input type="radio" name="perubahan_hubungan_suami" value="Ya" class="sr-only peer">
                                <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Ya</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="perubahan_hubungan_suami" value="Tidak" checked class="sr-only peer">
                                <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center font-bold text-sm text-slate-500 peer-checked:border-primary peer-checked:bg-primary-light/40 peer-checked:text-primary transition-all">Tidak</div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 items-center">
                        <button type="reset" class="px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            Reset
                        </button>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-colors shadow-md shadow-blue-100 dark:shadow-none flex items-center gap-2">
                            <span class="material-symbols-outlined text-xl">send</span> Kirim Gejala Cemas & Fisik
                        </button>
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
    // TAB SWITCH LOGIC
    // ==========================================
    const tabBtnEpds = document.getElementById("tabBtnEpds");
    const tabBtnKecemasan = document.getElementById("tabBtnKecemasan");
    const containerEpds = document.getElementById("containerEpds");
    const containerKecemasan = document.getElementById("containerKecemasan");

    tabBtnEpds.addEventListener("click", () => {
        tabBtnEpds.classList.replace("text-slate-500", "text-primary");
        tabBtnEpds.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnEpds.classList.remove("hover:text-slate-700", "dark:text-slate-400");
        
        tabBtnKecemasan.classList.replace("text-primary", "text-slate-500");
        tabBtnKecemasan.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnKecemasan.classList.add("hover:text-slate-700", "dark:text-slate-400");
        
        containerEpds.classList.replace("hidden", "block");
        containerKecemasan.classList.replace("block", "hidden");
    });

    tabBtnKecemasan.addEventListener("click", () => {
        tabBtnKecemasan.classList.replace("text-slate-500", "text-primary");
        tabBtnKecemasan.classList.add("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnKecemasan.classList.remove("hover:text-slate-700", "dark:text-slate-400");
        
        tabBtnEpds.classList.replace("text-primary", "text-slate-500");
        tabBtnEpds.classList.remove("bg-white", "shadow-sm", "dark:bg-slate-700");
        tabBtnEpds.classList.add("hover:text-slate-700", "dark:text-slate-400");
        
        containerKecemasan.classList.replace("hidden", "block");
        containerEpds.classList.replace("block", "hidden");
    });

    // ==========================================
    // SUBMIT ACTIONS WITH SWEETALERT2
    // ==========================================
    const submitForm = async (formElement, redirectUrl) => {
        const loader = document.getElementById("page-loader");
        if (loader) {
            loader.style.display = "flex";
            loader.style.opacity = "1";
        }

        const formData = new FormData(formElement);

        // Map checklist ketegangan fisik checkboxes to individual Yes/No fields
        if (formElement.id === "formKejiwaanIbu") {
            const checklistItems = [
                'gelisah', 'gemetar', 'tidak_dapat_rileks', 'ketegangan_otot', 
                'sakit_kepala', 'jantung_berdebar', 'berkeringat_berlebihan', 
                'sesak_napas', 'kepala_terasa_ringan', 'keluhan_ulu_hati'
            ];
            
            // Set all checklist items default to Tidak
            checklistItems.forEach(item => {
                formData.set(item, 'Tidak');
            });
            
            // Set checked items to Ya
            const checkedBoxes = formElement.querySelectorAll("input[name='ketegangan_fisik[]']:checked");
            checkedBoxes.forEach(box => {
                const val = box.value;
                if (val === 'nyeri_ulu_hati') {
                    formData.set('keluhan_ulu_hati', 'Ya');
                } else {
                    formData.set(val, 'Ya');
                }
            });
            
            formData.delete('ketegangan_fisik[]');
        }

        try {
            const response = await fetch(formElement.action, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Screening kejiwaan Bunda berhasil disimpan.',
                    confirmButtonColor: '#2b7cee'
                }).then(() => {
                    window.location.href = redirectUrl;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message || 'Terjadi masalah di server backend.'
                });
                if (loader) {
                    loader.style.opacity = "0";
                    setTimeout(() => loader.style.display = "none", 200);
                }
            }
        } catch (error) {
            console.error("Error submit screening:", error);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Gagal',
                text: 'Terjadi kendala saat menghubungi server. Periksa kembali jaringan Anda.'
            });
            if (loader) {
                loader.style.opacity = "0";
                setTimeout(() => loader.style.display = "none", 200);
            }
        }
    };

    document.getElementById("formEpds").addEventListener("submit", function(e) {
        e.preventDefault();
        submitForm(this, "<?= base_url('assessment-kejiwaan/hasil') ?>");
    });

    document.getElementById("formKejiwaanIbu").addEventListener("submit", function(e) {
        e.preventDefault();
        submitForm(this, "<?= base_url('assessment-kejiwaan/hasil') ?>");
    });
});
</script>
<?= $this->endSection() ?>