<?php

namespace App\Libraries;

use App\Models\SettingModel;

class GoogleSheetsService
{
    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Mengambil data rekapitulasi lengkap bulanan untuk disinkronkan
     */
    public function getMonthlyExportData(?string $targetMonth = null): array
    {
        $db = \Config\Database::connect();
        
        // Bulan default: Bulan & Tahun saat ini (Contoh: "Agustus 2026")
        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $currentMonthNum = (int) date('n');
        $currentYear = date('Y');
        $sheetName = $targetMonth ?: ($indonesianMonths[$currentMonthNum] . ' ' . $currentYear);

        // Ambil data users dengan role 'user' (Ibu)
        $builder = $db->table('users');
        $builder->select('users.*, puskesmas.nama as nama_puskesmas, kabupaten_kota.nama as nama_kabkota');
        $builder->join('puskesmas', 'puskesmas.id = users.id_puskesmas', 'left');
        $builder->join('kabupaten_kota', 'kabupaten_kota.id = users.id_kabkota', 'left');
        $builder->whereIn('users.role', ['user', 'ibu']);
        $builder->orderBy('users.created_at', 'DESC');
        $users = $builder->get()->getResultArray();

        $rows = [];
        $totalIbu = count($users);
        $totalAsiLancar = 0;
        $totalKejiwaanRisiko = 0;

        foreach ($users as $index => $u) {
            // Ambil status ASI terakhir
            $asi = $db->table('cek_kelancaran_asi')
                      ->where('user_id', $u['id'])
                      ->orderBy('tgl_pengisian', 'DESC')
                      ->get()->getRowArray();
            
            $statusAsi = $asi['status_kecukupan_asi'] ?? 'BELUM ISI';
            if ($statusAsi === 'Cukup') {
                $totalAsiLancar++;
            }

            // Ambil status kejiwaan terakhir
            $kejiwaan = $db->table('kondisi_kejiwaan_ibu')
                           ->where('user_id', $u['id'])
                           ->orderBy('tgl_pengisian', 'DESC')
                           ->get()->getRowArray();
            
            $statusKejiwaan = $kejiwaan['status_kejiwaan'] ?? 'Belum Diisi';
            if ($statusKejiwaan === 'Berisiko') {
                $totalKejiwaanRisiko++;
            }

            // Status Kehamilan Human Readable
            $statusHamil = match ($u['status_kehamilan']) {
                'pra_kehamilan' => 'Pra-Kehamilan',
                'hamil' => 'Kehamilan Active',
                'pasca_melahirkan' => 'Pasca Melahirkan',
                default => 'Belum Set'
            };

            $tglDaftar = !empty($u['created_at']) ? date('d/m/Y H:i', strtotime($u['created_at'])) : '-';

            $rows[] = [
                'no'               => $index + 1,
                'tgl_daftar'       => $tglDaftar,
                'nama_ibu'         => $u['nama'],
                'umur'             => ($u['umur'] ?? '-') . ' thn',
                'no_telp'          => "'" . self::formatPhoneNumber($u['no_telp'] ?? '-'),
                'puskesmas'        => $u['nama_puskesmas'] ?? '-',
                'kabkota'          => $u['nama_kabkota'] ?? '-',
                'status_kehamilan' => $statusHamil,
                'status_asi'       => $statusAsi,
                'status_kejiwaan'  => $statusKejiwaan,
                'jumlah_anak'      => $u['jumlah_anak'] ?? 0,
                'alamat'           => $u['alamat'] ?? '-'
            ];
        }

        // Summary Statistics untuk Card Header di Google Sheets
        $summary = [
            'total_ibu'          => $totalIbu,
            'asi_lancar'         => $totalAsiLancar,
            'asi_perlu_evaluasi' => $totalIbu - $totalAsiLancar,
            'kejiwaan_berisiko'  => $totalKejiwaanRisiko,
            'last_update'        => date('d/m/Y H:i:s')
        ];

        $headers = [
            'No', 'Tanggal Daftar', 'Nama Ibu', 'Umur', 'No. Telepon',
            'Puskesmas', 'Kabupaten/Kota', 'Status Kehamilan',
            'Status Kelancaran ASI', 'Kondisi Kejiwaan', 'Jumlah Anak', 'Alamat'
        ];

        return [
            'sheet_name'    => $sheetName,
            'summary_stats' => $summary,
            'headers'       => $headers,
            'rows'          => $rows
        ];
    }

    /**
     * Kirim data ke Webhook Google Apps Script
     */
    public function syncToWebhook(?string $targetWebhookUrl = null): array
    {
        $webhookUrl = trim($targetWebhookUrl ?: $this->settingModel->getVal('google_webhook_url'));

        if (empty($webhookUrl)) {
            return [
                'success' => false,
                'message' => 'URL Webhook Google Sheets belum dikonfigurasi. Silakan masukkan URL Webhook di pengaturan.'
            ];
        }

        // Sanitasi URL Google Apps Script jika user sengaja/tidaksengaja meng-copy URL /edit atau /dev
        if (str_contains($webhookUrl, 'script.google.com')) {
            if (str_contains($webhookUrl, '/edit')) {
                $webhookUrl = preg_replace('/\/edit.*$/', '/exec', $webhookUrl);
            } elseif (str_contains($webhookUrl, '/dev')) {
                $webhookUrl = preg_replace('/\/dev.*$/', '/exec', $webhookUrl);
            }
        }

        $payload = $this->getMonthlyExportData();
        $jsonPayload = json_encode($payload);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhookUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Ikuti redirect 302 Google ke script.googleusercontent.com
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonPayload)
        ]);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) SiCubit/1.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyambung ke Webhook Google: ' . $curlErr
            ];
        }

        // Google Webhook mengembalikan 200 OK setelah redirect
        if ($httpCode >= 200 && $httpCode < 400) {
            $this->settingModel->setVal('last_synced_at', date('Y-m-d H:i:s'));
            return [
                'success' => true,
                'message' => 'Berhasil menyinkronkan data ke Google Sheets pada sheet tab "' . $payload['sheet_name'] . '"!',
                'timestamp' => date('d M Y H:i:s')
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Gagal mengirim ke Webhook Google. HTTP Status: ' . $httpCode . '. Mohon pastikan Web App Apps Script sudah di-deploy dengan akses "Anyone" (Siapa Saja) dan URL berakhiran /exec.'
            ];
        }
    }

    /**
     * Menghasilkan script Google Apps Script bawaan untuk dipasang di Google Sheets
     */
    public static function getAppsScriptCode(): string
    {
        return <<<'GS'
function doGet(e) {
  return ContentService.createTextOutput(JSON.stringify({result: "success", message: "SI CUBIT Webhook Active"}))
                       .setMimeType(ContentService.MimeType.JSON);
}

function doPost(e) {
  try {
    var contents = (e && e.postData) ? e.postData.contents : "";
    var data = contents ? JSON.parse(contents) : {};
    var ss = SpreadsheetApp.getActiveSpreadsheet();
    var sheetName = data.sheet_name || "Sheet Utama";
    
    var sheet = ss.getSheetByName(sheetName);
    if (!sheet) {
      sheet = ss.insertSheet(sheetName);
    }
    
    sheet.clearContents();
    sheet.clearFormats();
    
    // 1. DOKUMEN HEADER
    sheet.getRange("A1").setValue("PANEL KENDALI MONITORING KESEHATAN IBU & ANAK (SI CUBIT)");
    sheet.getRange("A1").setFontSize(14).setFontWeight("bold").setFontColor("#0F172A");
    
    var lastUpdateStr = (data.summary_stats && data.summary_stats.last_update) ? data.summary_stats.last_update : "";
    sheet.getRange("A2").setValue("Update Terakhir: " + lastUpdateStr);
    sheet.getRange("A2").setFontSize(9).setFontItalic(true).setFontColor("#64748B");
    
    // 2. KPI CARDS
    if (data.summary_stats) {
      sheet.getRange("A4").setValue("TOTAL IBU");
      sheet.getRange("A5").setValue(data.summary_stats.total_ibu || 0);
      sheet.getRange("A4:A5").setBackground("#EFF6FF").setFontColor("#1E40AF").setHorizontalAlignment("center");
      sheet.getRange("A4").setFontSize(9).setFontWeight("bold");
      sheet.getRange("A5").setFontSize(14).setFontWeight("bold");

      sheet.getRange("C4").setValue("ASI LANCAR");
      sheet.getRange("C5").setValue(data.summary_stats.asi_lancar || 0);
      sheet.getRange("C4:C5").setBackground("#ECFDF5").setFontColor("#065F46").setHorizontalAlignment("center");
      sheet.getRange("C4").setFontSize(9).setFontWeight("bold");
      sheet.getRange("C5").setFontSize(14).setFontWeight("bold");

      sheet.getRange("E4").setValue("KEJIWAAN BERISIKO");
      sheet.getRange("E5").setValue(data.summary_stats.kejiwaan_berisiko || 0);
      sheet.getRange("E4:E5").setBackground("#FEF2F2").setFontColor("#991B1B").setHorizontalAlignment("center");
      sheet.getRange("E4").setFontSize(9).setFontWeight("bold");
      sheet.getRange("E5").setFontSize(14).setFontWeight("bold");
    }
    
    // 3. TABEL HEADERS
    var startRow = 7;
    var headers = data.headers || [];
    if (headers && headers.length > 0) {
      var headerRange = sheet.getRange(startRow, 1, 1, headers.length);
      headerRange.setValues([headers]);
      headerRange.setBackground("#0F172A");
      headerRange.setFontColor("#FFFFFF");
      headerRange.setFontWeight("bold");
      headerRange.setHorizontalAlignment("center");
      headerRange.setVerticalAlignment("middle");
      sheet.setRowHeight(startRow, 30);
    }
    
    // 4. BARIS DATA
    var rows = data.rows || [];
    if (rows && rows.length > 0) {
      var rowArray = [];
      for (var i = 0; i < rows.length; i++) {
        var r = rows[i];
        rowArray.push([
          r.no || (i + 1),
          r.tgl_daftar || "",
          r.nama_ibu || "",
          r.umur || "",
          r.no_telp || "",
          r.puskesmas || "",
          r.kabkota || "",
          r.status_kehamilan || "",
          r.status_asi || "",
          r.status_kejiwaan || "",
          r.jumlah_anak || 0,
          r.alamat || ""
        ]);
      }
      
      var dataRange = sheet.getRange(startRow + 1, 1, rowArray.length, headers.length);
      dataRange.setValues(rowArray);
      
      for (var j = 0; j < rowArray.length; j++) {
        var currentRowIndex = startRow + 1 + j;
        var rowRange = sheet.getRange(currentRowIndex, 1, 1, headers.length);
        if (j % 2 === 1) {
          rowRange.setBackground("#F8FAFC");
        }
        
        var asiCell = sheet.getRange(currentRowIndex, 9);
        var asiVal = asiCell.getValue();
        if (asiVal === "Cukup") {
          asiCell.setBackground("#DCFCE7").setFontColor("#166534").setFontWeight("bold");
        } else if (asiVal === "Kurang" || asiVal === "Tidak Cukup") {
          asiCell.setBackground("#FEE2E2").setFontColor("#991B1B").setFontWeight("bold");
        }

        var jiwaCell = sheet.getRange(currentRowIndex, 10);
        var jiwaVal = jiwaCell.getValue();
        if (jiwaVal === "Berisiko") {
          jiwaCell.setBackground("#FEE2E2").setFontColor("#991B1B").setFontWeight("bold");
        } else if (jiwaVal === "Normal") {
          jiwaCell.setBackground("#DCFCE7").setFontColor("#166534");
        }
      }
    }
    
    // 5. AUTO RESIZE & FREEZE
    var numCols = headers.length > 0 ? headers.length : 12;
    for (var col = 1; col <= numCols; col++) {
      sheet.autoResizeColumn(col);
    }
    sheet.setFrozenRows(startRow);
    
    return ContentService.createTextOutput(JSON.stringify({result: "success", sheet: sheetName}))
                         .setMimeType(ContentService.MimeType.JSON);
  } catch (err) {
    return ContentService.createTextOutput(JSON.stringify({result: "error", error: err.toString()}))
                         .setMimeType(ContentService.MimeType.JSON);
  }
}
GS;
    }

    public static function formatPhoneNumber(?string $phone): string
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
}
