<?php

namespace Controller;

use Model\Book;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Model\Reservation;
use Src\Validator\Validator;
class Site
{
    public function index(): string
    {
        // Получаем все книги из таблицы Book_copies
        $books = Book::all();

        // Передаем переменную books в шаблон
        return (new View())->render('site.index', ['books' => $books]);
    }


    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }
    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

// 1. Детальный просмотр книги
    public function viewBook(Request $request): string
    {
        $book = Book::where('InventoryNumber', $request->id)->first();
        return (new View())->render('site.view', ['book' => $book]);
    }

// 2. Личный кабинет пользователя (Мои бронирования)
    public function myReservations(): string
    {
        // Получаем брони текущего пользователя вместе с данными о книгах
        $reservations = \Model\Reservation::where('userID', Auth::user()->id)
            ->with('book') // Загружаем связанные книги
            ->get();

        return (new View())->render('site.reservations', ['reservations' => $reservations]);
    }


// 3. Логика создания бронирования
    public function reserve(Request $request): void
    {
        Reservation::create([
            'BookID' => $request->id,
            // Вызываем метод getId(), который теперь возвращает userID
            'userID' => Auth::user()->getId(),
            'ReservationDate' => date('Y-m-d'),
            'ExpiryDate' => date('Y-m-d', strtotime('+7 days')),
            'Status' => 'booked'
        ]);

        app()->route->redirect('/my-reservations');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}