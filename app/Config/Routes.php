<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;
use App\Controllers\Dashboard;
use App\Controllers\Customer;
use App\Controllers\Product;

/**
 * @var RouteCollection $routes
 */

$routes->group('auth', static function ($routes) {
    $routes->get('login', [AuthController::class, 'login']);
});

$routes->get('/', [Dashboard::class, 'index']);

service('auth')->routes($routes);

$routes->group('customer', static function ($routes) {
    $routes->get('/', [Customer::class, 'index']);
    $routes->get('create', [Customer::class, 'create']);
    $routes->get('(:num)/edit', [Customer::class, 'edit']);
    $routes->get('delete/(:num)', [Customer::class, 'delete']);
    $routes->post('save', [Customer::class, 'save']);
    $routes->get('list', [Customer::class, 'list']);
});

$routes->group('product', static function ($routes) {
    $routes->get('/', [Product::class, 'index']);
});