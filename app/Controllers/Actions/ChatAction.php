<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ChatAction extends BaseController
{
    public function sendMessage(): ResponseInterface
    {
        $pesanBunda = $this->request->getPost('message');

        // Validasi jika pesan kosong
        if (empty($pesanBunda)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Pesan tidak boleh kosong.',
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Panggil fungsi untuk menembak API Gemini
        $balasanAI = $this->askGemini($pesanBunda);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => $balasanAI,
            'time'    => date('H:i') . ' WIB'
        ]);
    }

    private function askGemini(string $pesan): string
    {
        // Mengambil API Key dari file .env
        $apiKey = getenv('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            return "Maaf Bunda, sistem Bidan AI belum dikonfigurasi. Pastikan GEMINI_API_KEY sudah ditambahkan di file .env ya.";
        }

        // Endpoint Gemini 1.5 Flash (Cepat & Pintar)
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

        // Context / Persona Bidan (System Instruction)
        $systemPrompt = "Kamu adalah 'Bidan AI' dari aplikasi SI CUBIT (Sistem Informasi Catatan Ibu Bayi Terintegrasi). 
        Tugasmu membantu ibu hamil dan menyusui. 
        Gunakan sapaan 'Bunda'. 
        Jawablah dengan ramah, empatik, suportif, dan menggunakan bahasa Indonesia yang santai tapi profesional. 
        Berikan jawaban yang ringkas, mudah dipahami, dan langsung ke intinya (maksimal 2-3 paragraf pendek). 
        Jika ada kondisi medis darurat atau berbahaya, sarankan untuk segera periksa ke dokter kandungan atau puskesmas.";

        // Format Payload sesuai standar Gemini API
        $payload = [
            "system_instruction" => [
                "parts" => [
                    ["text" => $systemPrompt]
                ]
            ],
            "contents" => [
                [
                    "parts" => [
                        ["text" => $pesan]
                    ]
                ]
            ],
            // Pengaturan suhu (0.0 kaku/pasti, 1.0 kreatif). 0.7 pas untuk asisten virtual.
            "generationConfig" => [
                "temperature" => 0.7,
                "maxOutputTokens" => 500
            ]
        ];

        try {
            // Gunakan CURL Request bawaan CI4
            $client = \Config\Services::curlrequest();
            $response = $client->post($url, [
                'json'    => $payload,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'timeout' => 15,
                
                // KUNCI UTAMA AGAR JALAN DI LOCALHOST XAMPP (Mengabaikan cek SSL)
                'verify'  => false 
            ]);

            $result = json_decode($response->getBody(), true);

            // Ekstrak teks balasan dari struktur JSON Gemini
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $result['candidates'][0]['content']['parts'][0]['text'];
                
                // Merapikan format teks bawaan AI (Markdown) agar sesuai dengan HTML
                $reply = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $reply); // Ubah **Teks** jadi Bold
                $reply = preg_replace('/\\*(.*?)\\*/', '<em>$1</em>', $reply);           // Ubah *Teks* jadi Italic
                $reply = nl2br(trim($reply));                                            // Ubah Enter jadi <br>

                return $reply;
            }

            return "Maaf Bunda, Bidan AI sedang kebingungan merespon. Bisa diulangi pertanyaannya?";

        } catch (\Exception $e) {
            // Menulis error ke log CodeIgniter (writable/logs) untuk keperluan debugging
            log_message('error', 'Gemini API Error: ' . $e->getMessage());
            
            // Pesan error yang aman untuk ditampilkan ke user
            return "Maaf Bunda, server Bidan AI sedang sibuk atau ada gangguan koneksi. Coba lagi beberapa saat ya.";
        }
    }
}