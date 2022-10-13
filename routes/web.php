<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
        CustomerController,
        ErrorPageController,
        MedicalController,
        MyPageController,
        ReportController,
        ShopSelectController,
        UserController,
        VisitReserveController
    };

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

Route::get('/', function () {
    return view('welcome');
});

// ログイン後のトップページ
Route::get('/myPage', [MyPageController::class, 'index'])->middleware(['auth'])->name('myPage');
Route::get('/error', [ErrorPageController::class, 'index'])->middleware(['auth'])->name('error');

// 店舗選択系
Route::middleware(['auth'])->prefix('shop')->group(function(){
    Route::get('/select', [ShopSelectController::class, 'index'])->name('shop.select');
    Route::get('/selecting/{shop}', [ShopSelectController::class, 'selecting'])->name('shop.selecting');
    Route::get('/deselect', [ShopSelectController::class, 'deselect'])->name('shop.deselect');
});

// 日報
Route::get('/report', [ReportController::class, 'index'])->middleware(['auth'])->name('report');

// 予約
Route::middleware(['auth'])->prefix('reserve')->group(function(){
    Route::get('/visited/{visitReserve}', [VisitReserveController::class, 'visited'])->name('reserve.visited');
    Route::get('/destroy/{visitReserve}', [VisitReserveController::class, 'destroy'])->name('reserve.destroy');
    Route::get('/list/{date}', [VisitReserveController::class, 'list'])->name('reserve.list');
});
Route::get('/reserve/', [VisitReserveController::class, 'index'])->middleware(['auth'])->name('reserve');

// 顧客関係
Route::resource('customer', CustomerController::class)->middleware(['auth']);

// ユーザー関係
Route::middleware(['auth'])->prefix('user')->group(function(){
    Route::post('/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/belongSelect', [UserController::class, 'belongSelect'])->name('user.belongSelect');
    Route::get('/belongSelected/{user}', [UserController::class, 'belongSelected'])->name('user.belongSelected');
    Route::get('/deleteBelongShop/{user}', [UserController::class, 'deleteBelongShop'])->name('user.deleteBelongShop');
});
Route::resource('user', UserController::class)->middleware(['auth']);

// カルテ
Route::get('/medical', [MedicalController::class, 'index'])->middleware(['auth'])->name('medical.index');

Route::get('/medicalCreate/{shop}', [MedicalController::class, 'create'])->name('medical.create');
Route::post('/medicalStore/{shop}', [MedicalController::class, 'store'])->name('medical.store');







require __DIR__.'/auth.php';
