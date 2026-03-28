<h2>Мои забронированные книги</h2>
<table border="1" cellpadding="10" style="border-collapse: collapse; width: 50%;">
    <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Дата брони</th>
        <th>Срок действия</th>
        <th>Местоположение</th>
        <th>Электронная</th>
        <th>Действия</th>
    </tr>
    <?php if (empty($reservations)): ?>
        <tr><td colspan="7">Нет активных бронирований.</td></tr>
    <?php else: ?>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= $res->book->Title ?? 'N/A' ?></td>
                <td><?= $res->book->Author ?? 'N/A' ?></td>
                <td><?= $res->ReservationDate ?></td>
                <td><?= $res->ExpiryDate ?></td>
                <td><?= $res->book->SelfLocation ?? '' ?></td>
                <td>
                    <?php if ($res->book->IsElectronic): ?>
                        <a href="<?= $res->book->ElectronicLink ?>" target="_blank">Читать онлайн</a>
                    <?php else: ?>
                        Нет
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" action="/reserve/cancel" onsubmit="return confirm('Вы уверены?');" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?php
                        if (!isset($_SESSION['csrf_token'])) {
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        }
                        echo $_SESSION['csrf_token'];
                        ?>">
                        <input type="hidden" name="reservation_id" value="<?= $res->ReservationID ?>">
                        <input type="hidden" name="book_id" value="<?= $res->BookID ?>">
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                            Отменить
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
