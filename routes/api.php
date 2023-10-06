<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getData', 'Mocking\Controllers\Controller@getData'); 
Route::get('/getMenu', 'Mocking\Controllers\Controller@getMenu'); 
Route::post('/postData', 'Mocking\Controllers\Controller@postData'); 
Route::put('/putData/{id}', 'Mocking\Controllers\Controller@putData');
Route::put('/putMenu/{id}', 'Mocking\Controllers\Controller@updateMenu');
Route::delete('/deletePesanan/{id}', 'Mocking\Controllers\Controller@destroy');
