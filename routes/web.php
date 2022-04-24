<?php

use App\Http\Controllers\HomeController;
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


Route::post('/healthform', ['as'=>'healthform.edit', 'uses'=>'HealthFormController@edit']);
Route::patch('/healthform/update/{healthform}', ['as'=>'healthform.update', 'uses'=>'HealthFormController@update']);
Route::get('/healthform/show/{healthform}', ['as'=>'healthform.show', 'uses'=>'HealthFormController@show']);
Route::get('/healthform/download/{healthform}', ['as'=>'healthform.downloadPDF', 'uses'=>'HealthFormController@downloadPDF']);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function() {

    Route::get('/dashboard', [HomeController::class, 'index']);

    Route::get('/user/{user}', ['as'=>'dashboard.user', 'uses'=>'UsersController@edit']);
    Route::patch('/user/{user}', ['as'=>'dashboard.update', 'uses'=>'UsersController@update']);

    Route::resource('dashboard/healthinformation', 'HealthInformationController');
    Route::get('healthinformation/createDataTables', ['as'=>'healthinformation.CreateDataTables','uses'=>'HealthInformationController@createDataTables']);
    Route::resource('dashboard/incidents', 'IncidentController');
    Route::get('incidents/createDataTables', ['as'=>'incidents.CreateDataTables','uses'=>'IncidentController@createDataTables']);
    Route::resource('dashboard/measures', 'MeasureController');
    Route::get('measures/createDataTables', ['as'=>'measures.CreateDataTables','uses'=>'MeasureController@createDataTables']);
    Route::resource('dashboard/medications', 'MedicationController');
    Route::get('medications/createDataTables', ['as'=>'medications.CreateDataTables','uses'=>'MedicationController@createDataTables']);
    Route::resource('dashboard/monitoring', 'MonitoringController');
    Route::get('monitoring/createDataTables', ['as'=>'monitoring.CreateDataTables','uses'=>'MonitoringController@createDataTables']);
    Route::resource('dashboard/surveillance', 'SurveillanceController');
    Route::get('surveillance/createDataTables', ['as'=>'surveillance.CreateDataTables','uses'=>'SurveillanceController@createDataTables']);
    Route::resource('dashboard/healthstatus', 'HealthStatusController');
    Route::get('healthstatus/createDataTables', ['as'=>'healthstatus.CreateDataTables','uses'=>'HealthStatusController@createDataTables']);

    Route::group(['middleware' => 'manager'], function() {
        Route::resource('dashboard/users', 'AdminUsersController', ['as' => 'dashboard']);
        Route::get('users/createDataTables', ['as'=>'users.CreateDataTables','uses'=>'AdminUsersController@createDataTables']);
        Route::resource('dashboard/healthforms', 'HealthFormController')->except(['show', 'update', 'edit']);
        Route::post('dashboard/healthforms/import',  ['as'=>'healthforms.import', 'uses'=>'HealthFormController@import']);
        Route::get('healthforms/createDataTables', ['as'=>'healthforms.CreateDataTables','uses'=>'HealthFormController@createDataTables']);
    });
});

Route::get('admin/run-migrations', function () {
    return Artisan::call('migrate', ["--force" => true ]);
});

Route::get('admin/run-deployment', function () {
    Artisan::call('optimize:clear');
    return true;
});

Route::get('admin/run-migrations-seed', function () {
    return Artisan::call('migrate:refresh', ["--seed" => true ]);
});
