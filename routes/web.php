<?php

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
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix("/tasks")->name("task.")->group(function () {
        Route::get("/", [\App\Http\Controllers\TaskController::class, "index"])->name("index");
        Route::get("/{task}", [\App\Http\Controllers\TaskController::class, "show"])->name("show");
        Route::get("/{task}/edit", [\App\Http\Controllers\TaskController::class, "edit"])->name("edit");

        Route::post("/create", [\App\Http\Controllers\TaskController::class, "store"])->name("store");
        Route::put("/{task}/edit", [\App\Http\Controllers\TaskController::class, "update"])->name("update");

        Route::delete("/{task}/delete", [\App\Http\Controllers\TaskController::class, "destroy"])->name("delete");
    });

    Route::prefix("/categories")->name("category.")->group(function () {
        Route::get("/", [\App\Http\Controllers\CategoryController::class, "index"])->name("index");
        Route::get("/{category}", [\App\Http\Controllers\CategoryController::class, "show"])->name("show");
        Route::get("/{category}/edit", [\App\Http\Controllers\CategoryController::class, "edit"])->name("edit");

        Route::post("/create", [\App\Http\Controllers\CategoryController::class, "store"])->name("store");
        Route::put("/{category}/edit", [\App\Http\Controllers\CategoryController::class, "update"])->name("update");

        Route::delete("/{category}/delete", [\App\Http\Controllers\CategoryController::class, "destroy"])->name("delete");
    });
});

require __DIR__ . '/auth.php';
