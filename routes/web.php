<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return redirect()->route('banks.index');
    })->name('dashboard');

    // Rute aplikasi keuangan pribadi Anda
    // Route::resource('banks', BankController::class);
    // Route::resource('incomes', IncomeController::class);
    // Route::resource('expenses', ExpenseController::class);
    //
    Route::resource('banks', BankController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('expenses/{expense}/edit-detail', [ExpenseController::class, 'editDetail'])->name('expenses.edit-detail');
    Route::get('expenses/{expense}/create-detail', [ExpenseController::class, 'createDetail'])->name('expenses.create-detail');
    Route::post('expenses/store-detail', [ExpenseController::class, 'storeDetail'])->name('expenses.store-detail');
});

require __DIR__ . '/auth.php';
