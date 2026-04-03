<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<style type="text/tailwindcss">
    .admin-gradient {
        background: radial-gradient(circle at top right, #f8fafc 0%, #e2e8f0 100%);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="min-h-screen admin-gradient flex items-center justify-center p-6">
    <div class="w-full max-w-lg">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center size-20 bg-amber-500 rounded-3xl shadow-xl shadow-amber-200 mb-4 text-white">
                <span class="material-symbols-outlined text-5xl font-variation-fill">lock_reset</span>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pemulihan <span class="text-amber-600">Akun</span></h1>
            <p class="text-slate-500 mt-2 font-medium italic">Atur ulang akses masuk Petugas Kesehatan</p>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-slate-200/50">
            <div class="mb-8 text-center md:text-left">
                <h2 class="text-xl font-bold text-slate-800">Masalah Masuk?</h2>
                <p class="text-sm text-slate-400 mt-1 leading-relaxed">Masukkan NIP atau Email resmi Anda. Kami akan mengirimkan instruksi pemulihan ke sistem Puskesmas.</p>
            </div>

            <form onsubmit="event.preventDefault(); alert('Instruksi pemulihan telah dikirim ke Email Institusi Anda. Silakan cek kotak masuk.'); window.location.href='<?= base_url('admin/login') ?>';" class="space-y-6">
                
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-slate-400 tracking-widest ml-2 italic">NIP / Email Resmi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">alternate_email</span>
                        <input type="text" placeholder="contoh: 19900101XXXXXXXX" class="w-full pl-12 pr-5 py-4 bg-slate-50 border-0 rounded-2xl text-sm focus:ring-2 focus:ring-amber-500/20 placeholder:text-slate-300" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                        Kirim Instruksi
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-100">
                <a href="<?= base_url('admin/login') ?>" class="text-[11px] font-bold text-slate-400 hover:text-primary transition-all flex items-center justify-center gap-1 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span> Kembali ke Login
                </a>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-400 mt-8">
            Puskesmas Digital • Kota Banjarbaru &copy; 2024. All rights reserved.
        </p>
    </div>
</div>

<?= $this->endSection() ?>