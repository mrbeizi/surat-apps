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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('data-user', 'UserController');
    Route::resource('data-kategori', 'KategoriController');
    Route::resource('data-inbox', 'InboxController');
    Route::resource('data-kop-surat', 'KopSuratController');

    /* Delete All Selected Row */
    Route::post('/deleteSelectedKategori','KategoriController@deleteAll')->name('deleteSelectedKategori');
    Route::post('/deleteSelectedInbox','InboxController@deleteAll')->name('deleteSelectedInbox');
});
