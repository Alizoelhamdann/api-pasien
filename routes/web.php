<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;

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

Route::get('/pasiens', [PasienController::class, 'index']);
Route::post('/pasiens/store',[PasienController::class, 'store']);
Route::patch('/pasiens/{id}/update',[PasienController::class,'update']);
Route::delete('/pasiens/{id}/delete', [PasienController::class, 'destroy']);    
Route::get('/',[PasienController::class, 'createToken']);
Route::get('/pasiens/{id}', [PasienController::class, 'show']);
Route::get('/pasiens/show/trash', [PasienController::class, 'trash']);
Route::get('/pasiens/show/trash/{id}', [PasienController::class, 'restore']);
Route::get('/pasiens/show/trash/permanent/{id}', [PasienController::class, 'permanentDelete']);

