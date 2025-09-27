<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MadrasahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomponenSppController;
use App\Http\Controllers\TagihanSantriController;
use App\Http\Controllers\PenagihanSantriController;
use App\Http\Controllers\PilihanMakanSantriController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[LandingController::class,'index'])->name('/');
Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
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


Route::get('data/madrasah',[MadrasahController::class,'index'])->name('madrasah.index');
Route::get('create/madrasah',[MadrasahController::class,'create'])->name('madrasah.create');
Route::post('store/madrasah', action: [MadrasahController::class, 'store'])->name('madrasah.store');
Route::get('edit/madrasah/{id}',[MadrasahController::class,'edit'])->name('madrasah.edit');
Route::put('update/madrasah/{id}', [MadrasahController::class, 'update'])->name('madrasah.update');

Route::get('data/komponen_spp',[KomponenSppController::class,'index'])->name('komponen_spp.index');
Route::get('create/komponen_spp',[KomponenSppController::class,'create'])->name('komponen_spp.create');
Route::post('store/komponen_spp', [KomponenSppController::class, 'store'])->name('komponen_spp.store');
Route::get('edit/komponen_spp/{id}',[KomponenSppController::class,'edit'])->name('komponen_spp.edit');
Route::put('update/komponen_spp/{id}', [KomponenSppController::class, 'update'])->name('komponen_spp.update');
Route::delete('destroy/komponen_spp/{id}', [KomponenSppController::class, 'destroy'])->name('komponen_spp.destroy');

Route::get('data/pilih/makan/santri',[PilihanMakanSantriController::class,'index'])->name('pilihan-makan-santri.index');
Route::get('create/pilih/makan/santri',[PilihanMakanSantriController::class,'create'])->name('pilihan-makan-santri.create');
Route::post('store/pilih/makan/santri', action: [PilihanMakanSantriController::class, 'store'])->name('pilihan-makan-santri.store');
Route::get('edit/pilih/makan/santri/{id}',[PilihanMakanSantriController::class,'edit'])->name('pilihan-makan-santri.edit');
Route::put('update/pilih/makan/santri/{id}', [PilihanMakanSantriController::class, 'update'])->name('pilihan-makan-santri.update');

Route::get('data/penagihan/santri',[PenagihanSantriController::class,'index'])->name('penagihan-santri.index');
Route::get('create/penagihan/santri/{id}',[PenagihanSantriController::class,'generateTagihan'])->name('penagihan-santri.create');
Route::post('/penagihan-santri/generate-all', [PenagihanSantriController::class, 'generateAllTagihan'])->name('penagihan-santri.generate-all');

Route::get('data/tagihan/santri',[TagihanSantriController::class,'index'])->name('tagihan-santri.index');
Route::get('penagihan-santri/{id_santri}/detail', [TagihanSantriController::class, 'show'])->name('penagihan-santri.show');

Route::get('data/user',[UserController::class,'index'])->name('user.index');
Route::get('create/user',[UserController::class,'create'])->name('user.create');
Route::post('store/user',[UserController::class,'store'])->name('user.store');
Route::get('edit/user/{id}',[UserController::class,'edit'])->name('user.edit');
Route::put('update/user/{id}',[UserController::class,'update'])->name('user.update');









