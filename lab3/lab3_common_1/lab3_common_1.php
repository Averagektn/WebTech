<!--Устранение дубликатов из произвольного многомерного массива (например,
если в таком массиве пять раз встречается число 100, оно должно
остаться в массиве в одном экземпляре).-->
<?php
function to_one_dimensional($arr): array {
    $result = array();
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, to_one_dimensional($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}

function out(array $arr): void {
    foreach ($arr as $elem) {
        if (is_array($elem)) {
            out($elem);
        } else {
            echo $elem . "\n";
        }
    }
}

$array = array(
    array(1, 2, 3),
    array(1, 2, 4),
    array(1, 5, 3, array(6,7,4, array(1)))
);

$array = to_one_dimensional($array);
$array = array_unique($array);
out($array);