<?php
// Подключение к базе данных
$host = 'localhost'; // хост базы данных
$user = 'root'; // имя пользователя базы данных
$password = 'Oboev54'; // пароль базы данных
$database = 'lab5'; // имя базы данных
$table = 'cities'; // имя таблицы
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

// Получение данных из GeoNames
$country = 'RU'; // код страны
$region = 'MOW'; // код региона
$maxRows = 1000; // максимальное количество строк в ответе
$username = 'Oboev54'; // имя пользователя на GeoNames
$url = "http://htmlweb.ru/json/geo/city_list?country=РОССИЯ&api_key=53286a491714a7bf5df35fe6691e5764&p=20";
$data = file_get_contents($url);
$data = json_decode($data, true);

foreach ($data['items'] as $item) {
    $name = mysqli_real_escape_string($link, $item['english']);
    $sql = "INSERT INTO {$table} (name, used) VALUES ('{$name}', 0)";
    if (mysqli_query($link, $sql)) {
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: " . mysqli_error($link);
    }
}

// Закрытие соединения с базой данных
mysqli_close($link);
