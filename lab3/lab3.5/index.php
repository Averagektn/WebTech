<!--Обработку произвольного многомерного массива (допускается явная инициализация такого массива внутри программы)
таким образом, что все целые числа умножаются на два, все дроби округляются до сотых, все строки переводятся
в верхний регистр.-->

<?php
function process(array $arr): array
{
    foreach($arr as &$elem) {
        if (is_int($elem)) {
            $elem *= 2;
        } else if (is_float($elem)) {
            $elem = round($elem, 2);
        } else if (is_string($elem)) {
            $elem = mb_strtoupper($elem);
        } else if (is_array($elem)){
            $elem = process($elem);
        }
    }
    return $arr;
}

function out(array $arr): void
{
    foreach ($arr as $elem) {
        if (is_array($elem)){
            out($elem);
        } else{
            echo $elem . "\n";
        }
    }
}

$ELEMS = array(array(array(array("one", "two", "three"),333,555,777,999),1.234,2.145678,3.3333333),
    798,
    4449849
);

out($ELEMS);
echo "\nRESULT: \n";
$ELEMS = process($ELEMS);
out($ELEMS);