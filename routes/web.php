<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\PromotionController;


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

/*
Para que vaya al nuevo home
Route::get('/', function () {
    return view('welcome');
});
*/

/*
Esta opcion sería sin agregar un controlador

Route::get('/home', function () {
    return view('home.home');
});
*/

// esta opcion es para agregar una ruta con controlador
Route::get( '/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// todas las rutas al AdminController
Route::resource( 'admin', AdminController::class)->middleware('auth', 'verified');

// todas las rutas al OrderController
Route::get('/verify-payment/{id}','App\Http\Controllers\OrderController@verifyPaymentID')->name('order.verifyPaymentID')->middleware('auth', 'verified');
Route::get('/order-to-verify','App\Http\Controllers\OrderController@showToVerify')->name('order.showToVerify')->middleware('auth', 'verified');
Route::get('/order-to-send','App\Http\Controllers\OrderController@showToSend')->name('order.showToSend')->middleware('auth', 'verified');
Route::get('/order-sent','App\Http\Controllers\OrderController@showSent')->name('order.showSent')->middleware('auth', 'verified');
Route::resource( 'order', OrderController::class)->middleware('auth', 'verified');

// todas las rutas al UserAdminController
Route::get('/user-admin','App\Http\Controllers\UserAdminController@index')->name('useradmin.index')->middleware('auth', 'verified');
Route::get('/user-admin/{id}/upper','App\Http\Controllers\UserAdminController@upper')->name('useradmin.upper')->middleware('auth', 'verified');
Route::get('/user-admin/{id}/lower','App\Http\Controllers\UserAdminController@lower')->name('useradmin.lower')->middleware('auth', 'verified');
Route::delete('/user-admin/{id}','App\Http\Controllers\UserAdminController@destroy')->name('useradmin.destroy')->middleware('auth', 'verified');

// todas las rutas al CategoryController
Route::resource( 'category', CategoryController::class)->middleware('auth', 'verified');

// todas las rutas al CategoryController
Route::resource( 'categoryproduct', CategoryProductController::class)->middleware('auth', 'verified');

// todas las rutas al PromotionController
Route::resource( 'promotion', PromotionController::class)->middleware('auth', 'verified');

// todas las rutas al StoreController
Route::get('/payorder/{id}','App\Http\Controllers\StoreController@payorder')->name('store.payorder');
Route::get('/store-grid','App\Http\Controllers\StoreController@indexGrid')->name('store.indexGrid');
Route::get('/store-grid-category/{id}','App\Http\Controllers\StoreController@indexGridCategory')->name('store.indexGridCategory');
Route::get('/store-grid-promotion','App\Http\Controllers\StoreController@indexGridPromotion')->name('store.indexGridPromotion');
Route::resource( 'store', StoreController::class);

// rutas para la autenticacion de usuario
Auth::routes(['verify' => true]);

// ruta para la verificación de email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

// rutas para el carro de compras

Route::post('/cart-add', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/cart-checkout','App\Http\Controllers\CartController@cart')->name('cart.checkout');
Route::post('/cart-clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
Route::post('/cart-removeitem', 'App\Http\Controllers\CartController@removeitem')->name('cart.removeitem');
Route::post('/cart-update', 'App\Http\Controllers\CartController@update')->name('cart.update');

// confirmación del carro y pago
Route::post( '/paycart', [StoreController::class, 'paycart']);
// redireccion final mercado pago
Route::get( '/success', [StoreController::class, 'success']);
Route::get( '/failure', [StoreController::class, 'failure']);
Route::get( '/pending', [StoreController::class, 'pending']);

// rutas para la edicion de usuarios
Route::get('/user-edit','App\Http\Controllers\UserController@edit')->name('user.edit');

Route::post('/user-update','App\Http\Controllers\UserController@update')->name('user.update');

