<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('privacy', [FrontendController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('terms', [FrontendController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('about', [FrontendController::class, 'about_us'])->name('page.about_us');
Route::get('contact', [FrontendController::class, 'contact_us'])->name('page.contact_us');