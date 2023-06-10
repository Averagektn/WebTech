<?php
require_once '../MyMail.php';
require_once '../template.class.php';

$db_host = "localhost";
$db_name = "lab8";
$db_user = "root";
$db_pass = "Oboev54";
$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$table_num = $_POST['table'];

$query = "SELECT * FROM orders WHERE date = '$date' AND table_num = '$table_num'";
$result = mysqli_query($db, $query);

echo file_get_contents('../templates/head_alert.tpl');
$alert = file_get_contents('../templates/alert.tpl');

$template = new Template();
$template->setMainTemplate('../templates/alert.tpl');
$labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
    "menu"=>"Menu", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
    "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
    "appetisers"=>"Appetisers", "starters"=>"Starters", "salads"=>"Salads", "main_dishes"=>"Main Dishes",
    "statistics"=>"Statistics"];
$template->setLabels($labelsArray);

$template->setPlaceholderDirect("{HEADER}", file_get_contents('../templates/header.tpl'));
$template->setPlaceholderDirect("{FOOTER}", file_get_contents('../templates/footer.tpl'));

if (mysqli_num_rows($result) == 0 && $date >= date('Y-m-d')) {
    if(Send("WTCafe", $email, "You have booked $table_num table for $date in WTCafe")){
        $query = "INSERT INTO orders (name, email, date, table_num) VALUES ('$name', '$email', '$date', '$table_num')";
        mysqli_query($db, $query);
        $message = "Your order was added";
    }
    else{
        $message = "Email error";
    }
    $template->setPlaceholderDirect('{MESSAGE}', $message);
    $template->processTemplate();
    echo $template->getFinalPage();
} else {

    $message = "Incorrect date or this table is unavailable";
    $template->setPlaceholderDirect('{MESSAGE}', $message);
    $template->processTemplate();
    echo $template->getFinalPage();
}
