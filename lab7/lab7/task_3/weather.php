<?php
function getWeatherForecast($url): bool|string|null
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($curl);

    if ($response === false) {
        echo "Ошибка при выполнении запроса: " . curl_error($curl);
        return null;
    }

    curl_close($curl);

    return $response;
}

function extractTemperatures($responses): array
{
    $temperatures = [];

    foreach ($responses as $response) {
        $data = json_decode($response, true);

        // Извлечение температуры из каждого ответа
        if (isset($data['main']['temp'])) {
            $temperature = $data['main']['temp'];
            $temperatures[] = $temperature;
        } elseif (isset($data['current']['temp_c'])) {
            $temperature = $data['current']['temp_c'];
            $temperatures[] = $temperature;
        } elseif (isset($data['data']['values']['temperature'])) {
            $temperature = $data['data']['values']['temperature'];
            $temperatures[] = $temperature;
        } elseif (isset($data['days'][0]['temp'])) {
            $temperature = $data['days'][0]['temp'];
            $temperatures[] = $temperature;
        } elseif (isset($data['data'][0]['temp'])) {
            $temperature = $data['data'][0]['temp'];
            $temperatures[] = $temperature;
        }
    }

    return $temperatures;
}

$city = $_POST['city'];

$weatherSites = [
    "api.openweathermap.org/data/2.5/weather?q=$city&units=metric&APPID=62cdad65e66524c345e788238415c6cc",
    "http://api.weatherapi.com/v1/current.json?key=d9fbdaf2021742c7a53155214232305&q=$city&aqi=no",
    "https://api.tomorrow.io/v4/weather/realtime?accept=application/json&location=$city&apikey=GmAMIO8lLMkm7DrMtRtl6kVpGzTkAEOV",
    "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/$city?unitGroup=metric&key=NJGC7MSW52PKKTJ7EDECCAETH&contentType=json",
    "https://api.weatherbit.io/v2.0/current?city=$city&key=d91eb4c27d694cddbd7397a0dd9ddeaa&include=minutely"
];

$temperatureSum = 0;
$count = 0;
$responses = [];
$temperatures = [];

foreach ($weatherSites as $siteUrl) {
    $responses[] = getWeatherForecast($siteUrl);
}

$temperatures = extractTemperatures($responses);

foreach ($temperatures as $temperature){
    $temperatureSum += $temperature;
}

if (count($temperatures) > 0) {
    $averageTemperature = $temperatureSum / count($temperatures);
    echo "<p>Weather for $city: $averageTemperature °C</p>";
} else {
    echo "<p>Error in city name $city or API error</p>";
}