<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

<script src="https://cdn.tailwindcss.com"></script>

<script id="tailwind-config">
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    "primary": "#5B8DEF",
                    "accent-purple": "#8B5CF6",
                    "bg-deep": "#0A0A0F",
                    "bg-card": "#13131A",
                    "warm-gray": "#8A8A94",
                },
                fontFamily: { "sans": ["Plus Jakarta Sans", "sans-serif"] },
            },
        },
    }
</script>

<style type="text/tailwindcss">
    body {
        background-color: #0A0A0F;
    }
    .app-bg {
        background:
            radial-gradient(ellipse 80% 50% at 50% -10%, rgba(91, 141, 239, 0.18), transparent),
            radial-gradient(ellipse 60% 40% at 90% 20%, rgba(139, 92, 246, 0.12), transparent),
            #0A0A0F;
    }
    .gradient-text {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .gradient-btn {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        box-shadow: 0 10px 30px -8px rgba(91, 141, 239, 0.45);
    }
    .icon-badge {
        background: radial-gradient(circle at 30% 30%, #ffffff, #eef2ff);
        box-shadow: 0 0 0 10px rgba(91, 141, 239, 0.08), 0 20px 40px -12px rgba(91, 141, 239, 0.35);
    }
    .dark-card {
        background: #13131A;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }
    .dark-input {
        background: #16161E;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .dark-input:focus-within {
        border-color: rgba(91, 141, 239, 0.6);
        box-shadow: 0 0 0 4px rgba(91, 141, 239, 0.12);
    }
</style>

<div class="app-bg flex flex-col md:flex-row w-full min-h-screen text-slate-100 font-sans relative">

    <!-- Mobile top hero -->
    <div class="md:hidden relative w-full flex flex-col items-center justify-center px-6 pt-14 pb-6 flex-shrink-0 z-10">
        <a href="<?= base_url('login') ?>" class="absolute top-6 left-6 p-2 rounded-full bg-white/5 border border-white/10 text-slate-300 hover:text-white transition flex items-center justify-center">
            <span class="material-symbols-outlined text-xl">arrow_back_ios_new</span>
        </a>

        <div class="relative flex items-center justify-center w-24 h-24 rounded-3xl icon-badge mb-4">
            <span class="material-symbols-outlined text-[46px] text-primary">lock_reset</span>
        </div>

        <div class="flex items-center justify-center gap-2">
            <span class="font-extrabold text-lg gradient-text">SI CUBIT</span>
        </div>
        <p class="text-warm-gray text-xs text-center mt-1 max-w-xs">Langkah Awal Memantau Tumbuh Kembang Si Kecil</p>
    </div>

    <!-- Desktop left hero -->
    <div class="hidden md:flex w-5/12 h-screen sticky top-0 flex-col items-center justify-center p-12 z-10">
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings: 'FILL' 1">child_care</span>
                <span class="font-extrabold text-2xl tracking-wide gradient-text">SI CUBIT</span>
            </div>
            <p class="text-warm-gray text-sm font-medium">Langkah Awal Memantau Tumbuh Kembang Si Kecil</p>
        </div>

        <div class="relative flex items-center justify-center w-44 h-44 rounded-[2rem] icon-badge mb-6">
            <span class="material-symbols-outlined text-[84px] text-primary">lock_reset</span>
        </div>
    </div>

    <!-- Form panel -->
    <div class="flex-1 px-6 sm:px-10 md:px-16 lg:px-24 py-10 md:py-16 relative z-20 flex flex-col justify-center min-h-screen">

        <div class="dark-card rounded-3xl p-8 md:p-10 max-w-xl mx-auto w-full">

            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-extrabold text-white">Atur Ulang Password</h1>
                <p class="text-warm-gray text-sm mt-2">Masukkan nomor WhatsApp terdaftar Bunda untuk membuat password baru.</p>
            </div>

            <form id="resetForm" class="space-y-5 w-full">
                <div class="space-y-4">
                    <div class="relative dark-input rounded-2xl">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none text-xl">phone</span>
                        <input class="w-full pl-12 pr-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Nomor WhatsApp Terdaftar" type="tel" name="no_telp" required />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none text-xl">lock</span>
                        <input id="newPassword" class="w-full pl-12 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Password Baru" type="password" name="password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 cursor-pointer hover:text-primary transition-colors select-none" data-target="newPassword">visibility_off</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none text-xl">lock</span>
                        <input id="confirmPassword" class="w-full pl-12 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Konfirmasi Password Baru" type="password" name="konfirmasi_password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 cursor-pointer hover:text-primary transition-colors select-none" data-target="confirmPassword">visibility_off</span>
                    </div>
                </div>

                <div class="pt-4 space-y-4">
                    <button id="btnReset" class="w-full gradient-btn text-white font-bold py-4 rounded-2xl active:scale-[0.98] transition-all" type="submit">
                        Simpan Password Baru
                    </button>
                    <div class="text-center">
                        <a href="<?= base_url('login') ?>" class="text-sm font-semibold text-slate-500 hover:text-primary transition-colors">Kembali ke halaman Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Toggle show/hide password
document.querySelectorAll('.toggle-pass').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const input = document.getElementById(toggle.dataset.target);
        if (input.type === 'password') {
            input.type = 'text';
            toggle.textContent = 'visibility';
            toggle.classList.replace('text-slate-500', 'text-primary');
        } else {
            input.type = 'password';
            toggle.textContent = 'visibility_off';
            toggle.classList.replace('text-primary', 'text-slate-500');
        }
    });
});

document.getElementById('resetForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnReset');
    const formData = new FormData(this);

    Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        background: '#13131A',
        color: '#f1f5f9',
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
                confirmButtonColor: '#5B8DEF',
                background: '#13131A',
                color: '#f1f5f9'
            }).then(() => {
                window.location.href = '<?= base_url('login') ?>';
            });
        } else {
            let errorHtml = '<ul style="text-align: left; list-style-type: disc; padding-left: 20px; color: #f87171; font-size: 14px;">';
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
                confirmButtonColor: '#5B8DEF',
                background: '#13131A',
                color: '#f1f5f9'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Koneksi Bermasalah',
            text: 'Terjadi kesalahan pada server. Coba lagi nanti.',
            confirmButtonColor: '#5B8DEF',
            background: '#13131A',
            color: '#f1f5f9'
        });
    } finally {
        btn.disabled = false;
    }
});
</script>

<?= $this->endSection() ?>