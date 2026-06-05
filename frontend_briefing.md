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

## 6. Laporan Pembaruan Backend (5 Commit Terakhir)
Sebagai referensi bagi tim Frontend, berikut adalah rincian API, daftar file yang diubah/ditambah, dan perubahan database selama 5 commit terakhir untuk mendukung implementasi UI/UX:

### 1. `6a34808` - docs: sync frontend briefing with db migration design
- **Tujuan:** Sinkronisasi dokumen *briefing* dan merapikan struktur database migration.
- **File Diubah/Ditambah:**
  - `[NEW]` `app/Database/Migrations/2026-06-01-000000_CreateSiCubitDatabase.php`
  - `[NEW]` `app/Database/Seeds/SiCubitSeeder.php`
  - `[MODIFY]` `app/Database/Seeds/DatabaseSeeder.php`
  - `[NEW/UPDATE]` `frontend_briefing.md`
  - `[DELETE]` Belasan file migration lama dihapus.
- **Update Migration:** Semua file migration lama telah dikonsolidasikan (digabung) menjadi satu file `CreateSiCubitDatabase.php` untuk mempermudah *setup* awal aplikasi.

### 2. `14915f1` - fix: correct view path for welcome screen
- **Tujuan:** Memperbaiki *bug* pada rute *view* otentikasi.
- **File Diubah/Ditambah:**
  - `[MODIFY]` `app/Controllers/Auth.php` (mengubah path `welcome` menjadi `auth/welcome`)
- **Update Migration:** - (Tidak ada)

### 3. `0922249` - feat: add data bayi, kondisi kejiwaan ibu, status kehamilan users, etc.
- **Tujuan:** Mengimplementasikan form kuesioner baru dari revisi UI/UX (Data Bayi, Kejiwaan Ibu, Kelancaran ASI).
- **File Diubah/Ditambah:**
  - `[NEW]` `app/Controllers/Actions/DataBayiAction.php` & `KondisiKejiwaanAction.php`
  - `[NEW]` `app/Models/DataBayiModel.php` & `KondisiKejiwaanIbuModel.php`
  - `[MODIFY]` `app/Controllers/Actions/DataEntryAction.php`
- **Update Migration:** 
  - Penambahan kolom `status_kehamilan` pada tabel `users`.
  - Pembuatan tabel baru `data_bayi` dan `kondisi_kejiwaan_ibu`.
  - Penambahan kolom indikator kualitatif & kuantitatif kelancaran ASI pada tabel `cek_kelancaran_asi`.
  - Update opsi Enum pada `kondisi_puting`.

### 4. `0c339c8` - update all main user feature
- **Tujuan:** Menambahkan kerangka dasar (view & controller) untuk seluruh fitur utama pengguna di aplikasi.
- **File Diubah/Ditambah:**
  - `[NEW]` Lebih dari 20 file view dasar di folder `app/Views/` (Dashboard, Edukasi, Chat, Profil, Laktasi, dll).
  - `[NEW]` `app/Controllers/Dashboard.php`, `Edukasi.php`, `Chat.php`, `Profil.php`, `Laktasi.php`, `Riwayat.php`, `Admin.php`.
  - `[NEW]` `app/Controllers/Actions/ChatAction.php` & `ProfilAction.php`.
  - `[MODIFY]` `app/Config/Routes.php` (menambahkan lebih dari 100 rute backend/frontend).
- **Update Migration:** - (Tidak ada penambahan database pada commit ini)

### 5. `4ac9f5b` - feat: setup backend auth, role, and edukasi feature APIs
- **Tujuan:** Menyiapkan fitur Autentikasi (login/register), manajemen Role pengguna, dan API konten Edukasi.
- **File Diubah/Ditambah:**
  - `[NEW]` `app/Controllers/Actions/AdminContentAction.php` & `ContentAction.php`.
  - `[NEW]` `app/Models/ArtikelModel.php` & `VideoModel.php`.
  - `[NEW]` `app/Database/Seeds/UserSeeder.php`.
  - `[MODIFY]` `app/Controllers/Actions/AuthAction.php` & `DataReadAction.php`.
- **Update Migration:** 
  - Pembuatan tabel `users`, `artikel`, dan `video`. 
  - Perubahan nama tabel dari `ibu` menjadi `users` beserta pembaruan relasi *foreign key*.

> **Kesimpulan:** 
> Seluruh rute (endpoint) dan logika penyimpanan data ke database **sudah siap**. Tim Frontend hanya perlu memanggil *endpoint* yang tepat (seperti `DataBayiAction` dan `KondisiKejiwaanAction`) serta menyesuaikan format data (payload) yang dikirim agar sesuai dengan skema tabel.
