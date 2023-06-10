<!--5.	Чтение из командной строки произвольного количества слов (каждое слово – отдельный параметр командной строки)
и определение самого длинного слова (или самых длинных слов, если таких окажется больше одного).-->

<?php

// Initialize variables
$longest_words = array();
$max_length = 0;

// Check if script is run in command line mode and if there are arguments
if (isset($argc) && isset($argv)){

    // Check if there is more than one argument
    if ($argc > 1){

        // Iterate over all arguments and find the longest word(s)
        for ($i = 1; $i < $argc && is_string($argv[$i]); $i++) {
            $length = mb_strlen($argv[$i]);

            // If the current word is longer than the previously found the longest word, reset the array and add the new word
            if ($length > $max_length) {
                $max_length = $length;
                $longest_words = array($argv[$i]);
            }
            // If the current word is of the same length as the previously found the longest word, add it to the array
            elseif ($length == $max_length) {
                $longest_words[] = $argv[$i];
            }
        }

        // Print out the longest word(s)
        if (count($longest_words) > 0){
            echo "Longest word(s): ";
            for ($i = 0; $i < count($longest_words); $i++){
                echo $longest_words[$i] . " ";
            }
        }
        // If no words were found, print out an error message
        else{
            echo "No words entered";
        }

    }
    // If no arguments were provided, print out an error message
    else{
        echo "No words entered";
    }
}