<?php
/**
 * Завдання 6.1: Таблиця: 7 x 5 комірок різного кольору
 */

require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';

function generateMultiColorTable(int $rows, int $cols): string
{
     $html = "<table class='chessboard'>";
    
    for ($i = 0; $i < $rows; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $cols; $j++) {
            $diagonal = ($i + $j) / ($rows + $cols - 2);
            $hue = (int)($diagonal * 360);
            
            $color = "hsl({$hue}, 85%, 60%)";
            $html .= "<td style='background-color:{$color};'></td>";
        }
        $html .= "</tr>";
    }
    
    $html .= "</table>";
    return $html;
}
$rows = 7;
$cols = 5;
$table = generateMultiColorTable($rows, $cols);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 6.1 — Таблиця: 7 x 5 комірок різного кольору</title>
    <link rel="stylesheet" href="../../demo/demo.css">
</head>
<body class="task7-table-body body-with-header">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант 5</a>
            <a href="/lr1/demo/task7_table.php?from=v5" class="header-btn header-btn-demo">Demo</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">В-5 / Завд. 6.1</div>
    </header>

    <h1>🎨 Таблиця: 7 x 5 комірок різного кольору <?= $rows ?>x<?= $cols ?></h1>
    <div class="params">generateMultiColorTable(<?= $rows ?>, <?= $cols ?>)</div>

    <?= $table ?>

    <?= devReloadScript() ?>
</body>
</html>
