<?php

use Illuminate\Support\Facades\Route;



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
->name('home');
Route::get('/board/{id}/{board_name}', [App\Http\Controllers\HomeController::class, 'viewBoard'])
->name('home.board');

Route::get('/board/{board_id}/{class_id}/{board_name}/{class_name}', [App\Http\Controllers\HomeController::class, 'viewClass'])
->name('home.board.classes');


