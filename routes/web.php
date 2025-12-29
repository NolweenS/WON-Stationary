<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FAQController;
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

require __DIR__.'/auth.php';



