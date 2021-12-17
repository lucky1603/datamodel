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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'HomeController@root');

Auth::routes();

Route::get('analytics/ntp', 'AnalyticsController@ntp')->name('analytics.ntp');
Route::get('analytics/startupTypes', 'AnalyticsController@startupTypes')->name('analytics.startupTypes');
Route::get('analytics/howDidUHear', 'AnalyticsController@howDidUHear')->name('analytics.howDidUHear');
Route::get('analytics/splitInterest', 'AnalyticsController@splitInterest')->name('analytics.splitInterest');
Route::get('analytics/splitOptions/{attributeName}', 'AnalyticsController@splitOptions')->name('anaytics.splitOptions');

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
Route::get('notify', 'AnonimousController@notifyUser')->name('user.notify');
Route::get('confsent', 'AnonimousController@formSent')->name('user.confsent');
Route::get('/createProfile', 'AnonimousController@createProfile')->name('createProfileAnonimous');
Route::post('/createProfile', 'AnonimousController@storeProfile')->name('storeProfileAnonimous');
Route::get('/createRaisingStarts', 'AnonimousController@createRaisingStarts')->name('createRaisingStarts');
Route::post('/createRaisingStarts', 'AnonimousController@storeRaisingStarts')->name('storeRaisingStarts');
Route::get('refreshcaptcha', 'AnonimousController@refreshCaptcha');
Route::get('testmail/{email}', 'AnonimousController@testMail');
Route::get('construction', 'AnonimousController@construction');

Route::get('profiles', 'ProfileController@index')->name('profiles.index');
Route::get('profiles/list', 'ProfileController@list')->name('profiles.list');
Route::post('profiles/filter', 'ProfileController@filter')->name('profiles.filter');
Route::get('profiles/create', 'ProfileController@create')->name('profiles.create');
Route::post('profiles/create', 'ProfileController@store')->name('profiles.store');
Route::get('profiles/edit/{profile}', 'ProfileController@edit')->name('profiles.edit');
Route::post('profiles/edit', 'ProfileController@update')->name('profiles.update');
Route::get('profiles/trainingCandidates', 'ProfileController@getTrainingCandidates')->name('profiles.trainingcandidates');
Route::get('profiles/{profile}', 'ProfileController@show')->name('profiles.show');
Route::get('profiles/programdata/{program}', 'ProfileController@getProgramData')->name('profiles.programdata');
Route::get('profiles/getProgramsForMentor/{mentor}', 'ProfileController@getProgramsForMentor')->name('profiles.programsformentor');
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
Route::post('profiles/evalDemoDay', 'ProfileController@evalDemoDay')->name('profiles.evalDemoDay');
Route::post('profiles/evalPhase', 'ProfileController@evalPhase')->name('profiles.evalPhase');
Route::post('profiles/notifyContract', 'ProfileController@notifyContract')->name('profiles.notifycontract');
Route::post('profiles/saveApplicationData', 'ProfileController@saveApplicationData')->name('profiles.saveapplicationdata');
Route::get('profiles/apply/{program}/{profile}', 'ProfileController@apply')->name('profiles.apply');

Route::get('/files/create', 'FileController@create')->name('files.create');
Route::post('/files/create', 'FileController@show')->name('files.show');
Route::get('/situations/{situation}', 'SituationsController@show')->name('situations.show');

Route::get('/trainings', 'TrainingsController@index')->name('trainings');
Route::get('/trainings/create', 'TrainingsController@create')->name('trainings.create');
Route::post('/trainings/create', 'TrainingsController@store')->name('trainings.store');
Route::post('trainings/filter', 'TrainingsController@filter')->name('trainings.filter');
Route::get('/trainings/forme', 'TrainingsController@forMe')->name('trainings.forme');
Route::get('/trainings/mine', 'TrainingsController@mine')->name('trainings.mine');
Route::post('/trainings/signup', 'TrainingsController@signup')->name('trainings.signup');
Route::post('trainings/update/{training}', 'TrainingsController@update')->name('trainings.update');
Route::get('/trainings/showmine/{training}', 'TrainingsController@showMine')->name('trainings.showmine');
Route::get('/trainings/delete/{training}', 'TrainingsController@delete')->name('trainings.delete');
Route::get('/trainings/{training}', 'TrainingsController@show')->name('trainings.show');

Route::get('mentors', 'MentorController@index')->name('mentors.index');
Route::get('mentors/create', 'MentorController@create')->name('mentors.create');
Route::post('mentors/create', 'MentorController@store')->name('mentors.store');
Route::post('mentors/filter', 'MentorController@filter')->name('mentors.filter');
Route::get('mentors/ownsessions/{mentor}', 'MentorController@ownSessions')->name('mentors.ownsessions');
Route::get('mentors/edit/{mentor}', 'MentorController@edit')->name('mentors.edit');
Route::post('mentors/edit', 'MentorController@update')->name('mentors.update');
Route::get('mentors/showdata/{mentor}', 'MentorController@showData')->name('mentors.showdata');
Route::get('mentors/delete/{mentor}/{program}', "MentorController@deleteProgram")->name('mentors.delete');
Route::get('mentors/forprogram/{program}', 'MentorController@forProgram')->name('mentors.forprogram');
Route::get('mentors/programs/{mentor}', 'MentorController@programs')->name('mentors.programs');
Route::get('mentors/sessions/{program}/{mentor}', 'MentorController@sessions')->name('mentors.sessions');
Route::get('mentors/addprogram/{mentor}', 'MentorController@addProgram')->name('mentors.addprogram');
Route::post('mentors/addprogram', 'MentorController@storeProgram')->name('mentors.storeprogram');
Route::get('mentors/profile/{mentor}', 'MentorController@profile')->name('mentors.profile');

Route::post('/demoday/sendfiles', 'DemoDayController@sendfiles')->name('demoday.sendfiles');
Route::post('/faza1/sendfiles', 'Faza1Controller@sendfiles')->name('faza1.sendfiles');
Route::post('/faza1/update', 'Faza1Controller@update')->name('faza1.update');
Route::post('/demoday/update', 'DemoDayController@update')->name('demoday.update');
Route::post('/preselection/update/{preselection}', 'PreselectionController@update')->name('preselection.update');
Route::post('/selection/update/{selection}', 'SelectionController@update')->name('selection.update');
Route::post('/contracts/update/{contract}', 'ContractsController@update')->name('contract.update');
Route::post('/appeval/update/{appeval}', 'AppFormEvaluationController@update')->name('appeval.update');

Route::post('sessions/create', 'SessionController@store')->name('sessions.store');
Route::post('sessions/edit', 'SessionController@update')->name('sessions.update');
Route::get('sessions/edit/{session}', 'SessionController@edit')->name('sessions.edit');
Route::get('sessions/create/{program}/{mentor}', 'SessionController@create')->name('sessions.create');

Route::get('user/getsessionvalue/{key}', "UserController@getSessionValue")->name('getsessionvalue');
Route::post('user/setsessionvalues', 'UserController@setSessionValues')->name('setsessionvalues');


