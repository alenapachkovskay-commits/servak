<div class="reservation-confirm" style="max-width: 600px; margin: 50px auto; border: 1px solid #ddd; padding: 30px; border-radius: 8px;">
    <h1>Подтверждение бронирования</h1>

    <div style="text-align: left; background: #f9f9f9; padding: 15px; margin-bottom: 20px;">
        <p><strong>Название:</strong> <?= $book->Title ?></p>
        <p><strong>Автор:</strong> <?= $book->Author ?></p>
        <p><strong>Инвентарный номер:</strong> <?= $book->InventoryNumber ?></p>
        <p><strong>Место на полке:</strong> <?= $book->SelfLocation ?></p>
    </div>

    <form method="POST" action="/reserve/confirm">
        <!-- CSRF ТОКЕН - обязательно! -->
        <input type="hidden" name="csrf_token" value="<?php
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        echo $_SESSION['csrf_token'];
        ?>">

        <input type="hidden" name="book_id" value="<?= $book->InventoryNumber ?>">

        <div style="margin: 20px 0;">
            <label for="expiry">Выберите дату, до которой вы заберете книгу:</label><br>
            <input type="date" id="expiry" name="expiry_date"
                   value="<?= date('Y-m-d', strtotime('+3 days')) ?>"
                   min="<?= date('Y-m-d') ?>" required>
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Подтвердить бронь
        </button>
        <a href="/" style="display: block; margin-top: 15px; color: #666;">Отмена</a>
    </form>
</div>
