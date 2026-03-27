<?php

use Src\Route;
Route::add('GET', '/', [Controller\Site::class, 'index']);

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
// Просмотр конкретной книги
Route::add('GET', '/book/view', [Controller\Site::class, 'viewBook']);

// Личный кабинет со списком броней (только для авторизованных)
Route::add('GET', '/my-reservations', [Controller\Site::class, 'myReservations'])
    ->middleware('auth');

// Обработка бронирования
Route::add('POST', '/reserve', [Controller\Site::class, 'reserve'])
    ->middleware('auth');

