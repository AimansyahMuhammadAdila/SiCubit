<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1a1ab7",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111121",
                        "accent-teal": "#e0f2f1",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .login-split-bg {
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex items-center justify-center">

    <div id="page-loader"
        class="fixed inset-0 z-[9999] bg-white dark:bg-slate-900 flex flex-col items-center justify-center transition-opacity duration-500"
        style="opacity: 1; display: flex;">
        <div class="flex flex-col items-center justify-center">
            <div class="relative flex items-center justify-center w-28 h-28">
                <div class="absolute inset-0 bg-blue-100 dark:bg-slate-800 rounded-full animate-pulse opacity-60"></div>
                <svg class="w-16 h-16 text-primary relative z-10 animate-bounce" viewBox="0 0 24 24" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2.5-9c.83 0 1.5-.67 1.5-1.5S10.33 8 9.5 8 8 8.67 8 9.5 8.83 11 9.5 11zm5 0c.83 0 1.5-.67 1.5-1.5S15.83 8 15 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 4c-2.28 0-4.22-1.66-5-4h10c-.78 2.34-2.72 4-5 4z" />
                </svg>
            </div>
            <div class="mt-6 text-center">
                <p class="text-primary font-black text-xl tracking-[0.2em] animate-pulse uppercase">SI CUBIT</p>
                <p class="text-slate-400 text-[10px] mt-1 font-medium">Panel Admin Petugas Kesehatan...</p>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen w-full overflow-hidden">
        <div class="hidden lg:flex lg:w-1/2 login-split-bg relative items-center justify-center p-12 overflow-hidden">
            <div class="relative z-10 flex flex-col items-center text-center max-w-lg">
                <div class="mb-8 p-4 bg-white/30 backdrop-blur-md rounded-2xl border border-white/40">
                    <div class="size-48 bg-white/40 rounded-xl flex items-center justify-center shadow-inner">
                        <span class="material-symbols-outlined text-[100px] text-primary">medical_information</span>
                    </div>
                </div>
                <h2 class="text-slate-900 text-3xl font-extrabold leading-tight tracking-tight mb-4 uppercase">
                    Puskesmas Digital
                </h2>
                <p class="text-slate-700 text-lg leading-relaxed">
                    SI CUBIT memudahkan Bidan dan Tenaga Kesehatan untuk memvalidasi data kesehatan Ibu dan Anak secara
                    *real-time* di wilayah Kota Banjarbaru.
                </p>
            </div>
            <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-80 h-80 bg-primary/20 rounded-full blur-3xl"></div>
        </div>

        <div
            class="w-full lg:w-1/2 flex flex-col items-center justify-center px-6 md:px-12 lg:px-24 bg-white dark:bg-background-dark">
            <div class="w-full max-w-[440px]">
                <header class="flex flex-col items-start gap-6 mb-10">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/30">
                            <span class="material-symbols-outlined">baby_changing_station</span>
                        </div>
                        <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold">SI CUBIT</h2>
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-slate-900 dark:text-slate-100 text-4xl font-black italic">Selamat Datang</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-base">Silakan masuk untuk mengakses Dashboard
                            Petugas.</p>
                    </div>
                </header>

                <form action="<?= base_url('admin/dashboard') ?>" class="flex flex-col gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 dark:text-slate-100 text-sm font-semibold" for="email">ID Petugas /
                            Email</label>
                        <div class="relative flex items-stretch">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">badge</span>
                            </div>
                            <input
                                class="form-input flex w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:border-primary focus:ring-4 focus:ring-primary/10 h-14 pl-12 pr-4 text-slate-900 dark:text-slate-100 transition-all"
                                id="email" placeholder="NIP atau Email Institusi" required type="text" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <label class="text-slate-900 dark:text-slate-100 text-sm font-semibold"
                                for="password">Password</label>
                            <a class="text-primary text-sm font-semibold hover:underline italic"
                                href="<?= base_url('lupa-password') ?>">Lupa Password?</a>
                        </div>
                        <div class="relative flex items-stretch">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input
                                class="form-input flex w-full rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:border-primary focus:ring-4 focus:ring-primary/10 h-14 pl-12 pr-12 text-slate-900 dark:text-slate-100 transition-all"
                                id="password" placeholder="••••••••" required type="password" />
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400" type="button">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </div>
                    </div>

                    <form id="adminLoginForm" class="flex flex-col gap-6">
                        <button id="btnSubmit" type="submit" ...>Masuk ke Dashboard</button>
                    </form>
                </form>

                <footer class="mt-12 text-center">
                    <p class="text-slate-500 dark:text-slate-400 text-sm italic">
                        Bukan Petugas? <a class="text-primary font-bold hover:underline"
                            href="<?= base_url('login') ?>">Masuk sebagai Bunda</a>
                    </p>
                    <div
                        class="mt-8 flex items-center justify-center gap-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                        <span>POLTEKKES</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script>
        // Script Loader tetap disertakan agar transisi mulus
        document.addEventListener("DOMContentLoaded", () => {
            const loader = document.getElementById("page-loader");
            window.addEventListener("load", () => {
                setTimeout(() => {
                    loader.style.opacity = "0";
                    setTimeout(() => { loader.style.display = "none"; }, 500);
                }, 800);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const formData = new FormData(this);

        btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Memvalidasi...';
        btn.disabled = true;

        try {
            const response = await fetch('<?= base_url('api/admin/login') ?>', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Akses Diberikan',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '<?= base_url('admin/dashboard') ?>';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Masuk',
                    text: result.message,
                    confirmButtonColor: '#1a1ab7'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error Sistem',
                text: 'Gagal terhubung ke server.'
            });
        } finally {
            btn.innerHTML = 'Masuk ke Dashboard';
            btn.disabled = false;
        }
    });

    // Fitur Toggle Password
    const togglePassword = (el) => {
        const input = el.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            el.innerHTML = '<span class="material-symbols-outlined text-[20px]">visibility_off</span>';
        } else {
            input.type = 'password';
            el.innerHTML = '<span class="material-symbols-outlined text-[20px]">visibility</span>';
        }
    };
</script>
</body>

</html>