<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\CustomerController;
use App\Controllers\PackageController;
use App\Controllers\ProductController;
use App\Controllers\OrderController;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('/', [DashboardController::class, 'index']);

$routes->group('customer', static function ($routes) {
    $routes->get('/', [CustomerController::class, 'index']);
    $routes->get('create', [CustomerController::class, 'create']);
    $routes->get('(:num)/edit', [CustomerController::class, 'edit']);
    $routes->get('delete/(:num)', [CustomerController::class, 'delete']);
    $routes->post('save', [CustomerController::class, 'save']);
    $routes->get('list', [CustomerController::class, 'list']);
});

$routes->group('package', static function ($routes) {
    $routes->get('/', [PackageController::class, 'index']);
    $routes->get('create', [PackageController::class, 'create']);
    $routes->get('(:num)/edit', [PackageController::class, 'edit']);
    $routes->get('delete/(:num)', [PackageController::class, 'delete']);
    $routes->post('save', [PackageController::class, 'save']);
    $routes->get('list', [PackageController::class, 'list']);
});

$routes->group('product', static function ($routes) {
    $routes->get('/', [ProductController::class, 'index']);
    $routes->get('create', [ProductController::class, 'create']);
    $routes->get('(:num)/edit', [ProductController::class, 'edit']);
    $routes->get('delete/(:num)', [ProductController::class, 'delete']);
    $routes->post('save', [ProductController::class, 'save']);
    $routes->get('list', [ProductController::class, 'list']);
    $routes->get('get/(:num)',  [ProductController::class, 'get']);
});

$routes->group('order', static function ($routes) {
    $routes->get('/', [OrderController::class, 'index']);
    $routes->get('create', [OrderController::class, 'create']);
    $routes->get('create_customer_list', [OrderController::class, 'create_customer_list']);
    $routes->get('create_product_list', [OrderController::class, 'create_product_list']);
});