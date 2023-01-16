<?php

use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/welcome', [UsersController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function(){ 
    Route::controller(UsersController::class)->group(function () {
        Route::get('/users','index')->name('users.index');
        Route::get('/users/excel','export')->name('toexcel');
        Route::get('/users/pdf','exportToPdf')->name('topdf');
        Route::get('/users/pdf/page','PdfPage')->name('pdfpage');
        Route::get('/users/add','AddUser')->name('add.user');
        Route::get('/users/getdatatabledata','getDataTableData')->name('getDataTableData');
        Route::post('/users/store/toDB','StoreUser')->name('store.user');
        Route::post('/users/id','DataById')->name('databy.id');
        Route::post('/users/update','update')->name('update');
        Route::post('/users/store','store')->name('store');
        Route::post('/users/delete','delete')->name('delete');
    });
});