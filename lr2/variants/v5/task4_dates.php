<?php
/**
 * Завдання 4: Різниця дат
 *
 * Варіант 5: 01-01-2024 та 01-01-2026 → 731 днів (104 тижнів і 3 днів)
 */
require_once __DIR__ . '/layout.php';

function dateDifference(string $date1, string $date2): int|false
{
    $d1 = DateTime::createFromFormat('d-m-Y', $date1);
    $d2 = DateTime::createFromFormat('d-m-Y', $date2);

    if (!$d1 || !$d2) {
        return false;
    }

    $interval = $d1->diff($d2);
    return $interval->days;
}

function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('d-m-Y', $date);
    return $d && $d->format('d-m-Y') === $date;
}

// Вхідні дані (варіант 5)
$date1 = $_POST['date1'] ?? '01-01-2024';
$date2 = $_POST['date2'] ?? '01-01-2026';
$submitted = isset($_POST['date1']);

$error = '';
$days = null;

if ($submitted) {
    if (!isValidDate($date1)) {
        $error = "Перша дата має невірний формат. Використовуйте ДД-ММ-РРРР";
    } elseif (!isValidDate($date2)) {
        $error = "Друга дата має невірний формат. Використовуйте ДД-ММ-РРРР";
    } else {
        $days = dateDifference($date1, $date2);
    }
}

ob_start();
?>
<div class="demo-card">
    <h2>Різниця дат</h2>
    <p class="demo-subtitle">Кількість днів між двома датами (ДД-ММ-РРРР)</p>

    <form method="post" class="demo-form">
        <div class="form-row">
            <div>
                <label for="date1">Перша дата</label>
                <input type="text" id="date1" name="date1" value="<?= htmlspecialchars($date1) ?>" placeholder="ДД-ММ-РРРР">
            </div>
            <div>
                <label for="date2">Друга дата</label>
                <input type="text" id="date2" name="date2" value="<?= htmlspecialchars($date2) ?>" placeholder="ДД-ММ-РРРР">
            </div>
        </div>
        <button type="submit" class="btn-submit">Обчислити</button>
    </form>

    <?php if ($error): ?>
    <div class="demo-result demo-result-error">
        <h3>Помилка</h3>
        <div class="demo-result-value"><?= htmlspecialchars($error) ?></div>
    </div>
    <?php elseif ($days !== null): ?>
    <div class="demo-result">
        <h3>Різниця</h3>
        <div class="demo-result-value"><?= $days ?> днів (<?= intdiv($days, 7) ?> тижнів і <?= $days % 7 ?> днів)</div>
    </div>

    <div class="demo-section">
        <h3>Деталі</h3>
        <table class="demo-table">
            <tr>
                <td class="demo-table-label">Дата 1</td>
                <td><span class="demo-tag demo-tag-primary"><?= htmlspecialchars($date1) ?></span></td>
            </tr>
            <tr>
                <td class="demo-table-label">Дата 2</td>
                <td><span class="demo-tag demo-tag-primary"><?= htmlspecialchars($date2) ?></span></td>
            </tr>
            <tr>
                <td class="demo-table-label">Різниця</td>
                <td><span class="demo-tag demo-tag-success"><?= $days ?> днів</span></td>
            </tr>
        </table>
    </div>

    <div class="demo-code">dateDifference("<?= htmlspecialchars($date1) ?>", "<?= htmlspecialchars($date2) ?>")
// Результат: <?= $days ?> днів (<?= intdiv($days, 7) ?> тижнів і <?= $days % 7 ?> днів)</div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4');
