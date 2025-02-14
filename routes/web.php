<?php
use App\Http\Controllers\UploadController;

Route::get('/', [UploadController::class, 'index'])->name('uploads.index');
Route::post('/upload', [UploadController::class, 'store'])->name('uploads.store');
Route::get('/upload/{upload}', [UploadController::class, 'show'])->name('uploads.show');

