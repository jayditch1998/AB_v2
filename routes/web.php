<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Websites\WebsitesController;
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

