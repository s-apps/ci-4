<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Dashboard;
use App\Controllers\Customer;
use App\Controllers\Product;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Dashboard::class, 'index']);
$routes->group('customer', static function ($routes) {
    $routes->get('/', [Customer::class, 'index']);
    $routes->get('create', [Customer::class, 'create']);
    $routes->get('edit', [Customer::class, 'edit']);
    $routes->post('save', [Customer::class, 'save']);
    $routes->get('list', [Customer::class, 'list']);
});
$routes->get('product', [Product::class, 'index']);
