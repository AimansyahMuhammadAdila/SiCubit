<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------------------------------------------------------------
// 1. FRONTEND ROUTES (HALAMAN WEB)
// ---------------------------------------------------------------

$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->get('lupa-password', 'Auth::lupaPassword');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('chat', 'Chat::index');
    $routes->get('riwayat', 'Riwayat::index');
    $routes->get('edukasi/video', 'Edukasi::video');
    $routes->get('laktasi/cek', 'Laktasi::cek'); 
    $routes->get('form-bayi', 'Laktasi::formBayi');
    $routes->get('assessment-kejiwaan', 'Laktasi::kejiwaan');
    $routes->get('laktasi/hasil', 'Laktasi::hasilAsi');
    $routes->get('assessment-kejiwaan/hasil', 'Laktasi::hasilKejiwaan');
    $routes->get('profil', 'Profil::index');
    $routes->get('profil/edit', 'Profil::edit');
    $routes->get('statistik', 'Dashboard::statistik');
    $routes->get('faq', 'Edukasi::faq');
});

// Admin Routes
$routes->get('admin/login', 'AuthAdmin::login');
$routes->get('admin/logout', 'AuthAdmin::logout');
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin::index');
    $routes->get('data-ibu', 'Admin::dataIbu');
    $routes->get('detail/(:num)', 'Admin::detail/$1');
    $routes->get('export-spreadsheet', 'Admin::exportSpreadsheet');
    $routes->post('sync-google-sheets', 'Admin::syncGoogleSheets');
    $routes->post('save-sheets-config', 'Admin::saveSheetsConfig');
});

// ---------------------------------------------------------------
// 2. API ROUTES (BACKEND SI CUBIT)
// ---------------------------------------------------------------

$routes->post('api/register', 'Actions\AuthAction::register');
$routes->post('api/login', 'Actions\AuthAction::login');
$routes->post('api/logout', 'Actions\AuthAction::logout');
$routes->post('api/reset-password', 'Actions\AuthAction::resetPassword');
$routes->get('api/wilayah/kabkota', 'Actions\AuthAction::getKabkota');
$routes->get('api/wilayah/puskesmas/(:segment)', 'Actions\AuthAction::getPuskesmas/$1');
$routes->post('api/admin/login', 'Actions\AuthAction::adminLogin');

$routes->group('api', ['namespace' => 'App\Controllers\Actions', 'filter' => 'auth'], static function ($routes) {
    $routes->post('save-riwayat', 'DataEntryAction::saveData');
    $routes->post('save-asi', 'DataEntryAction::saveAsiOnly');
    $routes->post('profil/update', 'ProfilAction::update');
    $routes->post('chat/send', 'ChatAction::sendMessage');
    
    $routes->get('profil', 'DataReadAction::profil');
    $routes->get('riwayat', 'DataReadAction::riwayat');
    $routes->get('cek-asi', 'DataReadAction::cekAsi');
    $routes->get('cek-asi/latest', 'DataReadAction::cekAsiLatest');
    $routes->get('dashboard', 'DataReadAction::dashboard');

    $routes->get('artikel', 'ContentAction::listArtikel');
    $routes->get('artikel/(:segment)', 'ContentAction::getArtikel/$1');
    $routes->get('video', 'ContentAction::listVideo');
    $routes->get('video/(:num)', 'ContentAction::getVideo/$1');

    $routes->post('data-bayi', 'DataBayiAction::save');
    $routes->get('data-bayi', 'DataBayiAction::index');
    $routes->get('data-bayi/(:num)', 'DataBayiAction::show/$1');

    $routes->post('kondisi-kejiwaan', 'KondisiKejiwaanAction::save');
    $routes->get('kondisi-kejiwaan', 'KondisiKejiwaanAction::index');
    $routes->get('kondisi-kejiwaan/latest', 'KondisiKejiwaanAction::latest');
});