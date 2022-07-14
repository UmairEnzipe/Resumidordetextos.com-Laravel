<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
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

// Route::get('privacy-policy', [FrontendController::class, 'privacy_policy'])->name('privacy_policy');
// Route::get('terms-and-conditions', [FrontendController::class, 'terms_and_conditions'])->name('terms_and_conditions');
// Route::get('about-us', [FrontendController::class, 'about_us'])->name('page.about_us');
// Route::get('contact-us', [FrontendController::class, 'contact_us'])->name('page.contact_us');
Route::get('artisan', function () {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('storage:link');
});

require __DIR__ . '/redirection.php';
require __DIR__ . '/custom.php';
require __DIR__ . '/admin.php';
Route::get('sitemap.xml', [FrontendController::class, 'sitemap']);
Route::post('contact', [ContactController::class, 'store']);
Route::get('blog', [FrontendController::class, 'blog'])->name('page.blog');
Route::get('blog/{slug}', [FrontendController::class, 'single_blog'])->name('page.single_blog');
Route::get('{slug}', [FrontendController::class, 'native_language_tool'])->name('native_language_tool');
Route::get('{lang}/{slug}', [FrontendController::class, 'other_language_tool'])->where(['lang' => '[a-z]{2}'])->name('other_language_tool');
Route::get('/', [FrontendController::class, 'index'])->name('home');
