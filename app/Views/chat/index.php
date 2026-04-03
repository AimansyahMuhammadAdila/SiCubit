<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-full w-full bg-slate-50 dark:bg-slate-900 relative">

    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 px-4 py-3 md:px-8 md:py-4 flex items-center justify-between flex-shrink-0 z-20 shadow-sm">
        <div class="flex items-center gap-3 md:gap-4">
            <a href="<?= base_url('/') ?>" class="md:hidden size-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            
            <div class="relative">
                <div class="size-10 md:size-12 rounded-full bg-gradient-to-br from-primary to-blue-400 flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined font-variation-fill">smart_toy</span>
                </div>
                <div class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
            </div>
            
            <div>
                <h1 class="font-bold text-base md:text-lg text-slate-800 dark:text-white leading-tight">Bidan AI</h1>
                <p class="text-[10px] md:text-xs text-green-500 font-medium flex items-center gap-1">
                    Selalu aktif membantu Bunda
                </p>
            </div>
        </div>
        
        <button class="text-slate-400 hover:text-primary transition p-2">
            <span class="material-symbols-outlined">more_vert</span>
        </button>
    </header>

    <div class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 space-y-6" id="chat-container">
        
        <div class="flex justify-center">
            <span class="bg-slate-200/50 dark:bg-slate-800 text-slate-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                Hari ini
            </span>
        </div>

        <div class="flex gap-3 max-w-[85%] md:max-w-[70%]">
            <div class="size-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center text-white text-xs mt-auto mb-1 hidden md:flex">
                <span class="material-symbols-outlined text-[16px] font-variation-fill">smart_toy</span>
            </div>
            <div>
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 md:p-4 rounded-t-2xl rounded-br-2xl rounded-bl-sm shadow-sm">
                    <p class="text-sm text-slate-700 dark:text-slate-200 leading-relaxed">
                        Halo Bunda Sarah! 👋 Saya Bidan AI dari SI CUBIT. Ada yang bisa saya bantu terkait kehamilan atau kelancaran ASI si kecil hari ini?
                    </p>
                </div>
                <span class="text-[10px] text-slate-400 mt-1 ml-1 block">08:00 WIB</span>
            </div>
        </div>

        <div class="flex gap-3 max-w-[85%] md:max-w-[70%] ml-auto justify-end">
            <div>
                <div class="bg-primary text-white p-3 md:p-4 rounded-t-2xl rounded-bl-2xl rounded-br-sm shadow-md">
                    <p class="text-sm leading-relaxed">
                        Pagi bidan, akhir-akhir ini ASI saya rasanya kurang lancar dan payudara agak bengkak. Harus gimana ya?
                    </p>
                </div>
                <span class="text-[10px] text-slate-400 mt-1 mr-1 block text-right">08:05 WIB</span>
            </div>
        </div>

        <div class="flex gap-3 max-w-[85%] md:max-w-[70%]">
            <div class="size-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center text-white text-xs mt-auto mb-1 hidden md:flex">
                <span class="material-symbols-outlined text-[16px] font-variation-fill">smart_toy</span>
            </div>
            <div>
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 md:p-4 rounded-t-2xl rounded-br-2xl rounded-bl-sm shadow-sm">
                    <p class="text-sm text-slate-700 dark:text-slate-200 leading-relaxed mb-3">
                        Jangan panik ya Bunda, payudara bengkak saat menyusui (engorgement) wajar terjadi. Berikut beberapa langkah awal yang bisa Bunda coba:
                    </p>
                    <ul class="text-sm text-slate-700 dark:text-slate-200 space-y-2 list-disc pl-4">
                        <li>Kompres payudara dengan air hangat sebelum menyusui.</li>
                        <li>Susui si kecil lebih sering, minimal 2-3 jam sekali.</li>
                        <li>Pastikan posisi pelekatan (latch on) bayi sudah benar.</li>
                    </ul>
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-slate-700 rounded-xl flex items-center gap-3 cursor-pointer hover:bg-blue-100 transition">
                        <div class="size-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center"><span class="material-symbols-outlined">play_circle</span></div>
                        <div>
                            <p class="text-xs font-bold text-slate-800 dark:text-white">Video: Cara Kompres & Pijat Payudara</p>
                            <p class="text-[10px] text-slate-500">Ketuk untuk menonton</p>
                        </div>
                    </div>
                </div>
                <span class="text-[10px] text-slate-400 mt-1 ml-1 block">08:06 WIB</span>
            </div>
        </div>

        </div>

    <div class="bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 p-3 flex-shrink-0 z-20">
        <form action="#" method="POST" class="max-w-4xl mx-auto relative flex items-center gap-2">
            
            <button type="button" class="size-11 md:size-12 flex-shrink-0 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition border border-slate-100">
                <span class="material-symbols-outlined">attach_file</span>
            </button>

            <div class="flex-1 relative flex items-center">
                <input type="text" class="w-full bg-white dark:bg-slate-800 border-2 border-primary/20 dark:border-slate-700 rounded-full pl-5 pr-12 py-3 md:py-3.5 text-sm text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all shadow-sm" placeholder="Tanyakan keluhan Bunda di sini...">
                
                <button type="button" class="absolute right-2 size-8 flex items-center justify-center text-slate-400 hover:text-primary transition">
                    <span class="material-symbols-outlined">mic</span>
                </button>
            </div>

            <button type="submit" class="size-11 md:size-12 flex-shrink-0 rounded-2xl bg-primary text-white flex items-center justify-center hover:bg-primary-dark transition shadow-md shadow-blue-200 active:scale-95 pl-1">
                <span class="material-symbols-outlined">send</span>
            </button>

        </form>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatContainer = document.getElementById("chat-container");
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
</script>

<?= $this->endSection() ?>