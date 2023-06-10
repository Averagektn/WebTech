<?php
require_once '../template.class.php';

$template = new Template();
$template->setMainTemplate('../templates/index.tpl');

$template->setPlaceholderDirect("{HEAD}", file_get_contents('../templates/head_index.tpl'));
$template->setPlaceholderDirect("{HEADER}", file_get_contents('../templates/header.tpl'));
$template->setPlaceholderDirect("{FOOTER}", file_get_contents('../templates/footer.tpl'));

$labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
    "menu"=>"Menu", "title"=>"Welcome", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
    "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
    "statistics"=>"Statistics"];
$template->setLabels($labelsArray);

$template->processTemplate();

echo $template->getFinalPage();

