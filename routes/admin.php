<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ToolsController;
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

Route::get('admin/hash/{hash}', [AdminController::class, 'setCookie']);
Route::get('admin/{login?}', [AdminController::class, 'index'])->middleware(['admin_access', 'guest'])->where('login', 'login')->name('login');
Route::post('admin/login', [AdminController::class, 'login'])->middleware(['admin_access', 'guest'])->where('login', 'login')->name('admin_login');
Route::prefix('admin')->middleware(['admin_access', 'auth'])->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // SETTING ROUTES
    Route::get('settings', [AdminController::class, 'settings'])->name('dashboard.settings');
    Route::post('settings', [AdminController::class, 'update_settings'])->name('dashboard.update.settings');
    Route::get('settings/delete', [AdminController::class, 'settings_delete'])->name('setting.delete');
    // SETTING ROUTES END
    //Blog Routes
    Route::prefix('blog')->group(function () {
        Route::get('index', [BlogController::class, 'index'])->name('blog.index');
        Route::get('add', [BlogController::class, 'create'])->name('blog.add');
        Route::post('store_feature_image', [BlogController::class, 'store_feature_image'])->name('store_blog_feature_image');
        Route::post('store_blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
        Route::get('delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
        Route::post('update', [BlogController::class, 'update'])->name('blog.update');
        Route::get('trash', [BlogController::class, 'trash_list'])->name('blog.trash_list');
        Route::get('permanent_destroy/{id}', [BlogController::class, 'blog_permanent_destroy'])->name('blog.permanent_destroy');
        Route::get('restore/{id}', [BlogController::class, 'blog_restore'])->name('blog.restore');
    });
    //Tool Routes
    Route::prefix('tool')->group(function () {
        Route::get('index', [ToolsController::class, 'index'])->name('tool.index');
        Route::get('add', [ToolsController::class, 'create'])->name('tool.add');
        Route::post('store_feature_image', [ToolsController::class, 'store_feature_image'])->name('store_feature_image');
        Route::post('store', [ToolsController::class, 'store'])->name('tool.store');
        Route::get('edit/{id}', [ToolsController::class, 'edit'])->name('tool.edit');
        Route::get('delete/{id}', [ToolsController::class, 'destroy'])->name('tool.delete');
        Route::post('update/{id}', [ToolsController::class, 'update'])->name('tool.update');
        Route::get('trash', [ToolsController::class, 'trash_list'])->name('tool.trash_list');
        Route::get('permanent_destroy/{id}', [ToolsController::class, 'tool_permanent_destroy'])->name('tool.permanent_destroy');
        Route::get('restore/{id}', [ToolsController::class, 'tool_restore'])->name('tool.restore');
    });
    //Tool Routes End

    //Media Routes
    Route::prefix('media')->group(function () {
        Route::get('add', [MediaController::class, 'create'])->name('media.add');
        Route::post('store', [MediaController::class, 'store'])->name('media.store');
        Route::get('delete/{id?}', [MediaController::class, 'delete'])->name('media.delete');
        Route::get('trash', [MediaController::class, 'trash_list'])->name('media.trash_list');
        Route::get('permanent_destroy/{id}', [MediaController::class, 'media_permanent_destroy'])->name('media.permanent_destroy');
        Route::get('restore/{id}', [MediaController::class, 'media_restore'])->name('media.restore');
    });

    // User List Routes
    Route::prefix('user')->group(function () {
        Route::get('list', [AdminController::class, 'user_list'])->name('admin.users_list');
        Route::get('trash', [AdminController::class, 'trash_list'])->name('admin.trash_list');
        Route::get('create', [AdminController::class, 'create'])->name('admin.users.create');
        Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::post('store', [AdminController::class, 'store'])->name('admin.users.store');
        Route::post('update/{id}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::get('destroy/{id}', [AdminController::class, 'user_destroy'])->name('admin.user.destroy');
        Route::get('permanent_destroy/{id}', [AdminController::class, 'user_permanent_destroy'])->name('admin.user.permanent_destroy');
        Route::get('restore/{id}', [AdminController::class, 'user_restore'])->name('admin.user.restore');
    });

    // CONTACT ROUTES
    Route::prefix('contact')->group(function () {
        Route::get('list', [ContactController::class, 'index'])->name('dashboard.contacts.list');
        Route::get('trash', [ContactController::class, 'trash'])->name('dashboard.contacts.trash');
        Route::get('delete/{id}', [ContactController::class, 'delete'])->name('dashboard.contacts.delete');
        Route::get('destroy/{id}', [ContactController::class, 'destroy'])->name('dashboard.contacts.destroy');
        Route::get('restore/{id}', [ContactController::class, 'restore'])->name('dashboard.contacts.restore');
    });
    // GET AND SET CONTENT
    Route::get('download/content/{id}', [ToolsController::class, 'download'])->name('content.download');
    Route::post('upload/content/{id}', [ToolsController::class, 'upload_tool_content'])->name('content.upload');
    // User List Routes END
    Route::get('modals', [AdminController::class, 'modals'])->name('dashboard.components');

    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    // USERS FEEDBACK ROUTES END
});
