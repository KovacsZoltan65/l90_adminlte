<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//Auth::routes();
Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard2', [HomeController::class, 'dashboard2'])->name('dashboard2');
Route::get('/dashboard3', [HomeController::class, 'dashboard3'])->name('dashboard3');

// ---------
// COMPANIES
// ---------
// Kijelölt törlése
Route::delete('companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
// Kijelölt visszaállítása
Route::get('companies/restore/one/{company}', [CompanyController::class, 'restore'])->name('companies.restore');
// Összes visszaállítása
Route::get('companies/restore/all', [CompanyController::class, 'restoreAll'])->name('companies.restore.all');
// Összes többi
Route::resource('companies', CompanyController::class);


// ---------
// PERSONS
// ---------
// Kijelölt törlése
Route::delete('persons/{person}', [PersonController::class, 'destroy'])->name('persons.destroy');
// Kijelölt visszaállítása
Route::get('persons/restore/one/{person}', [PersonController::class, 'restore'])->name('persons.restore');
// Összes visszaállítása
Route::get('persons/restore/all', [PersonController::class, 'restoreAll'])->name('persons.restore.all');
// Összes többi
Route::resource('persons', PersonController::class);

// ---------
// PRODUCTS
// ---------
// Kijelölt törlése
Route::delete('products/{product}', [PersonController::class, 'destroy'])->name('products.destroy');
// Kijelölt visszaállítása
Route::get('products/restore/one/{product}', [PersonController::class, 'restore'])->name('products.restore');
// Összes visszaállítása
Route::get('products/restore/all', [PersonController::class, 'restoreAll'])->name('products.restore.all');
// Összes többi
Route::resource('products', ProductController::class);
