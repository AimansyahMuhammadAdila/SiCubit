# Briefing Frontend: Implementasi Revisi UI/UX SiCubit

Dokumen ini berisi panduan dan instruksi tugas untuk tim Frontend, berdasarkan revisi terbaru. Tim Backend telah menyelesaikan pembuatan API dan struktur database, sehingga tugas Frontend sekarang adalah membuat tampilan antarmuka (UI) dan mengintegrasikan form input dengan endpoint backend yang sudah ada.

---

## 1. Pembaruan Alur Pengguna (User Flow)
**Referensi Revisi:** Poin C
- **Tugas Utama:** Frontend perlu memisahkan alur pengguna (UI state) untuk membedakan tahap "Kehamilan" dan "Pasca Melahirkan".
- **Implementasi:**
  - Buat alur step-by-step (misalnya berbentuk *wizard* atau halaman *onboarding* profil) agar pengguna melalui fase pra-kehamilan, kehamilan, hingga pasca melahirkan.
  - Tampilan dashboard dan menu harus disesuaikan berdasarkan **status kehamilan** pengguna (data status ini sudah tersedia dari API backend).

## 2. Fitur Alarm / Notifikasi
**Referensi Revisi:** Poin D
- **Tugas Utama:** Membuat sistem pengingat otomatis di sisi aplikasi (atau push notification).
- **Implementasi:**
  - Buat fitur alarm/notifikasi berulang **setiap 2 jam** yang bertugas mengingatkan ibu untuk menyusui bayi.
  - Tambahkan antarmuka (tombol/toggle) bagi pengguna untuk menghidupkan atau mematikan pengingat ini di pengaturan profil.

## 3. Pembaruan Form: Data Bayi & Kelancaran ASI
**Referensi Revisi:** Poin E, F, G
Pada halaman/form "Data Bayi" dan "Kelancaran ASI", tambahkan inputan (field) berikut:
- **Identitas & Fisik Bayi:**
  - Data Bayi yang dilahirkan (Bisa berupa input teks nama/status kelahiran)
  - Golongan Darah (Gunakan `Dropdown Select` atau `Radio Button`)
  - Berat Badan (Gunakan `Input Number` dengan satuan gram/kg)
  - Panjang Badan (Gunakan `Input Number` dengan satuan cm)
  - Lingkar Kepala, Lingkar Dada, Lingkar Lengan Atas (Gunakan `Input Number` satuan cm)
  - Suhu Bayi (Gunakan `Input Number` satuan °C)
- **Refleks Bayi (Gunakan `Checkbox` atau `Radio Button Ya/Tidak`):**
  - Reflek mencari puting (Rooting reflex)
  - Reflek mengisap
  - Reflek menelan

## 4. Pembaruan Form: Kondisi Kejiwaan Ibu (Assessment)
**Referensi Revisi:** Poin H (1-5)
Buat halaman kuesioner/assessment baru (bisa berupa form berurut atau *cards*) dengan opsi jawaban `Ya / Tidak` atau skala likert, untuk pertanyaan berikut:
1. Apakah ibu merasa khawatir yang berlebihan?
2. Apakah ibu merasakan ketegangan fisik berikut? *(Gunakan multiple Checkbox)*:
   - Gelisah
   - Gemetar
   - Tidak dapat rileks
   - Ketegangan otot
   - Sakit kepala
   - Jantung berdebar
   - Berkeringat berlebihan
   - Sesak napas
   - Kepala terasa ringan
   - Keluhan tidak nyaman di perut bagian atas sekitar ulu hati
3. Apakah ibu merasa lelah berkepanjangan, tapi sulit untuk tidur?
4. Apakah ibu mudah tersinggung dan marah?
5. Apakah ibu mengalami perubahan hubungan dengan suami?

## 5. Pembaruan Form: Cek Kelancaran Menyusui
**Referensi Revisi:** Poin H (6-10)
Tambahkan form input untuk pemantauan harian kelancaran ASI dengan field berikut:
- **Indikator Kuantitatif (Gunakan `Input Number`):**
  - Frekuensi menyusui (kali/hari) - *Target: 8-12 kali*
  - Lama menyusui per sesi (menit) - *Target: 5-10 menit*
  - Frekuensi BAB bayi (kali/hari) - *Target: 3-5 kali*
  - Frekuensi BAK bayi (kali/hari) - *Target: 6-8 kali*
  - Hasil Pumping (ml per sesi) - *(Validasi target backend: 0-3 hari 5-20ml, minggu 1 30-60ml, minggu 2 60-120ml)*
- **Indikator Kualitatif (Gunakan `Radio Button` / `Checkbox`):**
  - Bayi tidur minimal 12 jam sehari (Ya/Tidak)
  - Bayi terlihat puas dan tenang 2-3 jam setelah menyusu (Ya/Tidak)
  - Warna urine bayi pucat/jernih/tidak pekat (Ya/Tidak)
  - Payudara terasa penuh dan merembes (Ya/Tidak)
  - Berat badan naik sesuai usia (Ya/Tidak)
- **Kondisi Tambahan (Dropdown/Radio Button):**
  - Kondisi lainnya yang mendukung kelancaran ASI (`Text Area` atau `Input Text`)
  - Kondisi puting: *Tenggelam / Datar / Menonjol / Pecah-pecah*
  - Suami mengingatkan menyusui setiap 2 jam: `Ya / Tidak`
  - Suami mengingatkan makan bergizi/suplemen penambah ASI: `Ya / Tidak`

---

### Catatan untuk Frontend Developer:
- Seluruh endpoint API untuk menyimpan data di atas sudah disiapkan oleh tim Backend. Harap perhatikan _payload schema_ (nama parameter key) yang diminta saat melakukan metode POST.
- Gunakan elemen UI (seperti icon dan warna) yang memberikan kenyamanan psikologis (karena target pengguna adalah ibu hamil & menyusui).
- Pastikan input angka (_number_) divalidasi agar tidak dapat menerima huruf atau nilai negatif.

---

## 6. Status Kesiapan Backend (Berdasarkan 4 Commit Terakhir)
Sebagai referensi bagi tim Frontend, berikut adalah rincian API dan pekerjaan Backend yang **sudah diselesaikan** untuk mendukung implementasi di atas:

### A. Setup Autentikasi, Role, dan API Konten Edukasi (`4ac9f5b`)
- **Database:** Pembuatan tabel `users`, `artikel`, dan `video`. Perubahan relasi (foreign key) dari tabel `ibu` ke tabel `users`.
- **API:** Menyiapkan `AuthAction` (login/register & role), `AdminContentAction` & `ContentAction` (mengelola artikel dan video), serta `DataReadAction` & `DataEntryAction` (riwayat kehamilan & persalinan).
- **Seeder:** Menambahkan *dummy data* awal.

### B. Pembuatan Fitur-fitur Utama Pengguna (`0c339c8`)
- **Routing:** Memperbarui file konfigurasi `Routes.php` (menambahkan lebih dari 100 rute/endpoint baru).
- **Controllers & Logika:** Menambahkan controller untuk halaman `Admin`, `Auth`, `Dashboard`, `Chat`, `Edukasi`, `Laktasi`, `Profil`, dan `Riwayat`. Menambahkan fungsi logika pada `ChatAction` dan `ProfilAction`.
- **Views:** Menyertakan puluhan file _view_ dasar untuk semua fitur di atas (sebagai kerangka awal frontend).

### C. Penambahan Data Bayi, Kejiwaan Ibu & Kelancaran ASI (`0922249`)
- **Migrasi Database:** 
  - Penambahan kolom `status_kehamilan` pada tabel `users`.
  - Pembuatan tabel `data_bayi` dan `kondisi_kejiwaan_ibu`.
  - Penambahan kolom indikator kelancaran ASI pada tabel `cek_kelancaran_asi`.
  - Update Enum kondisi puting.
- **API & Model:** Pembuatan `DataBayiAction`, `DataBayiModel`, `KondisiKejiwaanAction`, dan `KondisiKejiwaanIbuModel` untuk menerima dan menyimpan data dari frontend. `DataEntryAction` telah dimodifikasi agar menyatu dengan alur ini.

### D. Perbaikan Jalur View (`14915f1`)
- **Bugfix:** Memperbaiki jalur folder *view* di dalam `Auth.php` yang tadinya mengarah langsung ke `welcome` menjadi `auth/welcome`.

> **Kesimpulan:** 
> Seluruh rute (endpoint) dan logika penyimpanan data ke database **sudah siap**. Tim Frontend hanya perlu memanggil *endpoint* yang tepat (seperti `DataBayiAction` dan `KondisiKejiwaanAction`) serta menyesuaikan format data (payload) yang dikirim agar sesuai dengan skema Backend.
