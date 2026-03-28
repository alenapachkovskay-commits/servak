<?php
use Src\Auth\Auth;
?>

<h1><?= $book->Title ?></h1>
<p>Автор: <?= $book->Author ?></p>
<p>Место на полке: <?= $book->SelfLocation ?></p>

<!-- Добавляем текст о статусе для наглядности -->
<p>Статус:
    <strong><?= ($book->StatusID == 1) ? 'Доступна' : 'Уже забронирована' ?></strong>
</p>

<?php if (Auth::check()): ?>

    <?php if ($book->StatusID == 1): ?>
        <!-- Кнопка активна, если StatusID равен 1 (Свободна) -->
        <form method="GET" action="/reserve">
            <input type="hidden" name="id" value="<?= $book->InventoryNumber ?>">
            <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; cursor: pointer;">
                Забронировать книгу
            </button>
        </form>
    <?php else: ?>
        <!-- Кнопка заблокирована (disabled), если статус не 1 -->
        <button disabled style="background: #ccc; color: #666; padding: 10px 20px; cursor: not-allowed;">
            Книга забронирована
        </button>
        <p style="color: red; font-size: 0.9em;">Эту книгу уже кто-то взял, выберите другую.</p>
    <?php endif; ?>

<?php else: ?>
    <p><a href="/login">Войдите</a>, чтобы забронировать.</p>
<?php endif; ?>
