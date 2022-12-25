<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) 
    require SYSTEMPATH . 'Config/Routes.php';

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/autenticacion/login', 'Autenticacion::login');
$routes->group('api', ['namespace' => 'App\Controllers\API', 'filter' => 'autFiltro'], function($routes) {
    //  Cliente.
    $routes->get('clientes', 'Clientes::index');
    $routes->post('clientes/crear', 'Clientes::crear');
    $routes->get('clientes/editar/?(:num)?', 'Clientes::editar/$1');  // Los ? son para que el parámetro sea opcional.
    $routes->put('clientes/actualizar/?(:num)?', 'Clientes::actualizar/$1');
    $routes->delete('clientes/eliminar/?(:num)?', 'Clientes::eliminar/$1');
    //  Cuenta.
    $routes->get('cuentas', 'Cuentas::index');
    $routes->post('cuentas/crear', 'Cuentas::crear');
    $routes->get('cuentas/editar/?(:num)?', 'Cuentas::editar/$1'); 
    $routes->put('cuentas/actualizar/?(:num)?', 'Cuentas::actualizar/$1');
    $routes->delete('cuentas/eliminar/?(:num)?', 'Cuentas::eliminar/$1');
    //  Tipo de Transacciones.
    $routes->get('tipo_transaccion', 'TipoTransaccion::index');
    $routes->post('tipo_transaccion/crear', 'TipoTransaccion::crear');
    $routes->get('tipo_transaccion/editar/?(:num)?', 'TipoTransaccion::editar/$1'); 
    $routes->put('tipo_transaccion/actualizar/?(:num)?', 'TipoTransaccion::actualizar/$1');
    $routes->delete('tipo_transaccion/eliminar/?(:num)?', 'TipoTransaccion::eliminar/$1');
    // Transacciones.
    $routes->get('transaccion', 'Transaccion::index');
    $routes->post('transaccion/crear', 'Transaccion::crear');
    $routes->get('transaccion/editar/?(:num)?', 'Transaccion::editar/$1'); 
    $routes->put('transaccion/actualizar/?(:num)?', 'Transaccion::actualizar/$1');
    $routes->delete('transaccion/eliminar/?(:num)?', 'Transaccion::eliminar/$1');
    $routes->get('transaccion/cliente/?(:num)?', 'Transaccion::cliente/$1');  // Implementa una consulta multitabla.
    // Roles.
    $routes->get('roles', 'Roles::index');
    $routes->post('roles/crear', 'Roles::crear');
    $routes->get('roles/editar/?(:num)?', 'Roles::editar/$1');
    $routes->put('roles/actualizar/?(:num)?', 'Roles::actualizar/$1');
    $routes->delete('roles/eliminar/?(:num)?', 'Roles::eliminar/$1');
    // Usuarios
    $routes->get('usuarios', 'Usuarios::index');
    $routes->post('usuarios/crear', 'Usuarios::crear');
    $routes->get('usuarios/editar/?(:num)?', 'Usuarios::editar/$1');
    $routes->put('usuarios/actualizar/?(:num)?', 'Usuarios::actualizar/$1');
    $routes->delete('usuarios/eliminar/?(:num)?', 'Usuarios::eliminar/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
