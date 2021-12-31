<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $countryCode = 'in';
    if (isset($_POST['lat']) && isset($_POST['lng'])) {
        $locateUrl = "https://nominatim.openstreetmap.org/reverse?lat={$_POST['lat']}&lon={$_POST['lng']}&format=json";
        $locateResult = json_decode(cUrl($locateUrl), true);
        $countryCode = $locateResult['address']['country_code'];
        $IpCountry = $locateResult['address']['country'];
        $IpCity = $locateResult['address']['city'];
        $Ipzip = $locateResult['address']['postcode'];
    }
    if (isset($_POST['zip'])) {
        $zipCode = $_POST['zip'];
        $zipResult = json_decode(cUrl("http://www.postalpincode.in/api/pincode/{$zipCode}"), true);
        if ($zipResult['Status'] === 'Success') {
            $zipCity = $zipResult['PostOffice'][0]['District'];
            $zipState = $zipResult['PostOffice'][0]['State'];
            $zipCountry = $zipResult['PostOffice'][0]['Country'];
        }
    } else {
        $zipCode = $Ipzip;
    }
    $apiKey = 'd550a6722093b58246518e9c92eb0678';
    $baseUrl = "https://api.openweathermap.org/data/2.5/weather?zip={$zipCode},{$countryCode}&appid={$apiKey}&units=metric";
    $result = cURl($baseUrl);
    $result = json_decode($result, true);
    $temp = floor($result['main']['temp']);
    $temp_max = floor($result['main']['temp_max']);
    $temp_min = floor($result['main']['temp_min']);
    $pressure = $result['main']['pressure'];
    $humidity = $result['main']['humidity'];
    $clouds = $result['clouds']['all'];
    $sunrise = $result['sys']['sunrise'];
    $sunset = $result['sys']['sunset'];
    if (isset($IpCountry)) {
        $country = $IpCountry;
    } else {
        $country = $zipCountry;
    }
    if (isset($IpCity)) {
        $city_name = $IpCity;
    } else {
        $city_name = $zipCity;
    }
    $wind = $result['wind']['speed'];
    $day = date('l');
    $date = date('d F Y');
    $forecast_link = "https://api.openweathermap.org/data/2.5/forecast?zip={$zipCode},{$countryCode}&appid={$apiKey}&units=metric";
    $resultf = cURl($forecast_link);
    $resultf = json_decode($resultf, true);
    $nextDay = [];
    for ($i = 0; $i <= 3; $i++) {
        array_push($nextDay, floor(($resultf['list'][$i]['main']['temp'])));
    }
    $finalJson = ['country_code' => $countryCode, 'country' => $country, 'city' => $city_name, 'temp' => $temp, 'nextDay' => $nextDay, 'pressure' => $pressure, 'humidity' => $humidity, 'clouds' => $clouds, 'wind' => $wind, 'day' => $day, 'date' => $date];
    echo json_encode($finalJson);
} else {
    echo 'We Only Accept Post Request.';
}
function cUrl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
