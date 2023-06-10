<!--в произвольном тексте последовательности из двух и более пробельных символов
заменить на один пробел, каждое предложение оформить в виде отдельного абзаца, все аббревиа-
туры (например ОАО, АСУ и т.п.) подчеркнуть, все числа вывести синим цветом. Текст полу-
чать из файла-->

<?php

$text = file_get_contents("src.txt");
echo $text . "<br>";

// Useless space removing
$text = mb_ereg_replace("[[:space:]]+", " ", $text);

// Underlining
$text = mb_ereg_replace('[\p{Lu}]{2,}', '<u>\\0</u>', $text);

// Painting digits
$text = mb_ereg_replace('[\d+]', '<span style="color: blue;">\\0</span>', $text);

// Dividing
$text = mb_ereg_replace("([^\.\?!]+[\.\?!])", "<p>\\0</p>", $text);
echo '<br>' . $text;

file_put_contents("dst.txt", $text);