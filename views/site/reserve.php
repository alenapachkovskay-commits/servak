<?php
use Src\Auth\Auth;

// 1. Проверяем авторизацию (только зарегистрированные могут бронить)
if (!Auth::check()) {
    header('Location: /login');
    exit;
}

// 2. Получаем ID книги из POST-запроса (из твоей кнопки "Забронировать")
$bookId = $_POST['id'] ?? null;

// 3. Здесь должна быть логика контроллера:
// - Проверка, не забронирована ли уже книга (StatusID в Book_copies)
// - INSERT в таблицу Reservation (Status = 'active', ReservationDate = NOW(), ExpiryDate = +7/14 дней)
// - UPDATE в таблице Book_copies (StatusID = ID статуса 'booked')

?>

<div class="reservation-confirm" style="max-width: 500px; margin: 50px auto; text-align: center; border: 1px solid #ddd; padding: 20px;">
    <h1>Подтверждение бронирования</h1>

    <div class="info">
        <p>Вы собираетесь забронировать книгу с инвентарным номером: <strong><?= htmlspecialchars($bookId) ?></strong></p>
        <p>Пользователь: <strong><?= Auth::user()->Name ?></strong> (ID: <?= Auth::user()->userID ?>)</p>
    </div>

    <form method="POST" action="/reserve/confirm">
        <input type="hidden" name="book_id" value="<?= $bookId ?>">
        <input type="hidden" name="user_id" value="<?= Auth::user()->userID ?>">

        <div style="margin: 20px 0;">
            <label for="expiry">Дата, до которой заберете книгу:</label><br>
            <!-- Устанавливаем дату по умолчанию (например, через 3 дня) -->
            <input type="date" id="expiry" name="expiry_date"
                   value="<?= date('Y-m-d', strtotime('+3 days')) ?>" required>
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Подтвердить бронь
        </button>
        <a href="/catalog" style="display: block; margin-top: 15px; color: #666;">Отмена</a>
    </form>
</div>
