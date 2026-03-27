<h2>Мои забронированные книги</h2>
<table>
    <tr>
        <th>Книга</th>
        <th>Дата брони</th>
        <th>Срок до</th>
    </tr>
    <?php foreach ($reservations as $res): ?>
        <tr>
            <td><?= $res->book->Title ?? 'Книга удалена' ?></td>
            <td><?= $res->ReservationDate ?></td>
            <td><?= $res->ExpiryDate ?></td>
        </tr>
    <?php endforeach; ?>
</table>
