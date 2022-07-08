<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// store
Route::get('/', function() {
	return redirect('/login');
})->name('store.index');
Route::get('store/cars/{page?}', ['as' => 'store.cars', 'uses' => 'App\Http\Controllers\StoreController@cars']);
Route::get('store/about', ['as' => 'sales.about', 'uses' => 'App\Http\Controllers\StoreController@about']);
Route::get('store/contact', ['as' => 'cars.contact', 'uses' => 'App\Http\Controllers\StoreController@contact']);
Route::get('store/services', ['as' => 'cars.services', 'uses' => 'App\Http\Controllers\StoreController@services']);
Route::get('store/car-detail/{carId}', ['as' => 'cars.detail', 'uses' => 'App\Http\Controllers\StoreController@detail']);

Route::group(['middleware' => 'auth'], function () {
	Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::resource('products', 'App\Http\Controllers\ProductController');
	Route::resource('movements', 'App\Http\Controllers\MovementController');
	Route::resource('taxes', 'App\Http\Controllers\TaxController');
	Route::resource('reservations', 'App\Http\Controllers\ReservationController');
	Route::resource('sales', 'App\Http\Controllers\SaleController');
	Route::resource('purchases', 'App\Http\Controllers\PurchaseController');
	Route::resource('clients', 'App\Http\Controllers\ClientController');
	Route::resource('taxations', 'App\Http\Controllers\TaxationController');
	// users
	Route::put('users/{userId}/password', ['as' => 'users.password', 'uses' => 'App\Http\Controllers\UserController@password']);
	Route::get('users/create/new-user-service', ['as' => 'users.create-new-user-service', 'uses' => 'App\Http\Controllers\UserController@createNewUserService']);
	// car entry details
	Route::get('cars/{carId}/edit-details', ['as' => 'cars.edit-details', 'uses' => 'App\Http\Controllers\CarEntryController@editDetails']);
	Route::post('cars/store-details', ['as' => 'cars.store-details', 'uses' => 'App\Http\Controllers\CarEntryController@storeDetails']);
	Route::put('cars/{carEntryId}/update-details', ['as' => 'cars.update-details', 'uses' => 'App\Http\Controllers\CarEntryController@updateDetails']);
	// car entry expenses
	Route::get('cars/{carId}/edit-expenses', ['as' => 'cars.edit-expenses', 'uses' => 'App\Http\Controllers\CarEntryController@editExpenses']);
	Route::post('cars/store-expenses', ['as' => 'cars.store-expenses', 'uses' => 'App\Http\Controllers\CarEntryController@storeExpenses']);
	Route::put('cars/{carEntryId}/update-expenses', ['as' => 'cars.update-expenses', 'uses' => 'App\Http\Controllers\CarEntryController@updateExpenses']);
	// car images
	Route::get('cars/{carId}/edit-images', ['as' => 'cars.edit-images', 'uses' => 'App\Http\Controllers\CarEntryController@editImages']);
	Route::put('cars/{carId}/update-images', ['as' => 'cars.update-images', 'uses' => 'App\Http\Controllers\CarEntryController@updateImages']);
	// car taxes
	Route::get('cars/report/taxes', ['as' => 'cars.taxes', 'uses' => 'App\Http\Controllers\CarController@indexTaxes']);
	// adjust manager
	Route::get('adjust-module/sales-adjust', ['as' => 'sales.saleAdjust', 'uses' => 'App\Http\Controllers\SaleController@saleAdjust']);
	Route::get('adjust-module/purchases-adjust', ['as' => 'purchases.saleAdjust', 'uses' => 'App\Http\Controllers\PurchaseController@purchaseAdjust']);
	// masters
	Route::get('cost-per-day', ['as' => 'costPerDay.edit', 'uses' => 'App\Http\Controllers\MsCostPerDayController@editCostPerDay']);
	Route::post('cost-per-day', ['as' => 'costPerDay.store', 'uses' => 'App\Http\Controllers\MsCostPerDayController@storeCostPerDay']);
	Route::put('cost-per-day', ['as' => 'costPerDay.update', 'uses' => 'App\Http\Controllers\MsCostPerDayController@updateCostPerDay']);
	// taxation images
	Route::get('taxations/{taxationId}/edit-images', ['as' => 'taxations.edit-images', 'uses' => 'App\Http\Controllers\TaxationController@editImages']);
	Route::put('taxations/{taxationId}/update-images', ['as' => 'taxations.update-images', 'uses' => 'App\Http\Controllers\TaxationController@updateImages']);
	// reports
	Route::get('reports/clients', ['as' => 'clients.showReport', 'uses' => 'App\Http\Controllers\ClientController@showReport']);
	Route::get('reports/sales', ['as' => 'sales.showReport', 'uses' => 'App\Http\Controllers\SaleController@showReport']);
	Route::get('reports/cars', ['as' => 'cars.showReport', 'uses' => 'App\Http\Controllers\CarController@showReport']);
	Route::get('reports/cars-history/{number?}', ['as' => 'cars.showHistory', 'uses' => 'App\Http\Controllers\CarController@showHistory']);
	Route::get('reports/salers', ['as' => 'users.showReport', 'uses' => 'App\Http\Controllers\UserController@showReport']);
	// notifications
	Route::get('notifications/soat', ['as' => 'notifications.showSoat', 'uses' => 'App\Http\Controllers\SaleController@showReport']);
	Route::get('notifications/tech', ['as' => 'notifications.showTech', 'uses' => 'App\Http\Controllers\SaleController@showReport']);
	Route::get('notifications/taxes', ['as' => 'notifications.showTaxes', 'uses' => 'App\Http\Controllers\SaleController@showReport']);
	// salers
	Route::get('cars-salers', ['as' => 'cars.index-salers', 'uses' => 'App\Http\Controllers\CarController@indexSalers']);
	Route::get('cars-salers/create', ['as' => 'cars.create-new-salers', 'uses' => 'App\Http\Controllers\CarController@createSalers']);
	Route::get('cars-salers/{carId}/edit', ['as' => 'cars.edit-salers', 'uses' => 'App\Http\Controllers\CarController@editSalers']);
	Route::post('cars-salers', ['as' => 'cars.store-salers', 'uses' => 'App\Http\Controllers\CarController@storeSalers']);
	// documents
	Route::get('documentos', ['as' => 'documents.index', 'uses' => 'App\Http\Controllers\DocumentController@index']);
	Route::get('cargar-documentos', ['as' => 'documents.index', 'uses' => 'App\Http\Controllers\DocumentController@storeExpenses']);
	// sales
	Route::get('update-sold-at-date', ['as' => 'sales.updateSoldAtDate', 'uses' => 'App\Http\Controllers\SaleController@updateSoldAtDate']);
	
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	// api
	Route::get('/api/masters', 'App\Http\Controllers\MsMasterController@indexApi');
	Route::get('/api/clients', 'App\Http\Controllers\ClientController@indexApi');
	Route::get('/api/expenses', 'App\Http\Controllers\CarController@indexExpensesApi');

	Route::get('/api/products', 'App\Http\Controllers\ProductController@apiIndex');
	Route::delete('/api/products/destroy/{productId}', 'App\Http\Controllers\ProductController@apiDestroy');

	Route::get('/api/taxes', 'App\Http\Controllers\TaxController@apiIndex');
	Route::delete('/api/taxes/destroy/{taxId}', 'App\Http\Controllers\TaxController@apiDestroy');

	Route::get('/reservations-calendar', 'App\Http\Controllers\ReservationController@index2');

	Route::get('/api/reservations', 'App\Http\Controllers\ReservationController@apiIndex');
	Route::get('/api/reservations-as-events', 'App\Http\Controllers\ReservationController@apiIndexAsEvents');
	Route::post('/api/reservations', 'App\Http\Controllers\ReservationController@apiStore');
	Route::put('/api/reservations/{id}', 'App\Http\Controllers\ReservationController@apiUpdate');
	Route::delete('/api/reservations/destroy/{reservationId}', 'App\Http\Controllers\ReservationController@apiDestroy');
	Route::get('/api/reservations-destroy/{reservationId}', 'App\Http\Controllers\ReservationController@apiDestroy')->middleware('web');

	Route::post('/api/movements', 'App\Http\Controllers\MovementController@apiStore');

	Route::get('/api/sales/fe-resend/{saleId}', 'App\Http\Controllers\SaleController@apiFeResend');
	Route::get('/api/sales/delete/{saleId}', 'App\Http\Controllers\SaleController@apiDelete');
	Route::post('/api/sales', 'App\Http\Controllers\SaleController@apiStore');
	Route::get('/api/sales-by-reservation-id/{reservationId}', 'App\Http\Controllers\SaleController@apiSalesByReservationId');
	Route::get('/api/sale-by-id/{saleId}', 'App\Http\Controllers\SaleController@apiSaleById');

});

Route::get('/commands/backup', function() {
    /* php artisan cache:clear */
    \Artisan::call('backup:run');

    return "Backup created successfully.";
});