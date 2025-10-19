<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/chat', function () {
return view('chat');
});
// Route::get('/home', function () {
//  // ini mengarah ke resources/views/home.blade.php
// });
