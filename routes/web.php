<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageController;

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
Route::get('/', [ImageController::class,'index'])->name('home');
Route::post('image/savePicture',[ImageController::class,'savePicture'])->name('image.savePicture');
Route::post('image/reOrder',[ImageController::class,'reOrder'])->name('image.reOrder');
Route::resource('image',ImageController::class);


Route::get('api/images',[ApiController::class, 'index'])->name('api.images');
Route::get('api/image/{id}',[ApiController::class, 'show'])->name('api.image');
