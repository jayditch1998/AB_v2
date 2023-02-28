<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Websites\WebsitesController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Businesses\BusinessesController;
use Illuminate\Support\Facades\Auth;
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
// 6


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// Route::get()

Route::name('admin.')->prefix('admin')->group(function () {
  Route::prefix('websites')->group(function () {
    Route::get('/', [WebsitesController::class, 'index'])->name('websites');
    Route::post('/create', [WebsitesController::class, 'create'])->name('website.create');
    Route::get('/delete', [WebsitesController::class, 'delete'])->name('website.delete');
    Route::post('/update', [WebsitesController::class, 'update'])->name('website.update');
  });
  Route::prefix('categories')->group(function () {
    Route::get('/', [CategoriesController::class, 'index'])->name('categories');
    Route::post('/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::get('/delete', [CategoriesController::class, 'delete'])->name('categories.delete');
    Route::post('/update', [CategoriesController::class, 'update'])->name('categories.update');
  });
  Route::prefix('businesses')->group(function () {
    Route::get('/', [BusinessesController::class, 'index'])->name('businesses');
    Route::post('/create', [BusinessesController::class, 'create'])->name('businesses.create');
    Route::get('/delete', [BusinessesController::class, 'delete'])->name('businesses.delete');
    Route::post('/update', [BusinessesController::class, 'update'])->name('businesses.update');
  });
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::name('')->prefix('user')->group(function () {
  Route::prefix('websites')->group(function () {
    Route::get('/', [WebsitesController::class, 'index'])->name('websites');
  });
});

require_once 'theme-routes.php';

Route::get('/barebone', function () {
    return view('barebone', ['title' => 'This is Title']);
});

