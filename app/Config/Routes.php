<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->setAutoRoute(true);
$routes->get('/kategori/hapus/(:any)', 'Kategori::index');
$routes->delete('/kategori/hapus/(:any)', 'Kategori::hapus/$1');

$routes->get('/barang/hapus/(:any)', 'Barang::index');
$routes->delete('/barang/hapus/(:any)', 'Barang::hapus/$1');

$routes->resource('register');
$routes->resource('login');

$routes->group('', ['filter' => 'authMiddleware'], function($routes) {
    $routes->resource('kategori');
});