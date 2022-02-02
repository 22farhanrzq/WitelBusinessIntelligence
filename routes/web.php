<?php

use Illuminate\Support\Facades\Route;
use App\Models\Distribution;
use Carbon\Carbon;

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

// Route::get('/index', function(){
//     return view('index');
// });

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Auth::routes();

Route::get('/performa/{kode_dist}', 'App\Http\Controllers\DashboardController@distribution');
Route::get('/input', 'App\Http\Controllers\CustomerController@input')->middleware('auth');
Route::get('/input/fetchMitra', 'App\Http\Controllers\CustomerController@fetchMitra');
Route::get('/input/fetchTeam', 'App\Http\Controllers\CustomerController@fetchTeam');
// Route::resource('/input', 'App\Http\Controllers\CustomerController');
Route::post('/input/store', 'App\Http\Controllers\CustomerController@store')->middleware('auth');
Route::get('/customer/detail/{track_id}', 'App\Http\Controllers\CustomerController@show')->name('detail');
Route::get('/customer/detail/{track_id}/edit', 'App\Http\Controllers\CustomerController@edit')->middleware('auth')->name('edit');
Route::patch('/input/update/{track_id}', 'App\Http\Controllers\CustomerController@update')->middleware('auth');
Route::delete('/customer/delete/{track_id}', 'App\Http\Controllers\CustomerController@destroy')->middleware('auth');
Route::get('/customer/{kode_dist}', 'App\Http\Controllers\CustomerController@index')->name('customer');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
