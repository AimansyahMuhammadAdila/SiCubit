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
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Hasil Screening Kejiwaan</h1>
                <p class="text-xs text-slate-600 font-medium">Informasi kondisi emosional & mental (EPDS) serta saran rujukan Bunda</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-10 animate-slide-up">
        <div class="max-w-4xl mx-auto pb-24 space-y-6">

            <?php if (empty($latest)): ?>
                <!-- DATA EMPTY STATE -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 text-center border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col items-center justify-center min-h-[300px]">
                    <div class="size-20 rounded-full bg-blue-50 dark:bg-slate-700/50 text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-4xl">psychology</span>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1">Belum Ada Data Screening</h3>
                    <p class="text-sm text-slate-400 max-w-sm mb-6">Bunda belum pernah melakukan screening kondisi kejiwaan atau EPDS sebelumnya.</p>
                    <a href="<?= base_url('assessment-kejiwaan') ?>" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white text-sm font-bold rounded-xl shadow-md transition-all">
                        Mulai Screening Sekarang
                    </a>
                </div>
            <?php else: ?>
                
                <?php
                // EPDS variables
                $hasEpds = isset($latest['epds_skor']);
                $epdsSkor = (int)($latest['epds_skor'] ?? 0);
                $epdsQ10 = (int)($latest['epds_q10'] ?? 0);

                // EPDS classification rule
                if ($epdsSkor <= 9) {
                    $epdsStatus = 'Normal / adaptasi emosional ringan';
                } elseif ($epdsSkor <= 12) {
                    $epdsStatus = 'Kemungkinan baby blues';
                } else {
                    $epdsStatus = 'Kemungkinan depresi postpartum';
                }

                // Somatic variables
                $somaticSkor = $latest['skor_kejiwaan'] ?? 0;
                $somaticStatus = $latest['status_kejiwaan'] ?? 'Normal';

                // EPDS styling determination
                $epdsColorClass = 'text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950/20 border-green-200 dark:border-green-800';
                $epdsBadgeColor = 'bg-green-500 text-white';
                
                if ($epdsSkor >= 13) {
                    $epdsColorClass = 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/20 border-rose-200 dark:border-rose-800';
                    $epdsBadgeColor = 'bg-rose-500 text-white';
                } elseif ($epdsSkor >= 10) {
                    $epdsColorClass = 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800';
                    $epdsBadgeColor = 'bg-amber-500 text-white';
                }

                // Referral rule: Score >= 10 OR Question #10 answered yes (> 0)
                $requiresReferral = ($epdsSkor >= 10 || $epdsQ10 > 0);
                ?>

                <!-- RESULT EPDS HEADER CARD -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/80 shadow-sm p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-start gap-4">
                        <div class="size-16 rounded-2xl bg-indigo-50 dark:bg-slate-700 text-indigo-500 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-3xl font-variation-fill">psychology</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Edinburgh Postnatal Depression Scale (EPDS)</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 dark:bg-slate-700/30 px-2 py-0.5 rounded border border-slate-100 dark:border-slate-600">Terakhir</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">Tanggal Pengisian: <?= date('d M Y', strtotime($latest['tgl_pengisian'])) ?></p>
                            
                            <div class="flex items-center gap-3 mt-4">
                                <div class="px-4 py-1.5 rounded-full text-xs font-bold <?= $epdsBadgeColor ?> shadow-sm">
                                    Skor EPDS: <?= $epdsSkor ?>
                                </div>
                                <span class="text-sm font-semibold text-slate-600 dark:text-slate-300"><?= esc($epdsStatus) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('assessment-kejiwaan') ?>" class="w-full md:w-auto px-5 py-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-primary hover:text-white transition-all text-center font-bold text-xs md:text-sm text-slate-600 dark:text-slate-300">
                        Screening Baru
                    </a>
                </div>

                <!-- ALERTS / MOTIVATIONAL BOXES -->
                <?php if ($requiresReferral): ?>
                    <!-- URGENT ATTENTION WARNING -->
                    <div class="bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-800 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-start gap-4">
                        <div class="size-12 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0 animate-pulse">
                            <span class="material-symbols-outlined text-2xl font-variation-fill">warning</span>
                        </div>
                        <div class="flex-1 space-y-2">
                            <h4 class="font-bold text-rose-800 dark:text-rose-400 text-base">Memerlukan Perhatian dan Rujukan Segera</h4>
                            <p class="text-sm text-rose-700 dark:text-rose-300/90 leading-relaxed">
                                Bunda terindikasi mengalami <strong><?= esc($epdsStatus) ?></strong> (Total Skor: <?= $epdsSkor ?>). 
                                <?php if ($epdsQ10 > 0): ?>
                                    Bunda juga menjawab ada pikiran untuk menyakiti diri sendiri (Pertanyaan No. 10). 
                                <?php endif; ?>
                                Mohon untuk segera melakukan rujukan ke tenaga profesional kesehatan jiwa (Dokter, Psikolog, atau Psikiater) atau ke fasilitas kesehatan terdekat (Puskesmas / Rumah Sakit).
                            </p>
                            <div class="pt-2">
                                <a href="https://wa.me/628118065432" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-200 dark:shadow-none transition-colors">
                                    <span class="material-symbols-outlined text-sm font-variation-fill">phone_in_talk</span> Hubungi Call Center Kesehatan Jiwa
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- NORMAL ADAPTATION MOTIVATION -->
                    <div class="bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800 rounded-3xl p-6 md:p-8 flex items-start gap-4">
                        <div class="size-12 rounded-2xl bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-2xl font-variation-fill">sentiment_satisfied</span>
                        </div>
                        <div class="flex-1 space-y-1">
                            <h4 class="font-bold text-green-800 dark:text-green-400 text-base">Bunda Hebat! Tetap Rileks Ya</h4>
                            <p class="text-sm text-green-700 dark:text-green-300/90 leading-relaxed">
                                Hasil screening menunjukkan kondisi emosional Bunda tergolong normal dan merupakan adaptasi emosional ringan yang wajar pasca melahirkan. 
                                Tetap luangkan waktu untuk beristirahat di kala si kecil tidur, konsumsi makanan bergizi, dan komunikasikan perasaan Bunda dengan suami tercinta.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- BREAKDOWN OF EPDS QUESTIONS -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-4">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        Detail Jawaban EPDS
                    </h3>
                    
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/60 text-xs md:text-sm space-y-3">
                        <?php
                        $epdsLabels = [
                            1 => "1. Masih dapat tertawa dan melihat hal-hal lucu",
                            2 => "2. Masih menantikan sesuatu dengan perasaan senang",
                            3 => "3. Menyalahkan diri sendiri saat terjadi kesalahan",
                            4 => "4. Merasa cemas atau khawatir tanpa alasan",
                            5 => "5. Merasa takut atau panik tanpa alasan",
                            6 => "6. Kewalahan mengatasi hal-hari menumpuk",
                            7 => "7. Sangat tidak bahagia sehingga sulit tidur",
                            8 => "8. Merasa sedih atau sengsara",
                            9 => "9. Sangat tidak bahagia sehingga menangis",
                            10 => "10. Muncul pikiran menyakiti diri sendiri"
                        ];

                        foreach ($epdsLabels as $n => $label):
                            $val = $latest["epds_q$n"] ?? 0;
                            // Check if question 10 has self harm risk
                            $isRiskQ10 = ($n === 10 && $val > 0);
                            $textColor = $isRiskQ10 ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-slate-700 dark:text-slate-300';
                            $scoreBg = $val >= 2 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-300';
                            if ($isRiskQ10) {
                                $scoreBg = 'bg-rose-500 text-white animate-pulse';
                            }
                        ?>
                        <div class="flex justify-between items-center py-2 gap-4">
                            <span class="<?= $textColor ?>"><?= esc($label) ?></span>
                            <span class="text-xs font-bold px-2 py-1 rounded <?= $scoreBg ?>">Skor: <?= $val ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- SOMATIC CHECKLIST RESULT CARD -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-teal-500">physical_therapy</span>
                        Screening Gejala Cemas & Fisik (Somatik)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/40 border border-slate-200/60 dark:border-slate-700/60">
                            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Status Kecemasan</div>
                            <div class="text-lg font-bold text-slate-800 dark:text-slate-200"><?= esc($somaticStatus) ?></div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-900/40 border border-slate-200/60 dark:border-slate-700/60">
                            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Total Gejala Fisik</div>
                            <div class="text-lg font-bold text-slate-800 dark:text-slate-200"><?= $somaticSkor ?> / 14 Gejala</div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
