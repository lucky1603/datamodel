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

Route::get('/edituser', 'Auth\EditUserController@index')->name('users');
Route::get('/edituser/addadmin', 'Auth\EditUserController@addadmin')->name('user.addadmin');
Route::post('/edituser/adminadded', 'Auth\EditUserController@adminadded')->name('user.adminadded');
Route::post('/edituser/deleted', 'Auth\EditUserController@deleted')->name('user.deleted');
Route::get('/edituser/addforclient/{client}', 'Auth\EditUserController@addforclient')->name('user.addforclient');
Route::post('/edituser/addedforclient/{client}', 'Auth\EditUserController@addedforclient')->name('user.addedforclient');
Route::get('/edituser/add', 'Auth\EditUserController@add')->name('user.add');
Route::get('/edituser/{user}', 'Auth\EditUserController@edit')->name('user.edit');
Route::post('/edituser/{user}', 'Auth\EditUserController@update')->name('user.update');
Route::post('/edituser/added/{client}', 'Auth\EditUserController@added')->name('user.added');
Route::get('/edituser/delete/{client}', 'Auth\EditUserController@delete')->name('user.delete');
Route::get('/edituser/editfromadminpreview/{client}', 'Auth\EditUserController@editFromAdminPreview')->name('user.editfromadminpreview');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clients', 'ClientController@index')->name('clients.index');
Route::get('/clients/create', 'ClientController@create')->name('clients.create');
Route::post('/clients/create', 'ClientController@store')->name('clients.store');
Route::get('/clients/companylist', 'ClientController@companyList')->name('clients.companylist');
Route::get('/clients/{client}', 'ClientController@show')->name('clients.show');
Route::get('/clients/check/{client}', 'ClientController@check')->name('clients.check');
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

Route::get('profiles', 'ProfileController@index')->name('profiles.index');
Route::get('profiles/{profile}', 'ProfileController@show')->name('profiles.show');


Route::get('/contracts', 'ContractsController@index')->name('contracts.index');
Route::get('/contracts/create/{client}', 'ContractsController@create')->name('contracts.create');
Route::post('/contracts/create/{client}', 'ContractsController@store')->name('contracts.store');
Route::get('/contracts/{contract}', 'ContractsController@show')->name('contracts.show');
Route::get('/contracts/payFirstInstallment/{contract}', 'ContractsController@payFirstInstallment')->name('contracts.payfirstinstallment');
Route::post('/contracts/payFirstInstallment/{contract}', 'ContractsController@firstInstallmentPayed')->name('contracts.firstinstallmentpayed');
Route::get('/contracts/destroy/{contract}', 'ContractsController@destroy')->name('contracts.destroy');

Route::get('/files/create', 'FileController@create')->name('files.create');
Route::post('/files/create', 'FileController@show')->name('files.show');
Route::get('/situations/{situation}', 'SituationsController@show')->name('situations.show');

Route::get('/trainings', 'TrainingsController@index')->name('trainings');
Route::get('/trainings/create', 'TrainingsController@create')->name('trainings.create');
Route::post('/trainings/create', 'TrainingsController@store')->name('trainings.store');
Route::get('/trainings/forme', 'TrainingsController@forMe')->name('trainings.forme');
Route::get('/trainings/mine', 'TrainingsController@mine')->name('trainings.mine');
Route::post('/trainings/signup', 'TrainingsController@signup')->name('trainings.signup');
Route::get('/trainings/showmine/{training}', 'TrainingsController@showMine')->name('trainings.showmine');
Route::get('/trainings/delete/{training}', 'TrainingsController@delete')->name('trainings.delete');
Route::get('/trainings/{training}', 'TrainingsController@show')->name('trainings.show');



