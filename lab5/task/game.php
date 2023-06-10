<?php
// Подключение к базе данных
$host = 'localhost'; // хост базы данных
$user = 'root'; // имя пользователя базы данных
$password = 'Oboev54'; // пароль базы данных
$database = 'lab5'; // имя базы данных
$table = 'cities'; // имя таблицы
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
//mysqli_set_charset($link, "utf8mb4");

// Функция для получения случайного города, начинающегося на заданную букву
function getRandomCityStartingWith($letter, $link, $table)
{
    $letter = strtoupper($letter);
    $letter = mysqli_real_escape_string($link, $letter); // экранирование спецсимволов
    $query = "SELECT name FROM {$table} WHERE name LIKE '{$letter}%' AND used = 0 ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($link, $query) or die("Error " . mysqli_error($link));
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $city = $row['name'];
        $query = "UPDATE {$table} SET used = 1 WHERE name = '{$city}'";
        mysqli_query($link, $query) or die("Error " . mysqli_error($link));
        return $city;
    } else {
        return null;
    }
}

// Игрок начинает игру
echo "Enter the name of the city:\n";

// Игра начинается
$previousCity = null;
$is_playing = true;
while ($is_playing) {
// Человек называет город
    $city = trim(fgets(STDIN));
    if ($city == "0"){
        break;
    }
    if ($previousCity !== null && strtolower(substr($city, 0, 1)) !== substr($previousCity, -1)) {
        echo "Incorrect city name\n";
        continue;
    }

    $query = "SELECT used FROM {$table} WHERE name = '{$city}'";
    $result = mysqli_query($link, $query) or die("Error " . mysqli_error($link));

    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO {$table} (name, used) VALUES ('{$city}', 1)";
        mysqli_query($link, $query) or die("Error " . mysqli_error($link));
    } else {
        $used = mysqli_fetch_assoc($result)['used'];
        if ($used == 1) {
            echo "This city was already mentioned\n";
            continue;
        }
    }

    $query = "UPDATE {$table} SET used = 1 WHERE name = '{$city}'";
    mysqli_query($link, $query) or die("Error " . mysqli_error($link));

// Компьютер называет город
    $letter = substr($city, -1);
    $random = rand(1, 1000);
    if ($random <= 974) {
        $randomCity = getRandomCityStartingWith($letter, $link, $table);
        if ($randomCity === null) {
            echo "Computer could not find city name which starts with '{$letter}', you won!";
            $is_playing = false;
        } else {
            $previousCity = $randomCity;
            $query = "UPDATE {$table} SET used = 1 WHERE name = '{$randomCity}'";
            mysqli_query($link, $query) or die("Error " . mysqli_error($link));
            echo "{$randomCity}\n";
        }
    } else {
        echo "Computer could not find city name which starts with '{$letter}', you won!";
        $is_playing = false;
    }
}
$query = "UPDATE {$table} SET used = 0";
mysqli_query($link, $query) or die("Error " . mysqli_error($link));
mysqli_close($link);
