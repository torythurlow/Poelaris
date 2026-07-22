<?php

use App\Http\Controllers\GemController;
use App\Http\Controllers\GemLinkController;
use App\Http\Controllers\JewelSocketController;
use App\Http\Controllers\LevelRangeController;
use App\Http\Controllers\MasteryAllocationController;
use App\Http\Controllers\NodeAllocationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TreeDataController;
use App\Http\Controllers\TreeVersionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', [TemplateController::class, 'index'])->name('home');
    Route::get('/tree-data', TreeDataController::class)->name('tree.data');
    Route::get('/tree-versions', [TreeVersionController::class, 'index'])->name('tree-versions.index');
    Route::post('/tree-versions/{version}/activate', [TreeVersionController::class, 'activate'])->name('tree-versions.activate');

    Route::resource('templates', TemplateController::class)->except(['edit', 'create']);

    Route::prefix('templates/{template}')->scopeBindings()->group(function () {
        Route::resource('ranges', LevelRangeController::class)->except(['index', 'show', 'edit', 'create']);
        Route::post('ranges/reorder', [LevelRangeController::class, 'reorder'])->name('ranges.reorder');

        Route::prefix('ranges/{range}')->group(function () {
            Route::post('nodes', [NodeAllocationController::class, 'store'])->name('nodes.store');
            Route::delete('nodes/{nodeId}', [NodeAllocationController::class, 'destroy'])->name('nodes.destroy');

            Route::post('masteries', [MasteryAllocationController::class, 'store'])->name('masteries.store');
            Route::put('masteries/{mastery}', [MasteryAllocationController::class, 'update'])->name('masteries.update');

            Route::resource('jewels', JewelSocketController::class)->except(['index', 'show', 'edit', 'create']);
            Route::resource('gem-links', GemLinkController::class)
                ->parameters(['gem-links' => 'gemLink'])
                ->except(['index', 'show', 'edit', 'create']);
            Route::post('gem-links/{gemLink}/gems', [GemController::class, 'store'])->name('gems.store');
            Route::delete('gem-links/{gemLink}/gems/{gem}', [GemController::class, 'destroy'])->name('gems.destroy');
        });
    });
});
