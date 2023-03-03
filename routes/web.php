<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panel\Home\HomeController;
use App\Http\Controllers\Panel\Notification\NotificationController;
use App\Http\Controllers\Panel\TakeMedicine\TakeMedicineController;
use App\Http\Controllers\Panel\PembelianObat\PembelianObatController;
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

// Route::redirect('/', '/home');
Route::get('/', [HomeController::class, 'index']);
Route::resource('/home', HomeController::class);
Route::resource('/take-medicine', TakeMedicineController::class)->only('create', 'store');
Route::resource('/pembelian-obat', PembelianObatController::class)->only('create', 'store');
Route::get('/home/json/datatables', [HomeController::class, 'datatables'])->name('home.json.datatables');
Route::get('/take-medicine/obat/{id}', [TakeMedicineController::class, 'jsonObat'])->name('take-medicine.obat');
Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
Route::view('/offline', 'vendor/laravelpwa/offline');