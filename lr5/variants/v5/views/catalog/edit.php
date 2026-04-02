<?php
$car = $car ?? [];
$errors = $errors ?? [];
?>

<h1>Редагувати авто #<?= (int)($car['id'] ?? 0) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Виправте помилки:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=catalog/edit&id=<?= (int)($car['id'] ?? 0) ?>" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['brand']) ? 'form__group--error' : '' ?>">
            <label for="car_brand" class="form__label">Марка <span class="required">*</span></label>
            <input type="text" id="car_brand" name="brand" class="form__input"
                   value="<?= htmlspecialchars($car['brand'] ?? '') ?>">
        </div>

        <div class="form__group <?= isset($errors['model']) ? 'form__group--error' : '' ?>">
            <label for="car_model" class="form__label">Модель <span class="required">*</span></label>
            <input type="text" id="car_model" name="model" class="form__input"
                   value="<?= htmlspecialchars($car['model'] ?? '') ?>">
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['year']) ? 'form__group--error' : '' ?>">
            <label for="car_year" class="form__label">Рік випуску <span class="required">*</span></label>
            <input type="number" id="car_year" name="year" class="form__input" min="1950" max="<?= (int)date('Y') + 1 ?>"
                   value="<?= htmlspecialchars($car['year'] ?? '') ?>">
        </div>

        <div class="form__group <?= isset($errors['price']) ? 'form__group--error' : '' ?>">
            <label for="car_price" class="form__label">Ціна, грн <span class="required">*</span></label>
            <input type="number" id="car_price" name="price" class="form__input" min="1" step="0.01"
                   value="<?= htmlspecialchars($car['price'] ?? '') ?>">
        </div>
    </div>

    <div class="form__group <?= isset($errors['engine_type']) ? 'form__group--error' : '' ?>">
        <label for="car_engine_type" class="form__label">Тип двигуна <span class="required">*</span></label>
        <select id="car_engine_type" name="engine_type" class="form__select">
            <option value="">Оберіть тип</option>
            <?php foreach (['бензин', 'дизель', 'електро', 'гібрид'] as $engine): ?>
                <option value="<?= $engine ?>" <?= ($car['engine_type'] ?? '') === $engine ? 'selected' : '' ?>>
                    <?= ucfirst($engine) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти</button>
        <a href="index.php?route=catalog/list" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
