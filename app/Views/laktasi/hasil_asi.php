<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md">
                <span class="material-symbols-outlined text-2xl">water_drop</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Hasil Evaluasi Kelancaran ASI</h1>
                <p class="text-xs text-slate-600 font-medium">Rangkuman pemantauan kuantitatif dan kualitatif kecukupan ASI harian Bunda</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-10 animate-slide-up">
        <div class="max-w-4xl mx-auto pb-24 space-y-6">

            <?php if (empty($latest)): ?>
                <!-- DATA EMPTY STATE -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 text-center border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col items-center justify-center min-h-[300px]">
                    <div class="size-20 rounded-full bg-blue-50 dark:bg-slate-700/50 text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-4xl">water_drop</span>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1">Belum Ada Data Evaluasi ASI</h3>
                    <p class="text-sm text-slate-400 max-w-sm mb-6">Bunda belum pernah mengisi evaluasi kelancaran ASI sebelumnya.</p>
                    <a href="<?= base_url('laktasi/cek') ?>" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white text-sm font-bold rounded-xl shadow-md transition-all">
                        Mulai Evaluasi Sekarang
                    </a>
                </div>
            <?php else: ?>
                
                <?php
                // Parse dynamic variables
                $isCukup = ($latest['status_kecukupan_asi'] === 'Ya');
                
                // Calculate age and pumping target
                $umurBayiHari = null;
                $kategoriUmur = 'Tidak diketahui';
                $targetPumping = 'N/A';
                $pumpingStatus = 'Sesuai';
                
                if (!empty($persalinan)) {
                    $tglLahir = new \DateTime($persalinan['tgl_pengisian']);
                    $tglCek = new \DateTime($latest['tgl_pengisian']);
                    $diff = $tglLahir->diff($tglCek);
                    $umurBayiHari = $diff->days;
                    
                    if ($umurBayiHari <= 3) {
                        $kategoriUmur = '0-3 Hari';
                        $targetPumping = '5 - 20 ml';
                        $pumpingStatus = ($latest['volume_pumping'] >= 5) ? 'Sesuai' : 'Kurang';
                    } elseif ($umurBayiHari <= 7) {
                        $kategoriUmur = 'Minggu Pertama (4-7 Hari)';
                        $targetPumping = '30 - 60 ml';
                        $pumpingStatus = ($latest['volume_pumping'] >= 30) ? 'Sesuai' : 'Kurang';
                    } else {
                        $kategoriUmur = '2 Minggu / Lebih (>= 8 Hari)';
                        $targetPumping = '60 - 120 ml';
                        $pumpingStatus = ($latest['volume_pumping'] >= 60) ? 'Sesuai' : 'Kurang';
                    }
                } else {
                    // Fallback using pumping value
                    $vp = $latest['volume_pumping'];
                    if ($vp >= 60) {
                        $kategoriUmur = '2 Minggu / Lebih (Estimasi)';
                        $targetPumping = '60 - 120 ml';
                        $pumpingStatus = 'Sesuai';
                    } elseif ($vp >= 30) {
                        $kategoriUmur = 'Minggu Pertama (Estimasi)';
                        $targetPumping = '30 - 60 ml';
                        $pumpingStatus = 'Sesuai';
                    } else {
                        $kategoriUmur = '0-3 Hari (Estimasi)';
                        $targetPumping = '5 - 20 ml';
                        $pumpingStatus = ($vp >= 5) ? 'Sesuai' : 'Kurang';
                    }
                }

                // Check positive/negative for each of the 10 points
                // 1) Frekuensi menyusui: 8-12 kali
                $freqMenyusuiVal = (int)$latest['frekuensi_menyusui'];
                $freqMenyusuiOk = ($freqMenyusuiVal >= 8); // positive if >= 8

                // 2) Lama menyusui: 5-10 Menit
                $lamaMenyusuiVal = (int)$latest['lama_menyusui'];
                $lamaMenyusuiOk = ($lamaMenyusuiVal >= 5); // positive if >= 5

                // 3) Frekuensi BAB bayi: 3-5 kali
                $babVal = (int)$latest['frekuensi_bab_bayi'];
                $babOk = ($babVal >= 3); // positive if >= 3

                // 4) Frekuensi BAK bayi: 6-8 kali
                $bakVal = (int)$latest['frekuensi_bak_bayi'];
                $bakOk = ($bakVal >= 6); // positive if >= 6

                // 5) Bayi tidur minimal 12 jam
                $tidurOk = ($latest['bayi_tidur_12jam'] === 'Ya');

                // 6) Bayi tenang & tampak puas 2-3 jam
                $tenangOk = ($latest['bayi_tenang_setelah_menyusu'] === 'Ya');

                // 7) Warna urine jernih/tidak pekat
                $urinOk = in_array($latest['warna_urin_bayi'], ['Jernih', 'Kuning Muda']);

                // 8) Payudara penuh & merembes
                $payudaraOk = ($latest['payudara_penuh'] === 'Ya');

                // 9) Berat badan naik sesuai usia
                $bbNaikOk = ($latest['bb_naik_sesuai_usia'] === 'Ya');

                // 10) Jika dipumping
                $pumpingOk = ($pumpingStatus === 'Sesuai');

                // Card background and badge styles
                $statusColorClass = $isCukup ? 'text-primary dark:text-primary-light bg-blue-50 dark:bg-slate-800/80 border-blue-100 dark:border-slate-700' : 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/20 border-rose-200 dark:border-rose-800';
                $statusBadgeClass = $isCukup ? 'bg-primary text-white' : 'bg-rose-500 text-white';
                $statusText = $isCukup ? 'Kebutuhan ASI Terpenuhi' : 'Perhatian: ASI Kurang Lancar';
                ?>

                <!-- HEADER CARD -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/80 shadow-sm p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-start gap-4">
                        <div class="size-16 rounded-2xl bg-blue-50 dark:bg-slate-700 text-primary flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-3xl font-variation-fill">water_drop</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Kecukupan Laktasi Harian</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 dark:bg-slate-700/30 px-2 py-0.5 rounded border border-slate-100 dark:border-slate-600">Terakhir</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">Tanggal Pengisian: <?= date('d M Y', strtotime($latest['tgl_pengisian'])) ?></p>
                            
                            <div class="flex items-center gap-3 mt-4">
                                <div class="px-4 py-1.5 rounded-full text-xs font-bold <?= $statusBadgeClass ?> shadow-sm">
                                    <?= $statusText ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('laktasi/cek') ?>" class="w-full md:w-auto px-5 py-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-primary hover:text-white transition-all text-center font-bold text-xs md:text-sm text-slate-600 dark:text-slate-300">
                        Evaluasi Baru
                    </a>
                </div>

                <!-- MOTIVASI KELANCARAN ASI -->
                <div class="rounded-3xl border p-6 md:p-8 flex items-start gap-4 <?= $statusColorClass ?>">
                    <div class="size-12 rounded-2xl bg-white dark:bg-slate-800/80 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="material-symbols-outlined text-2xl font-variation-fill">favorite</span>
                    </div>
                    <div class="flex-1 space-y-1">
                        <h4 class="font-bold text-base">Pesan & Motivasi untuk Bunda:</h4>
                        <p class="text-sm leading-relaxed">
                            <?php if ($isCukup): ?>
                                Bunda luar biasa! Produksi ASI Bunda saat ini terpenuhi dan mencukupi kebutuhan tumbuh kembang si kecil. Tetap susui si kecil sesering mungkin secara on-demand, pertahankan pikiran yang tenang, konsumsi gizi seimbang, dan istirahat yang cukup untuk menjaga kestabilan aliran ASI Bunda.
                            <?php else: ?>
                                Bunda hebat! Jangan berkecil hati ya. Produksi ASI yang kurang lancar adalah hal yang wajar dan sering dialami ibu menyusui. Tetaplah susui si kecil sesering mungkin agar merangsang hormon prolaktin, mintalah suami membantu pijat oksitosin di punggung untuk memicu hormon oksitosin, serta pastikan Bunda tetap rileks dan terhidrasi dengan minum air minimal 3 liter sehari.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <!-- DETAILED PARAMETER EVALUATION -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 md:p-8 space-y-6">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">verified</span>
                        Analisis 10 Parameter Kelancaran ASI
                    </h3>

                    <div class="space-y-4">
                        <?php
                        $parameters = [
                            [
                                "title" => "1. Frekuensi Menyusui",
                                "target" => "Target: 8 - 12 kali / hari",
                                "value" => "Input Bunda: " . $freqMenyusuiVal . " kali / hari",
                                "ok" => $freqMenyusuiOk
                            ],
                            [
                                "title" => "2. Durasi / Lama Menyusui",
                                "target" => "Target: 5 - 10 menit / sesi",
                                "value" => "Input Bunda: " . $lamaMenyusuiVal . " menit / sesi",
                                "ok" => $lamaMenyusuiOk
                            ],
                            [
                                "title" => "3. Frekuensi BAB Bayi",
                                "target" => "Target: 3 - 5 kali / hari",
                                "value" => "Input Bunda: " . $babVal . " kali / hari",
                                "ok" => $babOk
                            ],
                            [
                                "title" => "4. Frekuensi BAK Bayi",
                                "target" => "Target: 6 - 8 kali / hari",
                                "value" => "Input Bunda: " . $bakVal . " kali / hari",
                                "ok" => $bakOk
                            ],
                            [
                                "title" => "5. Pola Tidur Bayi",
                                "target" => "Target: Minimal tidur 12 jam / hari",
                                "value" => "Input Bunda: " . ($latest['bayi_tidur_12jam'] === 'Ya' ? 'Ya, minimal 12 jam' : 'Tidak'),
                                "ok" => $tidurOk
                            ],
                            [
                                "title" => "6. Kepuasan Bayi",
                                "target" => "Target: Tenang & tampak puas 2-3 jam setelah menyusu",
                                "value" => "Input Bunda: " . ($latest['bayi_tenang_setelah_menyusu'] === 'Ya' ? 'Ya, tenang & puas' : 'Tidak'),
                                "ok" => $tenangOk
                            ],
                            [
                                "title" => "7. Warna Urine Bayi",
                                "target" => "Target: Kuning pucat / jernih / tidak pekat",
                                "value" => "Input Bunda: " . esc($latest['warna_urin_bayi']),
                                "ok" => $urinOk
                            ],
                            [
                                "title" => "8. Kondisi Payudara Ibu",
                                "target" => "Target: Terasa penuh & merembes sebelum menyusui",
                                "value" => "Input Bunda: " . ($latest['payudara_penuh'] === 'Ya' ? 'Ya, penuh & merembes' : 'Tidak'),
                                "ok" => $payudaraOk
                            ],
                            [
                                "title" => "9. Kenaikan Berat Badan Bayi",
                                "target" => "Target: Naik sesuai rentang usia tumbuh kembang",
                                "value" => "Input Bunda: " . ($latest['bb_naik_sesuai_usia'] === 'Ya' ? 'Ya, berat badan naik sesuai usia' : 'Tidak'),
                                "ok" => $bbNaikOk
                            ],
                            [
                                "title" => "10. Hasil Pumping Laktasi",
                                "target" => "Target Kategori " . $kategoriUmur . ": " . $targetPumping . " / sesi",
                                "value" => "Input Bunda: " . (float)$latest['volume_pumping'] . " ml / sesi",
                                "ok" => $pumpingOk
                            ]
                        ];

                        foreach ($parameters as $param):
                            $badgeColor = $param['ok'] ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-950/30 dark:text-rose-400';
                            $statusSymbol = $param['ok'] ? 'check_circle' : 'cancel';
                            $statusLabel = $param['ok'] ? 'Terpenuhi (Sesuai)' : 'Kurang (Perlu Perhatian)';
                        ?>
                        <div class="p-4 rounded-2xl border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm md:text-base"><?= esc($param['title']) ?></h4>
                                <div class="flex flex-col gap-0.5 mt-1 text-xs text-slate-400 font-medium">
                                    <p><?= esc($param['target']) ?></p>
                                    <p class="text-slate-500 dark:text-slate-300"><?= esc($param['value']) ?></p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold <?= $badgeColor ?>">
                                <span class="material-symbols-outlined text-sm font-variation-fill"><?= $statusSymbol ?></span>
                                <?= $statusLabel ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
