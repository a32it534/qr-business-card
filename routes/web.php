<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PublicBusinessController;
Route::get('/', fn()=>view('home'))->name('home');
Route::middleware('guest')->group(function(){
 Route::get('/register',[AuthController::class,'showRegister'])->name('register');
 Route::post('/register',[AuthController::class,'register']);
 Route::get('/login',[AuthController::class,'showLogin'])->name('login');
 Route::post('/login',[AuthController::class,'login']);
});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function(){
 Route::get('/',[BusinessController::class,'index'])->name('index');
 Route::get('/business/create',[BusinessController::class,'create'])->name('business.create');
 Route::post('/business',[BusinessController::class,'store'])->name('business.store');
 Route::get('/business/{business}/edit',[BusinessController::class,'edit'])->name('business.edit');
 Route::put('/business/{business}',[BusinessController::class,'update'])->name('business.update');
 Route::delete('/business/{business}',[BusinessController::class,'destroy'])->name('business.destroy');
 Route::get('/business/{business}/qr',[BusinessController::class,'qr'])->name('business.qr');
 Route::get('/business/{business}/qr/download',[BusinessController::class,'qrDownload'])->name('business.qr.download');
});
Route::get('/b/{code}',[PublicBusinessController::class,'show'])->name('business.public');
