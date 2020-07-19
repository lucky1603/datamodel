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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clients', 'ClientController@index')->name('clients.index');
Route::get('/clients/create', 'ClientController@create')->name('clients.create');
Route::post('/clients/create', 'ClientController@store')->name('clients.store');
Route::get('/clients/{client}', 'ClientController@show')->name('clients.show');
Route::get('/contracts', 'ContractsController@index')->name('contracts.index');
Route::get('/contracts/create', 'ContractsController@create')->name('contracts.create');
Route::post('/contracts/create', 'ContractsController@store')->name('contracts.store');
Route::get('/contracts/{contract}', 'ContractsController@show')->name('contracts.show');

Route::get('/files/create', 'FileController@create')->name('files.create');
Route::post('/files/create', 'FileController@show')->name('files.show');


