<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<style>
    .gold-border {
        border: 2.5px solid #D4AF37;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35);
    }
    .app-container {
        width: 100%;
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        padding: 1.5rem;
        box-sizing: border-box;
    }
</style>

<div class="app-container">

    <!-- TOP KEMENKES LOGO PILL -->
    <header class="w-full pt-2 flex items-center justify-between z-30">
        <div class="bg-white/95 backdrop-blur-md px-4 py-2 rounded-full shadow-md border border-white/60 flex items-center gap-2">
            <img src="<?= base_url('uploads/Poltekkes.png') ?>" alt="Kemenkes Poltekkes Banjarmasin" class="h-8 object-contain">
        </div>
        <a href="<?= base_url('login') ?>" class="size-10 rounded-full bg-white/90 backdrop-blur shadow flex items-center justify-center text-slate-700 hover:bg-white transition">
            <span class="material-symbols-outlined text-xl">close</span>
        </a>
    </header>

    <!-- FORM LUPA PASSWORD CARD -->
    <main class="flex-1 flex flex-col items-center justify-center my-auto z-20 w-full py-6">
        
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-2xl border border-white/80 w-full space-y-5">
            
            <div class="text-center space-y-1">
                <div class="size-14 rounded-full bg-[#162065]/10 text-[#162065] flex items-center justify-center mx-auto mb-1">
                    <span class="material-symbols-outlined text-3xl">lock_reset</span>
                </div>
                <h2 class="text-2xl font-black text-[#162065] tracking-tight">Atur Ulang Password</h2>
                <p class="text-xs text-slate-500 font-medium">Masukkan nomor WhatsApp terdaftar untuk membuat password baru</p>
            </div>

            <form id="resetForm" class="space-y-4">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Nomor WhatsApp Terdaftar</label>
                    <input type="tel" name="no_telp" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Password Baru</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" required placeholder="Ulangi password baru" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                </div>

                <button type="submit" id="btnReset" class="w-full py-3.5 bg-black hover:bg-slate-900 text-white font-black text-lg rounded-2xl gold-border uppercase tracking-wider transition-all active:scale-95 shadow-xl mt-2">
                    SIMPAN PASSWORD
                </button>
            </form>

            <div class="text-center pt-1">
                <a href="<?= base_url('login') ?>" class="text-xs text-[#162065] font-black underline hover:text-blue-950">Kembali ke Halaman Login</a>
            </div>

        </div>

    </main>

    <footer class="text-center py-2 text-[10px] text-slate-500 font-medium">
        &copy; <?= date('Y') ?> SI CUBIT - Kemenkes Poltekkes Banjarmasin
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('resetForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnReset');
        const origText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'MEMPROSES...';

        const formData = new FormData(this);

        try {
            const response = await fetch('<?= base_url('api/reset-password') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message || 'Password berhasil diperbarui.',
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '<?= base_url('login') ?>';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: result.message || 'Gagal mengatur ulang password.'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Bermasalah',
                text: 'Terjadi kesalahan pada server. Coba lagi nanti.'
            });
        } finally {
            btn.disabled = false;
            btn.innerText = origText;
        }
    });
</script>

<?= $this->endSection() ?>