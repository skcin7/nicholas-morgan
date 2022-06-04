<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlphabetizerController;
use App\Http\Controllers\AvatarsController;
use App\Http\Controllers\BookmarkletsController;
use App\Http\Controllers\ExamplesController;
use App\Http\Controllers\MastermindController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', [WelcomeController::class, 'welcome'])->name('web.welcome');
//Route::get('welcome', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('contact', [WelcomeController::class, 'contact'])->name('web.contact');
Route::get('contact_card', [WelcomeController::class, 'downloadContactCard'])->name('contact_card');
Route::get('about', [WelcomeController::class, 'about'])->name('about');
Route::get('pgp', [WelcomeController::class, 'pgp'])->name('web.pgp');
Route::get('followers_difference', [WelcomeController::class, 'followersDifference'])->name('followers_difference');
Route::post('followers_difference', [WelcomeController::class, 'followersDifference'])->name('followers_difference');
Route::get('mail', [WelcomeController::class, 'redirectToGmail'])->name('mail');
Route::get('gmail', [WelcomeController::class, 'redirectToGmail'])->name('gmail');

//Route::get('/', 'WelcomeController@welcome')->name('welcome');
//Route::get('contact', 'WelcomeController@contact')->name('contact');
//Route::get('contact_card', 'WelcomeController@downloadContactCard')->name('contact_card');
//Route::get('followers_difference', 'WelcomeController@followersDifference')->name('followers_difference');
//Route::post('followers_difference', 'WelcomeController@followersDifference')->name('followers_difference');

// Resume related routes go in here:
Route::group(['prefix' => 'resume'], function() {
    Route::get('/', [ResumeController::class, 'resume'])->name('resume');
    Route::get('game_collecting', [ResumeController::class, 'getGameCollectingResume'])->name('resume.game_collecting');
});

// Mastermind Routes
Route::group(['middleware' => 'mastermind', 'prefix' => 'mastermind'], function() {
    Route::get('/', [MastermindController::class, 'mastermindHome'])->name('web.mastermind');
    Route::get('phpinfo', [MastermindController::class, 'phpinfo'])->name('web.mastermind.phpinfo');
    Route::get('adminer', [MastermindController::class, 'adminer'])->name('web.mastermind.adminer');

//    // Projects
//    Route::group(['prefix' => 'projects'], function() {
//        Route::get('/', [ProjectsController::class, 'manage'])->name('web.mastermind.projects');
//    });

    // Writings
    Route::group(['prefix' => 'writings'], function() {
        Route::get('/', [WritingsController::class, 'admin'])->name('web.mastermind.writings');
    });

    // Writing Categories
    Route::group(['prefix' => 'writing_categories'], function() {
        Route::get('/', [WritingCategoriesController::class, 'admin'])->name('web.mastermind.writing_categories');
        Route::post('create', [WritingCategoriesController::class, 'create'])->name('web.mastermind.writing_categories.create');
        Route::post('{name}/update', [WritingCategoriesController::class, 'update'])->name('web.mastermind.writing_categories.update');
        Route::post('{name}/delete', [WritingCategoriesController::class, 'delete'])->name('web.mastermind.writing_categories.delete');
    });

    // Avatars
    Route::group(['prefix' => 'avatars'], function() {
        Route::get('/', [AvatarsController::class, 'admin'])->name('web.mastermind.avatars');
        Route::post('/', [AvatarsController::class, 'create'])->name('web.mastermind.avatars.create');
    });

    // Admin quotes routes:
    Route::group(['prefix' => 'quotes'], function() {
        Route::get('/', [QuotesController::class, 'manage'])->name('web.mastermind.quotes');
    });
});

Route::group(['prefix' => 'alphabetizer'], function() {
    Route::get('/', [AlphabetizerController::class, 'index'])->name('alphabetizer');
});

Route::group(['prefix' => 'bookmarklets'], function() {
    Route::get('/', [BookmarkletsController::class, 'index'])->name('bookmarklets');
});

Route::group(['prefix' => 'projects'], function() {
    Route::get('/', [ProjectsController::class, 'index'])->name('web.projects');
});


Route::get('writings', [WritingsController::class, 'index'])->name('writings');
Route::get('writings/create', [WritingsController::class, 'showCreate'])->name('writing.showCreate');
Route::post('writings/create', [WritingsController::class, 'create'])->name('writings.create');
Route::get('writing/{id}', [WritingsController::class, 'show'])->name('writing.show');
Route::get('writing/{id}/edit', [WritingsController::class, 'showEdit'])->name('writing.showEdit');
Route::post('writing/{id}', [WritingsController::class, 'update'])->name('writing.update');

Route::post('writing/{id}/trash', [WritingsController::class, 'trash'])->name('writing.trash');
Route::post('writing/{id}/untrash', [WritingsController::class, 'untrash'])->name('writing.untrash');
Route::post('writing/{id}/permanently_delete', [WritingsController::class, 'permanentlyDelete'])->name('writing.permanently_delete');

Route::group(['prefix' => 'examples'], function() {
    Route::get('/', [ExamplesController::class, 'index'])->name('examples');
    Route::get('menubar', [ExamplesController::class, 'menubar'])->name('examples.menubar');
});


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
