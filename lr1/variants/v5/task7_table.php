<?php
/**
 * Завдання 6.1: Таблиця: 7 x 5 комірок різного кольору
 */
require_once __DIR__ . '/layout.php';
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
$content = '
    <h1>🎨 Кольорова таблиця ' . $rows . 'x' . $cols . '</h1>
    <div class="params">generateMultiColorTable(' . $rows . ', ' . $cols . ')</div>
    ' . $table;
renderVariantLayout($content, 'Завдання 6.1', 'task7-table-body');
