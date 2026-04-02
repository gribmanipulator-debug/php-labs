<div class="page-home">
    <h1>Автосалон</h1>
    <p class="page-home__subtitle">Варіант 5 &mdash; Лабораторна робота №5</p>
    <p class="text-muted">Демонстраційний сайт автосалону: файлова гостьова книга, галерея фото авто, CRUD каталогу машин через PDO та авторизація користувачів.</p>

    <h2>Файли</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Гостьова книга</h3>
            <p class="card__text">Залишайте відгуки про сервіс автосалону. Коментарі зберігаються у текстовому файлі.</p>
            <a href="index.php?route=guestbook/index" class="btn btn--small">Відгуки</a>
        </div>

        <div class="card">
            <h3 class="card__title">Фото авто</h3>
            <p class="card__text">Завантажуйте зображення автомобілів. Галерея доступна одразу на сторінці.</p>
            <a href="index.php?route=upload/index" class="btn btn--small">Галерея</a>
        </div>

        <div class="card">
            <h3 class="card__title">Каталоги клієнтів</h3>
            <p class="card__text">Персональні папки користувачів з підпапками video, music, photo.</p>
            <a href="index.php?route=folder/create" class="btn btn--small">Каталоги</a>
        </div>
    </div>

    <h2>База даних</h2>
    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Каталог автомобілів (CRUD)</h3>
            <p class="card__text">Список авто з брендом, моделлю, роком, ціною та типом двигуна. PDO + SQLite.</p>
            <a href="index.php?route=catalog/list" class="btn btn--small">До каталогу</a>
        </div>

        <div class="card">
            <h3 class="card__title">Акаунт користувача</h3>
            <p class="card__text">Реєстрація, вхід, профіль, редагування та видалення акаунту. Хешування паролів.</p>
            <a href="index.php?route=auth/login" class="btn btn--small">Увійти</a>
        </div>

        <div class="card">
            <h3 class="card__title">Налаштування</h3>
            <p class="card__text">Колір фону (сесія) та привітання (cookie). Успадковано з ЛР4.</p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштування</a>
        </div>
    </div>
</div>
