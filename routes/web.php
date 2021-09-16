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

Route::get('/edituser', 'Auth\EditUserController@index')->name('users');
Route::get('/edituser/addadmin', 'Auth\EditUserController@addadmin')->name('user.addadmin');
Route::post('/edituser/adminadded', 'Auth\EditUserController@adminadded')->name('user.adminadded');
Route::post('/edituser/deleted', 'Auth\EditUserController@deleted')->name('user.deleted');
Route::post('/edituser/updatePassword', 'Auth\EditUserController@updatePassword')->name('user.updatepassword');
Route::get('/edituser/addforprofile/{profile}', 'Auth\EditUserController@addForProfile')->name('user.addforprofile');
Route::post('/edituser/addedforprofile/{profile}', 'Auth\EditUserController@addedForProfile')->name('user.addedforprofile');
Route::get('/edituser/add', 'Auth\EditUserController@add')->name('user.add');
Route::get('/edituser/{user}', 'Auth\EditUserController@edit')->name('user.edit');
Route::post('/edituser/{user}', 'Auth\EditUserController@update')->name('user.update');
Route::post('/edituser/added/{client}', 'Auth\EditUserController@added')->name('user.added');
Route::get('/edituser/delete/{client}', 'Auth\EditUserController@delete')->name('user.delete');
Route::get('/edituser/editfromadminpreview/{client}', 'Auth\EditUserController@editFromAdminPreview')->name('user.editfromadminpreview');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testuser/{user}', 'AnonimousController@testuser')->name('user.test');
Route::get('/verify/{token}', 'AnonimousController@verify')->name('user.verify');
Route::get('/notify/{token}', 'AnonimousController@notifyUser')->name('user.notify');
Route::get('/createProfile', 'AnonimousController@createProfile')->name('createProfileAnonimous');
Route::post('/createProfile', 'AnonimousController@store')->name('storeProfileAnonimous');

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
Route::get('profiles/create', 'ProfileController@create')->name('profiles.create');
Route::post('profiles/create', 'ProfileController@store')->name('profiles.store');
Route::get('profiles/{profile}', 'ProfileController@show')->name('profiles.show');
Route::get('profiles/testMail/{profile}', 'ProfileController@testMail')->name('profiles.testmail');
Route::get('profiles/reports/{profile}', "ProfileController@reports")->name('profiles.reports');
Route::get('profiles/trainings/{profile}', "ProfileController@trainings")->name('profiles.trainings');
Route::get('profiles/sessions/{profile}', "ProfileController@sessions")->name('profiles.sessions');
Route::get('profiles/verify/{token}', 'ProfileController@verify')->name('profiles.verify');
Route::get('profiles/profile/{profile}', 'ProfileController@profile')->name('profiles.profile');
Route::get('profiles/check/{profile}', 'ProfileController@check')->name('profiles.check');
Route::post('profiles/evalPreselection', 'ProfileController@evalPreselection')->name('profiles.evalpreselection');
Route::post('profiles/evalSelection', 'ProfileController@evalSelection')->name('profiles.evalselection');
Route::post('profiles/evalContract', 'ProfileController@evalContract')->name('profiles.evalcontract');
Route::post('profiles/notifyContract', 'ProfileController@notifyContract')->name('profiles.notifycontract');
Route::post('profiles/saveApplicationData', 'ProfileController@saveApplicationData')->name('profiles.saveapplicationdata');
Route::get('profiles/apply/{program}/{profile}', 'ProfileController@apply')->name('profiles.apply');

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

Route::get('mentors', 'MentorController@index')->name('mentors.index');
Route::get('mentors/create', 'MentorController@create')->name('mentors.create');
Route::post('mentors/create', 'MentorController@store')->name('mentors.store');
Route::get('mentors/delete/{mentor}/{program}', "MentorController@deleteProgram")->name('mentors.delete');
Route::get('mentors/programs/{mentor}', 'MentorController@programs')->name('mentors.programs');
Route::get('mentors/sessions/{program}/{mentor}', 'MentorController@sessions')->name('mentors.sessions');
Route::get('mentors/addprogram/{mentor}', 'MentorController@addProgram')->name('mentors.addprogram');
Route::post('mentors/addprogram', 'MentorController@storeProgram')->name('mentors.storeprogram');
Route::get('mentors/profile/{mentor}', 'MentorController@profile')->name('mentors.profile');

Route::post('/preselection/update/{preselection}', 'PreselectionController@update')->name('preselection.update');
Route::post('/selection/update/{selection}', 'SelectionController@update')->name('selection.update');
Route::post('/contracts/update/{contract}', 'ContractsController@update')->name('contract.update');

Route::post('sessions/create', 'SessionController@store')->name('sessions.store');
Route::get('sessions/create/{program}/{mentor}', 'SessionController@create')->name('sessions.create');


