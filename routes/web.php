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

Route::get('/',['uses'=>'ProductsController@show','as'=>'products']);
Route::get('/productDetails/{id}',['uses'=>'PrDetailsController@show','as'=>'productDetails']);
Route::get('/category/{id}',['uses'=>'CategoryController@category','as'=>'category']);
Route::get('/subCategory/{id}',['uses'=>'CategoryController@show','as'=>'subCategory']);
Route::get('/login',['uses'=>'RegisterController@show','as'=>'registerView']);
Route::get('/register',['uses'=>'RegisterController@show','as'=>'registerView']);
Route::post('/register',['uses'=>'RegisterController@register','as'=>'register']);
Route::post('/login',['uses'=>'RegisterController@login','as'=>'login']);
Route::get('/logout',['uses'=>'RegisterController@logout','as'=>'logout']);
Route::post('/search',['uses'=>'SearchController@search','as'=>'search']);
Route::post('/searchAll',['uses'=>'SearchController@searchAll','as'=>'searchAll']);
Route::post('/scroll',['uses'=>'ProductsController@scroll','as'=>'scroll']);


Route::group(['middleware'=>'auth'],function (){

    Route::get('/delete/{prId}',['uses'=>'PrDetailsController@deleteItem','as'=>'deleteItem']);
    Route::get('/addNew', ['uses'=>'ProductsController@showAdd','as'=>'addView']);
    Route::post('/addNew', ['uses'=>'ProductsController@addNew','as'=>'addNewItem']);
    Route::get('/update/{uId}', ['uses'=>'ProductsController@updateView','as'=>'updateView']);
    Route::post('/update/{id}', ['uses'=>'ProductsController@update','as'=>'update']);
    Route::get('/admin',['middleware'=>'isAdmin','uses'=>'AdminController@admin','as'=>'admin']);
    Route::post('/block',['middleware'=>'isAdmin','uses'=>'AdminController@block','as'=>'block']);
    Route::post('/unBlock',['middleware'=>'isAdmin','uses'=>'AdminController@unBlock','as'=>'unBlock']);

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








