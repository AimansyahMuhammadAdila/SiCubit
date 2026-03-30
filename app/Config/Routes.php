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
$routes->group('api', ['filter' => 'auth'], static function ($routes) {
    // POST — simpan data
    $routes->post('save-riwayat', 'Actions\DataEntryAction::saveData');

    // GET — ambil data
    $routes->get('profil',        'Actions\DataReadAction::profil');
    $routes->get('riwayat',       'Actions\DataReadAction::riwayat');
    $routes->get('cek-asi',       'Actions\DataReadAction::cekAsi');
    $routes->get('cek-asi/latest', 'Actions\DataReadAction::cekAsiLatest');
    $routes->get('dashboard',     'Actions\DataReadAction::dashboard');
});
