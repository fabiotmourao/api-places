<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;


Route::get('/places', [PlaceController::class,  'index']);
Route::post('/place/create', [PlaceController::class,  'store']);
Route::put('/place/update/{id}',[PlaceController::class,  'update']);
Route::delete('/place/delete/{id}',[PlaceController::class,  'delete']);

