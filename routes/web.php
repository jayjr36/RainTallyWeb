<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RainDataController;
use App\Livewire\RainDataReader;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/all-data', [RainDataController::class, 'allData']);
Route::get('/filtered-data', [RainDataController::class, 'filteredData']);
Route::get('/chart-data', [RainDataController::class, 'chartData'])->name('rain-data.chart');

Route::get('/all-data', RainDataReader::class)->name('rain.data');