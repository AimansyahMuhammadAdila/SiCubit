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

    <!-- FORM LOGIN CARD -->
    <main class="flex-1 flex flex-col items-center justify-center my-auto z-20 w-full max-w-md mx-auto py-6">
        
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-2xl border border-white/80 w-full space-y-6">
            
            <div class="text-center space-y-2">
                <div class="size-16 rounded-full bg-[#162065]/10 text-[#162065] flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-3xl">lock</span>
                </div>
                <h2 class="text-2xl font-black text-[#162065] tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-xs text-slate-500 font-medium">Masukan nomor telepon & password akun Bunda</p>
            </div>

            <form id="loginForm" class="space-y-4">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider mb-1">Nomor Telepon / WhatsApp</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">call</span>
                        <input type="tel" name="no_telp" required placeholder="08xxxxxxxxxx" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-[11px] font-black text-slate-600 uppercase tracking-wider">Password</label>
                        <a href="<?= base_url('lupa-password') ?>" class="text-[11px] font-bold text-[#162065] hover:underline">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
                        <input type="password" id="loginPassword" name="password" required placeholder="Masukkan Password" class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#162065] focus:ring-2 focus:ring-[#162065]/10"/>
                        <button type="button" onclick="togglePasswordVisibility('loginPassword')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                </div>

                <button type="submit" id="btnSubmit" class="w-full py-4 bg-black hover:bg-slate-900 text-white font-black text-lg rounded-2xl gold-border uppercase tracking-wider transition-all active:scale-95 shadow-xl mt-4">
                    MASUK SEKARANG
                </button>
            </form>

            <div class="text-center pt-2">
                <p class="text-xs text-slate-600 font-bold">
                    Belum punya akun? <a href="<?= base_url('register') ?>" class="text-[#162065] font-black underline hover:text-blue-950">Daftar Akun Baru</a>
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
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    }

    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const origText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'MEMPROSES...';

        const formData = new FormData(this);

        try {
            const response = await fetch('<?= base_url('api/login') ?>', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Masuk!',
                    text: data.message || 'Selamat datang kembali, Bunda!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    const role = data.data?.role || 'ibu';
                    if (role === 'admin' || role === 'bidan') {
                        window.location.href = '<?= base_url('admin/dashboard') ?>';
                    } else {
                        window.location.href = '<?= base_url('dashboard') ?>';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Masuk',
                    text: data.message || 'Nomor telepon atau password salah.'
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