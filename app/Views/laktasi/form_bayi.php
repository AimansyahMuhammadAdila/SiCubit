<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-full w-full">

    <div class="mb-4">
        <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 text-[#162065] font-extrabold text-xs shadow-sm hover:bg-white transition mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
        </a>
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-2xl bg-[#162065] text-white flex items-center justify-center font-bold shadow-md">
                <span class="material-symbols-outlined text-2xl">child_care</span>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-black text-[#162065] tracking-tight">Pembaruan Data Bayi</h1>
                <p class="text-xs text-slate-600 font-medium">Lengkapi dimensi fisik & respons refleks tumbuh kembang si kecil</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto no-scrollbar relative z-10 pb-24">
        <div class="max-w-4xl mx-auto pb-24">
            
           <form id="formUpdateDataBayi" action="<?= base_url('api/data-bayi') ?>" method="POST" class="flex flex-col gap-6 md:gap-8">
                <?= csrf_field() ?> <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                        <span class="material-symbols-outlined text-primary text-2xl font-variation-fill">child_care</span>
                        <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Identitas & Dimensi Fisik</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label for="nama_bayi" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Data / Nama Bayi Terlahir</label>
                            <input type="text" id="nama_bayi" name="nama_bayi" required placeholder="Contoh: Muhammad Akhdan / Bayi Kembar 1"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="golongan_darah" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Golongan Darah</label>
                            <div class="relative">
                                <select id="golongan_darah" name="golongan_darah" required
                                    class="w-full appearance-none px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="Belum Tahu">Belum Tahu</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="suhu_bayi" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Suhu Tubuh Bayi</label>
                            <div class="relative">
                                <input type="number" id="suhu_bayi" name="suhu_bayi" step="0.1" min="30" max="45" required placeholder="36.5"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">°C</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="berat_badan" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Berat Badan</label>
                            <div class="relative">
                                <input type="number" id="berat_badan" name="berat_badan" min="0" required placeholder="3200"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">gram</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="panjang_badan" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Panjang Badan</label>
                            <div class="relative">
                                <input type="number" id="panjang_badan" name="panjang_badan" min="0" step="0.1" required placeholder="49.5"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="lingkar_kepala" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lingkar Kepala</label>
                            <div class="relative">
                                <input type="number" id="lingkar_kepala" name="lingkar_kepala" min="0" step="0.1" required placeholder="34"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="lingkar_dada" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lingkar Dada</label>
                            <div class="relative">
                                <input type="number" id="lingkar_dada" name="lingkar_dada" min="0" step="0.1" required placeholder="33"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label for="lingkar_lengan" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lingkar Lengan Atas (LiLA)</label>
                            <div class="relative">
                                <input type="number" id="lingkar_lengan" name="lingkar_lengan" min="0" step="0.1" required placeholder="11"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:border-primary dark:focus:border-primary transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">cm</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-700/80 flex flex-col gap-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                        <span class="material-symbols-outlined text-rose-500 text-2xl font-variation-fill">pulse</span>
                        <h2 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg">Refleks Primitif Bayi</h2>
                    </div>

                    <p class="text-xs text-slate-400 -mt-2">Amati respon alami bayi Anda dan pilih kondisi yang paling sesuai.</p>

                    <div class="flex flex-col gap-4 divide-y divide-slate-100 dark:divide-slate-700/60">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-3 gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mencari Puting (Rooting Reflex)</h4>
                                <p class="text-xs text-slate-400">Bayi menoleh ke arah pipi atau sudut mulut yang disentuh.</p>
                            </div>
                            <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/60 p-1 rounded-xl border border-slate-200/60 dark:border-slate-700 w-full sm:w-auto">
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_rooting" value="Ya" required class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white transition-all">Ya</div>
                                </label>
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_rooting" value="Tidak" class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white transition-all">Tidak</div>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Mengisap (Sucking Reflex)</h4>
                                <p class="text-xs text-slate-400">Bayi otomatis mengisap saat ada sesuatu menyentuh langit-langit mulutnya.</p>
                            </div>
                            <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/60 p-1 rounded-xl border border-slate-200/60 dark:border-slate-700 w-full sm:w-auto">
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_mengisap" value="Ya" required class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white transition-all">Ya</div>
                                </label>
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_mengisap" value="Tidak" class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white transition-all">Tidak</div>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pt-4 gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Reflek Menelan (Swallowing Reflex)</h4>
                                <p class="text-xs text-slate-400">Bayi mampu menelan cairan atau ASI yang masuk ke dalam mulut dengan lancar.</p>
                            </div>
                            <div class="flex gap-2 bg-slate-50 dark:bg-slate-900/60 p-1 rounded-xl border border-slate-200/60 dark:border-slate-700 w-full sm:w-auto">
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_menelan" value="Ya" required class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-primary peer-checked:text-white transition-all">Ya</div>
                                </label>
                                <label class="flex-1 sm:flex-initial cursor-pointer text-center">
                                    <input type="radio" name="reflek_menelan" value="Tidak" class="sr-only peer">
                                    <div class="px-4 py-2 rounded-lg text-xs font-bold text-slate-400 peer-checked:bg-rose-500 peer-checked:text-white transition-all">Tidak</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 items-center">
                    <button type="reset" class="px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Reset Form
                    </button>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-colors shadow-md shadow-blue-100 dark:shadow-none flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span> Simpan Data Bayi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formUpdateDataBayi");
    const numInputs = form.querySelectorAll("input[type='number']");

    // 1. Validasi Real-time Input Angka Negatif
    numInputs.forEach(input => {
        input.addEventListener("input", function() {
            if (this.value < 0) {
                this.value = 0; // Atur paksa ke 0 jika diisi negatif
            }
        });
    });

    // 2. Intersept Submit Form menggunakan Fetch API asynchronous ke Backend
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        // Ambil elemen loader dari layout/main.php jika ingin menggunakannya kembali
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
                alert("Berhasil! Data Bayi berhasil disimpan ke sistem.");
                window.location.href = "<?= base_url('dashboard') ?>";
            } else {
                alert("Gagal menyimpan data: " + (result.message || "Terjadi kesalahan sistem backend."));
                if (loader) {
                    loader.style.opacity = "0";
                    setTimeout(() => loader.style.display = "none", 200);
                }
            }
        } catch (error) {
            console.error("Error submit data bayi:", error);
            alert("Gagal terhubung ke server backend. Cek koneksi jaringan Anda.");
            if (loader) {
                loader.style.opacity = "0";
                setTimeout(() => loader.style.display = "none", 200);
            }
        }
    });
});
</script>
<?= $this->endSection() ?>