<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');


Route::get('data/santri',[SantriController::class,'index'])->name('santri.index');
Route::get('create/santri',[SantriController::class,'create'])->name('santri.create');
Route::post('/santri/store', [SantriController::class, 'store'])->name('santri.store');
Route::get('edit/santri/{id}',[SantriController::class,'edit'])->name('santri.edit');
Route::put('/santri/update/{id}', [SantriController::class, 'update'])->name('santri.update');
Route::delete('delete/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');
Route::get('detail/santri/{id}', [SantriController::class, 'show'])->name('santri.show');




