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

/****Getting the language of the user browser****/

$request = request()->segment(1);
$language = null;

if (!empty($request) && in_array($request,config('translatable.locales'))) {
    $language = $request;
    App::setLocale($language);
} else {
    $language = 'en';
}

/*
Route::get('/', function () {
    return view('welcome');
});//*/

Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::group(['prefix' => $language], function () {


    Route::get('/',function () {
        return view('welcome');
    });


    Route::get(trans('routes.home'), [
        'as'      => 'home.index',
        'uses'    => 'HomeController@index']);

   // Route::get(trans('routes.home').'/{locale}', [
    //    'as'      => 'home.transindex',
     //   'uses'    => 'HomeController@transIndex']);

    Route::post('/search', [
        'as'      => 'search',
        'uses'    => 'SearchController@store']);

});


Route::get('/view/{requete}', 'CrawlerController@view');
Route::get('/search/{requete}', 'CrawlerController@search');
//Route::get('/home/{locale}', 'HomeController@transIndex');
/*
Route::get('/search/{requete}', 'CrawlerController@search');
Route::get('/view/{requete}', 'CrawlerController@view');
Route::get('/searchBing/{requete}', 'CrawlerController@searchBing');
Route::get('/viewBing/{requete}', 'CrawlerController@viewBing');

Route::get('/{nb}', 'CrawlerController@nbchange');
Route::get('/search', 'CrawlerController@searchs');
Route::get('/view', 'CrawlerController@views');*/