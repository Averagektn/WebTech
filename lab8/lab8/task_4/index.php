<?php

function drawBarChart($values, $labels, $backgroundColor, $borderColor) {
    // Подсчет количества значений
    $numValues = count($values);

    // Создание холста для диаграммы
    $canvasWidth = count($labels) * 100; // Ширина холста
    $canvasHeight = max($values); // Высота холста
    $barWidth = $canvasWidth / $numValues; // Ширина столбца

    // Создание изображения
    $image = imagecreatetruecolor($canvasWidth, $canvasHeight);

    // Задание цвета фона
    $backgroundColorRGB = sscanf($backgroundColor, "#%2x%2x%2x");
    $bgColor = imagecolorallocate($image, $backgroundColorRGB[0], $backgroundColorRGB[1], $backgroundColorRGB[2]);
    imagefilledrectangle($image, 0, 0, $canvasWidth, $canvasHeight, $bgColor);

    // Задание цвета границ
    $borderColorRGB = sscanf($borderColor, "#%2x%2x%2x");
    $borderColor = imagecolorallocate($image, $borderColorRGB[0], $borderColorRGB[1], $borderColorRGB[2]);

    $fontSize = 12;
    $fontColor = imagecolorallocate($image, 0, 0, 0); // Черный цвет текста

    // Отрисовка столбцов диаграммы
    for ($i = 0; $i < $numValues; $i++) {
        $x1 = $i * $barWidth;
        $y1 = $canvasHeight - $values[$i];
        $x2 = ($i + 1) * $barWidth - 1;
        $y2 = $canvasHeight - 1;

        // Заполнение столбца
        $barColor = imagecolorallocate($image, 150, 200, 100);
        imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);

        // Отрисовка границы столбца
        imagerectangle($image, $x1, $y1, $x2, $y2, $borderColor);

        // Отображение метки столбца
        $label = $labels[$i] . " : $values[$i]";
        $labelWidth = imagefontwidth($fontSize) * strlen($label);
        $labelX = $x1 + 10;
        $labelY = $canvasHeight - 15;
        imagestring($image, 1, round($labelX), round($labelY), $label, $fontColor);
    }

    // Вывод изображения в строку в формате PNG
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();

    // Очистка памяти
    imagedestroy($image);

    // Возвращение данных изображения в формате PNG
    return $imageData;
}


// Путь к файлу JSON
$jsonFile = 'statistics.json';

// Загрузка данных из файла JSON
$jsonData = json_decode(file_get_contents($jsonFile), true);

// Преобразование данных в виде массива дат и чисел
$dates = array_keys($jsonData);
$values = array_values($jsonData);

// Получение текущей даты
$currentDate = date('Y-m-d');

// Проверка наличия текущей даты в массиве
if (!in_array($currentDate, $dates)) {
    // Добавление новой даты с начальным значением 0
    $dates[] = $currentDate;
    $values[] = 0;
}

// Увеличение значения для текущей даты на 1
$index = array_search($currentDate, $dates);
$values[$index]++;

// Обновление данных в виде ассоциативного массива
$jsonData = array_combine($dates, $values);

// Сохранение обновленных данных в файл JSON
file_put_contents($jsonFile, json_encode($jsonData));

// Генерация столбчатой диаграммы
$title = "Столбчатая диаграмма";
$imageData = drawBarChart($values, $dates, "#FFFFFF", "#000000");

// Кодирование данных изображения в base64
$imageBase64 = base64_encode($imageData);

// Вывод столбчатой диаграммы
echo '<h2>Daily visits</h2>';
echo '<img src="data:image/png;base64,' . $imageBase64 . '" alt="Диаграмма">';
