<?php
/**
 * Завдання 3: Конструктор
 *
 * Варіант 30: Конструктор задає початкові значення name, instrument, yearsPlaying
 */
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Product.php';

// Створюємо 3 об'єкти через конструктор
$musician1 = new Musician('Олексій Лисенко', 'Гітара', 10);
$musician2 = new Musician('Марина Даниленко', 'Фортепіано', 7);
$musician3 = new Musician('Артем Руденко', 'Скрипка', 14);

$musicians = [
    ['obj' => $musician1, 'avatar' => 'avatar-indigo', 'initial' => 'О', 'var' => '$musician1'],
    ['obj' => $musician2, 'avatar' => 'avatar-green', 'initial' => 'М', 'var' => '$musician2'],
    ['obj' => $musician3, 'avatar' => 'avatar-amber', 'initial' => 'А', 'var' => '$musician3'],
];

ob_start();
?>

<div class="task-header">
    <h1>Конструктор</h1>
    <p>Початкові значення задаються одразу при створенні об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Конструктор класу Musician</span>
<span class="code-keyword">public function</span> <span class="code-method">__construct</span>(<span class="code-class">string</span> <span class="code-variable">$name</span>, <span class="code-class">string</span> <span class="code-variable">$instrument</span>, <span class="code-class">int</span> <span class="code-variable">$yearsPlaying</span>)
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-variable">$name</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">instrument</span> = <span class="code-variable">$instrument</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">yearsPlaying</span> = <span class="code-variable">$yearsPlaying</ span>;
}

<span class="code-comment">// Створення через конструктор</span>
<span class="code-variable">$musician1</span> = <span class="code-keyword">new</span> <span class="code-class">Musician</span>(<span class="code-string">'Олексій Лисенко'</span>, <span class="code-string">'Гітара'</span>, <span class="code-string">10</span>);
<span class="code-variable">$musician2</span> = <span class="code-keyword">new</span> <span class="code-class">Musician</span>(<span class="code-string">'Марина Даниленко'</span>, <span class="code-string">'Фортепіано'</span>, <span class="code-string">7</span>);
<span class="code-variable">$musician3</span> = <span class="code-keyword">new</span> <span class="code-class">Musician</span>(<span class="code-string">'Артем Руденко'</span>, <span class="code-string">'Скрипка'</span>, <span class="code-string">14</span>);</div>

<div class="section-divider">
    <span class="section-divider-text">Об'єкти створені через конструктор</span>
</div>

<div class="users-grid">
    <?php foreach ($musicians as $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label"><?= $data['var'] ?> <span class="user-card-badge badge-constructor">constructor</span></div>
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
                <span class="user-card-field-value"><?= $data['obj']->yearsPlaying ?> р.</span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="section-divider">
    <span class="section-divider-text">getInfo() для кожного</span>
</div>

<div class="info-output">
    <div class="info-output-header">Виклик getInfo() для об'єктів, створених через конструктор</div>
    <div class="info-output-body">
        <?php foreach ($musicians as $data): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $data['var'] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($data['obj']->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 3', 'task3-body');
