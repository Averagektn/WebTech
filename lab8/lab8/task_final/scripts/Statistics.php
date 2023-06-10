<?php
require_once '../template.class.php';

function drawBarChart($values, $labels, $backgroundColor, $borderColor) {
    $numValues = count($values);

    $canvasWidth = count($labels) * 100;
    $canvasHeight = 300;
    $barWidth = $canvasWidth / $numValues;

    $image = imagecreatetruecolor($canvasWidth, $canvasHeight + 20);

    $backgroundColorRGB = sscanf($backgroundColor, "#%2x%2x%2x");
    $bgColor = imagecolorallocate($image, $backgroundColorRGB[0], $backgroundColorRGB[1], $backgroundColorRGB[2]);
    imagefilledrectangle($image, 0, 0, $canvasWidth, $canvasHeight + 20, $bgColor);

    $borderColorRGB = sscanf($borderColor, "#%2x%2x%2x");
    $borderColor = imagecolorallocate($image, $borderColorRGB[0], $borderColorRGB[1], $borderColorRGB[2]);

    $fontColor = imagecolorallocate($image, 0, 0, 0);

    $max = max($values);
    for ($i = 0; $i < $numValues; $i++) {
        $x1 = $i * $barWidth;
        $y1 = $canvasHeight - intdiv($canvasHeight * $values[$i], $max);
        $x2 = ($i + 1) * $barWidth - 1;
        $y2 = $canvasHeight - 1;

        $barColor = imagecolorallocate($image, 150, 200, 100);
        imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);

        imagerectangle($image, $x1, $y1, $x2, $y2, $borderColor);

        $label = $labels[$i] . " : $values[$i]";
        $labelX = $x1 + 10;
        $labelY = $canvasHeight + 5;
        imagestring($image, 2, round($labelX), round($labelY), $label, $fontColor);
    }

    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();

    imagedestroy($image);

    return $imageData;
}

$json = file_get_contents('statistics.json');
$data = json_decode($json, true);

$lastWeekDates = [];
$lastWeekValues = [];

$endDate = date('Y-m-d');
$startDate = date('Y-m-d', strtotime('-7 days', strtotime($endDate)));

$currentDate = $startDate;
while ($currentDate <= $endDate) {
    if (isset($data[$currentDate])) {
        $lastWeekDates[] = $currentDate;
        $lastWeekValues[] = $data[$currentDate];
    }

    $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate))); // Переходим к следующей дате
}

$imageData = drawBarChart($lastWeekValues, $lastWeekDates, "#FFFFFF", "#96CB64");

$imageBase64 = base64_encode($imageData);

$template = new Template();

$template->setMainTemplate('../templates/statistics.tpl');
$labelsArray = ["open_hours"=>"We are open at:", "cafe_name"=>"WTCafe", "home"=>"Home", "booking"=>"Booking",
    "menu"=>"Menu", "working_days"=>"Mon-Fri", "weekdays"=>"Sat-Sun", "working_days_time"=>"7am-11pm",
    "weekdays_time"=>"9am-9pm", "location"=>"Find us:", "address"=>"19th Paradise Street Sitia <br> 128 Meserole Avenu",
    "appetisers"=>"Appetisers", "starters"=>"Starters", "salads"=>"Salads", "main_dishes"=>"Main Dishes",
    "statistics"=>"Statistics"];
$template->setLabels($labelsArray);

$template->setPlaceholderDirect("{HEAD}", file_get_contents('../templates/head_alert.tpl'));
$template->setPlaceholderDirect("{HEADER}", file_get_contents('../templates/header.tpl'));
$template->setPlaceholderDirect("{FOOTER}", file_get_contents('../templates/footer.tpl'));

$replacement = '<h1 class="Text">Daily visits</h1>' . '<img src="data:image/png;base64,' . $imageBase64 . '" alt="Diagram">';
$template->setPlaceholderDirect('{STATISTICS}', $replacement);

$template->processTemplate();

echo $template->getFinalPage();
