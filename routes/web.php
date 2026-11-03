<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SiteController,AuthController,AdminController};
Route::get('/',[SiteController::class,'home'])->name('home');
Route::get('/venues',[SiteController::class,'venues'])->name('venues');
Route::get('/venues/{venue:slug}',[SiteController::class,'venue'])->name('venue.show');
Route::get('/services',[SiteController::class,'services'])->name('services');
Route::get('/events',[SiteController::class,'events'])->name('events');
Route::get('/clients',[SiteController::class,'clients'])->name('clients');
Route::view('/about','pages.about')->name('about');
Route::get('/contact',[SiteController::class,'contact'])->name('contact');
Route::post('/enquiries',[SiteController::class,'enquiry'])->middleware('throttle:5,1')->name('enquiry.store');
Route::middleware('guest')->group(function(){Route::get('/admin/login',[AuthController::class,'loginForm'])->name('login');Route::post('/admin/login',[AuthController::class,'login'])->middleware('throttle:5,1')->name('admin.login.submit');});
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
 Route::post('/logout',[AuthController::class,'logout'])->name('logout');
 Route::get('/',[AdminController::class,'dashboard'])->name('dashboard');
 Route::get('/enquiries',[AdminController::class,'enquiries'])->name('enquiries');
 Route::get('/enquiries/{enquiry}',[AdminController::class,'enquiry'])->name('enquiry');
 Route::put('/enquiries/{enquiry}',[AdminController::class,'enquiryUpdate'])->name('enquiry.update');
 Route::get('/content/{section}',[AdminController::class,'index'])->name('items');
 Route::get('/content/{section}/create',[AdminController::class,'create'])->name('create');
 Route::post('/content/{section}',[AdminController::class,'store'])->name('store');
 Route::get('/content/{section}/{id}/edit',[AdminController::class,'edit'])->name('edit');
 Route::put('/content/{section}/{id}',[AdminController::class,'update'])->name('update');
 Route::delete('/content/{section}/{id}',[AdminController::class,'destroy'])->name('delete');
});
