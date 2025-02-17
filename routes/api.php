<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;


Route::get('/places/index', [PlaceController::class,  'index']);
Route::get('/places/show/{id}', [PlaceController::class,  'show']);
Route::get('/places/search', [PlaceController::class, 'search']);
Route::post('/place/create', [PlaceController::class,  'store']);
Route::put('/place/update/{id}',[PlaceController::class,  'update']);
Route::delete('/place/delete/{id}',[PlaceController::class,  'delete']);
