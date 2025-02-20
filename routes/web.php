<?php
use App\Http\Controllers\FileUploadController;

Route::get('/upload', [FileUploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload.file');

Route::get('/filter', [FileUploadController::class, 'showFilterForm'])->name('filter.form');
Route::get('/filter-programs', [FileUploadController::class, 'filterPrograms'])->name('filter.programs');