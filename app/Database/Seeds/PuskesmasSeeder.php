<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PuskesmasSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // ===================================================================
        // 1. Kota Banjarmasin (6371)
        // ===================================================================
        $banjarmasin = [
            // Banjarmasin Tengah
            ['id' => 'P637101', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Cempaka'],
            ['id' => 'P637102', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Teluk Dalam'],
            ['id' => 'P637103', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Sungai Mesa'],
            ['id' => 'P637104', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Gadang Hanyar'],
            ['id' => 'P637105', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Seberang Mesjid'],
            // Banjarmasin Utara
            ['id' => 'P637106', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kayu Tangi'],
            ['id' => 'P637107', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Alalak Tengah'],
            ['id' => 'P637108', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Alalak Selatan'],
            ['id' => 'P637109', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Sungai Andai'],
            ['id' => 'P637110', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Sungai Jingah'],
            // Banjarmasin Selatan
            ['id' => 'P637111', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pekauman'],
            ['id' => 'P637112', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kelayan Timur'],
            ['id' => 'P637113', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pemurus Dalam'],
            ['id' => 'P637114', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pemurus Baru'],
            ['id' => 'P637115', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kelayan Dalam'],
            ['id' => 'P637116', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Mantuil'],
            ['id' => 'P637117', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Beruntung Raya'],
            ['id' => 'P637118', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Basirih Baru'],
            // Banjarmasin Timur
            ['id' => 'P637119', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kuripan'],
            ['id' => 'P637120', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kebun Bunga'],
            ['id' => 'P637121', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pekapuran Raya'],
            ['id' => 'P637122', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Karang Mekar'],
            ['id' => 'P637123', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Terminal'],
            ['id' => 'P637124', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Sungai Bilu'],
            ['id' => 'P637125', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pengambangan'],
            // Banjarmasin Barat
            ['id' => 'P637126', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Pelambuan'],
            ['id' => 'P637127', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Kuin Raya'],
            ['id' => 'P637128', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Teluk Tiram'],
            ['id' => 'P637129', 'id_kabkota' => '6371', 'nama' => 'Puskesmas Banjarmasin Indah'],
        ];

        // ===================================================================
        // 2. Kabupaten Banjar (6303)
        // ===================================================================
        $banjar = [
            // Martapura & Sekitarnya
            ['id' => 'P630301', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Martapura 1'],
            ['id' => 'P630302', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Martapura 2'],
            ['id' => 'P630303', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Martapura Timur'],
            ['id' => 'P630304', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Martapura Barat'],
            // Wilayah Gambut & Kertak Hanyar
            ['id' => 'P630305', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Gambut'],
            ['id' => 'P630306', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Kertak Hanyar'],
            ['id' => 'P630307', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Tatah Makmur'],
            ['id' => 'P630308', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Beruntung Baru'],
            ['id' => 'P630309', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Aluh-Aluh'],
            // Wilayah Hulu
            ['id' => 'P630310', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Sungai Tabuk 1'],
            ['id' => 'P630311', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Sungai Tabuk 2'],
            ['id' => 'P630312', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Astambul'],
            ['id' => 'P630313', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Mataraman'],
            ['id' => 'P630314', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Simpang Empat 1'],
            ['id' => 'P630315', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Simpang Empat 2'],
            ['id' => 'P630316', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Pengaron'],
            ['id' => 'P630317', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Sambung Makmur'],
            ['id' => 'P630318', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Sungai Pinang'],
            // Wilayah Pegunungan/Waduk
            ['id' => 'P630319', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Karang Intan 1'],
            ['id' => 'P630320', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Karang Intan 2'],
            ['id' => 'P630321', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Aranio'],
            ['id' => 'P630322', 'id_kabkota' => '6303', 'nama' => 'Puskesmas Belimbing'],
        ];

        // ===================================================================
        // 3. Kabupaten Kotabaru (6305)
        // ===================================================================
        $kotabaru = [
            // Pulau Laut
            ['id' => 'P630501', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Kotabaru'],
            ['id' => 'P630502', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Sebatung'],
            ['id' => 'P630503', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Dirgahayu'],
            ['id' => 'P630504', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Hilir Muara'],
            ['id' => 'P630505', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Semayap'],
            ['id' => 'P630506', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Mekar Pura'],
            ['id' => 'P630507', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Tanjung Seloka'],
            ['id' => 'P630508', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Tanjung Pelayar'],
            ['id' => 'P630509', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Tanjung Lalak'],
            // Kepulauan
            ['id' => 'P630510', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Marabatuan'],
            ['id' => 'P630511', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Sungai Bali'],
            // Daratan Kalimantan
            ['id' => 'P630512', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Serongga'],
            ['id' => 'P630513', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Cantung'],
            ['id' => 'P630514', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Geronggang'],
            ['id' => 'P630515', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Pudi'],
            ['id' => 'P630516', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Pantai'],
            ['id' => 'P630517', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Magalau'],
            ['id' => 'P630518', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Pamukan Utara'],
            ['id' => 'P630519', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Pamukan Selatan'],
            ['id' => 'P630520', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Pamukan Barat'],
            ['id' => 'P630521', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Sampanahan'],
            ['id' => 'P630522', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Hampang'],
            ['id' => 'P630523', 'id_kabkota' => '6305', 'nama' => 'Puskesmas Sungai Durian'],
        ];

        // ===================================================================
        // 4. Kabupaten Tabalong (6308)
        // ===================================================================
        $tabalong = [
            // Tanjung
            ['id' => 'P630801', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Tanjung'],
            ['id' => 'P630802', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Hikun'],
            // Murung Pudak
            ['id' => 'P630803', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Murung Pudak'],
            ['id' => 'P630804', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Mabuun'],
            // Selatan
            ['id' => 'P630805', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Kelua'],
            ['id' => 'P630806', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Banua Lawas'],
            ['id' => 'P630807', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Pugaan'],
            ['id' => 'P630808', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Muara Harus'],
            ['id' => 'P630809', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Tanta'],
            // Utara
            ['id' => 'P630810', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Haruai'],
            ['id' => 'P630811', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Upau'],
            ['id' => 'P630812', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Muara Uya'],
            ['id' => 'P630813', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Jaro'],
            ['id' => 'P630814', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Wirang'],
            ['id' => 'P630815', 'id_kabkota' => '6308', 'nama' => 'Puskesmas Bintang Ara'],
        ];

        // ===================================================================
        // 5. Kabupaten Tanah Laut (6301)
        // ===================================================================
        $tanahLaut = [
            // Pelaihari
            ['id' => 'P630101', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Pelaihari'],
            ['id' => 'P630102', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Angsau'],
            ['id' => 'P630103', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Sungai Riam'],
            // Pesisir
            ['id' => 'P630104', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Takisung'],
            ['id' => 'P630105', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Kurau'],
            ['id' => 'P630106', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Bumi Makmur'],
            ['id' => 'P630107', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Batakan'],
            // Lintas Provinsi
            ['id' => 'P630108', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Bati-Bati'],
            ['id' => 'P630109', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Tambang Ulang'],
            ['id' => 'P630110', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Bentok Kampung'],
            // Timur
            ['id' => 'P630111', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Jorong'],
            ['id' => 'P630112', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Asam-Asam'],
            ['id' => 'P630113', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Kintap'],
            ['id' => 'P630114', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Batu Ampar'],
            ['id' => 'P630115', 'id_kabkota' => '6301', 'nama' => 'Puskesmas Tajau Pecah'],
        ];

        // ===================================================================
        // 6. Kabupaten Tanah Bumbu (6310)
        // ===================================================================
        $tanahBumbu = [
            // Pusat
            ['id' => 'P631001', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Batulicin'],
            ['id' => 'P631002', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Simpang Empat'],
            ['id' => 'P631003', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Lasung'],
            // Pesisir
            ['id' => 'P631004', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Pagatan'],
            ['id' => 'P631005', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Kusan Hulu'],
            ['id' => 'P631006', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Sungai Loban'],
            ['id' => 'P631007', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Angsana'],
            ['id' => 'P631008', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Satui'],
            // Pedalaman
            ['id' => 'P631009', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Mantewe'],
            ['id' => 'P631010', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Karang Bintang'],
            ['id' => 'P631011', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Sebamban 1'],
            ['id' => 'P631012', 'id_kabkota' => '6310', 'nama' => 'Puskesmas Sebamban 2'],
        ];

        // ===================================================================
        // 7. Kabupaten Barito Kuala (6304)
        // ===================================================================
        $baritoKuala = [
            // Marabahan
            ['id' => 'P630401', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Marabahan'],
            ['id' => 'P630402', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Cerbon'],
            // Selatan (Dekat Banjarmasin)
            ['id' => 'P630403', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Alalak'],
            ['id' => 'P630404', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Berangas'],
            ['id' => 'P630405', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Semangat Dalam'],
            ['id' => 'P630406', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Mandastana'],
            // Hulu
            ['id' => 'P630407', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Anjir Pasar'],
            ['id' => 'P630408', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Anjir Muara'],
            ['id' => 'P630409', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Wanaraya'],
            ['id' => 'P630410', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Barambai'],
            ['id' => 'P630411', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Rantau Badauh'],
            ['id' => 'P630412', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Belawang'],
            ['id' => 'P630413', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Mekarsari'],
            ['id' => 'P630414', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Tabukan'],
            ['id' => 'P630415', 'id_kabkota' => '6304', 'nama' => 'Puskesmas Kuripan'],
        ];

        // ===================================================================
        // 8. Kabupaten Hulu Sungai Tengah (6307)
        // ===================================================================
        $hst = [
            // Barabai
            ['id' => 'P630701', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Barabai'],
            ['id' => 'P630702', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Awang Besar'],
            // Pegunungan Meratus
            ['id' => 'P630703', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Hantakan'],
            ['id' => 'P630704', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Pagat'],
            // Lainnya
            ['id' => 'P630705', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Birayang'],
            ['id' => 'P630706', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Limpasu'],
            ['id' => 'P630707', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Batu Tangga'],
            ['id' => 'P630708', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Kasarangan'],
            ['id' => 'P630709', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Pantai Hambawang'],
            ['id' => 'P630710', 'id_kabkota' => '6307', 'nama' => 'Puskesmas Labuan Amas Utara'],
        ];

        // ===================================================================
        // 9. Kabupaten Hulu Sungai Selatan (6306)
        // ===================================================================
        $hss = [
            // Kandangan
            ['id' => 'P630601', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Kandangan'],
            ['id' => 'P630602', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Gambah'],
            ['id' => 'P630603', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Jambu Hilir'],
            // Negara (Perairan)
            ['id' => 'P630604', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Daha Selatan'],
            ['id' => 'P630605', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Daha Utara'],
            ['id' => 'P630606', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Daha Barat'],
            // Lainnya
            ['id' => 'P630607', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Loksado'],
            ['id' => 'P630608', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Padang Batung'],
            ['id' => 'P630609', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Kalumpang'],
            ['id' => 'P630610', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Simpur'],
            ['id' => 'P630611', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Wasah'],
            ['id' => 'P630612', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Angkinang'],
            ['id' => 'P630613', 'id_kabkota' => '6306', 'nama' => 'Puskesmas Telaga Langsat'],
        ];

        // ===================================================================
        // 10. Kabupaten Hulu Sungai Utara (6309)
        // ===================================================================
        $hsu = [
            // Amuntai
            ['id' => 'P630901', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Amuntai Pusat'],
            ['id' => 'P630902', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Amuntai Selatan'],
            ['id' => 'P630903', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Pekapuran'],
            // Perairan
            ['id' => 'P630904', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Danau Panggang'],
            ['id' => 'P630905', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Paminggir'],
            ['id' => 'P630906', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Babirik'],
            // Lainnya
            ['id' => 'P630907', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Alabio'],
            ['id' => 'P630908', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Haur Gading'],
            ['id' => 'P630909', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Banjang'],
            ['id' => 'P630910', 'id_kabkota' => '6309', 'nama' => 'Puskesmas Sungai Turak'],
        ];

        // ===================================================================
        // 11. Kabupaten Tapin (6302)
        // ===================================================================
        $tapin = [
            // Rantau
            ['id' => 'P630201', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Rantau'],
            ['id' => 'P630202', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Tapin Utara'],
            // Lainnya
            ['id' => 'P630203', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Binuang'],
            ['id' => 'P630204', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Tambarangan'],
            ['id' => 'P630205', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Salam Babaris'],
            ['id' => 'P630206', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Hatungun'],
            ['id' => 'P630207', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Bakarangan'],
            ['id' => 'P630208', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Lokpaikat'],
            ['id' => 'P630209', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Piani'],
            ['id' => 'P630210', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Margasari'],
            ['id' => 'P630211', 'id_kabkota' => '6302', 'nama' => 'Puskesmas Candi Laras Utara'],
        ];

        // ===================================================================
        // 12. Kabupaten Balangan (6311)
        // ===================================================================
        $balangan = [
            // Paringin
            ['id' => 'P631101', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Paringin'],
            ['id' => 'P631102', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Paringin Selatan'],
            // Lainnya
            ['id' => 'P631103', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Batumandi'],
            ['id' => 'P631104', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Lampihong'],
            ['id' => 'P631105', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Juai'],
            ['id' => 'P631106', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Halong'],
            ['id' => 'P631107', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Awayan'],
            ['id' => 'P631108', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Tebing Tinggi'],
            ['id' => 'P631109', 'id_kabkota' => '6311', 'nama' => 'Puskesmas Tanah Habang'],
        ];

        // ===================================================================
        // 13. Kota Banjarbaru (6372)
        // ===================================================================
        $banjarbaru = [
            // Utara/Selatan
            ['id' => 'P637201', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Banjarbaru Utara'],
            ['id' => 'P637202', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Banjarbaru Selatan'],
            ['id' => 'P637203', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Sungai Besar'],
            ['id' => 'P637204', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Guntung Paikat'],
            // Ujung/Bandara
            ['id' => 'P637205', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Landasan Ulin Timur'],
            ['id' => 'P637206', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Landasan Ulin Barat'],
            ['id' => 'P637207', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Guntung Payung'],
            ['id' => 'P637208', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Liang Anggang'],
            ['id' => 'P637209', 'id_kabkota' => '6372', 'nama' => 'Puskesmas Cempaka'],
        ];

        // Gabungkan semua data
        $allPuskesmas = array_merge(
            $banjarmasin,
            $banjar,
            $kotabaru,
            $tabalong,
            $tanahLaut,
            $tanahBumbu,
            $baritoKuala,
            $hst,
            $hss,
            $hsu,
            $tapin,
            $balangan,
            $banjarbaru
        );

        // Tambahkan timestamp
        foreach ($allPuskesmas as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        // Insert batch
        $this->db->table('puskesmas')->insertBatch($allPuskesmas);

        echo "Berhasil insert " . count($allPuskesmas) . " data puskesmas.\n";
    }
}
