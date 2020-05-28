<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes(['register' => false, 'reset' => false]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/administration', 'AdministrationController@index')->name('administration');
Route::get('/projet/{id}', 'ProjetController@index')->name('projet');
Route::get('/issue/{projet}/{id}', 'IssueController@index')->name('issue');
Route::get('/new/issue/{projet}', 'IssueController@new')->name('new_issue');

Route::prefix('v1')->group(function () {
    Route::get('users', 'AdministrationController@users');
    Route::get('projets', 'AdministrationController@projets');
    Route::post('projets/{id}', 'AdministrationController@deleteProjet');
    Route::put('projets', 'AdministrationController@ajoutProjet');
    Route::post('users/{id}', 'AdministrationController@delete');
    Route::put('users', 'AdministrationController@ajout');
    Route::get('/projet/{id}', 'ProjetController@get');
    Route::post('/new/issue/{projet}', 'IssueController@add');
});
