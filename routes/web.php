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


Route::get('/',[App\Http\Controllers\MapsController::class, 'info'])->name('info');
Route::get('/home',[App\Http\Controllers\MapsController::class, 'home'])->name('home');
Route::post('/new_maps',[App\Http\Controllers\MapsController::class, 'mapas'])->name('maps');
Route::get('/history',[App\Http\Controllers\MapsController::class, 'history'])->name('history');
