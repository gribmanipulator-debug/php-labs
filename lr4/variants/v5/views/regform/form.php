<?php
$errors = $errors ?? [];
$old = $old ?? [];
$operations = $operations ?? [
    'sum' => 'Додавання',
    'sub' => 'Віднімання',
    'mul' => 'Множення',
    'div' => 'Ділення',
];
$selectedOperation = is_string($old['operation'] ?? '') ? $old['operation'] : 'sum';
?>

<h1>Калькулятор вартості автомобіля</h1>
<p>Виконайте розрахунок для автосалону й введіть очікуваний результат, щоб перевірити правильність.</p>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Помилки у формі:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=regform/form" class="form">
    <div class="form__group">
        <label for="number1" class="form__label">Число 1</label>
        <input type="text" id="number1" name="number1"
               class="form__input<?= isset($errors['number1']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['number1'] ?? '') ?>"
               placeholder="Наприклад: 500000">
        <?php if (isset($errors['number1'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['number1']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="number2" class="form__label">Число 2</label>
        <input type="text" id="number2" name="number2"
               class="form__input<?= isset($errors['number2']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['number2'] ?? '') ?>"
               placeholder="Наприклад: 10000">
        <?php if (isset($errors['number2'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['number2']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="operation" class="form__label">Функція</label>
        <select id="operation" name="operation"
                class="form__select<?= isset($errors['operation']) ? ' form__input--error' : '' ?>">
            <?php foreach ($operations as $operationKey => $operationLabel): ?>
                <option value="<?= htmlspecialchars($operationKey) ?>"
                    <?= $selectedOperation === $operationKey ? 'selected' : '' ?>>
                    <?= htmlspecialchars($operationLabel) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['operation'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['operation']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="expected_result" class="form__label">Результат</label>
        <input type="text" id="expected_result" name="expected_result"
               class="form__input<?= isset($errors['expected_result']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['expected_result'] ?? '') ?>"
               placeholder="Введіть ваш очікуваний результат">
        <?php if (isset($errors['expected_result'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['expected_result']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Перевірити результат</button>
        <button type="reset" class="btn btn--secondary">Очистити</button>
    </div>
</form>
