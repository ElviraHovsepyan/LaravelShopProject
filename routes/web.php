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
Route::get('/test','TestController@testCurl');

Route::get('/',function(){return redirect()->route('products');});
Route::get('/products/all/{scroll?}',['uses'=>'ProductsController@show','as'=>'products']);
Route::get('/productDetails/{id}',['uses'=>'PrDetailsController@show','as'=>'productDetails']);
Route::get('/category/{id}/{scroll?}',['uses'=>'CategoryController@category','as'=>'category']);
Route::get('/subCategory/{id}/{scroll?}',['uses'=>'CategoryController@show','as'=>'subCategory']);
Route::get('/login',['uses'=>'RegisterController@show','as'=>'registerView']);
Route::get('/register',['uses'=>'RegisterController@show','as'=>'registerView']);
Route::post('/register',['uses'=>'RegisterController@register','as'=>'register']);
Route::post('/login',['uses'=>'RegisterController@login','as'=>'login']);
Route::get('/logout',['uses'=>'RegisterController@logout','as'=>'logout']);
Route::post('/search',['uses'=>'SearchController@search','as'=>'search']);
Route::post('/searchAll',['uses'=>'SearchController@searchAll','as'=>'searchAll']);
Route::post('/scroll',['uses'=>'ProductsController@scroll','as'=>'scroll']);
Route::get('/chart',['uses'=>'ChartController@show','as'=>'chart']);
Route::post('/chart',['uses'=>'ChartController@getData','as'=>'getData']);
Route::post('/filter',['uses'=>'ProductsController@filter','as'=>'filter']);

Route::group(['middleware'=>'auth'],function (){
    Route::get('/delete/{prId}',['uses'=>'PrDetailsController@deleteItem','as'=>'deleteItem']);
    Route::get('/addNew', ['uses'=>'ProductsController@showAdd','as'=>'addView']);
    Route::post('/addNew', ['uses'=>'ProductsController@addNew','as'=>'addNewItem']);
    Route::get('/update/{uId}', ['uses'=>'ProductsController@updateView','as'=>'updateView']);
    Route::post('/update/{id}', ['uses'=>'ProductsController@update','as'=>'update']);
    Route::get('/admin',['middleware'=>'isAdmin','uses'=>'AdminController@admin','as'=>'admin']);
    Route::get('/promocode',['middleware'=>'isAdmin','uses'=>'AdminController@promocodes','as'=>'promocodes']);
    Route::post('/promocode',['middleware'=>'isAdmin','uses'=>'AdminController@editPromocodes','as'=>'editPromocodes']);
    Route::post('/block',['middleware'=>'isAdmin','uses'=>'AdminController@block','as'=>'block']);
    Route::post('/unBlock',['middleware'=>'isAdmin','uses'=>'AdminController@unBlock','as'=>'unBlock']);
    Route::get('/export',['uses'=>'CsvController@exportCsv','as'=>'export']);
    Route::get('/export/{id}',['uses'=>'CsvController@exportCsvOne','as'=>'exportOne']);
    Route::post('/import',['uses'=>'CsvController@import','as'=>'import']);
    Route::post('/insert',['uses'=>'CsvController@insert','as'=>'insert']);


    Route::post('/add',['uses'=>'PrDetailsController@add','as'=>'add']);
    Route::post('/buy',['uses'=>'PrDetailsController@buy','as'=>'buy']);
    Route::get('/pdf/{name}',['uses'=>'PrDetailsController@createPdf','as'=>'createPdf']);
    Route::get('/myInvoices/{key?}',['uses'=>'PrDetailsController@showInvoices','as'=>'showInvoices']);
    Route::get('/getInvoices/{key}',['uses'=>'PrDetailsController@getInvoices','as'=>'getInvoices']);
    Route::post('/chat',['uses'=>'ChatController@index','as'=>'chat']);
    Route::post('/getUser',['uses'=>'ChatController@getUser','as'=>'getUser']);
    Route::get('/storage',['middleware'=>'isAdmin','uses'=>'AdminController@storage','as'=>'storage']);
    Route::post('/quant',['middleware'=>'isAdmin','uses'=>'AdminController@setQuantity','as'=>'quantity']);
    Route::get('/sale',['middleware'=>'isAdmin','uses'=>'AdminController@sale','as'=>'sale']);
    Route::post('/sale',['middleware'=>'isAdmin','uses'=>'AdminController@getBestSales','as'=>'getSale']);
    Route::get('/subscrAdmin',['middleware'=>'isAdmin','uses'=>'AdminController@subscriptions','as'=>'subscriptions']);
    Route::post('/subscrAdmin',['middleware'=>'isAdmin','uses'=>'AdminController@editSubscriptions','as'=>'editSubscriptions']);
    Route::post('/delSub',['middleware'=>'isAdmin','uses'=>'AdminController@deleteSubscriptions','as'=>'deleteSubscriptions']);
    Route::post('/subscribe',['uses'=>'SubscribeController@subscribe','as'=>'subscribe']);
});

Route::group(['prefix'=>'Api'],function (){
    Route::get('/token',['uses'=>'ApiController@token','as'=>'token']);
    Route::get('/products','ApiCOntroller@getProducts');
    Route::post('/products','ApiCOntroller@addProduct');
    Route::put('/products/{id}', 'ApiController@editProduct');
    Route::get('/product/{id}', 'ApiController@getProduct');
    Route::delete('/products/{id}', 'ApiController@deleteProduct');
});

// google api
Route::get('/google', ['uses'=>'GoogleDriveController@init','as'=>'start']);
Route::get('/google_list', ['uses'=>'GoogleDriveController@getFilesList', 'as' => 'list']);
Route::get('/google_page', ['uses'=>'GoogleDriveController@index','as'=>'index']);
Route::get('/drive', 'GoogleDriveController@getGoogleDriveRedirectData');
Route::post('/google_upload',['uses'=>'GoogleDriveController@uploadFiles','as'=>'upload']);
Route::get('/create_folder',['uses'=>'GoogleDriveController@createFolder','as'=>'createFolder']);
Route::get('/move',['uses'=>'GoogleDriveController@moveBetweenFolders','as'=>'move']);

