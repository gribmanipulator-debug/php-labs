<div class="page-home">
    <h1>Автосалон</h1>
    <p class="page-home__subtitle">Ласкаво просимо до автосалону! Тут доступні каталог авто, тест-драйв і кредитні програми.</p>

    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Каталог автомобілів</h3>
            <p class="card__text">
                Переглядайте популярні моделі, порівнюйте комплектації
                та орієнтовну вартість нових авто.
            </p>
            <a href="index.php?route=index/catalog" class="btn btn--small">Відкрити каталог</a>
        </div>

        <div class="card">
            <h3 class="card__title">Калькулятор вартості</h3>
            <p class="card__text">
                Виконайте обчислення для ціни, знижки або платежу
                і перевірте правильність результату.
            </p>
            <a href="index.php?route=regform/form" class="btn btn--small">Відкрити калькулятор</a>
        </div>

        <div class="card">
            <h3 class="card__title">Параметри запиту</h3>
            <p class="card__text">
                Технічна сторінка для перегляду GET та POST параметрів запиту.
            </p>
            <a href="index.php?route=reqview/showrequest" class="btn btn--small">Перейти</a>
        </div>

        <div class="card">
            <h3 class="card__title">Тест-драйв і кредит</h3>
            <p class="card__text">
                Налаштуйте колір сайту, збережіть персональне привітання
                і продовжуйте роботу у власному режимі.
            </p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштувати</a>
        </div>
    </div>

    <div class="info-block">
        <h2>Структура MVC</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Клас</th>
                    <th>Призначення</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><code>Application</code></td><td>Завантаження додатку, виклик контролера</td></tr>
                <tr><td><code>Router</code></td><td>Розбір URL &rarr; контролер + дія</td></tr>
                <tr><td><code>Request</code></td><td>Обгортка для <code>$_GET</code> / <code>$_POST</code></td></tr>
                <tr><td><code>Controller</code></td><td>Базовий клас контролера</td></tr>
                <tr><td><code>PageController</code></td><td>Контролер для сторінок</td></tr>
                <tr><td><code>View</code></td><td>Базовий клас для відображення</td></tr>
                <tr><td><code>PageView</code></td><td>Шаблон сторінки з layout</td></tr>
            </tbody>
        </table>
    </div>
</div>
