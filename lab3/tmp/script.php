<?php
$date = "12.03.2023";
echo "Привет, " . $date;
$curr_date = date_create_from_format('d.m.Y', $date);
if (is_bool($curr_date)){
    echo "ERROR";
}
else{
    $curr_date->modify('+1 day');
}
var_dump($curr_date);
echo $curr_date->format('d.m.Y');