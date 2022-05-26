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


Route::get('/healthform', ['as'=>'healthform.edit', 'uses'=>'HealthFormController@edit']);
Route::patch('/healthform/update/{healthform}', ['as'=>'healthform.update', 'uses'=>'HealthFormController@update']);
Route::get('/healthform/show/{healthform}', ['as'=>'healthform.show', 'uses'=>'HealthFormController@show']);
Route::get('/healthform/download/{healthform}', ['as'=>'healthform.downloadPDF', 'uses'=>'HealthFormController@downloadPDF']);
Route::get('healthform/searchajaxcity', ['as'=>'searchajaxcity','uses'=>'HealthFormController@searchResponseCity']);
Route::get('healthform/downloadVaccination/{healthform}', ['as'=>'downloadVaccination','uses'=>'HealthFormController@downloadVaccination']);
Route::get('healthform/downloadAllergy/{healthform}', ['as'=>'downloadAllergy','uses'=>'HealthFormController@downloadAllergy']);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'verified'], function() {

    Route::get('/dashboard', [HomeController::class, 'index']);

    Route::get('/user/{user}', ['as'=>'dashboard.user', 'uses'=>'UsersController@edit']);
    Route::patch('/user/{user}', ['as'=>'dashboard.update', 'uses'=>'UsersController@update']);

    Route::resource('dashboard/healthinformation', 'HealthInformationController');
    Route::get('healthinformation/createDataTables', ['as'=>'healthinformation.CreateDataTables','uses'=>'HealthInformationController@createDataTables']);
    Route::get('healthinformation/searchajaxcode', ['as'=>'searchajaxcode','uses'=>'HealthInformationController@searchResponseCode']);
    Route::get('healthinformation/search', ['uses'=>'HealthInformationController@search']);
    Route::resource('dashboard/interventions', 'InterventionController');
    Route::get('interventions/createDataTables', ['as'=>'interventions.CreateDataTables','uses'=>'InterventionController@createDataTables']);

    Route::group(['middleware' => 'manager'], function() {
        Route::resource('dashboard/users', 'AdminUsersController', ['as' => 'dashboard']);
        Route::get('users/createDataTables', ['as'=>'users.CreateDataTables','uses'=>'AdminUsersController@createDataTables']);
        Route::resource('dashboard/healthforms', 'HealthFormController')->except(['show', 'update', 'edit']);
        Route::post('dashboard/healthforms/import',  ['as'=>'healthforms.import', 'uses'=>'HealthFormController@import']);
        Route::get('healthforms/createDataTables', ['as'=>'healthforms.CreateDataTables','uses'=>'HealthFormController@createDataTables']);
        Route::get('healthinformation/print/{healthinformation}', ['as'=>'healthinformation.print','uses'=>'HealthInformationController@print']);
        Route::post('dashboard/healthinformation/uploadProtocol/{healthinformation}', ['as'=>'uploadProtocol','uses'=>'HealthInformationController@uploadProtocol']);
        Route::get('healthinformation/downloadProtocol/{healthinformation}', ['as'=>'downloadProtocol','uses'=>'HealthInformationController@downloadProtocol']);
        Route::post('healthforms/{healthform}/open', ['as'=>'healthforms.open','uses'=>'HealthFormController@open']);
    });

    Route::group(['middleware' => 'admin'], function() {
        Route::get('audits', ['as'=>'dashboard.audits', 'uses'=>'AuditController@index']);
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
    return Artisan::call('migrate:refresh', ["--seed" => true , "--force" => true ]);
});

Route::get('admin/run-seeding', function () {
    return Artisan::call('db:seed', ["--class" => "InterventionSeeder" , "--force" => true ]);
});
