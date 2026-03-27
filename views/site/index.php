<h1>Добро пожаловать на главную страницу!</h1>
<h2>Каталог книг</h2>
<div class="catalog">
    <?php foreach ($books as $book): ?>
        <div class="book-card" style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
            <h3><?= $book->Title ?></h3>
            <p><strong>Автор:</strong> <?= $book->Author ?></p>
            <p><strong>Место:</strong> <?= $book->SelfLocation ?></p>
            <p><strong>Тип:</strong> <?= $book->IsElectronic ? 'Электронная' : 'Бумажная' ?></p>
            <a href="<?= app()->route->getUrl('/book/view') ?>?id=<?= $book->InventoryNumber ?>">
                Подробнее
            </a>
        </div>
    <?php endforeach; ?>
</div>
