<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Models\Post;
use App\Events\PostCreated;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/test-post', function () {
    $post = Post::create([
        'title'   => 'Observer Test Post',
        'content' => 'Checking observer via route',
        'user_id' => Auth::id(),
        // slug not passed intentionally
    ]);
    
    return $post;
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // user
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::get('/customers/list', [CustomerController::class, 'list'])->name('customers.list');

    // product
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/list', [ProductController::class, 'list'])->name('products.list');


});

require __DIR__.'/auth.php';
