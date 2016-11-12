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
*/

Route::auth();

Route::group(['middleware' => ['auth']], function () {
    Route::get('register', 'Auth\AuthController@showRegistrationForm')->name('register');;
    Route::post('register', 'Auth\AuthController@registerCompany');
    });


Route::get('/', 'DashboardController@index')->name('home');

Route::get('/jobs', 'JobsController@index')->name('jobs');
Route::post('/changeJobOwner', 'JobsController@changeJobOwner');

Route::get('/featured', 'FeaturedController@all')->name('featured');
Route::get('/featured/{companyId}', 'FeaturedController@edit')->name('editFeatured');
Route::post('/featured/{id}', 'FeaturedController@save');
Route::post('/featured/{id}/upload', 'FeaturedController@uploadImage');

Route::get('/pages', 'PagesController@index')->name('pages');
Route::post('/pages/create', 'PagesController@create');
Route::get('/pages/delete/{id}', 'PagesController@delete');
Route::get('/pages/{id}', 'PagesController@edit')->name('editPage');
Route::post('/editBlock/{blockId}', 'PagesController@saveBlock');

Route::get('/users', 'DashboardController@users')->name('users');

Route::get('/{company}', 'DashboardController@company')->name('company');
Route::post('/{company}/setPaying', 'CompanyController@setPaying');
Route::post('/{company}/setFeatured', 'CompanyController@setFeatured');
Route::post('/{company}/setLogo', 'CompanyController@setLogo');
Route::get('/{company}/delete/{jobId}', 'CompanyController@delete');
Route::get('/{company}/create', 'DashboardController@editJob')->name('createJob');
Route::post('/{company}/create', 'DashboardController@saveNewJob')->name('saveNewJob');
Route::get('/{company}/edit/{id}', 'DashboardController@editJob');
Route::post('/{company}/edit/{id}', 'DashboardController@saveJob');
