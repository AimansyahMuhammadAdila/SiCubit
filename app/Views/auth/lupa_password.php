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
                    "warm-gray": "#7A7A7A",
                },
                fontFamily: { "sans": ["Plus Jakarta Sans", "sans-serif"] },
            },
        },
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

<div class="flex flex-col md:flex-row w-full min-h-screen bg-slate-50 font-sans text-slate-800 relative">

    <div class="md:hidden curvy-bg-mobile relative h-72 w-full flex flex-col items-center justify-center px-6 pt-10 flex-shrink-0 z-10">
        <a href="<?= base_url('login') ?>" class="absolute top-12 left-6 p-2 rounded-full bg-white/60 backdrop-blur-sm text-slate-600 hover:bg-white transition">
            <span class="material-symbols-outlined">arrow_back_ios_new</span>
        </a>
        <div class="illustration-container relative flex items-center justify-center w-full max-w-[240px] aspect-square mt-4">
            <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center relative border-4 border-white">
                <div class="absolute inset-0 bg-blue-100 rounded-full opacity-40 animate-pulse"></div>
                <span class="material-symbols-outlined text-[80px] text-primary relative z-10" style="font-variation-settings: 'FILL' 1">lock_reset</span>
            </div>
            <div class="absolute top-0 right-4 w-10 h-10 bg-pink-100 rounded-full opacity-60"></div>
            <div class="absolute bottom-6 left-0 w-8 h-8 bg-blue-200 rounded-full opacity-60"></div>
        </div>
    </div>

    <div class="hidden md:flex curvy-bg-desktop w-5/12 h-screen sticky top-0 flex-col items-center justify-center p-12 shadow-[10px_0_30px_rgba(0,0,0,0.02)] z-10">
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="material-symbols-outlined text-5xl text-primary font-variation-fill">child_care</span>
                <span class="font-bold text-3xl text-primary">SI CUBIT</span>
            </div>
            <p class="text-slate-500 font-medium">Langkah Awal Memantau Tumbuh Kembang Si Kecil</p>
        </div>
        <div class="illustration-container relative flex items-center justify-center w-full max-w-[300px] aspect-square">
            <div class="w-56 h-56 bg-white rounded-full flex items-center justify-center relative border-8 border-white">
                <div class="absolute inset-0 bg-blue-100 rounded-full opacity-40 animate-pulse"></div>
                <span class="material-symbols-outlined text-[120px] text-primary relative z-10" style="font-variation-settings: 'FILL' 1">lock_reset</span>
            </div>
            <div class="absolute top-4 -right-2 w-14 h-14 bg-pink-100 rounded-full opacity-60"></div>
            <div class="absolute bottom-10 -left-6 w-10 h-10 bg-blue-200 rounded-full opacity-60"></div>
        </div>
    </div>

    <div class="flex-1 px-8 md:px-16 lg:px-24 pt-8 md:pt-16 pb-12 -mt-4 md:mt-0 bg-white md:bg-transparent relative z-20 flex flex-col justify-center min-h-screen">

        <div class="text-center md:text-left mb-8 md:mb-10 max-w-xl">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Atur Ulang Password</h1>
            <p class="text-warm-gray text-sm md:text-base mt-2">Masukkan nomor WhatsApp terdaftar Bunda untuk membuat password baru.</p>
        </div>

        <form id="resetForm" class="space-y-5 max-w-xl w-full">
            <div class="space-y-4">
                <div class="relative">
                    <input class="w-full px-5 py-3.5 bg-white border-0 rounded-2xl soft-input-shadow text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 transition-shadow" placeholder="Nomor WhatsApp Terdaftar" type="tel" name="no_telp" required />
                </div>

                <div class="relative">
                    <input class="w-full px-5 py-3.5 bg-white border-0 rounded-2xl soft-input-shadow text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 transition-shadow" placeholder="Password Baru" type="password" name="password" required />
                    <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer hover:text-primary transition-colors">visibility</span>
                </div>

                <div class="relative">
                    <input class="w-full px-5 py-3.5 bg-white border-0 rounded-2xl soft-input-shadow text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400 transition-shadow" placeholder="Konfirmasi Password Baru" type="password" name="konfirmasi_password" required />
                    <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer hover:text-primary transition-colors">visibility</span>
                </div>
            </div>

            <div class="pt-6 space-y-4">
                <button id="btnReset" class="w-full bg-primary hover:bg-[#3A80D2] text-white font-bold py-4 rounded-3xl shadow-lg shadow-primary/25 active:scale-[0.98] transition-all" type="submit">
                    Simpan Password Baru
                </button>
                <div class="text-center">
                    <a href="<?= base_url('login') ?>" class="text-sm font-semibold text-slate-400 hover:text-primary transition-colors">Kembali ke halaman Login</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('resetForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnReset');
    const formData = new FormData(this);

    Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    btn.disabled = true;

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
                text: result.message,
                confirmButtonColor: '#4A90E2'
            }).then(() => {
                window.location.href = '<?= base_url('login') ?>';
            });
        } else {
            let errorHtml = '<ul style="text-align: left; list-style-type: disc; padding-left: 20px; color: #ef4444; font-size: 14px;">';
            if(result.errors) {
                for (const key in result.errors) { errorHtml += `<li>${result.errors[key]}</li>`; }
            } else {
                errorHtml += `<li>${result.message}</li>`;
            }
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: errorHtml,
                confirmButtonColor: '#4A90E2'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Koneksi Bermasalah',
            text: 'Terjadi kesalahan pada server. Coba lagi nanti.',
            confirmButtonColor: '#4A90E2'
        });
    } finally {
        btn.disabled = false;
    }
});
</script>

<?= $this->endSection() ?>