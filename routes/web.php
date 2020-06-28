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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('delete/{id}', 'DropController@destroy');
Route::get('dropbox', 'DropController@index');
Route::post('drop', 'DropController@store')->name('dropboxupload');
Route::get('drop/{filetitle}', 'DropController@show');
Route::get('drop/{filetitle}/download', 'DropController@download');

