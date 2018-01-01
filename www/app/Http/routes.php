<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
['middleware' => 'web']
в этом файле app/Providers/RouteServiceProvider.php  уже прописана эта группа посредников
 для всех  маршрутов их можно не прописовать
*/

Route::group([], function () {

    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home']);

    Route::get('/page/{alias}', ['uses' => 'PageController@execute', 'as' => 'page']);

    Route::auth();


});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', function () {

       if (view()->exists('admin.index')){
           $date = ['title' => 'Панель администратора'];

           return view('admin.index', $date);

       }
    });

//Группа  маршрутов для работы с информацией хранящейся в таблице pages
    Route::group(['prefix' => 'pages'], function () {

     Route::get('/', ['uses' => 'PagesController@execute', 'as' => 'pages']);

     Route::match(['get', 'post'], '/add', ['uses' => 'PagesAddController@execute', 'as' => 'pagesAdd']);

     Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses' => 'PagesEditController@execute', 'as' => 'pagesEdit']);

    });

//Группа  маршрутов для работы с информацией хранящейся в таблице portfolios

    Route::group(['prefix' => 'portfolios'], function () {

        Route::get('/', ['uses' => 'PortfoliosController@execute', 'as' => 'portfolio']);

        Route::match(['get', 'post'], '/add', ['uses' => 'PortfoliosAddController@execute', 'as' => 'portfoliosAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses' => 'PortfoliosEditController@execute', 'as' => 'portfoliosEdit']);

    });

    //Группа  маршрутов для работы с информацией хранящейся в таблице services

    Route::group(['prefix' => 'services'], function () {

        Route::get('/', ['uses' => 'ServiceController@execute', 'as' => 'services']);

        Route::match(['get', 'post'], '/add', ['uses' => 'ServicesAddController@execute', 'as' => 'servicesAdd']);


        Route::match(['get', 'post', 'delete'], '/edit/{service}', ['uses' => 'ServicesEditController@execute', 'as' => 'servicesEdit']);

    });


});
Route::auth();

Route::get('/home', 'HomeController@index');
