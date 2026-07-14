<?php

use App\Http\Controllers\TreeVersionController;
use Illuminate\Support\Facades\Route;

Route::get('/tree-versions', [TreeVersionController::class, 'index'])->name('tree-versions.index');
Route::post('/tree-versions', [TreeVersionController::class, 'store'])->name('tree-versions.store');
Route::post('/tree-versions/{treeVersion}/activate', [TreeVersionController::class, 'activate'])->name('tree-versions.activate');
