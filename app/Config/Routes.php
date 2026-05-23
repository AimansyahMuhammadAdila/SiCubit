<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---------------------------------------------------------------
// 1. FRONTEND ROUTES (HALAMAN WEB)
// ---------------------------------------------------------------

// Halaman Publik (Tanpa Login)
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->get('lupa-password', 'Auth::lupaPassword'); // <-- Pindah ke sini (Publik)

// Halaman Internal (Wajib Login)
$routes->get('dashboard', 'Dashboard::index');
$routes->get('chat', 'Chat::index');
$routes->get('riwayat', 'Riwayat::index');
$routes->get('edukasi/video', 'Edukasi::video');
$routes->get('laktasi/cek', 'Laktasi::cek');
$routes->get('profil', 'Profil::index');
$routes->get('profil/edit', 'Profil::edit'); // <-- Pindah ke sini (Web)
$routes->get('statistik', 'Dashboard::statistik');

// Halaman Khusus Admin
$routes->get('admin/login', 'AuthAdmin::login');
    $routes->get('admin/logout', 'AuthAdmin::logout');

    // Halaman Dashboard Admin (Wajib Login)
    $routes->group('admin', ['filter' => 'auth'], function ($routes) {
        $routes->get('dashboard', 'Admin::index');
        $routes->get('data-ibu', 'Admin::dataIbu');
    });

    // --- RUTE API (PROSES) ---
    $routes->post('api/admin/login', 'Actions\AuthAction::adminLogin');


// ---------------------------------------------------------------
// 2. API ROUTES (BACKEND SI CUBIT)
// ---------------------------------------------------------------

// API Publik (Bisa diakses tanpa login)
$routes->post('api/register', 'Actions\AuthAction::register');
$routes->post('api/login', 'Actions\AuthAction::login');
$routes->post('api/logout', 'Actions\AuthAction::logout');
$routes->post('api/reset-password', 'Actions\AuthAction::resetPassword'); // <-- Pindah ke sini (Publik)

// API Wilayah (Dropdown Dinamis)
$routes->get('api/wilayah/kabkota', 'Actions\AuthAction::getKabkota');
$routes->get('api/wilayah/puskesmas/(:segment)', 'Actions\AuthAction::getPuskesmas/$1');
$routes->post('api/admin/login', 'Actions\AuthAction::adminLogin');

// API Terlindungi (Wajib pakai filter 'auth' alias sudah login)
$routes->group('api', ['namespace' => 'App\Controllers\Actions', 'filter' => 'auth'], static function ($routes) {

    // POST — Simpan Data
    $routes->post('save-riwayat', 'DataEntryAction::saveData');
    $routes->post('save-asi', 'DataEntryAction::saveAsiOnly');
    $routes->post('profil/update', 'ProfilAction::update'); // <-- URL menjadi api/profil/update
    $routes->post('chat/send', 'ChatAction::sendMessage');

    // GET — Ambil Data (Baca)
    $routes->get('profil', 'DataReadAction::profil');
    $routes->get('riwayat', 'DataReadAction::riwayat');
    $routes->get('cek-asi', 'DataReadAction::cekAsi');
    $routes->get('cek-asi/latest', 'DataReadAction::cekAsiLatest');
    $routes->get('dashboard', 'DataReadAction::dashboard');

    // GET — Edukasi
    $routes->get('artikel', 'ContentAction::listArtikel');
    $routes->get('artikel/(:segment)', 'ContentAction::getArtikel/$1');
    $routes->get('video', 'ContentAction::listVideo');
    $routes->get('video/(:num)', 'ContentAction::getVideo/$1');

    // --- Data Bayi (NEW) ---
    $routes->post('data-bayi', 'DataBayiAction::save');
    $routes->get('data-bayi', 'DataBayiAction::index');
    $routes->get('data-bayi/(:num)', 'DataBayiAction::show/$1');

    // --- Kondisi Kejiwaan Ibu (NEW) ---
    $routes->post('kondisi-kejiwaan', 'KondisiKejiwaanAction::save');
    $routes->get('kondisi-kejiwaan', 'KondisiKejiwaanAction::index');
    $routes->get('kondisi-kejiwaan/latest', 'KondisiKejiwaanAction::latest');

});