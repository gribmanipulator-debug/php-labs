<?php
/**
 * Завдання 6.2
 */

require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';

function generateRedSquares(int $rows, int $cols): string
{
    $squareSize = 80;
    $gap = 20;

    $totalWidth = ($squareSize * $cols) + ($gap * ($cols - 1));
    $totalHeight = ($squareSize * $rows) + ($gap * ($rows - 1));
    
    $html = "<div style='
        display: flex;
        flex-direction: column;
        gap: {$gap}px;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
        background: #000;
    '>";
    for ($i = 0; $i < $rows; $i++) {
        $html .= "<div style='display: flex; gap: {$gap}px;'>";
        for ($j = 0; $j < $cols; $j++) {
            $html .= "<div style='
                width: {$squareSize}px;
                height: {$squareSize}px;
                background: #ef4444;
                border: 2px solid #dc2626;
            '></div>";
        }
        
        $html .= "</div>";
    }
    
    $html .= "</div>";
    return $html;
}

$rows = 4;
$cols = 5;
$squares = generateRedSquares($rows, $cols);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 6.2 — 4 рядки × 5 червоних квадратів</title>
    <link rel="stylesheet" href="../../demo/demo.css">
    <style>
        body { margin: 0; padding: 0; overflow: hidden; }
    </style>
</head>
<body>
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант 5</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">В-5 / Завд. 6.2</div>
    </header>

    <?= $squares ?>

    <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); 
                color: white; background: rgba(0,0,0,0.7); padding: 10px 20px; 
                border-radius: 8px; font-family: monospace;">
        generateRedSquares(<?= $rows ?>, <?= $cols ?>)
        <br>Квадратів: <?= $rows * $cols ?>
    </div>

    <?= devReloadScript() ?>
</body>
</html>