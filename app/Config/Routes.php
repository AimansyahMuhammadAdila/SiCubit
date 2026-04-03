<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ---------------------------------------------------------------
// API Routes — SI CUBIT Backend
// ---------------------------------------------------------------

// Auth (public — tidak perlu login)
$routes->post('api/register', 'Actions\AuthAction::register');
$routes->post('api/login',    'Actions\AuthAction::login');
$routes->post('api/logout',   'Actions\AuthAction::logout');

// Data Entry & Read (protected — wajib login)
$routes->group('api', ['namespace' => 'App\Controllers\Actions'],['filter' => 'auth'], static function ($routes) {
    // POST — simpan data
    $routes->post('save-riwayat', 'DataEntryAction::saveData');
    $routes->post('save-asi',     'DataEntryAction::saveAsiOnly');

    // GET — ambil data
    $routes->get('profil',        'Actions\DataReadAction::profil');
    $routes->get('riwayat',       'Actions\DataReadAction::riwayat');
    $routes->get('cek-asi',       'Actions\DataReadAction::cekAsi');
    $routes->get('cek-asi/latest', 'Actions\DataReadAction::cekAsiLatest');
    $routes->get('dashboard',     'Actions\DataReadAction::dashboard');
});

$routes->group('api', ['namespace' => 'App\Controllers\Actions'], static function ($routes) {
    $routes->post('register', 'AuthAction::register');
    $routes->post('login', 'AuthAction::login');
    $routes->post('logout', 'AuthAction::logout');
});

//FRONTEND ROUTES

$routes->get('/', 'Auth::index');          // Buka web pertama kali -> welcome.php
$routes->get('login', 'Auth::login');      // Buka /login -> login.php
$routes->get('register', 'Auth::register');// Buka /register -> register.php

// Route untuk halaman dalam (Dashboard User & Navigasi)
$routes->get('dashboard', 'Dashboard::index');
$routes->get('chat', 'Chat::index');
$routes->get('riwayat', 'Riwayat::index');
$routes->get('edukasi/video', 'Edukasi::video');
$routes->get('laktasi/cek', 'Laktasi::cek');
$routes->get('profil', 'Profil::index');
$routes->get('statistik', 'Dashboard::statistik');

// Route khusus Admin
$routes->get('admin/dashboard', 'Dashboard::indexAdmin');
$routes->get('admin/data-ibu', 'Dashboard::dataIbu');
$routes->get('admin/detail/(:segment)', 'Dashboard::detail/$1');