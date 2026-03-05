<?php
/**
 * Завдання 6.2
 */
require_once __DIR__ . '/layout.php';
require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';

function generateRedSquares(int $rows, int $cols): string
{
    $squareSize = 80;
    $gap = 20;
    
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
$content = $squares . '
    <div class="circles-func">generateRedSquares(' . $n . ')</div>
    <div class="circles-counter">🔺 Квадратів: ' . $n . '</div>
    <p class="circles-info">Оновіть сторінку для нової композиції 🔄</p>';

renderVariantLayout($content, 'Завдання 6.2', 'task7-squares-body');
