<?php

use Illuminate\Routing\RouteAction;
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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/conversor','ConversorController@vista')->name('conversor.vista');
Route::post('/conversor/save','ConversorController@save')->name('conversor.save');
Route::get('/conversor/download','ConversorController@download')->name('conversor.dwnld');

Route::get('/conversordoc','ConversorDocController@vista')->name('conversordoc.vista');
Route::post('/conversordoc/save','ConversorDocController@save')->name('conversordoc.save');
Route::get('/conversordoc/download','ConversorDocController@download')->name('conversordoc.dwnld');
