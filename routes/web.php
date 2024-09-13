<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    Artisan::call('view:cache');
    Artisan::call('view:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
     Artisan::call('migrate --seed');
    return "Cache cleared successfully";
 });


Route::get('/{pathMatch}', function(){ return view('welcome'); })->where('pathMatch',".*");


