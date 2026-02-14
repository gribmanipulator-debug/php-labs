<?php
/**
 * Завдання 1: Форматований текст
 *
 * Вірш про художника з форматуванням: <b>, <i>, margin-left
 */
require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="poem">
    <?php
    echo "<p style='margin-left: 20px;'>У саду цвітуть <b>вишні</b> білі,</p>";
    echo "<p style='margin-left: 20px;'>Бджоли гудуть <i>весело</i> навколо,</p>";
    echo "<p style='margin-left: 20px;'>Пелюстки падають несміливі,</p>";
    echo "<p style='margin-left: 20px;'>Весна прийшла у наше село.</p>";
    ?>
</div>
<?php
$content = ob_get_clean();

renderVariantLayout($content, 'Завдання 1', 'task2-body');
