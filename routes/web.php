<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

// ---------- Registration ----------------
Route::get('users/register',	'Auth\RegisterController@showRegistrationForm');
Route::post('users/register',	'Auth\RegisterController@register');

// ---------- login ----------
// Route::get('users/login',	'Auth\LoginController@showLoginForm'); //Error Route [login] not defined
Route::get('users/login',	'Auth\LoginController@showLoginForm')->name('login');
Route::post('users/login',	'Auth\LoginController@login'); 

// logoout
Route::get('users/logout',	'Auth\LoginController@logout');


// --- admin ---
Route::group(
	array('prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>'manager'),	
	function()	{
		Route::get('users',	'UsersController@index');

		// Route::get('users',	['as'=>'admin.user.index',	'uses'=>'UsersController@index']);

		// admin roles
		Route::get('roles',	'RolesController@index');
		Route::get('roles/create',	'RolesController@create');
		Route::post('roles/create',	'RolesController@store');

		// make user and 'admin' or 'member'
		Route::get('users/{id?}/edit',	'UsersController@edit');
		Route::post('users/{id?}/edit','UsersController@update');

		// admin pages
		Route::get('/', 'PagesController@home');


		// admin  products
		Route::get('products',	'ProductsController@index');
		Route::get('products/create',	'ProductsController@create');
		Route::post('products/create',	'ProductsController@store');
		Route::get('products/{id?}/edit',	'ProductsController@edit');
		Route::post('products/{id?}/edit','ProductsController@update');

		// admin category
		Route::get('categories',	'CategoriesController@index');
		Route::get('categories/create',	'CategoriesController@create'); // show Form
		Route::post('categories/create',	'CategoriesController@store'); // POST form
		Route::get('categories/{id}/edit',	'CategoriesController@edit');
		Route::post('categories/{id}/edit',	'CategoriesController@update');
			
		// admin sizes
		Route::get('sizes',	'SizesController@index');
		Route::get('sizes/create',	'SizesController@create'); // show Form
		Route::post('sizes/create',	'SizesController@store'); // POST form
		Route::get('sizes/{id}/edit',	'SizesController@edit');
		Route::post('sizes/{id}/edit',	'SizesController@update');
			
				
	}

);


Route::get('/', 'FrontController@home');
Route::get('/shop',	'FrontController@index'); // show All products
Route::get('/shop/{slug?}', 'FrontController@show'); // show Single product

// CART
Route::get('/cart', 'CartsController@index'); // 
Route::get('/cart/create', 'CartsController@store'); // add to cart
Route::get('/cart/destroy/{id}', 'CartsController@destroy'); // DELETe single Caart item


// Checkout
//Route::get('/checkout', 'CustomersController@create'); // Show Form
Route::get('/checkout', 'CheckoutController@create'); // Show Form
//Route::post('/checkout', 'CustomersController@store'); // POST Form
Route::post('/checkout', 'CheckoutController@store'); // POST Form


//billing : Stripe 
Route::get('/billing', 'StripeBillingController@create'); // show FORM
Route::post('/billing', 'StripeBillingController@store')->name('stripe.post'); // POST FORM



Route::post('/comment',	'CommentsController@newComment');// POST insert Comment in DB