
<div style="text-align: center; margin-top: 50px; font-family: sans-serif;">
    <h1>Добро пожаловать в «Абонемент»! 📚</h1>
    <p style="font-size: 1.2em; color: #555;">
        Вы успешно вошли в систему читального зала.
    </p>

    <hr style="width: 50%; margin: 30px auto; border: 0; border-top: 1px solid #eee;">

    <div style="display: flex; justify-content: center; gap: 20px;">
        <!-- Ссылка на каталог книг -->
        <a href="<?= app()->route->getUrl('/') ?>"
           style="padding: 15px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Перейти в каталог книг
        </a>

        <!-- Ссылка в личный кабинет -->
        <a href="<?= app()->route->getUrl('/my-reservations') ?>"
           style="padding: 15px 25px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">
            Мои бронирования
        </a>
    </div>

    <?php if (app()->auth::user()->role == 1): // Если зашел библиотекарь ?>
        <div style="margin-top: 40px; padding: 20px; background: #fff3cd; display: inline-block; border-radius: 8px;">
            <strong>Панель сотрудника:</strong>
            Вы можете оформлять выдачу и искать книги по штрих-коду.
        </div>
    <?php endif; ?>
</div>
