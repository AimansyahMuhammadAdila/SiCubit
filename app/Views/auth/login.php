<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

<script src="https://cdn.tailwindcss.com"></script>

<script id="tailwind-config">
    tailwind.config = {
        darkMode: 'class',
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

<script>
    // Auto dark/light mode based on system preference
    (function() {
        function applyTheme() {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        applyTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);
    })();
</script>

<style type="text/tailwindcss">
    /* ── Dark mode (default from register) ── */
    .dark body {
        background-color: #0A0A0F;
    }
    .dark .app-bg {
        background:
            radial-gradient(ellipse 80% 50% at 50% -10%, rgba(91, 141, 239, 0.18), transparent),
            radial-gradient(ellipse 60% 40% at 90% 20%, rgba(139, 92, 246, 0.12), transparent),
            #0A0A0F;
    }
    .dark .gradient-text {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .dark .gradient-btn {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        box-shadow: 0 10px 30px -8px rgba(91, 141, 239, 0.45);
    }
    .dark .gradient-btn:hover {
        box-shadow: 0 14px 36px -6px rgba(91, 141, 239, 0.55);
    }
    .dark .icon-badge {
        background: radial-gradient(circle at 30% 30%, #ffffff, #eef2ff);
        box-shadow: 0 0 0 10px rgba(91, 141, 239, 0.08), 0 20px 40px -12px rgba(91, 141, 239, 0.35);
    }
    .dark .dark-card {
        background: #13131A;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }
    .dark .dark-input {
        background: #16161E;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .dark .dark-input:focus-within {
        border-color: rgba(91, 141, 239, 0.6);
        box-shadow: 0 0 0 4px rgba(91, 141, 239, 0.12);
        background: #16161E;
    }
    .dark .tab-active {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .dark .tab-inactive {
        color: #64748b;
    }
    .dark .tab-inactive:hover {
        color: #94a3b8;
    }
    .dark .back-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
    }
    .dark .back-btn:hover {
        color: #ffffff;
    }
    .dark .hero-subtitle {
        color: #8A8A94;
    }
    .dark .form-subtitle {
        color: #8A8A94;
    }
    .dark .link-secondary {
        color: #64748b;
    }
    .dark .toggle-pass-icon {
        color: #64748b;
    }
    .dark .toggle-pass-icon:hover {
        color: #5B8DEF;
    }
    .dark .input-icon {
        color: #4b5563;
    }
    .dark .input-text {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        font-family: sans-serif !important;
        letter-spacing: 1px;
    }
    .dark .input-text::placeholder {
        color: #64748b !important;
        -webkit-text-fill-color: #64748b !important;
        font-family: "Plus Jakarta Sans", sans-serif !important;
        letter-spacing: normal;
    }

    /* ── Light mode ── */
    body {
        background-color: #f8fafc;
    }
    .app-bg {
        background:
            radial-gradient(ellipse 80% 50% at 50% -10%, rgba(91, 141, 239, 0.08), transparent),
            radial-gradient(ellipse 60% 40% at 90% 20%, rgba(139, 92, 246, 0.05), transparent),
            #f8fafc;
    }
    .gradient-text {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .gradient-btn {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        box-shadow: 0 10px 30px -8px rgba(91, 141, 239, 0.3);
    }
    .gradient-btn:hover {
        box-shadow: 0 14px 36px -6px rgba(91, 141, 239, 0.4);
    }
    .icon-badge {
        background: radial-gradient(circle at 30% 30%, #ffffff, #eef2ff);
        box-shadow: 0 0 0 10px rgba(91, 141, 239, 0.06), 0 20px 40px -12px rgba(91, 141, 239, 0.2);
    }
    .dark-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 8px 32px -4px rgba(0, 0, 0, 0.06);
    }
    .dark-input {
        background: #f1f5f9;
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .dark-input:focus-within {
        border-color: rgba(91, 141, 239, 0.6);
        box-shadow: 0 0 0 4px rgba(91, 141, 239, 0.1);
        background: #ffffff;
    }
    .tab-active {
        background: linear-gradient(90deg, #5B8DEF 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .tab-inactive {
        color: #94a3b8;
    }
    .tab-inactive:hover {
        color: #64748b;
    }
    .back-btn {
        background: rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.08);
        color: #64748b;
    }
    .back-btn:hover {
        color: #1e293b;
        background: rgba(0, 0, 0, 0.06);
    }
    .hero-subtitle {
        color: #64748b;
    }
    .form-subtitle {
        color: #64748b;
    }
    .link-secondary {
        color: #94a3b8;
    }
    .toggle-pass-icon {
        color: #94a3b8;
    }
    .toggle-pass-icon:hover {
        color: #5B8DEF;
    }
    .input-icon {
        color: #94a3b8;
    }
    .input-text {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        font-family: sans-serif !important;
        letter-spacing: 1px;
    }
    .input-text::placeholder {
        color: #94a3b8 !important;
        -webkit-text-fill-color: #94a3b8 !important;
        font-family: "Plus Jakarta Sans", sans-serif !important;
        letter-spacing: normal;
    }

    /* ── Shared ── */
    .app-bg { min-height: 100vh; }
</style>

<div class="app-bg flex flex-col md:flex-row w-full min-h-screen font-sans relative">

    <!-- Mobile top hero -->
    <div class="md:hidden relative w-full flex flex-col items-center justify-center px-6 pt-14 pb-6 flex-shrink-0 z-10">
        <a href="<?= base_url('/') ?>" class="absolute top-6 left-6 p-2 rounded-full back-btn transition flex items-center justify-center">
            <span class="material-symbols-outlined text-xl">arrow_back_ios_new</span>
        </a>

        <div class="relative flex items-center justify-center w-24 h-24 rounded-3xl icon-badge mb-4">
            <span class="material-symbols-outlined text-[46px] text-primary">family_restroom</span>
        </div>

        <div class="flex items-center justify-center gap-2">
            <span class="font-extrabold text-lg gradient-text">SI CUBIT</span>
        </div>
        <p class="hero-subtitle text-xs text-center mt-1 max-w-xs">Langkah Awal Memantau Tumbuh Kembang Si Kecil</p>
    </div>

    <!-- Desktop left hero -->
    <div class="hidden md:flex w-5/12 h-screen sticky top-0 flex-col items-center justify-center p-12 z-10">
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-3 mb-2">
                <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings: 'FILL' 1">child_care</span>
                <span class="font-extrabold text-2xl tracking-wide gradient-text">SI CUBIT</span>
            </div>
            <p class="hero-subtitle text-sm font-medium">Sistem Pemantauan Kesehatan Ibu & Bayi</p>
        </div>

        <div class="relative flex items-center justify-center w-44 h-44 rounded-[2rem] icon-badge mb-6">
            <span class="material-symbols-outlined text-[84px] text-primary">family_restroom</span>
        </div>

        <p class="hero-subtitle text-sm text-center mt-2 max-w-sm">Senang melihat Bunda kembali. Login untuk memantau kesehatan si kecil.</p>
    </div>

    <!-- Form panel -->
    <div class="flex-1 px-6 sm:px-10 md:px-16 lg:px-24 pb-10 pt-2 md:py-16 relative z-20 flex flex-col justify-start md:justify-center">

        <div class="dark-card rounded-3xl p-8 md:p-10 max-w-xl mx-auto w-full">

            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-extrabold dark:text-white text-slate-900">Welcome Back!</h1>
                <p class="form-subtitle text-sm mt-2">Senang melihat Bunda kembali. Silakan masuk ke akun Anda.</p>
            </div>

            <div class="flex justify-center md:justify-start gap-8 mb-8 border-b dark:border-white/10 border-slate-200">
                <a href="<?= base_url('login') ?>" class="pb-3 tab-active font-bold border-b-2 border-primary text-sm transition-colors">Login</a>
                <a href="<?= base_url('register') ?>" class="pb-3 tab-inactive font-medium text-sm transition-colors">Registration</a>
            </div>

            <form id="loginForm" class="space-y-5 w-full">
                <?= csrf_field() ?>
                <div class="space-y-4">

                    <div class="relative dark-input rounded-2xl">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 input-icon pointer-events-none text-xl">phone</span>
                        <input id="loginPhone" class="w-full pl-12 pr-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Nomor Telepon / WhatsApp" type="tel" name="no_telp" required />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 input-icon pointer-events-none text-xl">lock</span>
                        <input id="passwordInput" class="w-full pl-12 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Masukkan Password" type="password" name="password" required />
                        <span id="togglePassword" class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 toggle-pass-icon cursor-pointer transition-colors select-none">visibility_off</span>
                    </div>

                    <div class="flex justify-end">
                        <a href="<?= base_url('lupa-password') ?>" class="text-[11px] font-semibold text-primary hover:underline">Lupa Password?</a>
                    </div>
                </div>

                <div class="pt-4">
                    <button id="btnSubmit" class="w-full gradient-btn text-white font-bold py-4 rounded-2xl active:scale-[0.98] transition-all" type="submit">
                        Login ke Dashboard
                    </button>
                </div>
            </form>

            <p class="text-center link-secondary text-xs mt-6">
                Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary font-semibold hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('btnSubmit');
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    // Detect dark mode for SweetAlert styling
    const isDark = () => document.documentElement.classList.contains('dark');
    const swalTheme = () => ({
        background: isDark() ? '#13131A' : '#ffffff',
        color: isDark() ? '#f1f5f9' : '#1e293b',
        confirmButtonColor: '#5B8DEF'
    });

    // Toggle show/hide password
    togglePassword.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.textContent = 'visibility';
            togglePassword.style.color = '#5B8DEF';
        } else {
            passwordInput.type = 'password';
            togglePassword.textContent = 'visibility_off';
            togglePassword.style.color = '';
        }
    });

    // Flash session error
    <?php if (session()->getFlashdata('error_session')) : ?>
        Swal.fire({
            icon: 'warning',
            title: 'Sesi Berakhir',
            text: '<?= esc(session()->getFlashdata('error_session'), 'js') ?>',
            confirmButtonText: 'Siap, Bunda',
            ...swalTheme()
        });
    <?php endif; ?>

    // Submit AJAX Form Login
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const originalText = btn.innerHTML;
        btn.innerHTML = `<span class="inline-flex items-center gap-2"><svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>`;
        btn.disabled = true;

        const formData = new FormData(this);
        const csrfToken = formData.get('<?= csrf_token() ?>');

        try {
            const response = await fetch('<?= base_url('api/login') ?>', {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: formData
            });

            const responseText = await response.text();

            try {
                const result = JSON.parse(responseText);
                if (result.status === 'success') {
                    // Tentukan redirect berdasarkan role
                    const role = result.data.role || 'user';
                    const redirectUrl = (role === 'admin' || role === 'bidan')
                        ? '<?= base_url('admin/dashboard') ?>'
                        : '<?= base_url('dashboard') ?>';

                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Selamat datang kembali, ' + (result.data.nama || 'Bunda'),
                        showConfirmButton: false,
                        timer: 1500,
                        ...swalTheme()
                    }).then(() => { window.location.href = redirectUrl; });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: result.message || 'Silakan cek kembali nomor telepon dan password Bunda.',
                        ...swalTheme()
                    });
                }
            } catch (parseError) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Terjadi gangguan pada sistem pusat backend.',
                    ...swalTheme()
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Terputus',
                text: 'Gagal menghubungi server. Pastikan jaringan internet Bunda aktif.',
                ...swalTheme()
            });
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
});
</script>

<?= $this->endSection() ?>