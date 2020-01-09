<?php namespace Config;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('App\Controllers\Production\Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'App\Controllers\Production\Home::index');
$routes->group('/', ['namespace' => 'App\Controllers\Production'], function($routes) {
	$routes->get('categories/(:any)', 'Categories::index/$1');
	$routes->get('business/(:any)', 'Business::index/$1');
	$routes->get('blog/(:num)', 'Blog::index/$1');
	$routes->get('homeLogin', 'Login::index');
});


$routes->get('login', 'Login::index');
$routes->group('login', function($routes) {
	$routes->get('logout', 'Login::logout');
	$routes->post('submit', 'Login::submit');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
	$routes->get('dashboard', 'Dashboard::index');

	$routes->get('categories', 'Categories::index');
	$routes->group('categories', function($routes) {
		$routes->get('addNew', 'Categories::addNew');
		$routes->get('edit/(:num)', 'Categories::edit/$1');
		$routes->post('submit', 'Categories::submit');
		$routes->post('getData', 'Categories::getData');
		$routes->post('delete', 'Categories::delete');
	});
	
	$routes->get('profile', 'Profile::index');
	$routes->group('profile', function($routes) {
		$routes->get('addNew', 'Profile::addNew');
		$routes->get('edit/(:num)', 'Profile::edit/$1');
		$routes->post('submit', 'Profile::submit');
		$routes->post('getData', 'Profile::getData');
		$routes->post('delete', 'Profile::delete');
	});

	$routes->group('users', ['namespace' => 'App\Controllers\Admin\Users'], function($routes) {
		$routes->get('account', 'Account::index');
		$routes->group('account', function($routes) {
			$routes->post('getData', 'Account::getData');
			$routes->post('delete', 'Account::delete');
			$routes->get('addNew', 'Account::addNew');
			$routes->get('edit/(:num)', 'Account::edit/$1');
			$routes->post('submit', 'Account::submit');
		});

		$routes->get('profile', 'Profile::index');
		$routes->group('profile', function($routes) {
			$routes->post('submit', 'Profile::submit');
		});
	});

	$routes->get('blog', 'Blog::index');
	$routes->group('blog', function($routes) {
		$routes->get('addNew', 'Blog::addNew');
		$routes->get('edit/(:num)', 'Blog::edit/$1');
		$routes->post('submit', 'Blog::submit');
		$routes->post('getData', 'Blog::getData');
		$routes->post('delete', 'Blog::delete');
	});
});

$routes->group('usaha', ['namespace' => 'App\Controllers\Usaha'], function($routes) {
	$routes->get('dashboard', 'Dashboard::index');

	$routes->group('profile', ['namespace' => 'App\Controllers\Usaha\Profile'], function($routes) {
		$routes->get('info', 'Info::index');
		$routes->group('info', function($routes) {
			$routes->post('submit', 'Info::submit');
		});

		$routes->get('item', 'Item::index');
		$routes->group('item', function($routes) {
			$routes->get('edit/(:num)', 'Item::edit/$1');
			$routes->post('submit', 'Item::submit');
			$routes->post('getData', 'Item::getData');
			$routes->post('delete', 'Item::delete');
		});
	});

	$routes->get('gallery', 'Gallery::index');
	$routes->group('gallery', function($routes) {
		$routes->post('submit', 'Gallery::submit');
		$routes->post('delete', 'Gallery::delete');
	});

	$routes->get('account', 'Account::index');
	$routes->group('account', function($routes) {
		$routes->post('submit', 'Account::submit');
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
