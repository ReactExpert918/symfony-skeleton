<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('is.token')->name('dashboard');

Route::middleware('is.token')->group(function () {
    Route::get('/authors', [ApiController::class, 'getAuthors'])->name('authors');
    Route::get('/authors/create', [ApiController::class, 'authorCreate'])->name('authors.create');
    Route::post('/authors', [ApiController::class, 'authorStore'])->name('authors.store');
    Route::delete('/authors/{author}', [ApiController::class, 'authorDestroy'])->name('authors.destroy');
    Route::get('/authors/{author}', [ApiController::class, 'authorShow'])->name('authors.show');
    Route::get('/books/create', [ApiController::class, 'bookCreate'])->name('books.create');
    Route::post('/books', [ApiController::class, 'bookStore'])->name('books.store');
    Route::delete('/books/{book}', [ApiController::class, 'bookDestroy'])->name('books.destroy');
});

require __DIR__.'/auth.php';
