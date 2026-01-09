<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileMessageController;
use App\Http\Controllers\DashboardController ;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::resource('news', NewsController::class)->parameters([
    'news' => 'news:slug'
]);

Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

Route::prefix('admin/faq')->middleware(['auth'])->group(function () {
    Route::get('/categories', [FAQController::class, 'categoriesIndex'])->name('faq.admin.categories.index');
    Route::get('/categories/create', [FAQController::class, 'categoriesCreate'])->name('faq.admin.categories.create');
    Route::post('/categories', [FAQController::class, 'categoriesStore'])->name('faq.admin.categories.store');
    Route::get('/categories/{category}/edit', [FAQController::class, 'categoriesEdit'])->name('faq.admin.categories.edit');
    Route::put('/categories/{category}', [FAQController::class, 'categoriesUpdate'])->name('faq.admin.categories.update');
    Route::delete('/categories/{category}', [FAQController::class, 'categoriesDestroy'])->name('faq.admin.categories.destroy');

    Route::get('/questions', [FAQController::class, 'questionsIndex'])->name('faq.admin.questions.index');
    Route::get('/questions/create', [FAQController::class, 'questionsCreate'])->name('faq.admin.questions.create');
    Route::post('/questions', [FAQController::class, 'questionsStore'])->name('faq.admin.questions.store');
    Route::get('/questions/{question}/edit', [FAQController::class, 'questionsEdit'])->name('faq.admin.questions.edit');
    Route::put('/questions/{question}', [FAQController::class, 'questionsUpdate'])->name('faq.admin.questions.update');
    Route::delete('/questions/{question}', [FAQController::class, 'questionsDestroy'])->name('faq.admin.questions.destroy');
});

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/promote', [UserManagementController::class, 'promote'])->name('users.promote');
    Route::patch('/users/{user}/demote', [UserManagementController::class, 'demote'])->name('users.demote');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Order status update route
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::post('/profile/{user}/message', [ProfileMessageController::class, 'store'])->name('profile.message.store');
Route::delete('/profile/message/{message}', [ProfileMessageController::class, 'destroy'])->name('profile.message.destroy');

Route::post('/notifications/mark-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth')->name('notifications.markRead');

require __DIR__.'/auth.php';


