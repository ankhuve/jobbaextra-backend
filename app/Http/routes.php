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
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@registerCompany');
    });


Route::get('/', 'DashboardController@index');
Route::get('/featured', 'DashboardController@featured');

Route::get('/{company}', 'DashboardController@companyJobs');
Route::post('/{company}/setPaying', 'CompanyController@setPaying');
Route::post('/{company}/setFeatured', 'CompanyController@setFeatured');
Route::post('/{company}/setLogo', 'CompanyController@setLogo');
