<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<style type="text/tailwindcss">
    .curvy-bg-mobile {
        background: linear-gradient(180deg, #E3F2FD 0%, #FFFFFF 100%);
        border-bottom-left-radius: 3rem;
        border-bottom-right-radius: 3rem;
    }
    .curvy-bg-desktop {
        background: linear-gradient(180deg, #E3F2FD 0%, #FFFFFF 100%);
        border-top-right-radius: 4rem;
        border-bottom-right-radius: 4rem;
    }
    .soft-input-shadow {
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.08);
    }
    .illustration-container {
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));
    }
</style>
<script id="tailwind-config">
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    "primary": "#4A90E2",
                    "soft-blue": "#E3F2FD",
                    "accent-blue": "#82B1FF",
                    "warm-gray": "#7A7A7A",
                },
                fontFamily: { "sans": ["Plus Jakarta Sans", "sans-serif"] },
            },
        },
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

<div class="flex flex-col md:flex-row w-full min-h-screen bg-slate-50 font-sans text-slate-800">

    <div class="md:hidden curvy-bg-mobile relative h-72 w-full flex flex-col items-center justify-center px-6 pt-10 flex-shrink-0 z-10">
        <a href="<?= base_url('/') ?>" class="absolute top-12 left-6 p-2 rounded-full bg-white/60 backdrop-blur-sm text-slate-600 hover:bg-white transition">
            <span class="material-symbols-outlined">arrow_back_ios_new</span>
        </a>

        <div class="illustration-container relative flex items-center justify-center w-full max-w-[240px] aspect-square mt-4">
            <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center relative border-4 border-white">
                <div class="absolute inset-0 bg-blue-100 rounded-full opacity-40 animate-pulse"></div>
                <span class="material-symbols-outlined text-[80px] text-primary relative z-10" style="font-variation-settings: 'FILL' 1">family_restroom</span>
            </div>
            <div class="absolute top-0 right-4 w-10 h-10 bg-pink-100 rounded-full opacity-60"></div>
            <div class="absolute bottom-6 left-0 w-8 h-8 bg-blue-200 rounded-full opacity-60"></div>
        </div>
    </div>

    <div class="hidden md:flex curvy-bg-desktop w-5/12 relative flex-col items-center justify-center p-12 shadow-[10px_0_30px_rgba(0,0,0,0.02)] z-10">
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="material-symbols-outlined text-5xl text-primary font-variation-fill">child_care</span>
                <span class="font-bold text-3xl text-primary">SI CUBIT</span>
            </div>
            <p class="text-slate-500 font-medium">Sistem Pemantauan Kesehatan Ibu & Bayi</p>
        </div>

        <div class="illustration-container relative flex items-center justify-center w-full max-w-[300px] aspect-square">
            <div class="w-56 h-56 bg-white rounded-full flex items-center justify-center relative border-8 border-white">
                <div class="absolute inset-0 bg-blue-100 rounded-full opacity-40 animate-pulse"></div>
                <span class="material-symbols-outlined text-[120px] text-primary relative z-10" style="font-variation-settings: 'FILL' 1">family_restroom</span>
            </div>
            <div class="absolute top-4 -right-2 w-14 h-14 bg-pink-100 rounded-full opacity-60"></div>
            <div class="absolute bottom-10 -left-6 w-10 h-10 bg-blue-200 rounded-full opacity-60"></div>
        </div>
    </div>

    <div class="flex-1 px-8 md:px-16 lg:px-24 pt-8 md:pt-0 pb-12 -mt-4 md:mt-0 bg-white md:bg-transparent relative z-20 flex flex-col justify-center">

        <div class="text-center md:text-left mb-8 md:mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Welcome Back!</h1>
            <p class="text-warm-gray text-sm md:text-base mt-2">Senang melihat Bunda kembali hari ini.</p>
        </div>

        <div class="flex justify-center md:justify-start gap-8 mb-8 border-b border-slate-200">
            <a href="<?= base_url('login') ?>" class="pb-3 text-primary font-bold border-b-2 border-primary text-sm transition-colors">Login</a>
            <a href="<?= base_url('register') ?>" class="pb-3 text-slate-400 font-medium text-sm hover:text-slate-600 transition-colors">Registration</a>
        </div>

        <form id="loginForm" class="space-y-5 max-w-md mx-auto md:mx-0 w-full">
            <div class="space-y-4">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">phone</span>
                    <input class="w-full pl-12 pr-5 py-3.5 bg-white border-0 rounded-2xl soft-input-shadow text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 transition-shadow" placeholder="Nomor Telepon / WhatsApp" type="tel" name="no_telp" required />
                </div>

                <div class="relative">
                    <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">lock</span>
                    <input class="w-full pl-12 pr-12 py-3.5 bg-white border-0 rounded-2xl soft-input-shadow text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 transition-shadow" placeholder="Masukkan Password" type="password" name="password" required />
                    <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer hover:text-primary transition-colors">visibility_off</span>
                </div>

                <div class="flex justify-end">
                    <a href="<?= base_url('lupa-password') ?>" class="text-[11px] font-semibold text-primary hover:underline">Lupa Password?</a>
                </div>
            </div>

            <div class="pt-4">
                <button id="btnSubmit" class="w-full bg-primary hover:bg-[#3A80D2] text-white font-bold py-4 rounded-3xl shadow-lg shadow-primary/25 active:scale-[0.98] transition-all" type="submit">
                    Login ke Dashboard
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const formData = new FormData(this);

        btn.innerHTML = 'Loading...';
        btn.disabled = true;

        try {
            const response = await fetch('<?= base_url('api/login') ?>', {
                method: 'POST',
                body: formData
            });

            const responseText = await response.text();

            try {
                const result = JSON.parse(responseText);

                if (result.status === 'success') {
                    // Pop-up Sukses dengan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Selamat datang, ' + result.data.nama,
                        showConfirmButton: false,
                        timer: 1500 // Akan menutup otomatis dalam 1.5 detik
                    }).then(() => {
                        // Redirect setelah pop-up tertutup
                        window.location.href = '<?= base_url('dashboard') ?>';
                    });
                } else {
                    // Pop-up Gagal dengan SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: result.message || 'Silakan cek kembali nomor telepon dan password Bunda.',
                        confirmButtonColor: '#4A90E2'
                    });
                }
            } catch (parseError) {
                console.error("Error dari server:", responseText);

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Terjadi error di backend! Cek console browser.',
                    confirmButtonColor: '#4A90E2'
                });
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Terputus',
                text: 'Gagal menghubungi server. Cek koneksi internet atau URL API.',
                confirmButtonColor: '#4A90E2'
            });
            console.error(error);
        } finally {
            btn.innerHTML = 'Login ke Dashboard';
            btn.disabled = false;
        }
    });
</script>

<?= $this->endSection() ?>