<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');


Route::get('data/santri',[SantriController::class,'index'])->name('santri.index');
Route::get('create/santri',[SantriController::class,'create'])->name('santri.create');
Route::post('store/santri', [SantriController::class, 'store'])->name('santri.store');
Route::get('edit/santri/{id}',[SantriController::class,'edit'])->name('santri.edit');
Route::put('update/santri/{id}', [SantriController::class, 'update'])->name('santri.update');
Route::delete('delete/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');
Route::get('detail/santri/{id}', [SantriController::class, 'show'])->name('santri.show');

Route::get('data/kamar',[KamarController::class,'index'])->name('kamar.index');
Route::get('create/kamar',[KamarController::class,'create'])->name('kamar.create');
Route::post('store/kamar', [KamarController::class, 'store'])->name('kamar.store');
Route::get('edit/kamar/{id}',[KamarController::class,'edit'])->name('kamar.edit');
Route::put('update/kamar/{id}', [KamarController::class, 'update'])->name('kamar.update');





