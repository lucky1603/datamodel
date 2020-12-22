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



Auth::routes();

Route::get('/edituser/{user}', 'Auth\EditUserController@edit')->name('user.edit');
Route::post('/edituser/{user}', 'Auth\EditUserController@update')->name('user.update');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clients', 'ClientController@index')->name('clients.index');
Route::get('/clients/create', 'ClientController@create')->name('clients.create');
Route::post('/clients/create', 'ClientController@store')->name('clients.store');
Route::get('/clients/companylist', 'ClientController@companyList')->name('clients.companylist');
Route::get('/clients/{client}', 'ClientController@show')->name('clients.show');
Route::get('/clients/edit/{client}', 'ClientController@edit')->name('clients.edit');
Route::post('/clients/update/{client}', 'ClientController@update')->name('clients.update');
Route::get('/clients/preselect/{client}', 'ClientController@preselect')->name('clients.preselect');
Route::post('/clients/preselect/{client}', 'ClientController@preselected')->name('clients.preselected');
Route::get('/clients/register/{client}', 'ClientController@register')->name('clients.register');
Route::get('/clients/invite/{client}', 'ClientController@invite')->name('clients.invite');
Route::post('/clients/invited/{client}', 'ClientController@invited')->name('clients.invited');
Route::get('/clients/confirm/{client}', 'ClientController@confirm')->name('clients.confirm');
Route::post('/clients/confirm/{client}', 'ClientController@confirmed')->name('clients.confirmed');
Route::get('/clients/select/{client}', 'ClientController@select')->name('clients.select');
Route::post('/clients/select/{client}', 'ClientController@selected')->name('clients.selected');
Route::get('/clients/assign/{client}', 'ClientController@assign')->name('clients.assign');
Route::post('/clients/assign/{client}', 'ClientController@assigned')->name('clients.assigned');
Route::get('/clients/assign_contract_date/{client}', 'ClientController@assignContractDate')->name('clients.assignContractDate');
Route::post('/clients/assign_contract_date/{client}', 'ClientController@assignedContractDate')->name('clients.assignedContractDate');

Route::get('/clients/confirm_contract_date/{client}', 'ClientController@confirmContractDate')->name('clients.confirmContractDate');
Route::post('/clients/confirm_contract_date/{client}', 'ClientController@confirmedContractDate')->name('clients.confirmedContractDate');

Route::get('/clients/show_contract/{client}', 'ClientController@showContract')->name('clients.showContract');
Route::get('/clients/profile/{client}', 'ClientController@profile')->name('clients.profile');


Route::get('/contracts', 'ContractsController@index')->name('contracts.index');
Route::get('/contracts/create/{client}', 'ContractsController@create')->name('contracts.create');
Route::post('/contracts/create/{client}', 'ContractsController@store')->name('contracts.store');
Route::get('/contracts/{contract}', 'ContractsController@show')->name('contracts.show');
Route::get('/contracts/payFirstInstallment/{contract}', 'ContractsController@payFirstInstallment')->name('contracts.payfirstinstallment');
Route::post('/contracts/payFirstInstallment/{contract}', 'ContractsController@firstInstallmentPayed')->name('contracts.firstinstallmentpayed');

Route::get('/files/create', 'FileController@create')->name('files.create');
Route::post('/files/create', 'FileController@show')->name('files.show');
Route::get('/situations/{situation}', 'SituationsController@show')->name('situations.show');



