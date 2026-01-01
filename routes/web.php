<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::resource('news', NewsController::class)->parameters([
    'news' => 'news:slug'
]);

// FAQ Routes
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

Route::prefix('admin/faq')->middleware(['auth'])->group(function () {
    // Categories
    Route::get('/categories', [FAQController::class, 'categoriesIndex'])->name('faq.admin.categories.index');
    Route::get('/categories/create', [FAQController::class, 'categoriesCreate'])->name('faq.admin.categories.create');
    Route::post('/categories', [FAQController::class, 'categoriesStore'])->name('faq.admin.categories.store');
    Route::get('/categories/{category}/edit', [FAQController::class, 'categoriesEdit'])->name('faq.admin.categories.edit');
    Route::put('/categories/{category}', [FAQController::class, 'categoriesUpdate'])->name('faq.admin.categories.update');
    Route::delete('/categories/{category}', [FAQController::class, 'categoriesDestroy'])->name('faq.admin.categories.destroy');

    // Questions
    Route::get('/questions', [FAQController::class, 'questionsIndex'])->name('faq.admin.questions.index');
    Route::get('/questions/create', [FAQController::class, 'questionsCreate'])->name('faq.admin.questions.create');
    Route::post('/questions', [FAQController::class, 'questionsStore'])->name('faq.admin.questions.store');
    Route::get('/questions/{question}/edit', [FAQController::class, 'questionsEdit'])->name('faq.admin.questions.edit');
    Route::put('/questions/{question}', [FAQController::class, 'questionsUpdate'])->name('faq.admin.questions.update');
    Route::delete('/questions/{question}', [FAQController::class, 'questionsDestroy'])->name('faq.admin.questions.destroy');
});
//Contact Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Alles in deze groep kan enkel gebeuren waren je ingelogd bent als admin(is_admin = true)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Lijst en Aanmaken
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');

    // Acties (Promote,Demote,Delete)
    Route::patch('/users/{user}/promote', [UserManagementController::class, 'promote'])->name('users.promote');
    Route::patch('/users/{user}/demote', [UserManagementController::class, 'demote'])->name('users.demote');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});
require __DIR__.'/auth.php';



