<?php

use App\Http\Controllers\Assistants\AutoformCreateUserController;
use App\Http\Controllers\AssistantsDemoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::get('/assistants', [AssistantsDemoController::class, 'index']);
    Route::get('/assistants/{assistant}/{inputMethod}', [AssistantsDemoController::class, 'show'])->name('assistants.show');


    // Route::group(['prefix' => 'assistants'], function () {
    //     Route::get('/', function () {
    //         return view('demo.assistants.index');
    //     });
    // });

    // // TODO:
    // Route::group(['prefix' => 'feature'], function () {
    //     Route::get('/formfill', function () {
    //         return view('feature.formfill');
    //     });
    //     Route::get('/navigate', function () {
    //         return view('feature.navigate');
    //     });
    //     Route::get('/inquire', function () {
    //         return view('feature.inquire');
    //     });
    //     Route::get('/audit', function () {
    //         return view('feature.audit');
    //     });
    //     Route::get('/execute', function () {
    //         return view('feature.execute');
    //     });
    // });
});
