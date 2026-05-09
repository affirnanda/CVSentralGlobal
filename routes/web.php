<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelolaHeroSectionController;

Route::get('/', [ProductController::class, 'welcome'])->name('welcome');

Route::get('/katalog-produk', [ProductController::class, 'katalog'])->name('katalog.index');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Testimonial Publik (Landing Page)
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('can:manage profile')->group(function () {
            Route::resource('profile', ProfileController::class);
        });

        Route::middleware('can:manage products')->group(function () {
            Route::resource('products', ProductController::class);
        });

        // Manajemen Testimoni oleh Admin
        Route::middleware('can:manage testimonials')->group(function () {
            Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
            Route::patch('/testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
            Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
        });

        // Hero section management routes
        Route::get('/kelola-hero-section', [KelolaHeroSectionController::class, 'index'])->name('hero-section.manage');
        Route::post('/kelola-hero-section', [KelolaHeroSectionController::class, 'update'])->name('hero-section.update');
    });
});

    Route::resource('faqs', FaqController::class);


require __DIR__.'/auth.php';
