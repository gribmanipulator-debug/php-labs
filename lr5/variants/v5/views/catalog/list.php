<?php
$cars = $cars ?? [];
?>

<h1>Каталог автомобілів</h1>
<p>CRUD-модуль автосалону через PDO (prepared statements).</p>

<div class="form__actions form__actions--mb">
    <a href="index.php?route=catalog/create" class="btn">Додати автомобіль</a>
</div>

<?php if (empty($cars)): ?>
    <p class="text-muted">У каталозі ще немає записів.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Рік</th>
                <th>Ціна, грн</th>
                <th>Двигун</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= (int)$car['id'] ?></td>
                    <td><?= htmlspecialchars($car['brand']) ?></td>
                    <td><?= htmlspecialchars($car['model']) ?></td>
                    <td><?= (int)$car['year'] ?></td>
                    <td><?= number_format((float)$car['price'], 2, '.', ' ') ?></td>
                    <td><?= htmlspecialchars($car['engine_type']) ?></td>
                    <td class="table__actions">
                        <a href="index.php?route=catalog/edit&id=<?= (int)$car['id'] ?>" class="btn btn--small">Редагувати</a>
                        <form method="POST" action="index.php?route=catalog/delete" class="form--inline"
                              onsubmit="return confirm('Видалити авто з каталогу?')">
                            <input type="hidden" name="id" value="<?= (int)$car['id'] ?>">
                            <button type="submit" class="btn btn--small btn--danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
