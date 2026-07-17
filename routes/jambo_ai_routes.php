<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'throttle:60,1'])->prefix('api/jambo-ai')->group(function () {
    Route::get('/tasks', 'JamboAiTaskController@index')->name('jambo_ai.tasks.index');
    Route::get('/history', 'JamboAiTaskController@history')->name('jambo_ai.tasks.history');
    Route::post('/tasks', 'JamboAiTaskController@store')->middleware('throttle:20,1')->name('jambo_ai.tasks.store');
    Route::post('/tasks/{id}/tooltip', 'JamboAiTaskController@sendTooltip')->name('jambo_ai.tasks.tooltip');
    Route::post('/tasks/{id}/busy', 'JamboAiTaskController@markBusy')->name('jambo_ai.tasks.busy');
    Route::post('/tasks/{id}/done', 'JamboAiTaskController@markDone')->name('jambo_ai.tasks.done');
    Route::post('/tasks/{id}/cancel', 'JamboAiTaskController@cancel')->name('jambo_ai.tasks.cancel');
});
