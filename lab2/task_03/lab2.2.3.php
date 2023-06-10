<!--3.	Отображение многомерного (не менее пяти уровней) массива в браузере таким образом, что чтобы элементы
первого уровня отображались красным цветом, второго – синим, третьего – зелёным, четвёртого – фиолетовым, пятого
и далее – жёлтым.-->

<?php
function printArray($array, $level = 0): void {
    // Finding out, which dimension in current
    $color = match ($level) {
        0 => 'red',
        1 => 'blue',
        2 => 'green',
        3 => 'purple',
        default => 'yellow',
    };

    // Setting color
    echo "<div style='color: $color;'>";

    // Printing text with new color
    foreach ($array as $key => $value) {
        // Case of array
        if (is_array($value)) {
            printArray($value, $level+1);
        // Case of value
        } else {
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level) . $value . "<br>";
        }
    }
    echo "</div>";
}

$array = array(
    "1_level_1", "1_level_2",
    array(
        "2_level_1",
        array(
            "3_level_1",
            array(
                "4_level_1",
                array("5_level_1", "5_level_2"),
                array(
                    array("6_level_1")
                )
            ),
            array(
                array("5_level_3", "5_level_4", "5_level_5"),
            )
        ),
        "2_level_2",
    ),
    "1_level_3",
);

printArray($array);