<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('can manage profile')->group(function () {
        Route::resource('profile', ProfileController::class);
        });

    Route::middleware('cant manage products')->group(function () {
        Route::resource('products', ProductController::class);       
    });

   

   

     Route::middleware('cant manage testimonials')->group(function () {
        Route::resource('testimonials', TestimonialController::class);       
    });


     Route::middleware('cant manage hero section')->group(function () {
        Route::resource('hero-section', HeroSectionController::class);       
    }); 
});

});

require __DIR__.'/auth.php';
