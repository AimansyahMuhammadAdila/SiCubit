<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md">
                <span class="material-symbols-outlined text-2xl">quiz</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">FAQ Laktasi & Menyusui</h1>
                <p class="text-xs text-slate-600 font-medium">Temukan jawaban cepat untuk keluhan dan kebingungan seputar ASI</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-10 pb-24">
        <div class="max-w-4xl mx-auto pb-24 space-y-4">

            <?php 
            $faqs = [
                [
                    "q" => "Bayi saya kok menyusu terus ya, tiap sebentar minta lagi. ASI saya kurang ya?",
                    "a" => "Tenang ya, Bu. Itu normal sekali, apalagi di awal kehidupan. Bayi memang bisa menyusu 8–12 kali sehari atau lebih. Justru semakin sering menyusu, ASI ibu akan semakin banyak.<br><br>👉 <strong>Jadi, bukan karena ASI kurang, tapi bayi sedang “memesan” ASI lebih banyak.</strong>"
                ],
                [
                    "q" => "Saya bingung, bayi saya pipisnya berapa kali sih yang normal?",
                    "a" => "Kalau bayi cukup ASI, biasanya:<br>• Pipis 6–8 kali atau lebih per hari<br>• Urin jernih/tidak pekat<br><br>👉 <strong>Ini tanda sederhana bahwa ASI ibu cukup 👍</strong>"
                ],
                [
                    "q" => "Kalau BAB bayi gimana ya, normalnya berapa kali?",
                    "a" => "Bayi ASI bisa BAB:<br>• Sering (3–5 kali/hari) di awal<br>• Atau kadang jarang (beberapa hari sekali) setelah usia >1 bulan<br><br>👉 <strong>Selama bayi tidak rewel dan fesesnya lembek, itu masih normal.</strong>"
                ],
                [
                    "q" => "Bayi saya sering menangis, apakah dia lapar terus?",
                    "a" => "Belum tentu, Bu 😊<br>Bayi menangis bisa karena:<br>• Lapar<br>• Ingin digendong<br>• Popok basah<br>• Butuh kenyamanan<br><br>👉 <strong>Coba lihat tanda lapar dulu (mengisap jari, mencari puting), jangan langsung panik.</strong>"
                ],
                [
                    "q" => "Bagaimana saya tahu bayi saya benar-benar cukup ASI?",
                    "a" => "Perhatikan ini ya:<br>• Pipis ≥6 kali/hari<br>• Bayi terlihat puas setelah menyusu<br>• Berat badan naik<br><br>👉 <strong>Kalau ini terpenuhi, insyaAllah ASI ibu cukup 💕</strong>"
                ],
                [
                    "q" => "Berat badan bayi saya naiknya sedikit, itu normal nggak?",
                    "a" => "Di awal, bayi memang bisa turun berat badan sedikit, lalu akan naik lagi.<br>Normalnya:<br>• Mulai naik setelah minggu pertama<br>• Bertambah sesuai usia<br><br>👉 <strong>Yang penting dipantau rutin di posyandu ya, Bu.</strong>"
                ],
                [
                    "q" => "Puting saya sakit sekali saat menyusui, kenapa ya?",
                    "a" => "Biasanya karena posisi atau pelekatan belum pas.<br>Ciri yang benar:<br>• Mulut bayi terbuka lebar<br>• Tidak hanya puting, tapi areola juga masuk<br><br>👉 <strong>Menyusui seharusnya tidak sakit, Bu.</strong>"
                ],
                [
                    "q" => "Bayi saya seperti hanya mengisap, tapi tidak menelan. Itu kenapa?",
                    "a" => "Bisa jadi pelekatan belum optimal.<br>Coba perhatikan:<br>• Ada suara menelan atau tidak<br>• Dagu bayi menempel ke payudara<br><br>👉 <strong>Kalau belum, bisa diperbaiki posisinya ya.</strong>"
                ],
                [
                    "q" => "Saya merasa ASI saya tidak keluar banyak, padahal bayi menyusu lama.",
                    "a" => "Kadang ASI sebenarnya ada, tapi alirannya kurang lancar karena:<br>• Ibu lelah atau stres<br>• Kurang rileks<br><br>👉 <strong>Coba tarik napas, rileks, atau minta suami bantu pijat oksitosin 💆‍♀️</strong>"
                ],
                [
                    "q" => "Saya capek dan stres, rasanya ingin berhenti menyusui…",
                    "a" => "Perasaan itu sangat wajar, Bu 🤍 Menyusui itu butuh energi dan emosi.<br>👉 <strong>Ibu tidak sendiri.</strong><br><br>Coba:<br>• Minta bantuan suami/keluarga<br>• Istirahat saat bayi tidur<br>• Cerita ke tenaga kesehatan"
                ],
                [
                    "q" => "Bayi saya tertidur saat menyusu, itu normal?",
                    "a" => "Normal, apalagi bayi baru lahir 😊<br>Tapi pastikan:<br>• Bayi menyusu cukup lama<br>• Ada tanda menelan<br><br>👉 <strong>Jika sering tertidur cepat, bisa dibangunkan perlahan.</strong>"
                ],
                [
                    "q" => "Apakah saya harus menjadwalkan menyusui?",
                    "a" => "Tidak perlu, Bu.<br>Menyusui sebaiknya sesuai keinginan bayi (on demand).<br><br>👉 <strong>Semakin sering bayi menyusu, semakin lancar ASI.</strong>"
                ],
                [
                    "q" => "Kalau payudara terasa kosong, apa ASI sudah habis?",
                    "a" => "Tidak ya 😊<br><br>Payudara yang lembek justru tanda tubuh sudah menyesuaikan produksi ASI."
                ],
                [
                    "q" => "Bayi saya rewel di malam hari, apakah ASI saya kurang?",
                    "a" => "Belum tentu, Bu.<br>Bayi memang sering lebih aktif malam hari.<br><br>👉 Bisa karena:<br>• Ingin dekat dengan ibu<br>• Pola tidur belum teratur"
                ],
                [
                    "q" => "Apa yang paling penting supaya ASI lancar?",
                    "a" => "Yang utama:<br>• Susui sesering mungkin<br>• Posisi & pelekatan benar<br>• Ibu tenang dan percaya diri<br><br>👉 <strong>Kunci utama: sering disusui + ibu rileks 💕</strong>"
                ]
            ];
            ?>

            <?php foreach ($faqs as $index => $item): ?>
            <details class="group bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/60 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-5 md:p-6 text-slate-700 dark:text-slate-200 focus:outline-none">
                    <div class="flex gap-4 items-start md:items-center">
                        <span class="flex-shrink-0 size-8 md:size-10 rounded-xl bg-blue-50 dark:bg-slate-700 text-primary flex items-center justify-center font-black text-sm md:text-base">
                            Q<?= $index + 1 ?>
                        </span>
                        <span class="text-sm md:text-base leading-snug pt-1 md:pt-0"><?= $item['q'] ?></span>
                    </div>
                    <span class="transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-4 text-slate-400">
                        <span class="material-symbols-outlined">expand_more</span>
                    </span>
                </summary>
                
                <div class="px-5 md:px-6 pb-6 pt-2 ml-12 md:ml-14 text-sm md:text-base text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-700/50 mt-2">
                    <div class="pt-4">
                        <?= $item['a'] ?>
                    </div>
                </div>
            </details>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const faqDetails = document.querySelectorAll("details");
    
    faqDetails.forEach((el) => {
        const summary = el.querySelector("summary");
        
        summary.addEventListener("click", (e) => {
            e.preventDefault();
            
            if (el.open) {
                el.style.overflow = "hidden";
                const startHeight = el.offsetHeight;
                const endHeight = summary.offsetHeight;
                
                const animation = el.animate([
                    { height: `${startHeight}px` },
                    { height: `${endHeight}px` }
                ], {
                    duration: 250,
                    easing: "ease-out"
                });
                
                animation.onfinish = () => {
                    el.open = false;
                    el.style.height = "";
                    el.style.overflow = "";
                };
            } else {
                // Close other open details for accordion effect (optional, let's do it for premium feel!)
                faqDetails.forEach((other) => {
                    if (other !== el && other.open) {
                        other.style.overflow = "hidden";
                        const otherStart = other.offsetHeight;
                        const otherSummary = other.querySelector("summary");
                        const otherEnd = otherSummary.offsetHeight;
                        
                        const otherAnim = other.animate([
                            { height: `${otherStart}px` },
                            { height: `${otherEnd}px` }
                        ], {
                            duration: 250,
                            easing: "ease-out"
                        });
                        
                        otherAnim.onfinish = () => {
                            other.open = false;
                            other.style.height = "";
                            other.style.overflow = "";
                        };
                    }
                });

                el.open = true;
                el.style.overflow = "hidden";
                const endHeight = el.offsetHeight;
                
                el.open = false;
                const startHeight = el.offsetHeight;
                
                el.open = true;
                
                const animation = el.animate([
                    { height: `${startHeight}px` },
                    { height: `${endHeight}px` }
                ], {
                    duration: 250,
                    easing: "ease-out"
                });
                
                animation.onfinish = () => {
                    el.style.height = "";
                    el.style.overflow = "";
                };
            }
        });
    });
});
</script>

<?= $this->endSection() ?>