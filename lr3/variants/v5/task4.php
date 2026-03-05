<?php
/**
 * Завдання 4: Клонування об'єктів
 *
 * Метод __clone() — при копіюванні задає значення за замовчанням: name = "Музикант", instrument = "", yearsPlaying = 0
 */
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Product.php';

// Оригінальний об'єкт (через конструктор)
$product3 = new Musician('Артем Руденко', 'Скрипка', 14);

// Клонуємо — __clone() задає значення за замовчанням
$product4 = clone $product3;

ob_start();
?>

<div class="task-header">
    <h1>Клонування</h1>
    <p>Метод <code>__clone()</code> задає значення за замовчанням при копіюванні об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Метод __clone() — викликається автоматично при clone</span>
<span class="code-keyword">public function</span> <span class="code-method">__clone</span>(): <span class="code-class">void</span>
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Новий товар'</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">instrument</span> = <span class="code-string">''</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">yearsPlaying</span> = 0;
}

<span class="code-comment">// Створюємо 4-й об'єкт через clone</span>
<span class="code-variable">$product4</span> = <span class="code-keyword">clone</span> <span class="code-variable">$product3</span>;</div>

<div class="section-divider">
    <span class="section-divider-text">Оригінал vs Клон</span>
</div>

<div class="comparison-wrapper">
    <div class="users-grid">
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-amber">А</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($product3->name) ?></div>
                    <div class="user-card-label">$product3 <span class="user-card-badge badge-constructor">original</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($product3->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">instrument</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($product3->instrument) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">yearsPlaying</span>
                    <span class="user-card-field-value"><?= $product3->yearsPlaying ?> р.</span>
                </div>
            </div>
        </div>

        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-rose">Н</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($product4->name) ?></div>
                    <div class="user-card-label">$product4 <span class="user-card-badge badge-clone">clone</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($product4->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">instrument</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($product4->instrument) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">yearsPlaying</span>
                    <span class="user-card-field-value"><?= $product4->yearsPlaying ?> р.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">getInfo() порівняння</span>
</div>

<div class="info-output">
    <div class="info-output-header">Результат getInfo() для оригіналу та клону</div>
    <div class="info-output-body">
        <div class="info-output-row">
            <span class="info-output-label">$product3</span>
            <span class="info-output-text"><?= htmlspecialchars($product3->getInfo()) ?></span>
        </div>
        <div class="info-output-row">
            <span class="info-output-label">$product4</span>
            <span class="info-output-text"><?= htmlspecialchars($product4->getInfo()) ?></span>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4', 'task4-body');
