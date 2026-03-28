<h1>Добро пожаловать на главную страницу!</h1>
<h2>Каталог книг</h2>
<div class="catalog">
    <?php foreach ($books as $book): ?>
        <div class="book-card" style="...">
            <h3><?= $book->Title ?></h3>
            <!-- Если StatusID не 1 (available), пишем что занята -->
            <p>Статус: <?= ($book->StatusID == 1) ? 'Свободна' : 'Забронирована' ?></p>

            <a href="<?= app()->route->getUrl('/book/view') ?>?id=<?= $book->InventoryNumber ?>">
                Подробнее
            </a>

            <?php if ($book->StatusID == 1): ?>
                <span style="color: green;">✔ Доступна для брони</span>
            <?php else: ?>
                <span style="color: red;">✘ Недоступна</span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>
