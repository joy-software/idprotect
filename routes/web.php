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

Route::get('/home', 'HomeController@index');

Route::get('/search/{requete}', 'CrawlerController@search');
Route::get('/view/{requete}', 'CrawlerController@view');
Route::get('/search', 'CrawlerController@searchs');
Route::get('/view', 'CrawlerController@views');