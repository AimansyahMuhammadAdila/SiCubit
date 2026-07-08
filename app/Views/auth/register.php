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
    /* ── Dark mode ── */
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
    .dark select.dark-select option {
        background: #16161E;
        color: #f1f5f9;
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
        color: #f1f5f9;
    }
    .dark .input-text::placeholder {
        color: #64748b;
    }
    .dark .select-text {
        color: #cbd5e1;
    }
    .dark .select-arrow {
        color: #64748b;
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
    select.dark-select option {
        background: #ffffff;
        color: #1e293b;
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
        color: #1e293b;
    }
    .input-text::placeholder {
        color: #94a3b8;
    }
    .select-text {
        color: #475569;
    }
    .select-arrow {
        color: #94a3b8;
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
            <p class="hero-subtitle text-sm font-medium">Langkah Awal Memantau Tumbuh Kembang Si Kecil</p>
        </div>

        <div class="relative flex items-center justify-center w-44 h-44 rounded-[2rem] icon-badge mb-6">
            <span class="material-symbols-outlined text-[84px] text-primary">family_restroom</span>
        </div>

        <p class="hero-subtitle text-sm text-center mt-2 max-w-sm">Daftarkan diri Bunda untuk mulai memantau perkembangan laktasi dan kesehatan.</p>
    </div>

    <!-- Form panel -->
    <div class="flex-1 px-6 sm:px-10 md:px-16 lg:px-24 pb-10 pt-2 md:py-16 relative z-20 flex flex-col justify-start md:justify-center">

        <div class="dark-card rounded-3xl p-8 md:p-10 max-w-xl mx-auto w-full">

            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-extrabold dark:text-white text-slate-900">Buat Akun Baru</h1>
                <p class="form-subtitle text-sm mt-2">Daftarkan diri Bunda untuk mulai memantau perkembangan laktasi dan kesehatan.</p>
            </div>

            <div class="flex justify-center md:justify-start gap-8 mb-8 border-b dark:border-white/10 border-slate-200">
                <a href="<?= base_url('login') ?>" class="pb-3 tab-inactive font-medium text-sm transition-colors">Login</a>
                <a href="<?= base_url('register') ?>" class="pb-3 tab-active font-bold border-b-2 border-primary text-sm transition-colors">Registration</a>
            </div>

            <form id="registerForm" class="space-y-5 w-full">
                <div class="space-y-4">
                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Nama Lengkap Ibu" type="text" name="nama" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative dark-input rounded-2xl">
                            <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Umur (Tahun)" type="number" name="umur" required />
                        </div>
                        <div class="relative dark-input rounded-2xl">
                            <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Jumlah Anak" type="number" name="jumlah_anak" />
                        </div>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Pekerjaan" type="text" name="pekerjaan" />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Nomor Telepon / WhatsApp" type="tel" name="no_telp" required />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <textarea class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text resize-none" rows="2" placeholder="Alamat Lengkap" name="alamat"></textarea>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select id="selectKabkota" class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none select-text appearance-none disabled:opacity-50" name="id_kabkota" required>
                            <option value="" disabled selected>Memuat Kab/Kota...</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 select-arrow pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select id="selectPuskesmas" class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none select-text appearance-none disabled:opacity-50" name="id_puskesmas" required disabled>
                            <option value="" disabled selected>Pilih Kab/Kota Terlebih Dahulu</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 select-arrow pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none select-text appearance-none" name="status_kehamilan" required>
                            <option value="" disabled selected>Pilih Status Kehamilan Bunda</option>
                            <option value="pra_kehamilan">Pra Kehamilan (Pranikah)</option>
                            <option value="hamil">Masa Kehamilan (Hamil)</option>
                            <option value="pasca_melahirkan">Pasca Melahirkan (Menyusui)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 select-arrow pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input id="regPassword" class="w-full px-5 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Buat Password" type="password" name="password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 toggle-pass-icon cursor-pointer transition-colors select-none" data-target="regPassword">visibility_off</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input id="regPasswordConfirm" class="w-full px-5 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none input-text" placeholder="Konfirmasi Password" type="password" name="konfirmasi_password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 toggle-pass-icon cursor-pointer transition-colors select-none" data-target="regPasswordConfirm">visibility_off</span>
                    </div>
                </div>

                <div class="pt-4">
                    <button id="btnReg" class="w-full gradient-btn text-white font-bold py-4 rounded-2xl active:scale-[0.98] transition-all" type="submit">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <p class="text-center link-secondary text-xs mt-6">
                Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary font-semibold hover:underline">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {

    // Detect dark mode for SweetAlert styling
    const isDark = () => document.documentElement.classList.contains('dark');
    const swalTheme = () => ({
        background: isDark() ? '#13131A' : '#ffffff',
        color: isDark() ? '#f1f5f9' : '#1e293b',
        confirmButtonColor: '#5B8DEF'
    });

    // 0. Toggle show/hide password (semua field password)
    document.querySelectorAll('.toggle-pass').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const input = document.getElementById(toggle.dataset.target);
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = 'visibility';
                toggle.style.color = '#5B8DEF';
            } else {
                input.type = 'password';
                toggle.textContent = 'visibility_off';
                toggle.style.color = '';
            }
        });
    });

    // 1. Script Fetch Data Wilayah Dinamis
    const selKabkota = document.getElementById('selectKabkota');
    const selPuskesmas = document.getElementById('selectPuskesmas');

    // Ambil data Kab/Kota saat halaman dimuat
    try {
        const res = await fetch('<?= base_url('api/wilayah/kabkota') ?>');
        const json = await res.json();

        if (json.status === 'success') {
            selKabkota.innerHTML = '<option value="" disabled selected>Pilih Kabupaten/Kota</option>';
            json.data.forEach(item => {
                selKabkota.innerHTML += `<option value="${item.id}">${item.tipe} ${item.nama}</option>`;
            });
        }
    } catch (err) {
        selKabkota.innerHTML = '<option value="" disabled selected>Gagal memuat wilayah</option>';
    }

    // Ambil data Puskesmas SAAT Kab/Kota dipilih
    selKabkota.addEventListener('change', async function() {
        const idKabkota = this.value;

        // Reset dan Matikan sementara dropdown puskesmas
        selPuskesmas.innerHTML = '<option value="" disabled selected>Memuat Puskesmas...</option>';
        selPuskesmas.disabled = true;

        try {
            const res = await fetch(`<?= base_url('api/wilayah/puskesmas/') ?>${idKabkota}`);
            const json = await res.json();

            if (json.status === 'success' && json.data.length > 0) {
                selPuskesmas.innerHTML = '<option value="" disabled selected>Pilih Puskesmas</option>';
                json.data.forEach(item => {
                    selPuskesmas.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                });
                selPuskesmas.disabled = false; // Hidupkan dropdown
            } else {
                selPuskesmas.innerHTML = '<option value="" disabled selected>Tidak ada Puskesmas</option>';
            }
        } catch (err) {
            selPuskesmas.innerHTML = '<option value="" disabled selected>Gagal memuat puskesmas</option>';
        }
    });

    // 2. Script Submit Form Register
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnReg');
        const formData = new FormData(this);

        Swal.fire({
            title: 'Memproses Pendaftaran...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); },
            ...swalTheme()
        });

        btn.disabled = true;

        try {
            const response = await fetch('<?= base_url('api/register') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: 'Akun Bunda sudah aktif, silakan login.',
                    ...swalTheme()
                }).then(() => {
                    window.location.href = '<?= base_url('login') ?>';
                });
            } else {
                let errorHtml = '<ul style="text-align: left; list-style-type: disc; padding-left: 20px; color: #f87171; font-size: 14px;">';
                if(result.errors) {
                    for (const key in result.errors) {
                        errorHtml += `<li>${result.errors[key]}</li>`;
                    }
                } else {
                    errorHtml += `<li>${result.message}</li>`;
                }
                errorHtml += '</ul>';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mendaftar',
                    html: errorHtml,
                    ...swalTheme()
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Bermasalah',
                text: 'Terjadi kesalahan pada server. Coba lagi nanti.',
                ...swalTheme()
            });
        } finally {
            btn.disabled = false;
        }
    });

});
</script>

<?= $this->endSection() ?>