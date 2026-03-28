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
                'Name' => ['required'],
                'Surname' => ['required'],
                'Email' => ['required'],
                'login' => ['required', 'unique:user,login'], // Таблица user
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Логин :field уже занят'
            ]);

            if($validator->fails()){
                return new View('site.signup', [
                    'message' => implode(', ', $validator->errors())
                ]);
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
        $userId = Auth::user()->userID;

        $reservations = Reservation::where('userID', $userId)
            ->with('book')
            ->get();

        return (new View())->render('site.reservations', ['reservations' => $reservations]);
    }




// 3. Логика создания бронирования
    // 1. Показываем форму подтверждения
    public function confirmReservation(Request $request): string
    {
        $bookId = $request->id;
        return (new View())->render('site.reserve_confirm', ['bookId' => $bookId]);
    }
    public function showReserveForm(Request $request): string
    {
        // 1. Ищем книгу по InventoryNumber
        $book = \Model\Book::where('InventoryNumber', $request->id)->first();

        // 2. Передаем объект $book в шаблон
        return (new View())->render('site.reserve', ['book' => $book]);
    }
// 2. Сохраняем в базу (POST /reserve/confirm)
    public function reserve(Request $request): void
    {
        // 1. Ищем саму книгу в базе
        $book = \Model\Book::where('InventoryNumber', $request->book_id)->first();

        // 2. Проверяем: если книга уже забронирована (StatusID != 1), не даем бронировать
        if (!$book || $book->StatusID != 1) {
            // Можно редиректнуть с сообщением об ошибке
            app()->route->redirect('/?error=already_booked');
            return;
        }

        // 3. Если свободна — создаем ОДНУ запись в Reservation
        \Model\Reservation::create([
            'BookID'          => $request->book_id,
            'userID'          => \Src\Auth\Auth::user()->userID,
            'ReservationDate' => date('Y-m-d'),
            'ExpiryDate'      => $request->expiry_date,
            'Status'          => 'active'
        ]);

        // 4. ВАЖНО: Меняем статус книги на "Забронировано" (допустим, это ID 2)
        // Теперь она пропадет из доступных и не будет дублироваться
        $book->StatusID = 2;
        $book->save();

        app()->route->redirect('/my-reservations');
    }
    public function cancelReservation(Request $request): void
    {
        // 1. Находим и удаляем запись о бронировании
        $reservation = \Model\Reservation::where('ReservationID', $request->reservation_id)->first();

        if ($reservation) {
            $reservation->delete();
        }

        // 2. Находим книгу и возвращаем ей статус 1 (Свободна)
        $book = \Model\Book::where('InventoryNumber', $request->book_id)->first();
        if ($book) {
            $book->StatusID = 1;
            $book->save();
        }

        // 3. Возвращаемся обратно в личный кабинет
        app()->route->redirect('/my-reservations');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}