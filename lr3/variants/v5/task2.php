<?php
/**
 * Завдання 2: Метод getInfo()
 *
 * Варіант 30: Метод getInfo() — повертає рядок: "Музикант: {name}, Інструмент: {instrument}, Стаж: {yearsPlaying} р."
 */
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Product.php';

// Створюємо 3 об'єкти
$product1 = new Musician();
$product1->name = 'Олексій Лисенко';
$product1->instrument = 'Гітара';
$product1->yearsPlaying = 10;

$product2 = new Musician();
$product2->name = 'Марина Даниленко';
$product2->instrument = 'Фортепіано';
$product2->yearsPlaying = 7;

$product3 = new Musician();
$product3->name = 'Артем Руденко';
$product3->instrument = 'Скрипка';
$product3->yearsPlaying = 14;

$products = [$product1, $product2, $product3];
$labels = ['$product1', '$product2', '$product3'];

ob_start();
?>

<div class="task-header">
    <h1>Метод getInfo()</h1>
    <p>Виводить значення властивостей об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Метод getInfo() повертає рядок з інформацією</span>
<span class="code-keyword">public function</span> <span class="code-method">getInfo</span>(): <span class="code-class">string</span>
{
    <span class="code-keyword">return</span> <span class="code-string">"Музикант: {$this->name}, Інструмент: {$this->instrument}, Років гри: {$this->yearsPlaying} р."</span>;
}

<span class="code-comment">// Виклик для кожного об'єкта</span>
<span class="code-variable">$product1</span><span class="code-arrow">-></span><span class="code-method">getInfo</span>();</div>

<div class="section-divider">
    <span class="section-divider-text">Результат виклику</span>
</div>

<div class="info-output">
    <div class="info-output-header">getInfo() — вивід для кожного об'єкта</div>
    <div class="info-output-body">
        <?php foreach ($products as $i => $product): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $labels[$i] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($product->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">Картки товарів</span>
</div>

<div class="users-grid">
    <?php
    $avatars = ['avatar-indigo', 'avatar-green', 'avatar-amber'];
    $initials = ['О', 'М', 'А'];
    foreach ($products as $i => $product):
    ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $avatars[$i] ?>"><?= $initials[$i] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($product->name) ?></div>
                <div class="user-card-label"><?= $labels[$i] ?>->getInfo()</div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($product->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">instrument</span>
                <span class="user-card-field-value"><?= htmlspecialchars($product->instrument) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">yearsPlaying</span>
                <span class="user-card-field-value"><?= $product->yearsPlaying ?> р.</span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 2', 'task2-body');
