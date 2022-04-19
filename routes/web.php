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


Route::post('/healthform', ['as'=>'healthform.show', 'uses'=>'HealthFormController@show']);
Route::patch('/healthform/update/{healthform}', ['as'=>'healthform.update', 'uses'=>'HealthFormController@update']);


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


    Route::group(['middleware' => 'manager'], function() {
        Route::resource('dashboard/users', 'AdminUsersController', ['as' => 'dashboard']);
        Route::get('users/createDataTables', ['as'=>'users.CreateDataTables','uses'=>'AdminUsersController@createDataTables']);
        Route::resource('dashboard/healthforms', 'HealthFormController');
        Route::post('dashboard/healthforms/import',  ['as'=>'healthforms.import', 'uses'=>'HealthformController@import']);
        Route::get('healthforms/createDataTables', ['as'=>'healthforms.CreateDataTables','uses'=>'HealthformController@createDataTables']);
    });
});
