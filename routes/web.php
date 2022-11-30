<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('analytics/raisingStartsDashboard', 'AnalyticsController@raisingStartsDashboard')->name('analytics.RsDashboard');
Route::get('analytics/getProfileStatisticsSummary', 'AnalyticsController@getProfileStatisticsSummary')->name('analytics.getProfileStatisticsSummary');
Route::post('analytics/startupTypes', 'AnalyticsController@startupTypes')->name('analytics.startupTypes');
Route::get('analytics/howDidUHear', 'AnalyticsController@howDidUHear')->name('analytics.howDidUHear');
Route::get('analytics/howDidUHear1/{year}', 'AnalyticsController@howDidUHear1')->name('analytics.howDidUHear1');
Route::get('analytics/splitInterest', 'AnalyticsController@splitInterest')->name('analytics.splitInterest');
Route::get('analytics/countries', 'AnalyticsController@getCountries')->name('analytics.countries');
Route::post('analytics/countryNames', 'AnalyticsController@getCountryNames')->name('analytics.countryNames');
Route::post('analytics/workshopAndSessionStats', 'AnalyticsController@getWorkshopAndSessionStats')->name('analytics.workshopAndSessionStats');
Route::get('analytics/splitOptions/{attributeName}/{year}', 'AnalyticsController@splitOptions')->name('analytics.splitOptions');
Route::post('analytics/programStatuses', 'AnalyticsController@programStatuses')->name('analytics.programStatuses');
Route::post('analytics/ntp', 'AnalyticsController@ntp')->name('analytics.ntp');


Route::get('/edituser', 'Auth\EditUserController@index')->name('users');
Route::get('/edituser/addadmin', 'Auth\EditUserController@addadmin')->name('user.addadmin');
Route::get('/edituser/changePasswordFromEmail/{token}', 'Auth\EditUserController@changePasswordFromEmail')->name('user.changePasswordFromEmail');
Route::post('/edituser/changePassword', 'Auth\EditUserController@changePassword')->name('user.changePassword');
Route::post('/edituser/initSendPassword', 'Auth\EditUserController@initSendPassword')->name('user.initSendPassword');
Route::post('/edituser/adminadded', 'Auth\EditUserController@adminadded')->name('user.adminadded');
Route::post('/edituser/deleteAsync', 'Auth\EditUserController@deleteAsync')->name('user.deleteAsync');
Route::post('/edituser/deleted', 'Auth\EditUserController@deleted')->name('user.deleted');
Route::post('/edituser/updatePassword', 'Auth\EditUserController@updatePassword')->name('user.updatepassword');
Route::get('/edituser/addforprofile/{profile}', 'Auth\EditUserController@addForProfile')->name('user.addforprofile');
Route::post('/edituser/addedforprofile/{profile}', 'Auth\EditUserController@addedForProfile')->name('user.addedforprofile');
Route::get('edituser/userData/{user}', 'Auth\EditUserController@userData')->name('user.userData');
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
Route::get('wrongUserPassword', 'AnonimousController@wrongUserPassword')->name('wrongUserPassword');
Route::get('confsent', 'AnonimousController@formSent')->name('user.confsent');
Route::get('/createProfile', 'AnonimousController@createProfile')->name('createProfileAnonimous');
Route::post('/createProfile', 'AnonimousController@storeProfile')->name('storeProfileAnonimous');
Route::get('/createRaisingStarts', 'AnonimousController@createRaisingStarts')->name('createRaisingStarts');
Route::post('/createRaisingStarts', 'AnonimousController@storeRaisingStarts')->name('storeRaisingStarts');
Route::get('createIncubationBITF', 'AnonimousController@createIncubationBITF')->name('createIncubationBITF');
Route::post('storeIncubationBITF', 'AnonimousController@storeIncubationBITF')->name('storeIncubationBITF');
Route::get('createRastuce', 'AnonimousController@createRastuce')->name('createRastuce');
Route::post('createRastuce', 'AnonimousController@storeRastuce')->name('storeRastuce');
Route::get('refreshcaptcha', 'AnonimousController@refreshCaptcha');
Route::get('testmail/{email}', 'AnonimousController@testMail');
Route::get('construction', 'AnonimousController@construction');
Route::get('expired', 'AnonimousController@accountExpired')->name('expired');
Route::get('toggleLocale', 'AnonimousController@toggleLocale')->name('toggleLocale');
Route::get('universities','AnonimousController@universities')->name('universities');

Route::get('programs/statistics/{program}', 'ProgramController@getStatistics')->name('program.getStatistics');
Route::post('programs/statistics', 'ProgramController@updateStatistics')->name('program.updateStatistics');
Route::post('programs/backToForm', 'ProgramController@backToForm')->name('programs.backToForm');

Route::get('profiles', 'ProfileController@index')->name('profiles.index');
Route::get('profiles/situations/{profile}', 'ProfileController@getSituations')->name('profiles.situations');
Route::post('profiles/setSessionVars', 'ProfileController@setSessionVars')->name('profiles.setSessionVars');
Route::get('profiles/exportProfiles', 'ProfileController@exportProfiles')->name('profiles.exportProfiles');
Route::get('profiles/programStatisticsDashboard', 'ProfileController@programStatisticsDashboard')->name('profiles.programStatisticsDashboard');
Route::get('profiles/exportRaisingStarts', 'ProfileController@exportRaisingStarts')->name('profiles.exportRaisingStarts');
Route::get('profiles/bulkMail', 'ProfileController@prepareMail')->name('profiles.prepareMail');
Route::post('profiles/bulkMail', 'ProfileController@sendMail')->name('profiles.sendMail');
Route::get('profiles/mailClients', 'ProfileController@getMailClients')->name('profiles.mailClients');
Route::get('profiles/list', 'ProfileController@list')->name('profiles.list');
Route::post('profiles/filter', 'ProfileController@filter')->name('profiles.filter');
Route::post('profiles/filterCache', 'ProfileController@filterCache')->name('profiles.filterCache');
Route::get('profiles/create', 'ProfileController@create')->name('profiles.create');
Route::post('profiles/create', 'ProfileController@store')->name('profiles.store');
Route::get('profiles/programsForProfile/{profile}', 'ProfileController@getProgramsForProfile')->name('profiles.programs');
Route::get('profiles/profileUsers/{profile}', 'ProfileController@getProfileUsers')->name('profiles.profileUsers');
Route::post('profiles/programAttendances/{profile}', 'ProfileController@programAttendances')->name('profiles.programAttendances');
Route::get('profiles/edit/{profile}', 'ProfileController@edit')->name('profiles.edit');
Route::get('profiles/statistics/{profile}', 'ProfileController@getStatistics')->name('profiles.getStatistics');
Route::post('profiles/statistics', 'ProfileController@updateStatistics')->name('profiles.updateStatistics');
Route::post('profiles/edit', 'ProfileController@update')->name('profiles.update');
Route::get('profiles/trainingCandidates', 'ProfileController@getTrainingCandidates')->name('profiles.trainingcandidates');
Route::get('profiles/{profile}', 'ProfileController@show')->name('profiles.show');
Route::get('profiles/pvd/{profile}', 'ProfileController@getProfileViewData')->name('profiles.pvd');
Route::get('profiles/profileTexts/{profile}', 'ProfileController@getProfileTexts')->name('profiles.profileTexts');
Route::get('profiles/profileData/{profile}', 'ProfileController@getProfileData')->name('profiles.profileData');
Route::get('profiles/programdata/{program}', 'ProfileController@getProgramData')->name('profiles.programdata');
Route::get('profiles/getProgramsForMentor/{mentor}', 'ProfileController@getProgramsForMentor')->name('profiles.programsformentor');
//Route::get('profiles/reports/{profile}', "ProfileController@reports")->name('profiles.reports');
Route::get('profiles/trainings/{profile}', "ProfileController@trainings")->name('profiles.trainings');
Route::get('profiles/sessions/{profile}', "ProfileController@sessions")->name('profiles.sessions');
Route::get('profiles/verify/{token}', 'ProfileController@verify')->name('profiles.verify');
Route::get('profiles/profile/{profile}', 'ProfileController@profile')->name('profiles.profile');
Route::get('profiles/profile/showTraining/{profile}/{training}', 'ProfileController@showTraining')->name('profiles.showProfileTraining');
Route::get('profiles/check/{profile}', 'ProfileController@check')->name('profiles.check');
Route::post('profiles/evalPreselection', 'ProfileController@evalPreselection')->name('profiles.evalpreselection');
Route::post('profiles/evalSelection', 'ProfileController@evalSelection')->name('profiles.evalselection');
Route::post('profiles/evalContract', 'ProfileController@evalContract')->name('profiles.evalcontract');
Route::post('profiles/evalDemoDay', 'ProfileController@evalDemoDay')->name('profiles.evalDemoDay');
Route::post('profiles/evalPhase', 'ProfileController@evalPhase')->name('profiles.evalPhase');
Route::post('profiles/notifyContract', 'ProfileController@notifyContract')->name('profiles.notifycontract');
Route::post('profiles/saveApplicationData', 'ProfileController@saveApplicationData')->name('profiles.saveapplicationdata');
Route::post('profiles/saveIBITFApplicationData', 'ProfileController@saveIBITFApplicationData')->name('profiles.saveIBITFApplicationData');
Route::get('profiles/otherCompanies/{profile}', 'ProfileController@otherCompanies')->name('profiles.otherCompanies');
Route::post('profiles/otherCompanies/{profile}', 'ProfileController@filterOtherCompanies')->name('profiles.filterOtherCompanies');
Route::get('profiles/apply/{program}/{profile}', 'ProfileController@apply')->name('profiles.apply');

Route::get('programs', 'ProgramController@index')->name('programs.index');
Route::get('programs/create', 'ProgramController@create')->name('programs.create');
Route::get('programs/{program}', 'ProgramController@show')->name('programs.show');
Route::get('programs/sessions/{program}', 'ProgramController@sessions')->name('programs.sessions');
Route::get('programs/check/{program}', 'ProgramController@check')->name('programs.check');
Route::get('programs/profile/{program}', 'ProgramController@profile')->name('programs.profile');
Route::get('programs/apply/{program}/{profile}', 'ProgramController@apply')->name('programs.apply');
Route::get('programs/trainings/{program}', 'ProgramController@trainings')->name('programs.trainings');
Route::post('programs/attendances/{program}', 'ProgramController@attendances')->name('programs.attendances');
Route::get('programs/training/{program}/{training}', 'ProgramController@training')->name('programs.training');
Route::post('programs/filterCache', 'ProgramController@filterCache')->name('programs.filterCache');
Route::post('programs/evalPhase', 'ProgramController@evalPhase')->name('programs.evalPhase');
Route::post('programs/saveApplicationData', 'ProgramController@saveApplicationData')->name('programs.saveapplicationdata');
Route::post('programs/saveIBITFApplicationData', 'ProgramController@saveIBITFApplicationData')->name('programs.saveIBITFApplicationData');


Route::get('/files/create', 'FileController@create')->name('files.create');
Route::post('/files/create', 'FileController@show')->name('files.show');
Route::get('/situations/{situation}', 'SituationsController@show')->name('situations.show');

Route::get('/trainings', 'TrainingsController@index')->name('trainings');
Route::get('trainings/edit/{training}', 'TrainingsController@edit')->name('trainings.edit');
Route::post('trainings/update/{training}', 'TrainingsController@update')->name('trainings.update');
Route::get('/trainings/create', 'TrainingsController@create')->name('trainings.create');
Route::post('/trainings/create', 'TrainingsController@store')->name('trainings.store');
Route::post('trainings/filter', 'TrainingsController@filter')->name('trainings.filter');
Route::get('/trainings/forme', 'TrainingsController@forMe')->name('trainings.forme');
Route::get('/trainings/mine', 'TrainingsController@mine')->name('trainings.mine');
Route::post('/trainings/signup', 'TrainingsController@signup')->name('trainings.signup');
Route::get('/trainings/showmine/{training}', 'TrainingsController@showMine')->name('trainings.showmine');
Route::get('/trainings/delete/{training}', 'TrainingsController@delete')->name('trainings.delete');
Route::get('trainings/fetch/{trainingId}', 'TrainingsController@fetch')->name('trainings.fetch');
Route::get('trainings/get/{training}', 'TrainingsController@get')->name('trainings.get');
Route::get('trainings/attendance/{training}/{program}', 'TrainingsController@getAttendance')->name('trainings.attendance');
Route::get('/trainings/{training}', 'TrainingsController@show')->name('trainings.show');
Route::post('trainings/{training}', 'TrainingsController@updateAttendances')->name('trainings.updateAttendances');

Route::get('mentors', 'MentorController@index')->name('mentors.index');
Route::get('mentors/create', 'MentorController@create')->name('mentors.create');
Route::post('mentors/create', 'MentorController@store')->name('mentors.store');
Route::post('mentors/filter', 'MentorController@filter')->name('mentors.filter');
Route::post('mentors/filterAddPrograms/{mentor}', 'MentorController@filterAddPrograms')->name('mentors.filterAddPrograms');
Route::get('mentors/getData/{mentor}', 'MentorController@getData')->name('mentors.getData');
Route::get('mentors/ownsessions/{mentor}', 'MentorController@ownSessions')->name('mentors.ownsessions');
Route::get('mentors/edit/{mentor}', 'MentorController@edit')->name('mentors.edit');
Route::post('mentors/edit', 'MentorController@update')->name('mentors.update');
Route::get('mentors/showdata/{mentor}', 'MentorController@showData')->name('mentors.showdata');
Route::get('mentors/deleteAllPrograms/{mentor}', 'MentorController@deleteAllPrograms')->name('mentors.deleteAllPrograms');
Route::get('mentors/deleteProgram/{mentor}/{program}', "MentorController@deleteProgram")->name('mentors.delete');
Route::get('mentors/forprogram/{program}', 'MentorController@forProgram')->name('mentors.forprogram');
Route::get('mentors/programs/{mentor}', 'MentorController@programs')->name('mentors.programs');
Route::get('mentors/sessions/{program}/{mentor}', 'MentorController@sessions')->name('mentors.sessions');
Route::get('mentors/reportsForProgram/{mentor}/{program}', 'MentorController@reportsForProgram')->name('mentors.reportsForProgram');
Route::get('mentors/addprogram/{mentor}', 'MentorController@addProgram')->name('mentors.addprogram');
Route::post('mentors/addprogram', 'MentorController@storeProgram')->name('mentors.storeprogram');
Route::get('mentors/profile/{mentor}', 'MentorController@profile')->name('mentors.profile');
Route::post('mentors/saveSelectedProgram', 'MentorController@saveSelectedProgram');
Route::post('mentors/getSelectedProgram', 'MentorController@getSelectedProgram');

Route::post('mentor-reports/addFileGroup', 'MentorReportController@fileGroupAdded')->name('mentorreports.fileGroupAdded');
Route::get('mentor-reports/get/{report}', "MentorReportController@get")->name('mentorreports.get');
Route::get('mentor-reports/edit/{report}', 'MentorReportController@edit')->name('mentorreports.edit');

Route::post('/demoday/sendfiles', 'DemoDayController@sendfiles')->name('demoday.sendfiles');
Route::post('/faza1/sendfiles', 'Faza1Controller@sendfiles')->name('faza1.sendfiles');
Route::post('/faza1/update', 'Faza1Controller@update')->name('faza1.update');
Route::post('/faza1/rollback', 'Faza1Controller@rollback')->name('faza1.rollback');
Route::post('/demoday/update', 'DemoDayController@update')->name('demoday.update');
Route::post('/preselection/update/{preselection}', 'PreselectionController@update')->name('preselection.update');
Route::post('/selection/update/{selection}', 'SelectionController@update')->name('selection.update');
Route::post('contracts/deleteDocument', 'ContractsController@deleteContractDocument')->name('contracts.deleteDocument');
Route::post('/contracts/update/{contract}', 'ContractsController@update')->name('contract.update');
Route::post('/appeval/update/{appeval}', 'AppFormEvaluationController@update')->name('appeval.update');

Route::post('sessions/create', 'SessionController@store')->name('sessions.store');
Route::post('sessions/edit', 'SessionController@update')->name('sessions.update');
Route::get('sessions/edit/{session}', 'SessionController@edit')->name('sessions.edit');
Route::get('sessions/create/{program}/{mentor}', 'SessionController@create')->name('sessions.create');
Route::post('sessions/getSessionData', 'SessionController@getSessionData');

Route::get('user/getsessionvalue/{key}', "UserController@getSessionValue")->name('getsessionvalue');
Route::post('user/setsessionvalues', 'UserController@setSessionValues')->name('setsessionvalues');

Route::post('reports/addFileGroup', 'ReportController@fileGroupAdded')->name('reports.fileGroupAdded');
Route::post('reports/deleteFileGroup', 'ReportController@deleteFileGroup')->name('reports.deleteFileGroup');
Route::get('reports/{report}', 'ReportController@edit')->name('reports.edit');
Route::post('reports/changeSyncState', 'ReportController@changeSyncState')->name('reports.changeSyncState');
Route::get('reports/getStatistics/{report}', 'ReportController@getStatistics')->name('report.getStatistics');
Route::post('reports/changeStatus', 'ReportController@changeStatus')->name('reports.changeStatus');
Route::post('reports/statistics', 'ReportController@updateStatistics')->name('reports.updateStatistics');
Route::post('reports/{report}', 'ReportController@update')->name('reports.update');
Route::get('reports/addFileGroup/{report}', 'ReportController@addFileGroup')->name('reports.addFileGroup');
Route::get('reports/create/{program}', 'ReportController@create')->name('reports.create');
Route::post('reports/create/{report}', 'ReportController@store')->name('reports.store');
Route::get('reports/list/{program}', "ReportController@list")->name('reports.list');
Route::get('reports/getData/{report}', "ReportController@getData")->name('reports.getData');
Route::get('reports/programReports/{program}', 'ReportController@programReports')->name('reports.programReports');
Route::get('reports/programReportsInfo/{program}', 'ReportController@programReportsInfo')->name('reports.programReportsInfo');

Route::get('forms/showRaisingStarts', 'FormController@showRaisingStarts')->name('forms.showRaisingStarts');
Route::get('forms/showIncubation', 'FormController@showIncubation')->name('forms.showIncubation');
Route::get('forms/showForms', 'FormController@showForms')->name('forms.showForms');

Route::get('/lang-{lang}.js', 'LanguageController@show');



