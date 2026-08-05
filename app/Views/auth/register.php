<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<style>
    .gold-border {
        border: 2.5px solid #D4AF37;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35);
    }
    .full-app-container {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        padding: 1.5rem;
        box-sizing: border-box;
    }
</style>

<div class="full-app-container">

    <!-- TOP KEMENKES LOGO PILL (DIPERBESAR) -->
    <header class="w-full max-w-6xl mx-auto pt-2 flex items-center justify-between z-30">
        <div class="bg-white/95 backdrop-blur-md px-5 sm:px-6 py-3 rounded-full shadow-lg border border-white/80 flex items-center gap-3">
            <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes Banjarmasin" class="h-10 sm:h-12 md:h-14 object-contain">
        </div>
        <a href="<?= base_url('/') ?>" class="size-11 rounded-full bg-white/90 backdrop-blur shadow flex items-center justify-center text-slate-700 hover:bg-white transition">
            <span class="material-symbols-outlined text-xl">close</span>
        </a>
    </header>

    <!-- FORM REGISTER CARD -->
    <main class="flex-1 flex flex-col items-center justify-center my-auto z-20 w-full max-w-md mx-auto py-6">
        
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-2xl border border-white/80 w-full space-y-5">
            
            <div class="text-center space-y-1">
                <div class="size-14 rounded-full bg-[#162065]/10 text-[#162065] flex items-center justify-center mx-auto mb-1">
                    <span class="material-symbols-outlined text-3xl">person_add</span>
                </div>
                <h2 class="text-2xl font-black text-[#162065] tracking-tight">Daftar Akun SiCubit</h2>
                <p class="text-xs text-slate-500 font-medium">Isikan data diri Bunda untuk memulai pendampingan</p>
            </div>

            <form id="registerForm" class="space-y-3.5">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Nama Lengkap Bunda</label>
                    <input type="text" name="nama" required placeholder="Nama Lengkap" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="tel" name="no_telp" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Umur (Tahun)</label>
                        <input type="number" name="umur" min="12" max="60" placeholder="Contoh: 28" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Jumlah Anak</label>
                        <input type="number" name="jumlah_anak" min="0" max="20" placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Status Bunda Saat Ini</label>
                    <select name="status_kehamilan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10">
                        <option value="pra_kehamilan">Pra-Kehamilan (Perencanaan)</option>
                        <option value="hamil">Sedang Hamil</option>
                        <option value="pasca_melahirkan" selected>Pasca Melahirkan (Menyusui)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" id="regPassword" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10" oninput="document.getElementById('regConfirmPassword').value = this.value"/>
                    <input type="hidden" id="regConfirmPassword" name="konfirmasi_password" />
                </div>

                <button type="submit" id="btnSubmitReg" class="w-full py-3.5 bg-black hover:bg-slate-900 text-white font-black text-lg rounded-2xl gold-border uppercase tracking-wider transition-all active:scale-95 shadow-xl mt-3">
                    DAFTAR SEKARANG
                </button>
            </form>

            <div class="text-center pt-1">
                <p class="text-xs text-slate-600 font-bold">
                    Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-[#162065] font-black underline hover:text-blue-950">Masuk di sini</a>
                </p>
            </div>

        </div>

    </main>

    <footer class="text-center py-2 text-[11px] text-slate-500 font-medium">
        &copy; <?= date('Y') ?> SI CUBIT - Kemenkes Poltekkes Banjarmasin
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitReg');
        const origText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'MEMPROSES...';

        document.getElementById('regConfirmPassword').value = document.getElementById('regPassword').value;

        const formData = new FormData(this);

        try {
            const response = await fetch('<?= base_url('api/register') ?>', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success' || response.status === 201) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: data.message || 'Akun Bunda berhasil dibuat. Silakan login.',
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '<?= base_url('login') ?>';
                });
            } else {
                let errText = data.message || 'Mohon periksa kembali isian form Anda.';
                if (data.errors) {
                    errText = Object.values(data.errors).join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
                    html: errText
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Sistem',
                text: 'Tidak dapat tersambung ke server. Silakan coba lagi.'
            });
        } finally {
            btn.disabled = false;
            btn.innerText = origText;
        }
    });
</script>

<?= $this->endSection() ?>