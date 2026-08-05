<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md">
                <span class="material-symbols-outlined text-2xl">psychology</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Kondisi Kejiwaan Ibu</h1>
                <p class="text-xs text-slate-600 font-medium">Lengkapi screening emosional (EPDS) dan gejala cemas & fisik secara bertahap</p>
            </div>
        </div>
    </div>

    <div id="scrollContainer" class="flex-1 overflow-y-auto no-scrollbar relative z-10 scroll-smooth animate-slide-up">
        <div class="max-w-4xl mx-auto pb-28">
            
            <!-- Step Progress Indicator -->
            <div class="flex items-center justify-between mb-8 relative px-6 md:px-24">
                <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 rounded-full -z-10"></div>
                <div id="progressLine" class="absolute left-6 top-1/2 -translate-y-1/2 w-[0%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
                
                <div class="flex flex-col items-center gap-1.5 step-indicator cursor-pointer" data-step="1">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-primary text-white transition-colors duration-300 shadow-md flex-shrink-0">1</div>
                    <span class="text-[10px] md:text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors whitespace-nowrap">Screening EPDS</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 step-indicator cursor-pointer" data-step="2">
                    <div class="size-8 rounded-full flex items-center justify-center font-bold text-sm bg-slate-200 text-slate-400 dark:bg-slate-700 transition-colors duration-300 flex-shrink-0">2</div>
                    <span class="text-[10px] md:text-xs font-bold text-slate-400 transition-colors whitespace-nowrap">Gejala Cemas & Fisik</span>
                </div>
            </div>

            <form id="formKejiwaan" action="<?= base_url('api/kondisi-kejiwaan') ?>" method="POST" class="space-y-6 md:space-y-8 relative w-full">
                <?= csrf_field() ?>
                <input type="hidden" name="tgl_pengisian" value="<?= date('Y-m-d') ?>">

                <!-- STEP 1: EPDS FORM -->
                <div id="step-1" class="form-step transition-all duration-500 scale-100 opacity-100 w-full space-y-6">
                    <div class="bg-blue-50/70 dark:bg-slate-800/60 border border-blue-200 dark:border-slate-700 rounded-3xl p-5 md:p-6 text-xs md:text-sm text-slate-700 dark:text-slate-300 leading-relaxed shadow-sm space-y-3">
                        <div class="flex items-center gap-2 font-black text-primary dark:text-blue-400 text-sm md:text-base uppercase tracking-tight">
                            <span class="material-symbols-outlined text-xl">psychology</span>
                            EDINBURGH POSTNATAL DEPRESSION SCALE (EPDS)
                        </div>
                        <p class="font-medium text-slate-700 dark:text-slate-200">
                            <strong>Petunjuk Pengisian:</strong> Lingkari atau pilih jawaban yang paling sesuai dengan perasaan ibu selama 3-7 hari setelah melahirkan.
                        </p>
                        
                        <div class="border-t border-blue-200/80 dark:border-slate-700 pt-3">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-xs block mb-2">Interpretasi Skor EPDS:</span>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="p-3 bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200/80 dark:border-slate-700">
                                    <span class="font-black text-emerald-600 block text-xs">Total Skor 0–9</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-200 text-xs">Normal / adaptasi emosional ringan</span>
                                </div>
                                <div class="p-3 bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200/80 dark:border-slate-700">
                                    <span class="font-black text-amber-600 block text-xs">Total Skor 10–12</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-200 text-xs">Kemungkinan baby blues</span>
                                </div>
                                <div class="p-3 bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200/80 dark:border-slate-700">
                                    <span class="font-black text-rose-600 block text-xs">Total Skor ≥13</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-200 text-xs">Kemungkinan depresi postpartum</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-[11px] text-rose-600 dark:text-rose-400 font-bold leading-relaxed pt-1">
                            * Catatan: Jika skor ≥10 ATAU pertanyaan no. 10 dijawab ya (ada pikiran menyakiti diri) maka memerlukan perhatian dan rujukan segera. Dan lakukan rujukan ke tenaga profesional kesehatan jiwa.
                        </p>
                    </div>

                    <?php
                    $epdsQuestions = [
                        1 => [
                            "q" => "Saya masih dapat tertawa dan melihat hal-hal lucu",
                            "opts" => [
                                3 => "Sama sekali tidak dapat",
                                2 => "Jelas lebih sedikit dari biasanya",
                                1 => "Tidak sebanyak biasanya",
                                0 => "Sama seperti biasanya"
                            ]
                        ],
                        2 => [
                            "q" => "Saya masih menantikan sesuatu dengan perasaan senang",
                            "opts" => [
                                3 => "Hampir tidak sama sekali",
                                2 => "Sangat berkurang",
                                1 => "Sedikit berkurang dari biasanya",
                                0 => "Sama seperti biasanya"
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
                                3 => "Ya, sangat sering",
                                2 => "Ya, kadang-kadang",
                                1 => "Hampir tidak pernah",
                                0 => "Tidak pernah"
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
                </div>

                <!-- STEP 2: SOMATIC ANXIETY FORM -->
                <div id="step-2" class="form-step transition-all duration-500 blur-sm opacity-40 pointer-events-none select-none scale-[0.98] w-full space-y-6">
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
                </div>

                <!-- FIXED NAVIGATION BAR -->
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
                            <span class="material-symbols-outlined text-lg">save</span> Simpan Screening Kejiwaan
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formKejiwaan");
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

        // Map checklist ketegangan fisik checkboxes to individual Yes/No fields
        const checklistItems = [
            'gelisah', 'gemetar', 'tidak_dapat_rileks', 'ketegangan_otot', 
            'sakit_kepala', 'jantung_berdebar', 'berkeringat_berlebihan', 
            'sesak_napas', 'kepala_terasa_ringan', 'keluhan_ulu_hati'
        ];
        
        checklistItems.forEach(item => {
            formData.set(item, 'Tidak');
        });
        
        const checkedBoxes = form.querySelectorAll("input[name='ketegangan_fisik[]']:checked");
        checkedBoxes.forEach(box => {
            const val = box.value;
            if (val === 'nyeri_ulu_hati') {
                formData.set('keluhan_ulu_hati', 'Ya');
            } else {
                formData.set(val, 'Ya');
            }
        });
        formData.delete('ketegangan_fisik[]');

        try {
            const response = await fetch(form.action, {
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
                step.classList.remove("hidden", "blur-sm", "opacity-40", "pointer-events-none", "select-none", "scale-[0.98]");
                step.classList.add("block", "scale-100", "opacity-100");
            } else {
                step.classList.remove("block", "scale-100", "opacity-100");
                step.classList.add("hidden");
            }
        });

        if (currentStep === 1) btnPrev.classList.add("hidden"); else btnPrev.classList.remove("hidden");

        if (currentStep === totalSteps) {
            btnNext.classList.add("hidden"); 
            btnSubmit.classList.remove("hidden");
        } else {
            btnNext.classList.remove("hidden"); 
            btnSubmit.classList.add("hidden");
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

        window.scrollTo({ top: 0, behavior: 'smooth' });
        const scrollContainer = document.getElementById("scrollContainer");
        if (scrollContainer) scrollContainer.scrollTop = 0;
    }

    updateWizard();

    indicators.forEach((indicator) => {
        indicator.addEventListener("click", () => {
            const stepNum = parseInt(indicator.getAttribute("data-step"));
            if (stepNum && stepNum !== currentStep) {
                if (stepNum < currentStep || validateCurrentStep()) {
                    currentStep = stepNum;
                    updateWizard();
                }
            }
        });
    });

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
        if (currentStep > 1) {
            currentStep--; 
            updateWizard();
        }
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
                icon: 'success', title: 'Berhasil Disimpan!', text: 'Seluruh screening kondisi kejiwaan Bunda telah disimpan.', confirmButtonColor: '#162065'
            }).then(() => {
                window.location.href = '<?= base_url('assessment-kejiwaan/hasil') ?>'; 
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal melakukan sinkronisasi final.' });
        }
    });
});
</script>
<?= $this->endSection() ?>