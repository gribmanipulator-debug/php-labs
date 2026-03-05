<?php
/**
 * Завдання 1: Створення класів та об'єктів
 *
 * Варіант 5: Клас Musician із властивостями: name (string), instrument (string), yearsPlaying (int)
 */
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Product.php';

// Створюємо 3 об'єкти з довільними значеннями
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

$products = [
    ['obj' => $product1, 'avatar' => 'avatar-indigo', 'initial' => 'Н'],
    ['obj' => $product2, 'avatar' => 'avatar-green', 'initial' => 'К'],
    ['obj' => $product3, 'avatar' => 'avatar-amber', 'initial' => 'Р'],
];

ob_start();
?>

<div class="task-header">
    <h1>Створення об'єктів</h1>
    <p>Клас <code>Musician</code> з властивостями: name, instrument, yearsPlaying</p>
</div>

<div class="code-block"><span class="code-comment">// Створюємо об'єкт та задаємо властивості</span>
<span class="code-variable">$product1</span> = <span class="code-keyword">new</span> <span class="code-class">Musician</span>();
<span class="code-variable">$product1</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Олексій Лисенко'</span>;
<span class="code-variable">$product1</span><span class="code-arrow">-></span><span class="code-method">instrument</span> = <span class="code-string">'Гітара'</span>;
<span class="code-variable">$product1</span><span class="code-arrow">-></span><span class="code-method">yearsPlaying</span> = <span class="code-number">10</span>;</div>

<div class="section-divider">
    <span class="section-divider-text">3 об'єкти</span>
</div>

<div class="users-grid">
    <?php foreach ($products as $i => $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label">Об'єкт #<?= $i + 1 ?></div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">instrument</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->instrument) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">yearsPlaying</span>
                <span class="user-card-field-value"><?= $data['obj']->yearsPlaying ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 1', 'task1-body');
