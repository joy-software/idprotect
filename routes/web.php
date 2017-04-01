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
Route::get('/searchBing/{requete}', 'CrawlerController@searchBing');
Route::get('/viewBing/{requete}', 'CrawlerController@viewBing');
Route::get('/searchDuck/{requete}', 'CrawlerController@searchDuck');
Route::get('/viewDuck/{requete}', 'CrawlerController@viewDuck');
Route::get('/viewUrl/{requete}', 'CrawlerController@viewUrl');
Route::get('/{nb}', 'CrawlerController@nbchange');
Route::get('/search', 'CrawlerController@searchs');
Route::get('/view', 'CrawlerController@views');