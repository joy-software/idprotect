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



//Route::get('/home', 'HomeController@index');
Route::group(['prefix' => $language], function () {


    Route::get('/',function () {
        return view('welcome');
    });

    Auth::routes();

    // registration activation routes
    Route::get('activation/key/{activation_key}', ['as' => 'activation_key', 'uses' => 'Auth\ActivationKeyController@activateKey']);
    Route::get('activation/resend', ['as' =>  'activation_key_resend', 'uses' => 'Auth\ActivationKeyController@showKeyResendForm']);
    Route::post('activation/resend', ['as' =>  'activation_key_resend.post', 'uses' => 'Auth\ActivationKeyController@resendKey']);

    Route::get(trans('routes.home'), [
        'as'      => 'home',
        'uses'    => 'HomeController@index']);

   // Route::get(trans('routes.home').'/{locale}', [
    //    'as'      => 'home.transindex',
     //   'uses'    => 'HomeController@transIndex']);

    Route::post('/search', [
        'as'      => 'search',
        'uses'    => 'SearchController@store']);

    Route::post('/validSearchResult', [
        'as'      => 'validSR',
        'uses'    => 'SearchController@valid']);

    Route::post('/rejectSearchResult', [
        'as'      => 'rejectSR',
        'uses'    => 'SearchController@reject']);

    Route::post('/profile', [
        'as'      => 'profile',
        'uses'    => 'SearchController@profile']);

    Route::post('/avatar', [
        'as'      => 'avatar',
        'uses'    => 'SearchController@avatar']);

    Route::get('/load', [
        'as'      => 'load',
        'uses'    => 'SearchController@load']);

    Route::post('/p_load', [
        'as'      => 'p_load',
        'uses'    => 'SearchController@p_load']);

    Route::get('/search/{request}', 'CrawlerController@search');
    Route::get('/searchII/{request}', 'CrawlerController@addsearchII');
    Route::get('/searchS/{request}/{index}', 'CrawlerController@searchSocial');
    Route::get('/searchD/{request}/{index}', 'CrawlerController@searchDocument');
    Route::get('/searchV/{request}', 'CrawlerController@searchVideo');
    Route::get('/searchI/{request}', 'CrawlerController@searchImages');
    Route::get('/addsearch/{request}', 'CrawlerController@addsearch');
    Route::get('/addsearchII/{request}', 'CrawlerController@addsearchII');
    Route::get('/addsearchS/{request}/{index}', 'CrawlerController@addsearchSocial');
    Route::get('/addsearchD/{request}/{index}', 'CrawlerController@addsearchDocument');
    Route::get('/addsearchV/{request}', 'CrawlerController@addsearchVideo');
    Route::get('/addsearchI/{request}', 'CrawlerController@addsearchImages');


});

Route::get('/test', [
    'uses'    => 'SearchController@load']);

Route::get('/',function () {
  return  redirect()->route(trans('routes.home'));
});

Route::get('/view/{request}', 'CrawlerController@view');
Route::get('/search/img/{search}/{link?}', 'CrawlerController@fetching_img')
    ->where('link', '(.*)');


Route::get('auth/{provider}/', 'SocialAuthController@redirect');
Route::get('auth/{provider}/callback', 'SocialAuthController@callback');

Route::get('LoginLang/{lang}',function($lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/login')->withInput();
    }
    else{
        return  redirect('/en/login')->withInput();
    }

});

Route::get('RegisterLang/{lang}',function($lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/register')->withInput();
    }
    else{
        return  redirect('/en/register')->withInput();
    }

});

Route::get('HomeLang/{lang}',function($lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/accueil')->withInput();
    }
    else{
        return  redirect('/en/home')->withInput();
    }

});

Route::get('EmailLang/{lang}',function($lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/password/reset')->withInput();
    }
    else{
        return  redirect('/en/password/reset')->withInput();
    }

});

Route::get('EmailLang/{key}/{lang}',function($key,$lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/password/reset/'.$key)->withInput();
    }
    else{
        return  redirect('/en/password/reset/'.$key)->withInput();
    }

});

Route::get('KeyLang/{lang}',function($lang){

    if(str_contains($lang,'en'))
    {
        return  redirect('/fr/activation/resend')->withInput();
    }
    else{
        return  redirect('/en/activation/resend')->withInput();
    }

});

//Route::get('/home/{locale}', 'HomeController@transIndex');
/*
Route::get('/search/{requete}', 'CrawlerController@search');
Route::get('/view/{requete}', 'CrawlerController@view');
Route::get('/searchBing/{requete}', 'CrawlerController@searchBing');
Route::get('/viewBing/{requete}', 'CrawlerController@viewBing');

Route::get('/{nb}', 'CrawlerController@nbchange');
Route::get('/search', 'CrawlerController@searchs');
Route::get('/view', 'CrawlerController@views');*/