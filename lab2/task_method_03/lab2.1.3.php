<!--в произвольном тексте, введенном через форму, каждое третье слово перевести в-->
<!--верхний регистр, каждую третью букву всех слов сделать фиолетовой, подсчитать общее количе--->
<!--ство встречающихся в тексте букв "о" и "О"-->

<?php

const NAME = 'text';

if(isset($_GET[NAME])) {
    $text = $_GET[NAME];

    // Split text into words array
    $words = mb_split(" ", $text);

    // Count number of "о" and "О"
    $o_count = mb_substr_count($text, 'o') + mb_substr_count($text, 'O') +
               mb_substr_count($text, 'О') + mb_substr_count($text, 'о');

    // Change every 3 word
    for($i = 0; $i < count($words); $i++) {
        if(($i+1) % 3 == 0) {
            // Conversion to uppercase
            $words[$i] = mb_strtoupper($words[$i]);
        }

        // Changing color into purple
        $len = mb_strlen($words[$i]);
        $new_word = "";

        for($j = 0; $j < $len; $j++) {
            if(($j+1) % 3 == 0) {
                $new_word .= "<span style='color:purple'>".mb_substr($words[$i], $j, 1)."</span>";
            } else {
                $new_word .= mb_substr($words[$i], $j, 1);
            }
        }
        $words[$i] = $new_word;
    }

    // Creating result string from words array
    $result = implode(" ", $words);

    // Output
    echo "Result: " . $result . "<br>";
    echo "Number of 'о' and 'О' letters in text: ".$o_count;
}