<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebsitesController;

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
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::name('admin.')->prefix('admin')->group(function () {
  Route::prefix('websites')->group(function () {
    Route::get('/', [WebsitesController::class, 'index'])->name('websites');
  });
});

require_once 'theme-routes.php';

Route::get('/barebone', function () {
    return view('barebone', ['title' => 'This is Title']);
});

