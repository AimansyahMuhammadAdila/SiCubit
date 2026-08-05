<?php

namespace App\Controllers;

use App\Libraries\GoogleSheetsService;
use App\Models\SettingModel;

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
            'totalIbu'           => $db->table('users')->where('role', 'user')->countAllResults(),
            'perluCek'           => $db->table('riwayat_kehamilan')->countAllResults(),
            'resikoTinggi'       => $db->table('kondisi_kejiwaan_ibu')->where('status_kejiwaan', 'Berisiko')->countAllResults(),
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
            echo '<td style="border: 1px solid #E2E8F0;">' . htmlspecialchars($r['no_telp']) . '</td>';
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
        $builder->where('users.role', 'user');
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
}