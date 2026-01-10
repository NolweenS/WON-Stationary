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
use App\Http\Controllers\NewsletterController;
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

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('news', NewsController::class)->only(['index', 'show'])->parameters([
    'news' => 'news:slug'
]);

Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// --- CART ROUTES (Public + Auth) ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');

        // Profile Messages
        Route::post('/{user}/message', [ProfileMessageController::class, 'store'])->name('message.store');
        Route::delete('/message/{message}', [ProfileMessageController::class, 'destroy'])->name('message.destroy');
    });

    // Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/{product}', [WishlistController::class, 'store'])->name('store');
        Route::delete('/{product}', [WishlistController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    });

    // Notifications
    Route::post('/notifications/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markRead');
});


// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::patch('/{user}/promote', [UserManagementController::class, 'promote'])->name('promote');
        Route::patch('/{user}/demote', [UserManagementController::class, 'demote'])->name('demote');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Product Management
    Route::resource('products', ProductController::class)->except(['index', 'show']); // Index & Show are public

    // Category Management
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Order Management (Admin actions)
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // FAQ Management
    Route::prefix('faq')->name('faq.')->group(function () {
        Route::resource('categories', FAQController::class)
            ->names('categories')
            ->parameters(['categories' => 'category'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']); // Custom method names in controller need mapping or standard resource usage

        // Omdat de controller methodes niet standaard resource namen hebben (categoriesIndex ipv index),
        // behouden we de expliciete definities voor duidelijkheid, maar gegroepeerd.

        // FAQ Categories
        Route::get('/categories', [FAQController::class, 'categoriesIndex'])->name('categories.index');
        Route::get('/categories/create', [FAQController::class, 'categoriesCreate'])->name('categories.create');
        Route::post('/categories', [FAQController::class, 'categoriesStore'])->name('categories.store');
        Route::get('/categories/{category}/edit', [FAQController::class, 'categoriesEdit'])->name('categories.edit');
        Route::put('/categories/{category}', [FAQController::class, 'categoriesUpdate'])->name('categories.update');
        Route::delete('/categories/{category}', [FAQController::class, 'categoriesDestroy'])->name('categories.destroy');

        // FAQ Questions
        Route::get('/questions', [FAQController::class, 'questionsIndex'])->name('questions.index');
        Route::get('/questions/create', [FAQController::class, 'questionsCreate'])->name('questions.create');
        Route::post('/questions', [FAQController::class, 'questionsStore'])->name('questions.store');
        Route::get('/questions/{question}/edit', [FAQController::class, 'questionsEdit'])->name('questions.edit');
        Route::put('/questions/{question}', [FAQController::class, 'questionsUpdate'])->name('questions.update');
        Route::delete('/questions/{question}', [FAQController::class, 'questionsDestroy'])->name('questions.destroy');
    });

    // News Management (Full resource for admin except public index/show if needed, but usually admin manages all)
    Route::resource('news', NewsController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';
