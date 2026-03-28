<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pop it MVC</title>
    <style>
        /* Общие настройки */
        :root {
            --primary-color: #4a90e2;
            --dark-bg: #2c3e50;
            --light-bg: #f4f7f6;
            --text-color: #333;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Навигация */
        header {
            background-color: var(--dark-bg);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        nav a:hover {
            background-color: var(--primary-color);
        }

        /* Основной контент */
        main {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 400px;
        }

        /* Стили для форм (вход/регистрация) */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 0 auto;
        }

        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            opacity: 0.9;
        }

        /* Адаптивность */
        @media (max-width: 600px) {
            nav {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            main {
                margin: 10px;
            }
        }
    </style>

</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Начальная страница</a>
        <a href="<?= app()->route->getUrl('/') ?>">Каталог</a>
        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>

        <?php else: ?>
            <!-- Добавили ссылку на личный кабинет -->
            <a href="<?= app()->route->getUrl('/my-reservations') ?>">Мои брони</a>

            <!-- Исправлено на Name (с большой буквы) -->
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход из аккаунта пользователя (<?= app()->auth::user()->Name ?>)</a>
        <?php endif; ?>
    </nav>
    <!-- После навигации, перед </header> -->
    <div style="padding: 20px; background: #f5f5f5; text-align: center;">
        <form method="GET" action="<?= app()->route->getUrl('/') ?>">
            <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>"
                   placeholder="Поиск книг по названию..."
                   style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="padding: 10px 20px; background: #007cba; color: white; border: none; border-radius: 5px; cursor: pointer;">
                🔍 Найти
            </button>
        </form>
    </div>
</header>
<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>