<?php

use App\Http\Controllers\Dashboard\GradeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('grade', GradeController::class);
    }

);
