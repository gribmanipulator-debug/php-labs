<?php
$regData = $regData ?? [];
?>

<div class="success-page">
    <div class="alert alert--success">
        <h2>Розрахунок перевірено успішно!</h2>
        <p>
            <strong><?= htmlspecialchars($regData['number1'] ?? '') ?></strong>
            <?= htmlspecialchars($regData['operationLabel'] ?? '') ?>
            <strong><?= htmlspecialchars($regData['number2'] ?? '') ?></strong>
            = <strong><?= htmlspecialchars($regData['actualResult'] ?? '') ?></strong>
        </p>
        <p>Ваш введений результат <strong><?= htmlspecialchars($regData['expectedResult'] ?? '') ?></strong> збігається з правильним.</p>
    </div>

    <div class="success-page__actions">
        <a href="index.php" class="btn">На головну</a>
        <a href="index.php?route=regform/form" class="btn btn--secondary">Ще один розрахунок</a>
    </div>
</div>
