<?php

use Illuminate\Support\Facades\Route;
use JasonHorsleyTech\GptAssistant\GptAssistant;

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
    Route::get('/converse', function () {
        return view('feature.converse');
    });
    Route::get('/autoform', function () {
        return view('feature.autoform');
    });
    Route::get('/navigation', function () {
        return view('feature.navigation');
    });
    Route::get('/inquiry', function () {
        return view('feature.inquiry');
    });
    Route::get('/audit', function () {
        return view('feature.audit');
    });
    Route::get('/action', function () {
        return view('feature.action');
    });
});
