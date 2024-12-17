<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PrayerTimeController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

// Route::prefix('/dashboard')->controller(DashboardController::class)->group(function () {
//     Route::get('/', 'index')->name('dashboard');
// });

Route::get('/logs', [LogViewerController::class, 'index'])->name('logs.index');

Route::get('/prayertimes', [PrayerTimeController::class, 'index'])->name('prayertimes.index');

Route::middleware(['auth'])->prefix('logs')->group(function () {
    Route::get('/', [LogViewerController::class, 'index'])->name('logs.index');
});

// Group for prayer times with 'prayertimes' prefix
Route::middleware(['auth'])->prefix('prayertimes')->group(function () {
    Route::get('/', [PrayerTimeController::class, 'index'])->name('prayertimes.index');
});

Route::middleware('auth')->prefix('/dashboard')->controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('users', UserController::class);

Route::prefix('usermanagements')->controller(UserManagementController::class)->group(function () {
    Route::get('/', 'index')->name('usermanagements.index');
    Route::get('/create', 'create')->name('usermanagements.create');
    Route::post('/', 'store')->name('usermanagements.store');
    Route::get('/{id}/edit', 'edit')->name('usermanagements.edit');
    Route::patch('/{id}', 'update')->name('usermanagements.update');
    Route::delete('/{id}', 'destroy')->name('usermanagements.destroy');
    Route::get('/{id}', 'show')->name('usermanagements.show');  // Add this line

});

// Route::prefix('reports')->controller(ReportController::class)->group(function () {
//     Route::get('/', 'index')->name('reports.index'); // Report index page
//     Route::get('/download', 'download')->name('reports.download'); // Download PDF
// });

Route::middleware('auth')->prefix('reports')->controller(ReportController::class)->group(function () {
    Route::get('/', 'index')->name('reports.index');
    Route::get('/download', 'download')->name('reports.download');
});

Route::middleware('auth')->prefix('transactions')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index')->name('transactions.index');
    Route::post('/create', 'store')->name('transactions.store');
    Route::get('/show/{transactions}', 'show')->name('transactions.show');
    Route::get('/create', 'create')->name('transactions.create');
    Route::get('/{transactions}/edit', 'edit')->name('transactions.edit');
    Route::patch('/{transactions}/edit', 'update')->name('transactions.update');
    Route::delete('/{transactions}/destroy', 'destroy')->name('transactions.destroy');
});

// Category Routes (Protected)
Route::middleware('auth')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('categories.index');
    Route::get('/create', 'create')->name('categories.create');
    Route::post('/', 'store')->name('categories.store');
    Route::get('/{category}/edit', 'edit')->name('categories.edit');
    Route::patch('/{category}', 'update')->name('categories.update');
    Route::delete('/{category}', 'destroy')->name('categories.destroy');
});

// Recurring Transactions Routes (Protected)
Route::middleware('auth')->prefix('recurring-transactions')->controller(RecurringTransactionController::class)->group(function () {
    Route::get('/', 'index')->name('recurring-transactions.index');
    Route::get('/create', 'create')->name('recurring-transactions.create');
    Route::post('/', 'store')->name('recurring-transactions.store');
    Route::get('/{recurringTransaction}/edit', 'edit')->name('recurring-transactions.edit');
    Route::patch('/{recurringTransaction}', 'update')->name('recurring-transactions.update');
    Route::delete('/{recurringTransaction}', 'destroy')->name('recurring-transactions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
});


// Route::middleware('auth')->prefix('rooms')->controller(RoomController::class)->group(function () {
//     Route::get('/', 'index')->name('rooms.index'); // List rooms
//     Route::get('/create', 'create')->name('rooms.create'); // Create room
//     Route::post('/', 'store')->name('rooms.store'); // Store new room
//     Route::get('/{room}/edit', 'edit')->name('rooms.edit'); // Edit room
//     Route::patch('/{room}', 'update')->name('rooms.update'); // Update room
//     Route::delete('/{room}', 'destroy')->name('rooms.destroy'); // Delete room
// });

// Route::middleware('auth')->prefix('bookings')->controller(BookingController::class)->group(function () {
//     Route::get('/', 'index')->name('bookings.index'); // List bookings
//     Route::get('/create', 'create')->name('bookings.create'); // Create booking
//     Route::post('/', 'store')->name('bookings.store'); // Store new booking
//     Route::delete('/{booking}', 'destroy')->name('bookings.destroy'); // Cancel booking
// });

Route::middleware(['auth'])->group(function () {

    // Rooms Routes
    Route::resource('rooms', RoomController::class);

    // Booking Routes
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{roomId}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');

});
require __DIR__ . '/auth.php';
