<!--На экран вывести ссылки меню с названиями (например "О компании", "Услуги", "Прайс",-->
<!--"Контакты"). При клике по ссылке меняется и остается измененным цвет фона вокруг активной-->
<!--ссылки. Весь код на одной странице. Не использовать javascript. Использовать GET-запросы.-->

<?php
// An array to store background color for each link
$back_color = ['about'=>'white', 'services'=>'white', 'price'=>'white', 'contacts'=>'white'];

// Check if a link is set in the URL parameter
if (isset($_GET['link'])){
    $curr = $_GET['link']; // Set the current link to the one in the URL parameter
}

// If the current link is set, change its background color to green
if (isset($curr)){
    $back_color[$curr] = 'green';
}

// Function to return a style attribute with the given color as the background color
function get_style($color): string {
    return 'style = "background-color: ' . $color . '";';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Меню</title>
</head>
<body>
<ul>
    <li><a href="?link=about" <?php echo get_style($back_color['about']); ?>>О компании</a></li>
    <li><a href="?link=services" <?php echo get_style($back_color['services']); ?>>Услуги</a></li>
    <li><a href="?link=price" <?php echo get_style($back_color['price']); ?>>Прайс</a></li>
    <li><a href="?link=contacts" <?php echo get_style($back_color['contacts']); ?>>Контакты</a></li>
</ul>
</body>
</html>
