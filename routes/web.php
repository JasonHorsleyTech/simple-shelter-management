<?php

use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'feature'], function () {
    Route::get('/converse', function () {
        return view('feature.converse');
    });
    Route::get('/formfill', function () {
        return view('feature.formfill');
    });
    Route::get('/navigate', function () {
        return view('feature.navigate');
    });
    Route::get('/inquire', function () {
        return view('feature.inquire');
    });
    Route::get('/audit', function () {
        return view('feature.audit');
    });
    Route::get('/execute', function () {
        return view('feature.execute');
    });
});


Route::get('/test', function () {
});
