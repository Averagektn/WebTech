<!--Сортировку по алфавиту строк в текстовом файле
(имя файла передаётся как параметр командной строки)-->
<?php
// Получаем имя файла из параметров командной строки
if (isset($argv[1])) {
    $filename = $argv[1];
} else {
    die("Не указано имя файла\n");
}

// Читаем содержимое файла в массив строк
$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Сортируем массив строк по алфавиту с помощью mbstring
usort($lines, function($a, $b) {
    return mb_strtolower($a) <=> mb_strtolower($b);
});

// Выводим отсортированные строки на экран
foreach ($lines as $line) {
    echo $line . "\n";
}

// Записываем отсортированный массив обратно в файл
file_put_contents($filename, implode("\n", $lines));

echo "Файл отсортирован\n";

