<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col h-screen w-full bg-slate-50 dark:bg-slate-900 relative">

    <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 px-4 py-3 md:px-8 md:py-4 flex items-center justify-between flex-shrink-0 z-20 shadow-sm">
        <div class="flex items-center gap-3 md:gap-4">
            <a href="<?= base_url('dashboard') ?>" class="md:hidden size-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100">
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

    <div class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 space-y-6" id="chatContainer">
        
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
                        Halo Bunda! 👋 Saya Bidan AI dari SI CUBIT. Ada yang bisa saya bantu terkait kehamilan atau kelancaran ASI si kecil hari ini?
                    </p>
                </div>
                <span class="text-[10px] text-slate-400 mt-1 ml-1 block" id="time-start"></span>
            </div>
        </div>

    </div>

    <div class="bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 p-3 flex-shrink-0 z-20">
        <form id="chatForm" class="max-w-4xl mx-auto relative flex items-center gap-2">
            
            <button type="button" class="size-11 md:size-12 flex-shrink-0 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition border border-slate-100">
                <span class="material-symbols-outlined">attach_file</span>
            </button>

            <div class="flex-1 relative flex items-center">
                <input type="text" id="chatInput" name="message" class="w-full bg-white dark:bg-slate-800 border-2 border-primary/20 dark:border-slate-700 rounded-full pl-5 pr-12 py-3 md:py-3.5 text-sm text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all shadow-sm" placeholder="Ketik keluhan Bunda di sini..." required autocomplete="off">
            </div>

            <button type="submit" id="btnSend" class="size-11 md:size-12 flex-shrink-0 rounded-2xl bg-primary text-white flex items-center justify-center hover:bg-primary-dark transition shadow-md shadow-blue-200 active:scale-95 pl-1 disabled:opacity-50">
                <span class="material-symbols-outlined">send</span>
            </button>

        </form>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const chatContainer = document.getElementById("chatContainer");
    const chatForm = document.getElementById("chatForm");
    const chatInput = document.getElementById("chatInput");
    const btnSend = document.getElementById("btnSend");

    // Set waktu chat awal
    document.getElementById("time-start").innerText = getCurrentTime();

    // Fungsi mendapatkan waktu HH:MM
    function getCurrentTime() {
        const now = new Date();
        return now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0') + ' WITA';
    }

    // Fungsi scroll ke bawah
    function scrollToBottom() {
        chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior: 'smooth' });
    }

    // Render Chat User (Bunda)
    function appendUserMessage(message) {
        const html = `
            <div class="flex gap-3 max-w-[85%] md:max-w-[70%] ml-auto justify-end mb-4">
                <div>
                    <div class="bg-primary text-white p-3 md:p-4 rounded-t-2xl rounded-bl-2xl rounded-br-sm shadow-md">
                        <p class="text-sm leading-relaxed">${message}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 mt-1 mr-1 block text-right">${getCurrentTime()}</span>
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    // Render Chat Bidan AI
    function appendAIMessage(message, time) {
        const html = `
            <div class="flex gap-3 max-w-[85%] md:max-w-[70%] mb-4">
                <div class="size-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center text-white text-xs mt-auto mb-1 hidden md:flex">
                    <span class="material-symbols-outlined text-[16px] font-variation-fill">smart_toy</span>
                </div>
                <div>
                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-3 md:p-4 rounded-t-2xl rounded-br-2xl rounded-bl-sm shadow-sm">
                        <p class="text-sm text-slate-700 dark:text-slate-200 leading-relaxed">${message}</p>
                    </div>
                    <span class="text-[10px] text-slate-400 mt-1 ml-1 block">${time}</span>
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    // Render Indikator Mengetik
    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const html = `
            <div id="${id}" class="flex gap-3 max-w-[85%] md:max-w-[70%] mb-4">
                <div class="size-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center text-white text-xs mt-auto mb-1 hidden md:flex">
                    <span class="material-symbols-outlined text-[16px] font-variation-fill">smart_toy</span>
                </div>
                <div>
                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-4 rounded-t-2xl rounded-br-2xl rounded-bl-sm shadow-sm flex gap-1">
                        <div class="size-2 bg-slate-300 rounded-full animate-bounce"></div>
                        <div class="size-2 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="size-2 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
        return id;
    }

    // Event Submit Form Chat
    chatForm.addEventListener("submit", async function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;

        // 1. Tampilkan pesan user
        appendUserMessage(message);
        
        // 2. Kosongkan input & matikan tombol
        chatInput.value = '';
        btnSend.disabled = true;

        // 3. Tampilkan efek AI sedang mengetik
        const typingId = appendTypingIndicator();

        try {
            // 4. Kirim ke Backend API
            const formData = new FormData();
            formData.append('message', message);

            const response = await fetch('<?= base_url('api/chat/send') ?>', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            // 5. Hapus indikator mengetik
            document.getElementById(typingId).remove();

            // 6. Tampilkan balasan AI
            if (result.status === 'success') {
                appendAIMessage(result.message, getCurrentTime());
            }

        } catch (error) {
            document.getElementById(typingId).remove();
            appendAIMessage("Maaf Bunda, Bidan AI sedang mengalami gangguan koneksi. Coba lagi nanti ya.", getCurrentTime());
        } finally {
            btnSend.disabled = false;
            chatInput.focus();
        }
    });
});
</script>

<?= $this->endSection() ?>