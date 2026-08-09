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
        $builder->groupStart()
                ->whereIn('users.role', ['user', 'ibu'])
                ->orWhere('users.role IS NULL')
                ->orWhere('users.role', '')
        ->groupEnd();
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

        // Sanitasi URL Google Apps Script jika user sengaja/tidaksengaja meng-copy URL dengan /u/0/, ?authuser=0, /edit, atau /dev
        if (str_contains($webhookUrl, 'script.google.com')) {
            // Hapus jalur akun seperti /u/0/ atau /u/1/
            $webhookUrl = preg_replace('/\/u\/\d+\//', '/', $webhookUrl);
            // Hapus query params seperti ?authuser=0
            if (str_contains($webhookUrl, '?')) {
                $webhookUrl = explode('?', $webhookUrl)[0];
            }
            // Pastikan berakhiran /exec
            if (str_contains($webhookUrl, '/edit')) {
                $webhookUrl = preg_replace('/\/edit.*$/', '/exec', $webhookUrl);
            } elseif (str_contains($webhookUrl, '/dev')) {
                $webhookUrl = preg_replace('/\/dev.*$/', '/exec', $webhookUrl);
            }
        }

        $payload = $this->getMonthlyExportData();
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhookUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Ikuti redirect 302 Google ke script.googleusercontent.com
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/plain;charset=utf-8'
        ]);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); // Paksa HTTP/1.1 untuk cegah HTTP/2 stream reset error dari server Google
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) SiCubit/1.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
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
                'message' => 'Gagal mengirim ke Webhook Google. HTTP Status: ' . $httpCode . '. Jika menggunakan email Kampus/Organisasi (@poltekkes-kemenkes-bjm.ac.id), pastikan Web App di-deploy dengan akses "Anyone" (Siapa saja) tanpa pembatasan organisasi, atau gunakan akun @gmail.com pribadi.'
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
    var sheetName = data.sheet_name || "Agustus 2026";
    
    var sheet = ss.getSheetByName(sheetName);
    if (!sheet) {
      sheet = ss.insertSheet(sheetName);
    }
    
    sheet.clearContents();
    
    // 1. DOKUMEN HEADER
    sheet.getRange("A1").setValue("PANEL KENDALI MONITORING KESEHATAN IBU & ANAK (SI CUBIT)");
    sheet.getRange("A2").setValue("Update Terakhir: " + ((data.summary_stats && data.summary_stats.last_update) ? data.summary_stats.last_update : ""));
    
    // 2. KPI CARDS DATA
    if (data.summary_stats) {
      sheet.getRange("A4").setValue("TOTAL IBU");
      sheet.getRange("A5").setValue(Number(data.summary_stats.total_ibu || 0));

      sheet.getRange("C4").setValue("ASI LANCAR");
      sheet.getRange("C5").setValue(Number(data.summary_stats.asi_lancar || 0));

      sheet.getRange("E4").setValue("KEJIWAAN BERISIKO");
      sheet.getRange("E5").setValue(Number(data.summary_stats.kejiwaan_berisiko || 0));
    }
    
    // 3. TABEL HEADERS
    var startRow = 7;
    var headers = data.headers || [
      'No', 'Tanggal Daftar', 'Nama Ibu', 'Umur', 'No. Telepon',
      'Puskesmas', 'Kabupaten/Kota', 'Status Kehamilan',
      'Status Kelancaran ASI', 'Kondisi Kejiwaan', 'Jumlah Anak', 'Alamat'
    ];
    
    sheet.getRange(startRow, 1, 1, headers.length).setValues([headers]);
    
    // 4. BARIS DATA
    var rows = data.rows || [];
    if (rows && rows.length > 0) {
      var rowArray = [];
      for (var i = 0; i < rows.length; i++) {
        var r = rows[i] || {};
        rowArray.push([
          String(r.no || (i + 1)),
          String(r.tgl_daftar || "-"),
          String(r.nama_ibu || "-"),
          String(r.umur || "-"),
          String(r.no_telp || "-"),
          String(r.puskesmas || "-"),
          String(r.kabkota || "-"),
          String(r.status_kehamilan || "-"),
          String(r.status_asi || "-"),
          String(r.status_kejiwaan || "-"),
          Number(r.jumlah_anak || 0),
          String(r.alamat || "-")
        ]);
      }
      sheet.getRange(startRow + 1, 1, rowArray.length, headers.length).setValues(rowArray);
    }

    // 5. STYLING INSTAN (FAST BATCH MATRIX STYLING)
    try {
      sheet.getRange("A1").setFontSize(14).setFontWeight("bold");
      sheet.getRange("A2").setFontSize(9).setFontItalic(true);
      
      if (data.summary_stats) {
        sheet.getRange("A4:A5").setBackground("#EFF6FF").setFontColor("#1E40AF").setHorizontalAlignment("center");
        sheet.getRange("C4:C5").setBackground("#ECFDF5").setFontColor("#065F46").setHorizontalAlignment("center");
        sheet.getRange("E4:E5").setBackground("#FEF2F2").setFontColor("#991B1B").setHorizontalAlignment("center");
      }

      var headerRange = sheet.getRange(startRow, 1, 1, headers.length);
      headerRange.setBackground("#0F172A").setFontColor("#FFFFFF").setFontWeight("bold").setHorizontalAlignment("center");
      
      if (rows && rows.length > 0) {
        var bgMatrix = [];
        var fontMatrix = [];

        for (var j = 0; j < rows.length; j++) {
          var rData = rows[j] || {};
          var rowBg = [];
          var rowFont = [];

          var baseBg = (j % 2 === 1) ? "#F8FAFC" : "#FFFFFF";

          for (var c = 0; c < headers.length; c++) {
            rowBg.push(baseBg);
            rowFont.push("#0F172A");
          }

          // Index 8 = Status ASI (Kolom 9)
          var asiVal = rData.status_asi || "";
          if (asiVal === "Cukup") {
            rowBg[8] = "#DCFCE7";
            rowFont[8] = "#166534";
          } else if (asiVal === "Kurang" || asiVal === "Tidak Cukup") {
            rowBg[8] = "#FEE2E2";
            rowFont[8] = "#991B1B";
          }

          // Index 9 = Status Kejiwaan (Kolom 10)
          var jiwaVal = rData.status_kejiwaan || "";
          if (jiwaVal === "Berisiko") {
            rowBg[9] = "#FEE2E2";
            rowFont[9] = "#991B1B";
          } else if (jiwaVal === "Normal") {
            rowBg[9] = "#DCFCE7";
            rowFont[9] = "#166534";
          }

          bgMatrix.push(rowBg);
          fontMatrix.push(rowFont);
        }

        var tableDataRange = sheet.getRange(startRow + 1, 1, rows.length, headers.length);
        tableDataRange.setBackgrounds(bgMatrix);
        tableDataRange.setFontColors(fontMatrix);
      }
    } catch(styleErr) {
      // Ignore styling errors if any
    }
    
    return ContentService.createTextOutput(JSON.stringify({result: "success", sheet: sheetName, rows_count: rows.length}))
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
