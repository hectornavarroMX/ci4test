<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('citas', 'Citas::index');
$routes->post('citas/guardar', 'Citas::guardar');
$routes->get('citas/eliminar/(:num)', 'Citas::eliminar/$1');