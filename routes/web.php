<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {

        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('/category')->name('category.')->group(function (){
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/add', [CategoryController::class, 'form'])->name('add');
        Route::get('/{id}/edit', [CategoryController::class, 'form'])->name('edit');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('/unit')->name('unit.')->group(function (){
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::get('/add', [UnitController::class, 'form'])->name('add');
        Route::get('/{id}/edit', [UnitController::class, 'form'])->name('edit');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::put('/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/{id}', [UnitController::class, 'delete'])->name('delete');
    });

    Route::prefix('/payment-method')->name('paymentmethod.')->group(function (){
        Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/add', [PaymentMethodController::class, 'form'])->name('add');
        Route::get('/{id}/edit', [PaymentMethodController::class, 'form'])->name('edit');
        Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
        Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::delete('/{id}', [PaymentMethodController::class, 'delete'])->name('delete');
    });

    Route::prefix('/product')->name('product.')->group(function (){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/add', [ProductController::class, 'form'])->name('add');
        Route::get('/{id}/edit', [ProductController::class, 'form'])->name('edit');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'delete'])->name('delete');
    });

    Route::prefix('/sales')->name('sales.')->group(function (){
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/add', [SalesController::class, 'form'])->name('add');
        Route::get('/products/{id}', [SalesController::class, 'products'])->name('products');
        Route::get('/{id}/edit', [SalesController::class, 'form'])->name('edit');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::post('/{id}', [SalesController::class, 'update'])->name('update');
        Route::delete('/{id}', [SalesController::class, 'delete'])->name('delete');
    });

    Route::get('/image/{filename}', [ImageController::class, 'index'])->name('image');
});

require __DIR__.'/auth.php';
