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
    select.dark-select option {
        background: #16161E;
        color: #f1f5f9;
    }
</style>

<div class="app-bg flex flex-col md:flex-row w-full min-h-screen text-slate-100 font-sans relative">

    <!-- Mobile top hero -->
    <div class="md:hidden relative w-full flex flex-col items-center justify-center px-6 pt-14 pb-6 flex-shrink-0 z-10">
        <a href="<?= base_url('/') ?>" class="absolute top-6 left-6 p-2 rounded-full bg-white/5 border border-white/10 text-slate-300 hover:text-white transition flex items-center justify-center">
            <span class="material-symbols-outlined text-xl">arrow_back_ios_new</span>
        </a>

        <div class="relative flex items-center justify-center w-24 h-24 rounded-3xl icon-badge mb-4">
            <span class="material-symbols-outlined text-[46px] text-primary">family_restroom</span>
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
            <span class="material-symbols-outlined text-[84px] text-primary">family_restroom</span>
        </div>

        <p class="text-warm-gray text-sm text-center mt-2 max-w-sm">Daftarkan diri Bunda untuk mulai memantau perkembangan laktasi dan kesehatan.</p>
    </div>

    <!-- Form panel -->
    <div class="flex-1 px-6 sm:px-10 md:px-16 lg:px-24 py-10 md:py-16 relative z-20 flex flex-col justify-center min-h-screen">

        <div class="dark-card rounded-3xl p-8 md:p-10 max-w-xl mx-auto w-full">

            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-extrabold text-white">Buat Akun Baru</h1>
                <p class="text-warm-gray text-sm mt-2">Daftarkan diri Bunda untuk mulai memantau perkembangan laktasi dan kesehatan.</p>
            </div>

            <div class="flex justify-center md:justify-start gap-8 mb-8 border-b border-white/10">
                <a href="<?= base_url('login') ?>" class="pb-3 text-slate-500 font-medium text-sm hover:text-slate-300 transition-colors">Login</a>
                <a href="<?= base_url('register') ?>" class="pb-3 gradient-text font-bold border-b-2 border-primary text-sm transition-colors">Registration</a>
            </div>

            <form id="registerForm" class="space-y-5 w-full">
                <div class="space-y-4">
                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Nama Lengkap Ibu" type="text" name="nama" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative dark-input rounded-2xl">
                            <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Umur (Tahun)" type="number" name="umur" required />
                        </div>
                        <div class="relative dark-input rounded-2xl">
                            <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Jumlah Anak" type="number" name="jumlah_anak" />
                        </div>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Pekerjaan" type="text" name="pekerjaan" />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Nomor Telepon / WhatsApp" type="tel" name="no_telp" required />
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <textarea class="w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100 resize-none" rows="2" placeholder="Alamat Lengkap" name="alamat"></textarea>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select id="selectKabkota" class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none text-slate-300 appearance-none disabled:text-slate-600" name="id_kabkota" required>
                            <option value="" disabled selected>Memuat Kab/Kota...</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select id="selectPuskesmas" class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none text-slate-300 appearance-none disabled:text-slate-600" name="id_puskesmas" required disabled>
                            <option value="" disabled selected>Pilih Kab/Kota Terlebih Dahulu</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <select class="dark-select w-full px-5 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none text-slate-300 appearance-none" name="status_kehamilan" required>
                            <option value="" disabled selected>Pilih Status Kehamilan Bunda</option>
                            <option value="pra_kehamilan">Pra Kehamilan (Pranikah)</option>
                            <option value="hamil">Masa Kehamilan (Hamil)</option>
                            <option value="pasca_melahirkan">Pasca Melahirkan (Menyusui)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">expand_more</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input id="regPassword" class="w-full px-5 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Buat Password" type="password" name="password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 cursor-pointer hover:text-primary transition-colors select-none" data-target="regPassword">visibility_off</span>
                    </div>

                    <div class="relative dark-input rounded-2xl">
                        <input id="regPasswordConfirm" class="w-full px-5 pr-12 py-3.5 bg-transparent rounded-2xl text-sm focus:outline-none placeholder:text-slate-500 text-slate-100" placeholder="Konfirmasi Password" type="password" name="konfirmasi_password" required />
                        <span class="toggle-pass material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 cursor-pointer hover:text-primary transition-colors select-none" data-target="regPasswordConfirm">visibility_off</span>
                    </div>
                </div>

                <div class="pt-4">
                    <button id="btnReg" class="w-full gradient-btn text-white font-bold py-4 rounded-2xl active:scale-[0.98] transition-all" type="submit">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <p class="text-center text-slate-500 text-xs mt-6">
                Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary font-semibold hover:underline">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {

    // 0. Toggle show/hide password (semua field password)
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
            background: '#13131A',
            color: '#f1f5f9',
            didOpen: () => { Swal.showLoading(); }
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
                    confirmButtonColor: '#5B8DEF',
                    background: '#13131A',
                    color: '#f1f5f9'
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

});
</script>

<?= $this->endSection() ?>