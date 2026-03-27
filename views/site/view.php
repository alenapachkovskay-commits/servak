<?php
use Src\Auth\Auth;
?>

<h1><?= $book->Title ?></h1>
<p>Автор: <?= $book->Author ?></p>
<p>Место на полке: <?= $book->SelfLocation ?></p>

<?php if (Auth::check()): ?>
    <form method="POST" action="/reserve">
        <!-- Имя должно быть "id" -->
        <input type="hidden" name="id" value="<?= $book->InventoryNumber ?>">
        <button type="submit">Забронировать книгу</button>
    </form>
<?php else: ?>
    <p><a href="/login">Войдите</a>, чтобы забронировать.</p>
<?php endif; ?>
