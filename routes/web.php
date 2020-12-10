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

// Basic application routes:
Route::get('/', 'AppController@welcome')->name('welcome');
Route::get('contact', 'AppController@contact')->name('contact');
Route::get('about', 'AppController@about')->name('about');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::group(['prefix' => 'writing'], function() {
    Route::get('/', 'WritingController@index')->name('writing');
    Route::get('create', 'WritingController@create')->name('writing.create');
    Route::post('create', 'WritingController@processCreate')->name('writing.create');
    Route::get('{id}', 'WritingController@writing')->name('writing.writing');
    Route::get('{id}/edit', 'WritingController@update')->name('writing.update');
    Route::post('{id}/edit', 'WritingController@processUpdate')->name('writing.update');
});

// Routes related to the JNES emulator/Contra:
Route::group(['prefix' => 'nes'], function() {
    Route::get('{rom?}', 'NesEmulatorController@play')->name('nes');
//    Route::get('', 'NesEmulatorController@play')->name('contra_rom');
});



Route::get('home', 'HomeController@index')->name('home');


// Admin routes:
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('phpinfo.php', "AdminController@showPhpinfo")->name('admin.phpinfo');
    Route::get('adminer.php', "AdminController@showAdminer")->name('admin.adminer');
});
