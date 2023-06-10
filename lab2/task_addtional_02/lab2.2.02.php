<!--2.	Генерацию HTML-таблицы с указанным количеством строк (передаётся как параметр командной строки),
цвет фона которых меняется от белого к чёрному (количество «шагов» такого изменения фона должно быть равно
количеству строк таблицы).-->

<?php
const WHITE = 0xFF;

// Initializing number of rows
$rows = 1;
if (isset($argc) && isset($argv) && $argc > 1) {
    if (filter_var($argv[1], FILTER_VALIDATE_INT)) {
        $rows = $argv[1];
    }
}

// Initializing step and starting colors
$step = (int)(WHITE / $rows);
$bgColorR = WHITE;
$bgColorG = WHITE;
$bgColorB = WHITE;

echo '<table width=100%>';

for ($i = 0; $i < $rows; $i++) {

    // Changing color on every single iteration
    $bgColorR -= $step;
    $bgColorG -= $step;
    $bgColorB -= $step;

    // Set new color
    $bgColorHex = sprintf("#%02x%02x%02x", $bgColorR, $bgColorG, $bgColorB);
    echo "<tr style='background-color: $bgColorHex'>";

    echo '<td>' . '</td>';

    echo '</tr>';
}

echo '</table>';



