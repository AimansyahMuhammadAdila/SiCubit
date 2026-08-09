<?php

namespace App\Controllers;

use App\Libraries\GoogleSheetsService;
use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\KategoriVideoModel;
use App\Models\SettingModel;
use App\Models\VideoModel;

class Admin extends BaseController
{
    protected SettingModel $settingModel;
    protected GoogleSheetsService $sheetsService;

    public function __construct()
    {
        // PROTEKSI: Jika bukan admin, tendang ke login admin
        if (!session()->get('is_admin')) {
            header('Location: ' . base_url('admin/login'));
            exit;
        }

        $this->settingModel = new SettingModel();
        $this->sheetsService = new GoogleSheetsService();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Statistik Dinamis
        $data = [
            'title'              => 'Panel Kendali Bidan - SI CUBIT',
            'totalIbu'           => $db->table('users')->whereIn('role', ['user', 'ibu'])->countAllResults(),
            'perluCek'           => $db->table('riwayat_kehamilan')->countAllResults(),
            'resikoTinggi'       => $db->table('kondisi_kejiwaan_ibu')
                                       ->groupStart()
                                           ->where('status_kejiwaan', 'Berisiko')
                                           ->orWhere('epds_skor >=', 10)
                                       ->groupEnd()
                                       ->countAllResults(),
            'users'              => $this->getLatestUsers(),
            'google_webhook_url' => $this->settingModel->getVal('google_webhook_url', ''),
            'google_sheet_url'   => $this->settingModel->getVal('google_sheet_url', ''),
            'last_synced_at'     => $this->settingModel->getVal('last_synced_at', '-'),
            'apps_script_code'   => GoogleSheetsService::getAppsScriptCode()
        ];

        return view('admin/dashboard', $data);
    }

    public function dataIbu()
    {
        $db = \Config\Database::connect();
        $data = [
            'title'              => 'Data Ibu & Anak - SI CUBIT',
            'users'              => $this->getLatestUsers(),
            'wilayah'            => $db->table('kabupaten_kota')->orderBy('nama', 'ASC')->get()->getResultArray(),
            'puskesmas'          => $db->table('puskesmas')->orderBy('nama', 'ASC')->get()->getResultArray(),
            'google_webhook_url' => $this->settingModel->getVal('google_webhook_url', ''),
            'google_sheet_url'   => $this->settingModel->getVal('google_sheet_url', ''),
            'last_synced_at'     => $this->settingModel->getVal('last_synced_at', '-'),
            'apps_script_code'   => GoogleSheetsService::getAppsScriptCode()
        ];
        return view('admin/data_ibu', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        
        // Find user by id
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ibu tidak ditemukan.");
        }
        
        // Find Puskesmas & Kabkota names
        $puskesmas = $db->table('puskesmas')->where('id', $user['id_puskesmas'])->get()->getRowArray();
        $kabkota = $db->table('kabupaten_kota')->where('id', $user['id_kabkota'])->get()->getRowArray();
        $user['nama_puskesmas'] = $puskesmas['nama'] ?? '-';
        $user['nama_kabkota'] = $kabkota['nama'] ?? '-';

        // Retrieve historical checks
        $asiModel = new \App\Models\AsiModel();
        $kejiwaanModel = new \App\Models\KondisiKejiwaanIbuModel();
        $dataBayiModel = new \App\Models\DataBayiModel();
        $persalinanModel = new \App\Models\RiwayatPersalinanModel();
        $kehamilanModel = new \App\Models\RiwayatKehamilanModel();
        $praKehamilanModel = new \App\Models\RiwayatPraKehamilanModel();

        $data = [
            'title' => 'Detail Informasi Ibu - SI CUBIT',
            'user' => $user,
            'riwayat_asi' => $asiModel->getByUser($id),
            'riwayat_kejiwaan' => $kejiwaanModel->getByUser($id),
            'riwayat_bayi' => $dataBayiModel->getByUser($id),
            'persalinan' => $persalinanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
            'kehamilan' => $kehamilanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
            'pra_kehamilan' => $praKehamilanModel->where('user_id', $id)->orderBy('tgl_pengisian', 'DESC')->first(),
        ];
        
        return view('admin/detail_ibu', $data);
    }

    /**
     * AJAX Endpoint Simpan URL Webhook & Link Google Sheets
     */
    public function saveSheetsConfig()
    {
        $webhookUrl = trim($this->request->getPost('google_webhook_url') ?? '');
        $sheetUrl   = trim($this->request->getPost('google_sheet_url') ?? '');

        $this->settingModel->setVal('google_webhook_url', $webhookUrl);
        $this->settingModel->setVal('google_sheet_url', $sheetUrl);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Pengaturan Google Sheets berhasil disimpan!'
        ]);
    }

    /**
     * AJAX Endpoint Sinkronisasi Data ke Google Sheets
     */
    public function syncGoogleSheets()
    {
        $result = $this->sheetsService->syncToWebhook();
        return $this->response->setJSON($result);
    }

    /**
     * Download File Excel Spreadsheet Bulanan (.xls)
     */
    public function exportSpreadsheet()
    {
        $exportData = $this->sheetsService->getMonthlyExportData();
        $sheetName = $exportData['sheet_name'];
        $filename = "Rekap_SiCubit_" . str_replace(' ', '_', $sheetName) . ".xls";

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
        echo '<x:Name>' . htmlspecialchars($sheetName) . '</x:Name>';
        echo '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
        echo '<body>';

        // Title Header & KPI Summary
        echo '<table border="0" style="font-family: Arial, sans-serif; font-size: 11pt;">';
        echo '<tr><td colspan="12" style="font-size: 16pt; font-weight: bold; color: #0F172A;">MONITORING KESEHATAN IBU & ANAK (SI CUBIT) - ' . strtoupper(htmlspecialchars($sheetName)) . '</td></tr>';
        echo '<tr><td colspan="12" style="font-size: 10pt; color: #64748B; italic: true;">Update Terakhir: ' . htmlspecialchars($exportData['summary_stats']['last_update']) . '</td></tr>';
        echo '<tr><td colspan="12"></td></tr>';

        // KPI Summary Cards Table
        echo '<tr>';
        echo '<td colspan="3" style="background-color: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; text-align: center; padding: 10px;"><b>TOTAL IBU REGISTERED</b><br><span style="font-size: 16pt;">' . $exportData['summary_stats']['total_ibu'] . '</span></td>';
        echo '<td colspan="3" style="background-color: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; text-align: center; padding: 10px;"><b>ASI CUKUP</b><br><span style="font-size: 16pt;">' . $exportData['summary_stats']['asi_lancar'] . '</span></td>';
        echo '<td colspan="3" style="background-color: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; text-align: center; padding: 10px;"><b>KEJIWAAN BERISIKO</b><br><span style="font-size: 16pt;">' . $exportData['summary_stats']['kejiwaan_berisiko'] . '</span></td>';
        echo '<td colspan="3"></td>';
        echo '</tr>';
        echo '<tr><td colspan="12"></td></tr>';

        // Main Table Headers
        echo '<tr style="background-color: #0F172A; color: #FFFFFF; font-weight: bold; text-align: center; height: 35px;">';
        foreach ($exportData['headers'] as $h) {
            echo '<th style="border: 1px solid #334155; padding: 8px;">' . htmlspecialchars($h) . '</th>';
        }
        echo '</tr>';

        // Rows
        foreach ($exportData['rows'] as $idx => $r) {
            $bgColor = ($idx % 2 === 1) ? '#F8FAFC' : '#FFFFFF';
            echo '<tr style="background-color: ' . $bgColor . ';">';
            echo '<td style="border: 1px solid #E2E8F0; text-align: center;">' . $r['no'] . '</td>';
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['tgl_daftar']) . '</td>';
            echo '<td style="border: 1px solid #E2E8F0; font-weight: bold;">' . htmlspecialchars($r['nama_ibu']) . '</td>';
            echo '<td style="border: 1px solid #E2E8F0; text-align: center;">' . htmlspecialchars($r['umur']) . '</td>';
            $noTelpFormatted = $this->formatPhoneNumber($r['no_telp']);
            echo '<td style="border: 1px solid #E2E8F0; mso-number-format:\'\@\'; text-align: left;">' . htmlspecialchars($noTelpFormatted) . '</td>';
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['puskesmas']) . '</td>';
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['kabkota']) . '</td>';
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['status_kehamilan']) . '</td>';

            // ASI Badge Style
            $asiStyle = 'background-color: #F1F5F9; color: #475569;';
            if ($r['status_asi'] === 'Cukup') {
                $asiStyle = 'background-color: #DCFCE7; color: #166534; font-weight: bold;';
            } else if (in_array($r['status_asi'], ['Kurang', 'Tidak Cukup'])) {
                $asiStyle = 'background-color: #FEE2E2; color: #991B1B; font-weight: bold;';
            }
            echo '<td style="border: 1px solid #E2E8F0; text-align: center; ' . $asiStyle . '">' . htmlspecialchars($r['status_asi']) . '</td>';

            // Kejiwaan Style
            $jiwaStyle = 'background-color: #F1F5F9; color: #475569;';
            if ($r['status_kejiwaan'] === 'Berisiko') {
                $jiwaStyle = 'background-color: #FEE2E2; color: #991B1B; font-weight: bold;';
            } else if ($r['status_kejiwaan'] === 'Normal') {
                $jiwaStyle = 'background-color: #DCFCE7; color: #166534;';
            }
            echo '<td style="border: 1px solid #E2E8F0; text-align: center; ' . $jiwaStyle . '">' . htmlspecialchars($r['status_kejiwaan']) . '</td>';

            echo '<td style="border: 1px solid #E2E8F0; text-align: center;">' . $r['jumlah_anak'] . '</td>';
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['alamat']) . '</td>';
            echo '</tr>';
        }

        echo '</table></body></html>';
        exit;
    }

    private function getLatestUsers()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.*, puskesmas.nama as nama_puskesmas, kabupaten_kota.nama as nama_kabkota');
        $builder->join('puskesmas', 'puskesmas.id = users.id_puskesmas', 'left');
        $builder->join('kabupaten_kota', 'kabupaten_kota.id = users.id_kabkota', 'left');
        $builder->whereIn('users.role', ['user', 'ibu']);
        $builder->orderBy('users.created_at', 'DESC');
        
        $users = $builder->get()->getResultArray();

        // Tambahkan status ASI terakhir
        foreach ($users as &$u) {
            $asi = $db->table('cek_kelancaran_asi')
                      ->where('user_id', $u['id'])
                      ->orderBy('tgl_pengisian', 'DESC')
                      ->get()->getRowArray();
            $u['status_asi'] = $asi['status_kecukupan_asi'] ?? 'BELUM ISI';
        }

        return $users;
    }

    private function formatPhoneNumber(?string $phone): string
    {
        if (empty($phone)) return '-';
        $cleaned = trim($phone);
        if (str_starts_with($cleaned, '62')) {
            $cleaned = '0' . substr($cleaned, 2);
        } elseif (str_starts_with($cleaned, '8')) {
            $cleaned = '0' . $cleaned;
        }
        return $cleaned;
    }

    // ---------------------------------------------------------------
    // MANAGEMENT VIDEO EDUKASI (ADMIN)
    // ---------------------------------------------------------------

    public function video()
    {
        $videoModel = new VideoModel();
        $kategoriModel = new KategoriVideoModel();
        
        $selectedKategori = $this->request->getGet('kategori');
        $searchQuery      = trim($this->request->getGet('q') ?? '');

        $builder = $videoModel->select('video.*, kategori_video.nama_kategori')
                              ->join('kategori_video', 'kategori_video.id = video.id_kategori', 'left')
                              ->orderBy('video.created_at', 'DESC');

        if (!empty($selectedKategori)) {
            $builder->where('video.id_kategori', $selectedKategori);
        }

        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('video.judul', $searchQuery)
                    ->orLike('video.deskripsi', $searchQuery)
                    ->groupEnd();
        }

        $videos = $builder->findAll();

        foreach ($videos as &$v) {
            $v['youtube_id'] = self::extractYoutubeId($v['video_url'] ?? '');
        }

        $data = [
            'title'            => 'Kelola Video Edukasi - SI CUBIT Admin',
            'videos'           => $videos,
            'categories'       => $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
            'selectedKategori' => $selectedKategori,
            'searchQuery'      => $searchQuery,
        ];

        return view('admin/video', $data);
    }

    public function videoStore()
    {
        $judul      = trim($this->request->getPost('judul') ?? '');
        $videoUrl   = trim($this->request->getPost('video_url') ?? '');
        $idKategori = $this->request->getPost('id_kategori');
        $deskripsi  = trim($this->request->getPost('deskripsi') ?? '');
        $status     = $this->request->getPost('status') ?? 'published';

        if (empty($judul) || empty($videoUrl)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Link YouTube wajib diisi!');
        }

        if (!preg_match('~^https?://~i', $videoUrl)) {
            $videoUrl = 'https://' . $videoUrl;
        }

        $youtubeId = self::extractYoutubeId($videoUrl);
        if (!$youtubeId) {
            return redirect()->back()->withInput()->with('error', 'Format URL YouTube tidak valid.');
        }

        $videoModel = new VideoModel();
        
        $adminId = session()->get('user_id') ?? session()->get('id');
        if (!$adminId) {
            $db = \Config\Database::connect();
            $adminUser = $db->table('users')->where('role', 'admin')->get()->getRowArray();
            $adminId = $adminUser['id'] ?? 1;
        }

        try {
            $saved = $videoModel->insert([
                'judul'       => $judul,
                'video_url'   => $videoUrl,
                'id_kategori' => !empty($idKategori) ? (int) $idKategori : null,
                'deskripsi'   => $deskripsi,
                'id_penulis'  => (int) $adminId,
                'status'      => $status,
            ]);

            if (!$saved) {
                $errors = $videoModel->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Gagal menyimpan data ke database.';
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error videoStore: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan server: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/video'))->with('success', 'Video edukasi berhasil ditambahkan!');
    }

    public function videoUpdate($id)
    {
        $videoModel = new VideoModel();
        $video = $videoModel->find($id);

        if (!$video) {
            return redirect()->to(base_url('admin/video'))->with('error', 'Video tidak ditemukan.');
        }

        $judul      = trim($this->request->getPost('judul') ?? '');
        $videoUrl   = trim($this->request->getPost('video_url') ?? '');
        $idKategori = $this->request->getPost('id_kategori');
        $deskripsi  = trim($this->request->getPost('deskripsi') ?? '');
        $status     = $this->request->getPost('status') ?? 'published';

        if (empty($judul) || empty($videoUrl)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Link YouTube wajib diisi!');
        }

        if (!preg_match('~^https?://~i', $videoUrl)) {
            $videoUrl = 'https://' . $videoUrl;
        }

        $youtubeId = self::extractYoutubeId($videoUrl);
        if (!$youtubeId) {
            return redirect()->back()->withInput()->with('error', 'Format URL YouTube tidak valid.');
        }

        try {
            $updated = $videoModel->update($id, [
                'judul'       => $judul,
                'video_url'   => $videoUrl,
                'id_kategori' => !empty($idKategori) ? (int) $idKategori : null,
                'deskripsi'   => $deskripsi,
                'status'      => $status,
            ]);

            if (!$updated) {
                $errors = $videoModel->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui data.';
                return redirect()->back()->withInput()->with('error', $errorMsg);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error videoUpdate: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/video'))->with('success', 'Data video berhasil diperbarui!');
    }

    public function videoDelete($id)
    {
        $videoModel = new VideoModel();
        $video = $videoModel->find($id);

        if (!$video) {
            return redirect()->to(base_url('admin/video'))->with('error', 'Video tidak ditemukan.');
        }

        $videoModel->delete($id);

        return redirect()->to(base_url('admin/video'))->with('success', 'Video berhasil dihapus!');
    }

    // ---------------------------------------------------------------
    // MANAGEMENT KATEGORI VIDEO (ADMIN)
    // ---------------------------------------------------------------

    public function kategoriVideo()
    {
        $kategoriModel = new KategoriVideoModel();
        $db = \Config\Database::connect();

        $categories = $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll();

        foreach ($categories as &$c) {
            $c['total_video'] = $db->table('video')->where('id_kategori', $c['id'])->countAllResults();
        }

        $data = [
            'title'      => 'Kelola Kategori Video - SI CUBIT Admin',
            'categories' => $categories,
        ];

        return view('admin/kategori_video', $data);
    }

    public function kategoriVideoStore()
    {
        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $deskripsi    = trim($this->request->getPost('deskripsi') ?? '');

        if (empty($namaKategori)) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi!');
        }

        $slug = url_title($namaKategori, '-', true);

        $kategoriModel = new KategoriVideoModel();
        
        $saved = $kategoriModel->insert([
            'nama_kategori' => $namaKategori,
            'slug'          => $slug,
            'deskripsi'     => $deskripsi,
        ]);

        if (!$saved) {
            $errors = $kategoriModel->errors();
            return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal menyimpan kategori.');
        }

        return redirect()->to(base_url('admin/kategori-video'))->with('success', 'Kategori video berhasil ditambahkan!');
    }

    public function kategoriVideoUpdate($id)
    {
        $kategoriModel = new KategoriVideoModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to(base_url('admin/kategori-video'))->with('error', 'Kategori tidak ditemukan.');
        }

        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $deskripsi    = trim($this->request->getPost('deskripsi') ?? '');

        if (empty($namaKategori)) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi!');
        }

        $slug = url_title($namaKategori, '-', true);

        $updated = $kategoriModel->update($id, [
            'nama_kategori' => $namaKategori,
            'slug'          => $slug,
            'deskripsi'     => $deskripsi,
        ]);

        if (!$updated) {
            $errors = $kategoriModel->errors();
            return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui kategori.');
        }

        return redirect()->to(base_url('admin/kategori-video'))->with('success', 'Kategori video berhasil diperbarui!');
    }

    public function kategoriVideoDelete($id)
    {
        $kategoriModel = new KategoriVideoModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to(base_url('admin/kategori-video'))->with('error', 'Kategori tidak ditemukan.');
        }

        // Set null id_kategori pada video yang menggunakan kategori ini
        $db = \Config\Database::connect();
        $db->table('video')->where('id_kategori', $id)->update(['id_kategori' => null]);

        $kategoriModel->delete($id);

        return redirect()->to(base_url('admin/kategori-video'))->with('success', 'Kategori video berhasil dihapus!');
    }

    public static function extractYoutubeId(string $url): ?string
    {
        if (empty($url)) return null;
        preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?|shorts|live)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1] ?? null;
    }

    // ---------------------------------------------------------------
    // MANAGEMENT ARTIKEL EDUKASI (ADMIN)
    // ---------------------------------------------------------------

    public function artikel()
    {
        $artikelModel  = new ArtikelModel();
        $kategoriModel = new KategoriArtikelModel();
        
        $selectedKategori = $this->request->getGet('kategori');
        $searchQuery      = trim($this->request->getGet('q') ?? '');

        $builder = $artikelModel->select('artikel.*, users.nama as nama_penulis, kategori_artikel.nama_kategori')
                                ->join('users', 'users.id = artikel.id_penulis', 'left')
                                ->join('kategori_artikel', 'kategori_artikel.id = artikel.id_kategori', 'left')
                                ->orderBy('artikel.created_at', 'DESC');

        if (!empty($selectedKategori)) {
            $builder->where('artikel.id_kategori', $selectedKategori);
        }

        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('artikel.judul', $searchQuery)
                    ->orLike('artikel.isi_konten', $searchQuery)
                    ->groupEnd();
        }

        $artikels = $builder->findAll();

        $data = [
            'title'            => 'Kelola Artikel Edukasi - SI CUBIT Admin',
            'artikels'         => $artikels,
            'categories'       => $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll(),
            'selectedKategori' => $selectedKategori,
            'searchQuery'      => $searchQuery,
        ];

        return view('admin/artikel', $data);
    }

    public function artikelStore()
    {
        $judul      = trim($this->request->getPost('judul') ?? '');
        $idKategori = $this->request->getPost('id_kategori');
        $isiKonten  = trim($this->request->getPost('isi_konten') ?? '');
        $status     = $this->request->getPost('status') ?? 'published';

        if (empty($judul) || empty($isiKonten)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Isi Konten Artikel wajib diisi!');
        }

        $thumbnailUrl = null;
        $fileGambar   = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($fileGambar->getMimeType(), $validTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar harus JPG, JPEG, PNG, atau WEBP.');
            }

            if ($fileGambar->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran gambar maksimal 2MB.');
            }

            $newName = $fileGambar->getRandomName();
            $uploadDir = FCPATH . 'uploads/artikel/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileGambar->move($uploadDir, $newName);
            $thumbnailUrl = 'uploads/artikel/' . $newName;
        }

        $adminId = session()->get('user_id') ?? session()->get('id');
        if (!$adminId) {
            $db = \Config\Database::connect();
            $adminUser = $db->table('users')->where('role', 'admin')->get()->getRowArray();
            $adminId = $adminUser['id'] ?? 1;
        }

        $baseSlug = url_title($judul, '-', true);
        $slug = $baseSlug ?: 'artikel-' . time();

        $artikelModel = new ArtikelModel();
        
        $existing = $artikelModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        try {
            $saved = $artikelModel->insert([
                'judul'         => $judul,
                'slug'          => $slug,
                'thumbnail_url' => $thumbnailUrl,
                'id_kategori'   => !empty($idKategori) ? (int) $idKategori : null,
                'isi_konten'    => $isiKonten,
                'id_penulis'    => (int) $adminId,
                'status'        => $status,
            ]);

            if (!$saved) {
                $errors = $artikelModel->errors();
                return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal menyimpan artikel.');
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error artikelStore: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/artikel'))->with('success', 'Artikel berita/edukasi berhasil ditambahkan!');
    }

    public function artikelUpdate($id)
    {
        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->find($id);

        if (!$artikel) {
            return redirect()->to(base_url('admin/artikel'))->with('error', 'Artikel tidak ditemukan.');
        }

        $judul      = trim($this->request->getPost('judul') ?? '');
        $idKategori = $this->request->getPost('id_kategori');
        $isiKonten  = trim($this->request->getPost('isi_konten') ?? '');
        $status     = $this->request->getPost('status') ?? 'published';

        if (empty($judul) || empty($isiKonten)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Isi Konten Artikel wajib diisi!');
        }

        $thumbnailUrl = $artikel['thumbnail_url'];
        $fileGambar   = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($fileGambar->getMimeType(), $validTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format gambar harus JPG, JPEG, PNG, atau WEBP.');
            }

            if ($fileGambar->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran gambar maksimal 2MB.');
            }

            $newName = $fileGambar->getRandomName();
            $uploadDir = FCPATH . 'uploads/artikel/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileGambar->move($uploadDir, $newName);

            if (!empty($artikel['thumbnail_url']) && file_exists(FCPATH . $artikel['thumbnail_url'])) {
                @unlink(FCPATH . $artikel['thumbnail_url']);
            }

            $thumbnailUrl = 'uploads/artikel/' . $newName;
        }

        $baseSlug = url_title($judul, '-', true);
        $slug = $baseSlug ?: 'artikel-' . $id;

        $existing = $artikelModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        try {
            $updated = $artikelModel->skipValidation(true)->update($id, [
                'judul'         => $judul,
                'slug'          => $slug,
                'thumbnail_url' => $thumbnailUrl,
                'id_kategori'   => !empty($idKategori) ? (int) $idKategori : null,
                'isi_konten'    => $isiKonten,
                'status'        => $status,
            ]);

            if (!$updated) {
                $errors = $artikelModel->errors();
                return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui artikel.');
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error artikelUpdate: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/artikel'))->with('success', 'Artikel berhasil diperbarui!');
    }

    public function artikelDelete($id)
    {
        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->find($id);

        if (!$artikel) {
            return redirect()->to(base_url('admin/artikel'))->with('error', 'Artikel tidak ditemukan.');
        }

        if (!empty($artikel['thumbnail_url']) && file_exists(FCPATH . $artikel['thumbnail_url'])) {
            @unlink(FCPATH . $artikel['thumbnail_url']);
        }

        $artikelModel->delete($id);

        return redirect()->to(base_url('admin/artikel'))->with('success', 'Artikel berhasil dihapus!');
    }

    // ---------------------------------------------------------------
    // MANAGEMENT KATEGORI ARTIKEL (ADMIN)
    // ---------------------------------------------------------------

    public function kategoriArtikel()
    {
        $kategoriModel = new KategoriArtikelModel();
        $db = \Config\Database::connect();

        $categories = $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll();

        foreach ($categories as &$c) {
            $c['total_artikel'] = $db->table('artikel')->where('id_kategori', $c['id'])->countAllResults();
        }

        $data = [
            'title'      => 'Kelola Kategori Artikel - SI CUBIT Admin',
            'categories' => $categories,
        ];

        return view('admin/kategori_artikel', $data);
    }

    public function kategoriArtikelStore()
    {
        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $deskripsi    = trim($this->request->getPost('deskripsi') ?? '');

        if (empty($namaKategori)) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi!');
        }

        $slug = url_title($namaKategori, '-', true);

        $kategoriModel = new KategoriArtikelModel();
        
        $saved = $kategoriModel->insert([
            'nama_kategori' => $namaKategori,
            'slug'          => $slug,
            'deskripsi'     => $deskripsi,
        ]);

        if (!$saved) {
            $errors = $kategoriModel->errors();
            return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal menyimpan kategori.');
        }

        return redirect()->to(base_url('admin/kategori-artikel'))->with('success', 'Kategori artikel berhasil ditambahkan!');
    }

    public function kategoriArtikelUpdate($id)
    {
        $kategoriModel = new KategoriArtikelModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to(base_url('admin/kategori-artikel'))->with('error', 'Kategori tidak ditemukan.');
        }

        $namaKategori = trim($this->request->getPost('nama_kategori') ?? '');
        $deskripsi    = trim($this->request->getPost('deskripsi') ?? '');

        if (empty($namaKategori)) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi!');
        }

        $slug = url_title($namaKategori, '-', true);

        $updated = $kategoriModel->update($id, [
            'nama_kategori' => $namaKategori,
            'slug'          => $slug,
            'deskripsi'     => $deskripsi,
        ]);

        if (!$updated) {
            $errors = $kategoriModel->errors();
            return redirect()->back()->withInput()->with('error', !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui kategori.');
        }

        return redirect()->to(base_url('admin/kategori-artikel'))->with('success', 'Kategori artikel berhasil diperbarui!');
    }

    public function kategoriArtikelDelete($id)
    {
        $kategoriModel = new KategoriArtikelModel();
        $kategori = $kategoriModel->find($id);

        if (!$kategori) {
            return redirect()->to(base_url('admin/kategori-artikel'))->with('error', 'Kategori tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $db->table('artikel')->where('id_kategori', $id)->update(['id_kategori' => null]);

        $kategoriModel->delete($id);

        return redirect()->to(base_url('admin/kategori-artikel'))->with('success', 'Kategori artikel berhasil dihapus!');
    }
}