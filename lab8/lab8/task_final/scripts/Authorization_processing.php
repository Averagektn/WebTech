<?php
require_once '../template.class.php';
session_start();

$db_host = "localhost";
$db_name = "NAME";
$db_user = "USER";
$db_pass = "PASSWORD";
$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);

$_SESSION['email'] = $email;

$query = "SELECT * FROM users WHERE password = '$password' AND email = '$email'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) == 1) {
    $jsonFile = 'statistics.json';
    $jsonData = json_decode(file_get_contents($jsonFile), true);

    $dates = array_keys($jsonData);
    $values = array_values($jsonData);

    $currentDate = date('Y-m-d');

    if (!in_array($currentDate, $dates)) {
        $dates[] = $currentDate;
        $values[] = 0;
    }

    $index = array_search($currentDate, $dates);
    $values[$index]++;

    $jsonData = array_combine($dates, $values);

    file_put_contents($jsonFile, json_encode($jsonData));

    header("Location: ../scripts/Home.php");
    exit();
} else {
    $head_error = file_get_contents('../templates/head_alert.tpl');
    $error = file_get_contents('../templates/alert.tpl');
    $error_message = "Incorrect password or email";

    $template = new Template();
    $template->setMainTemplate('../templates/alert.tpl');
    $labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
        "menu"=>"Menu", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
        "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
        "appetisers"=>"Appetisers", "starters"=>"Starters", "salads"=>"Salads", "main_dishes"=>"Main Dishes",
        "statistics"=>"Statistics"];
    $template->setLabels($labelsArray);

    $template->setPlaceholderDirect("{HEADER}", '');
    $template->setPlaceholderDirect("{FOOTER}", '');
    $template->setPlaceholderDirect("{MESSAGE}", $error_message);

    $template->processTemplate();

    echo $head_error . $template->getFinalPage();
}
