<!--Необходимо вывести дату ближайшей доставки в формате: "12 апреля-->
<!--2020". Желаемую дату доставки вводить через форму в формате "11.04.2020" (DD.MM.YYYY).-->
<!--Алгоритм следующий: если сегодня времени меньше, чем 12-00, то доставка завтра, если более-->
<!--12-00, то послезавтра! Если день доставки попадает на праздничный или выходной день, то до--->
<!--ставка переносится на следующий день после праздника. Праздники и выходные хранятся в тек--->
<!--стовом файле "holidays.txt" в формате: "месяц-день"-->
<?php
const SUNDAY = 7;
const DATE = 'delivery_date';
const MONTHS = array("Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");

$date = $_GET[DATE];
$delivery_date = date_create_from_format('d.m.Y', $date);

if (is_bool($delivery_date)){
    echo "ERROR";
} else {
    $current_date = new DateTime();
    if ($current_date->format('H') < 12) {
        $delivery_date->modify('+1 day');
    } else {
        $delivery_date->modify('+2 day');
    }
    $holidays = file('holidays.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($holidays as $holiday) {
        if ($delivery_date->format('m-d') == $holiday || $delivery_date->format('N') == SUNDAY) {
            $delivery_date->modify('+1 day');
        }
    }
    echo $delivery_date->format('d ') . MONTHS[(int)$delivery_date->format('m') - 1] . $delivery_date->format(' Y');
}