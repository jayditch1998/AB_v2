<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Websites\WebsitesController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Businesses\BusinessesController;
use App\Http\Controllers\FormGeneratorController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\UserLevelController;
use App\Http\Controllers\FormFieldOption\FormFieldOptionController;
use App\Http\Controllers\Requests\RequestsController;
use App\Http\Controllers\Shortcodes\ShortcodesController;
use App\Http\Controllers\VerficationController;
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
Route::get('verification/{pending_id}/resendEmail', [VerficationController::class, 'resendEmail'])->name('verification.resendEmail');
Route::group(['middleware' => ['auth']], function(){
  Route::prefix('dashboard')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/update', [AdminController::class, 'update'])->name('dashboard.update');
  });
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
  Route::prefix('user-field-options')->group(function () {
    Route::get('/', [FormFieldOptionController::class, 'index'])->name('ufo');
    Route::get('/{user}', [FormFieldOptionController::class, 'editUserFormOptions'])->name('ufo.editUserFormOptions');
    Route::get('/destroy', [FormFieldOptionController::class, 'destroy'])->name('ufo.destroy');
    Route::get('/update', [FormFieldOptionController::class, 'update'])->name('ufo.update');
  });
  Route::prefix('online_request')->group(function () {
    Route::get('/', [RequestsController::class, 'index'])->name('online_request');
    Route::post('/create', [RequestsController::class, 'create'])->name('online_request.create');
    Route::get('/delete', [RequestsController::class, 'delete'])->name('online_request.delete');
    Route::post('/update', [RequestsController::class, 'update'])->name('online_request.update');

    Route::get('/approve', [RequestsController::class, 'approve'])->name('online_request.approve');
    Route::post('/approve/all/requests', [RequestsController::class, 'approveAll'])->name('online_request.approve.all');

    Route::get('/decline', [RequestsController::class, 'decline'])->name('online_request.decline');
    Route::post('/decline/all/requests', [RequestsController::class, 'declineAll'])->name('online_request.decline.all');
  });
  Route::prefix('wp-shortcodes')->group(function () {
    Route::get('/', [ShortcodesController::class, 'wpPluginIndex'])->name('wp-shortcodes');
    Route::post('/create', [ShortcodesController::class, 'create'])->name('businesses.create');
    Route::get('/delete', [ShortcodesController::class, 'delete'])->name('businesses.delete');
    Route::post('/update', [ShortcodesController::class, 'update'])->name('businesses.update');

    Route::get('/download', [ShortcodesController::class, 'downloadPlugin'])->name('admin.wp-plugins.download');
  });
  Route::prefix('verification')->group(function () {
    Route::get('/', [VerficationController::class, 'index'])->name('verification');
    Route::post('/update', [VerficationController::class, 'update'])->name('verification.update');

  });
  Route::prefix('form-generator')->group(function () {
    Route::get('/', [FormGeneratorController::class, 'index'])->name('form-generator');
    Route::post('/generate', [FormGeneratorController::class, 'generate'])->name('form-generator.generate');
    Route::get('/delete', [CategoriesController::class, 'delete'])->name('form-generator.destroy');
    Route::post('/update', [CategoriesController::class, 'update'])->name('form-generator.update');
  });
});



Route::name('admin.')->prefix('admin')->group(function () {
  Route::prefix('dashboard')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/update', [AdminController::class, 'update'])->name('dashboard.update');
  });
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

  Route::prefix('shortcodes')->group(function () {
    Route::get('/', [ShortcodesController::class, 'index'])->name('shortcodes');
    Route::post('/create', [ShortcodesController::class, 'create'])->name('businesses.create');
    Route::get('/delete', [ShortcodesController::class, 'delete'])->name('businesses.delete');
    Route::post('/update', [ShortcodesController::class, 'update'])->name('businesses.update');
  });

  Route::prefix('wp-shortcodes')->group(function () {
    Route::get('/', [ShortcodesController::class, 'wpPluginIndex'])->name('wp-shortcodes');
    Route::post('/create', [ShortcodesController::class, 'create'])->name('businesses.create');
    Route::get('/delete', [ShortcodesController::class, 'delete'])->name('businesses.delete');
    Route::post('/update', [ShortcodesController::class, 'update'])->name('businesses.update');

    Route::get('/download', [ShortcodesController::class, 'downloadPlugin'])->name('admin.wp-plugins.download');
  });


  Route::prefix('online_request')->group(function () {
    Route::get('/', [RequestsController::class, 'index'])->name('online_request');
    Route::post('/create', [RequestsController::class, 'create'])->name('online_request.create');
    Route::get('/delete', [RequestsController::class, 'delete'])->name('online_request.delete');
    Route::post('/update', [RequestsController::class, 'update'])->name('online_request.update');

    Route::post('/approve', [RequestsController::class, 'approve'])->name('online_request.approve');
    Route::post('/approve/all/requests', [RequestsController::class, 'approveAll'])->name('online_request.approve.all');

    Route::post('/decline', [RequestsController::class, 'decline'])->name('online_request.decline');
    Route::post('/decline/all/requests', [RequestsController::class, 'declineAll'])->name('online_request.decline.all');
  });

  Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/update', [UserController::class, 'update'])->name('users.update');
  });

  Route::prefix('user-field-options')->group(function () {
    Route::get('/', [FormFieldOptionController::class, 'index'])->name('ufo');
    Route::get('/destroy', [FormFieldOptionController::class, 'destroy'])->name('ufo.destroy');
    Route::post('/update', [FormFieldOptionController::class, 'update'])->name('ufo.update');
    Route::get('/{user}', [FormFieldOptionController::class, 'editUserFormOptions'])->name('ufo.editUserFormOptions');
  });
  Route::get('/test', function(){
    return 'tae';
  });
  Route::prefix('user-levels')->group(function () {
    Route::get('/', [UserLevelController::class, 'index'])->name('user-levels');
    Route::post('/store', [UserLevelController::class, 'store'])->name('user-levels.store');
    Route::get('/destroy', [UserLevelController::class, 'destroy'])->name('user-levels.destroy');
    Route::post('/update', [UserLevelController::class, 'update'])->name('user-levels.update');
  });

  Route::prefix('form-generator')->group(function () {
    Route::get('/', [FormGeneratorController::class, 'index'])->name('form-generator');
    Route::post('/generate', [FormGeneratorController::class, 'generate'])->name('form-generator.generate');
    Route::get('/delete', [CategoriesController::class, 'delete'])->name('form-generator.destroy');
    Route::post('/update', [CategoriesController::class, 'update'])->name('form-generator.update');
  });
  Route::prefix('verification')->group(function () {
    Route::get('/', [VerficationController::class, 'index'])->name('verification');
    Route::post('/update', [VerficationController::class, 'update'])->name('verification.update');

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

