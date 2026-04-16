<?php
$colors = $colors ?? [];
$currentColor = $currentColor ?? '#F8F8FF';
$error = $error ?? '';
?>

<h1>Колір фону (Сесії)</h1>

<p>Оберіть колір фону сторінки. Значення зберігається в <code>$_SESSION</code> та діє на всіх сторінках до закриття браузера.</p>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=settings/color" class="form">
    <div class="color-picker">
        <?php foreach ($colors as $hex => $label): ?>
            <label class="color-picker__item <?= $currentColor === $hex ? 'color-picker__item--active' : '' ?>">
                <input type="radio" name="bg_color" value="<?= htmlspecialchars($hex) ?>"
                    <?= $currentColor === $hex ? 'checked' : '' ?>>
                <span class="color-picker__swatch" style="background-color: <?= htmlspecialchars($hex) ?>"></span>
                <span class="color-picker__label"><?= htmlspecialchars($label) ?></span>
            </label>
        <?php endforeach; ?>
    </div>

</form>

<script>
(() => {
    const form = document.querySelector('.form');
    const items = Array.from(document.querySelectorAll('.color-picker__item'));
    const inputs = Array.from(document.querySelectorAll('input[name="bg_color"]'));

    if (!form || inputs.length === 0) {
        return;
    }

    const syncSelectedState = (selectedInput) => {
        items.forEach((item) => item.classList.remove('color-picker__item--active'));

        const activeItem = selectedInput.closest('.color-picker__item');
        if (activeItem) {
            activeItem.classList.add('color-picker__item--active');
        }

        document.body.style.backgroundColor = selectedInput.value;
    };

    inputs.forEach((input) => {
        input.addEventListener('change', () => {
            syncSelectedState(input);
            form.submit();
        });
    });
})();
</script>

<p class="text-muted text-muted--mt">Модуль успадковано з ЛР4. Також доступне <a href="index.php?route=settings/greeting">привітання через Cookie</a>.</p>
