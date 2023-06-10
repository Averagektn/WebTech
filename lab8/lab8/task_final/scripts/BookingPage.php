<?php
require_once '../template.class.php';

session_start();
$template = new Template();
$template->setMainTemplate('../templates/BookingPage.tpl');

$template->setPlaceholderDirect("{HEAD}", file_get_contents('../templates/head_booking.tpl'));
$template->setPlaceholderDirect("{HEADER}", file_get_contents('../templates/header.tpl'));
$template->setPlaceholderDirect("{FOOTER}", file_get_contents('../templates/footer.tpl'));

$labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
    "menu"=>"Menu", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
    "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
    "motto"=>"Just the right food",
    "review"=>"If you’ve been to one of our restaurants, you’ve seen – and<br>
                tasted – what keeps our customers coming back for more.<br>
                Perfect materials and freshly baked food.<br>

                Delicious Lambda cakes, muffins, and gourmet coffees make<br>
                us hard to resist! Stop in today and check us out! Perfect<br>
                materials and freshly baked food.<br>",
    "book"=>"Book now!", "statistics"=>"Statistics"];
$template->setLabels($labelsArray);

$name = "";
$email = "";
if (isset($_SESSION['email'])){
    $db_host = "localhost";
    $db_name = "lab8";
    $db_user = "root";
    $db_pass = "Oboev54";
    $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    $email = $_SESSION['email'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_row($result);
        $name = $row[0];
    }
}
$template->setPlaceholderDirect("{NAME}", $name);
$template->setPlaceholderDirect("{EMAIL}", $email);


$template->processTemplate();

echo $template->getFinalPage();
