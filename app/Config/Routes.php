<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// $routes->get('/', 'Home::index');

$routes->get('/', 'UserLogin::index');
$routes->post('/login', 'UserLogin::login');
$routes->post('/register', 'UserRegister::index');
$routes->get('/logout', 'UserLogin::logout');

$routes->get('/home', 'UserLogin::home', ['filter' => 'Auth']);

$routes->get('/books', 'Books::index', ['filter' => 'Auth']);
$routes->get('/books/new', 'Books::create', ['filter' => 'Auth']);
$routes->post('/books', 'Books::store', ['filter' => 'Auth']);

$routes->get('/perbook/(:num)', 'PerBook::index/$1', ['filter' => 'Auth']);
$routes->get('/perbook/new', 'PerBook::create', ['filter' => 'Auth']);
$routes->post('/perbook', 'PerBook::store', ['filter' => 'Auth']);
$routes->get('/perbook/(:num)/edit', 'PerBook::edit/$1', ['filter' => 'Auth']);
$routes->put('/perbook/(:num)', 'PerBook::update/$1', ['filter' => 'Auth']);

$routes->post('/perbook/dictionary', 'Dictionary::index', ['filter' => 'Auth']);

$routes->get('/percard/(:num)', 'PerCard::index/$1', ['filter' => 'Auth']);

$routes->get('/quizlets', 'Quizlets::index', ['filter' => 'Auth']);
$routes->get('/quizlets/new', 'Quizlets::create', ['filter' => 'Auth']);
$routes->post('/quizlets/generate', 'Quizlets::generateQuiz', ['filter' => 'Auth']);

$routes->get('/quizlets/flashcard', 'Flashcard::index', ['filter' => 'Auth']);
$routes->post('/quizlets/flashcard', 'Flashcard::store', ['filter' => 'Auth']);

$routes->get('/statistics', 'Statistics::index', ['filter' => 'Auth']);
$routes->post('/statistics', 'Statistics::changeDaily', ['filter' => 'Auth']);

$routes->post('/keep', 'Keep::toggleKeep', ['filter' => 'Auth']);

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
