<!--Введите через поле ввода строку состоящую из слов разделенных запятой (например,-->
<!--'Один, два, три, четыре, пять.'). Первое слово начинается с большой буквы, в конце точка.-->
<!--Расставьте слова в обратном порядке. Выведите строку. Только первое слово новой строки долж--->
<!--но начинаться с большой буквы, в конце предложения точка-->

<?php
const NAME = 'text';
if (isset($_GET[NAME])) {
    // Get input string and remove leading/trailing whitespace
    $string = rtrim($_GET[NAME], ".");
    $string = mb_strtolower(mb_substr($string, 0, 1)) . mb_substr($string, 1);

    // Split the string into an array of words
    $words = mb_split(",", $string);
    for ($i = 0; $i < count($words); $i++) {
        $words[$i] = trim($words[$i]);
    }

    // Reverse the array of words
    $words = array_reverse($words);
    // Join the reversed words into a new string, with first letter capitalized and the rest lowercase
    $new_string = implode(", ", $words);

    $new_string .= ".";

    $new_string = mb_strtoupper(mb_substr($new_string, 0, 1)) . mb_substr($new_string, 1);

    // Output the final string
    echo $new_string;
}
