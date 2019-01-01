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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(array('middleware' => 'auth'), function(){
// User With Login    
Route::get('/home', array('as' => 'home', 'routegroup' => 'home', 'uses' => 'HomeController@index'));

Route::get('/user', array('as' => 'user', 'searchtype' => '3', 'routegroup' => 'user', 'uses' => 'UserController@index'));
Route::get('/user/create', array('as' => 'user.create', 'routegroup' => 'user', 'uses' => 'UserController@create'));
Route::post('/user/store', array('as' => 'user.store', 'routegroup' => 'user','uses' => 'UserController@store'));
Route::get('/user/{id}/edit', array('as' => 'user.edit', 'routegroup' => 'profile','uses' => 'UserController@edit'));
Route::get('/user/{id}/delete', array('as' => 'user.delete', 'routegroup' => 'user', 'uses' => 'UserController@delete'));
Route::post('/user/update', array('as' => 'user.update', 'routegroup' => 'user', 'uses' => 'UserController@update'));

// Customer With Login    
Route::get('/customer', array('as' => 'customer', 'searchtype' => '2','routegroup' => 'customer','uses' => 'CustomerController@index'));
Route::get('/customer/create', array('as' => 'customer.create','routegroup' => 'customer', 'uses' => 'CustomerController@create'));
Route::post('/customer/store', array('as' => 'customer.store','routegroup' => 'customer', 'uses' => 'CustomerController@store'));
Route::get('/customer/{id}/edit', array('as' => 'customer.edit','routegroup' => 'customer', 'uses' => 'CustomerController@edit'));
Route::get('/customer/{id}/delete', array('as' => 'customer.delete','routegroup' => 'customer', 'uses' => 'CustomerController@delete'));
Route::post('/customer/update', array('as' => 'customer.update','routegroup' => 'customer', 'uses' => 'CustomerController@update'));

Route::get('/bill', array('as' => 'bill', 'searchtype' => '1','routegroup' => 'bill', 'uses' => 'BillController@index'));
Route::get('/billclose', array('as' => 'bill.close', 'searchtype' => '5','routegroup' => 'billclose',  'uses' => 'BillController@closelist'));
Route::get('/bill/create', array('as' => 'bill.create','routegroup' => 'bill', 'uses' => 'BillController@create'));
Route::post('/bill/store', array('as' => 'bill.store','routegroup' => 'bill', 'uses' => 'BillController@store'));
Route::get('/bill/{id}/edit', array('as' => 'bill.edit','routegroup' => 'bill', 'uses' => 'BillController@edit'));
Route::get('/bill/{id}/delete', array('as' => 'bill.delete','routegroup' => 'bill', 'uses' => 'BillController@delete'));
Route::post('/bill/update', array('as' => 'bill.update','routegroup' => 'bill', 'uses' => 'BillController@update'));
Route::get('/bill/{id}/close/{val}', array('as' => 'update.close','routegroup' => 'bill', 'uses' => 'BillController@updateClose'));

Route::get('/sizewithprice', array('as' => 'sizewithprice', 'searchtype' => '4','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@index'));
Route::get('/sizewithprice/create', array('as' => 'sizewithprice.create','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@create'));
Route::post('/sizewithprice/store', array('as' => 'sizewithprice.store','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@store'));
Route::get('/sizewithprice/{id}/edit', array('as' => 'sizewithprice.edit','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@edit'));
Route::get('/sizewithprice/{id}/delete', array('as' => 'sizewithprice.delete','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@delete'));
Route::post('/sizewithprice/update/{id}', array('as' => 'sizewithprice.update','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@update'));
Route::post('/copy-design', array('as' => 'sizewithprice.copy','routegroup' => 'sizewithprice', 'uses' => 'SizeWithPriceController@copyDesign'));

Route::get('/order', array('as' => 'order', 'searchtype' => '6','routegroup' => 'order', 'uses' => 'OrderController@index'));
Route::get('/order/{id}', array('as' => 'order.detail','routegroup' => 'bill', 'uses' => 'BillController@orderDetail'));
Route::post('/order/store', array('as' => 'order.store','routegroup' => 'bill', 'uses' => 'BillController@orderStore'));
Route::get('/order/{id}/delete/{bill_id}', array('as' => 'order.delete','routegroup' => 'bill', 'uses' => 'BillController@orderDelete'));

Route::post('/stoke', array('as' => 'stoke','routegroup' => 'stoke' , 'uses' => 'CustomerController@stokeindex'));
Route::post('/addstoke', array('as' => 'add.stoke','routegroup' => 'stoke', 'uses' => 'CustomerController@stokeadd'));

Route::get('/get-sizewithprice', array('as' => 'get.sizewithprice', 'uses' => 'BillController@getSizeWithPrice'));
Route::post('/assign-cloth', array('as' => 'assigncloth.store', 'uses' => 'BillController@assignCloth'));

Route::post('/payment', array('as' => 'payment.store', 'uses' => 'BillController@paymentPrice'));
Route::post('/autosearch-data', array('as' => 'autosearch.data', 'uses' => 'BillController@autoSearchData'));

Route::get('/report', array('as' => 'report','routegroup' => 'report', 'uses' => 'CustomerController@reportData'));
Route::get('/report-html', array('as' => 'report.html', 'uses' => 'OrderController@reportHtml'));

Route::get('/storage', array('as' => 'storage','routegroup' => 'storage', 'searchtype' => '7', 'uses' => 'OrderController@storage'));
Route::post('/storage', array('as' => 'storage.store','routegroup' => 'storage', 'uses' => 'OrderController@saveStorage'));
Route::get('/storage/{id}/delete', array('as' => 'storage.delete','routegroup' => 'storage', 'uses' => 'OrderController@delete'));

Route::post('/add-customer', array('as' => 'add.customer', 'uses' => 'BillController@addCustomer'));
Route::post('/add-cloth', array('as' => 'add.cloth', 'uses' => 'HomeController@addCloth'));
Route::post('/check-valid-order', array('as' => 'valid.order', 'uses' => 'OrderController@checkValidOrder'));

Route::get('/logout', array('as' => 'logout', 'uses' => 'UserController@logout'));
});