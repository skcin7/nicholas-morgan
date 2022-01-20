<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlphabetizerController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\BookmarkletsController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\WritingsController;
use App\Http\Controllers\WritingCategoriesController;

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

// Define Authentication Routes
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// Basic App Routes:

Route::get('/', [AppController::class, 'welcome'])->name('welcome');
Route::get('welcome', [AppController::class, 'welcome'])->name('welcome');

Route::get('contact', [AppController::class, 'contact'])->name('contact');
Route::get('contact_card', [AppController::class, 'downloadContactCard'])->name('contact_card');
Route::get('about', [AppController::class, 'about'])->name('about');
Route::get('pgp', [AppController::class, 'pgp'])->name('pgp');
Route::get('followers_difference', [AppController::class, 'followersDifference'])->name('followers_difference');
Route::post('followers_difference', [AppController::class, 'followersDifference'])->name('followers_difference');
Route::get('mail', [AppController::class, 'redirectToGmail'])->name('mail');
Route::get('gmail', [AppController::class, 'redirectToGmail'])->name('gmail');

//Route::get('/', 'AppController@welcome')->name('welcome');
//Route::get('contact', 'AppController@contact')->name('contact');
//Route::get('contact_card', 'AppController@downloadContactCard')->name('contact_card');
//Route::get('followers_difference', 'AppController@followersDifference')->name('followers_difference');
//Route::post('followers_difference', 'AppController@followersDifference')->name('followers_difference');

// Resume related routes go in here:
Route::group(['prefix' => 'resume'], function() {
    Route::get('/', [ResumeController::class, 'resume'])->name('resume');
    Route::get('game_collecting', [ResumeController::class, 'getGameCollectingResume'])->name('resume.game_collecting');
});

// Admin Routes
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('phpinfo', [AdminController::class, 'phpinfo'])->name('admin.phpinfo');
    Route::get('adminer', [AdminController::class, 'adminer'])->name('admin.adminer');

    // Writings
    Route::group(['prefix' => 'writings'], function() {
        Route::get('/', [WritingsController::class, 'admin'])->name('admin.writings');
    });

    // Writing Categories
    Route::group(['prefix' => 'writing_categories'], function() {
        Route::get('/', [WritingCategoriesController::class, 'admin'])->name('admin.writing_categories');
        Route::post('create', [WritingCategoriesController::class, 'create'])->name('admin.writing_categories.create');
        Route::post('{name}/update', [WritingCategoriesController::class, 'update'])->name('admin.writing_categories.update');
        Route::post('{name}/delete', [WritingCategoriesController::class, 'delete'])->name('admin.writing_categories.delete');
    });

    // Admin quotes routes:
    Route::group(['prefix' => 'quotes'], function() {
        Route::get('/', [QuotesController::class, 'manage'])->name('admin.quotes');
    });
});

Route::group(['prefix' => 'alphabetizer'], function() {
    Route::get('/', [AlphabetizerController::class, 'index'])->name('alphabetizer');
});

Route::group(['prefix' => 'bookmarklets'], function() {
    Route::get('/', [BookmarkletsController::class, 'index'])->name('bookmarklets');
});

Route::get('writings', [WritingsController::class, 'index'])->name('writings');
Route::get('writing/create', [WritingsController::class, 'showCreate'])->name('writing.showCreate');
Route::get('writing/{id}', [WritingsController::class, 'show'])->name('writing.show');
Route::get('writing/{id}/edit', [WritingsController::class, 'showEdit'])->name('writing.showEdit');
Route::post('writing', [WritingsController::class, 'create'])->name('writing.create');
Route::post('writing/{id}', [WritingsController::class, 'update'])->name('writing.update');

Route::post('writing/{id}/trash', [WritingsController::class, 'trash'])->name('writing.trash');
Route::post('writing/{id}/untrash', [WritingsController::class, 'untrash'])->name('writing.untrash');
Route::post('writing/{id}/permanently_delete', [WritingsController::class, 'permanentlyDelete'])->name('writing.permanently_delete');


//Route::group(['prefix' => 'writings'], function() {
//    Route::get('/', 'WritingsController@index')->name('writings');
//    Route::get('create', 'WritingsController@create')->name('writings.create');
//    Route::post('create', 'WritingsController@processCreate')->name('writings.create');
//    Route::get('{id}', 'WritingsController@writing')->name('writings.writing');
//    Route::get('{id}/edit', 'WritingsController@edit')->name('writings.writing.edit');
//    Route::post('{id}/edit', 'WritingsController@processEdit')->name('writings.writing.process_edit');
//    Route::post('{id}/trash', 'WritingsController@trash')->name('writings.writing.trash');
//    Route::post('{id}/untrash', 'WritingsController@untrash')->name('writings.writing.untrash');
//    Route::post('{id}/permanently_delete', 'WritingsController@permanentlyDelete')->name('writings.writing.permanently_delete');
//});

Route::group(['prefix' => 'albums'], function() {
    Route::get('/', 'AlbumsController@index')->name('albums');
//    Route::get('create', 'AlbumsController@create')->name('albums.create');
//    Route::post('create', 'AlbumsController@processCreate')->name('albums.create');
//    Route::get('{id}', 'AlbumsController@writing')->name('albums.writing');
//    Route::get('{id}/edit', 'AlbumsController@edit')->name('albums.writing.edit');
//    Route::post('{id}/edit', 'AlbumsController@processEdit')->name('albums.writing.process_edit');
//    Route::post('{id}/trash', 'AlbumsController@trash')->name('albums.writing.trash');
//    Route::post('{id}/untrash', 'AlbumsController@untrash')->name('albums.writing.untrash');
//    Route::post('{id}/permanently_delete', 'AlbumsController@permanentlyDelete')->name('albums.writing.permanently_delete');
});

// Routes related to the JNES emulator/Contra:
Route::group(['prefix' => 'nes'], function() {
    Route::get('{rom?}', 'NesEmulatorController@play')->name('nes');
//    Route::get('', 'NesEmulatorController@play')->name('contra_rom');
});


Route::get('home', 'HomeController@index')->name('home');



// Users routes:
Route::group(['prefix' => 'users'], function() {
    Route::get('/', "UsersController@index")->name('users');
});
Route::get('@{id}', "UsersController@get")->name('users.user');
Route::get('@{id}/secret', "UsersController@secret")->name('users.user.secret');
Route::get('@{id}/logins', "UsersController@logins")->name('users.user.logins');
