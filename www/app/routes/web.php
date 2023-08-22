<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UploadController::class, 'show'])->name('upload.form');
Route::post('/upload', [UploadController::class, 'uploadFile'])->name('upload');
Route::get('/rows', [RowController::class, 'index'])->name('row.index');
