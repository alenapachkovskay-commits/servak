<h2>Регистрация нового пользователя</h2>
<h3 style="color: red;"><?= $message ?? ''; ?></h3>
<form method="post">
    <!-- Имена полей теперь совпадают с колонками в БД -->
    <label>Фамилия <input type="text" name="Surname" required></label><br>
    <label>Имя <input type="text" name="Name" required></label><br>
    <label>Email <input type="email" name="Email" required></label><br>
    <label>Логин <input type="text" name="login" required></label><br>
    <label>Пароль <input type="password" name="password" required></label><br>
    <button type="submit">Зарегистрироваться</button>
</form>
