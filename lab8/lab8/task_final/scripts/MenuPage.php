<?php
require_once '../template.class.php';

$template = new Template();
$template->setMainTemplate('../templates/MenuPage.tpl');

$template->setPlaceholderDirect("{HEAD}", file_get_contents('../templates/head_menu.tpl'));
$template->setPlaceholderDirect("{HEADER}", file_get_contents('../templates/header.tpl'));
$template->setPlaceholderDirect("{FOOTER}", file_get_contents('../templates/footer.tpl'));

$labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
    "menu"=>"Menu", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
    "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
    "appetisers"=>"Appetisers", "starters"=>"Starters", "salads"=>"Salads", "main_dishes"=>"Main Dishes",
    "statistics"=>"Statistics"];
$template->setLabels($labelsArray);

$db_host = "localhost";
$db_name = "lab8";
$db_user = "root";
$db_pass = "Oboev54";
$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$query = "SELECT * FROM menu_appetisers";
$result = mysqli_query($db, $query);
load_from_db($result, $template, '{APPETISERS}');

$query = "SELECT * FROM menu_starters";
$result = mysqli_query($db, $query);
load_from_db($result, $template, '{STARTERS}');

$query = "SELECT * FROM menu_salads";
$result = mysqli_query($db, $query);
load_from_db($result, $template, '{SALADS}');

$query = "SELECT * FROM menu_main_dishes";
$result = mysqli_query($db, $query);
load_from_db($result, $template, '{MAIN_DISHES}');

$template->processTemplate();

echo $template->getFinalPage();

function load_from_db($result, $template, $tag): void
{
    $menu = "";
    while (is_array($row = mysqli_fetch_row($result))){
        $menu .= file_get_contents('../templates/menu_item.tpl');
        $menu = str_replace("{NAME}", $row[0], $menu);
        $menu = str_replace("{PRICE}", '$' . floatval($row[1] / 100), $menu);
        $menu = str_replace("{RESIPE}", $row[2], $menu);
    }
    $template->setPlaceholderDirect($tag, $menu);
}