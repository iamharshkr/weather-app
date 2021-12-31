<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Weather</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap');

        :root {
            --gradient: linear-gradient(135deg, #72EDF2 10%, #5151E5 100%);
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            line-height: 1.25em;
        }

        .clear {
            clear: both;
        }

        body {
            margin: 0;
            width: 100%;
            height: 100vh;
            font-family: 'Montserrat', sans-serif;
            background-color: #343d4b;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .container {
            border-radius: 25px;
            -webkit-box-shadow: 0 0 70px -10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 70px -10px rgba(0, 0, 0, 0.2);
            background-color: #222831;
            color: #ffffff;
            height: 400px;
        }

        .weather-side {
            position: relative;
            height: 100%;
            border-radius: 25px;
            width: 300px;
            -webkit-box-shadow: 0 0 20px -10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 20px -10px rgba(0, 0, 0, 0.2);
            -webkit-transition: -webkit-transform 300ms ease;
            transition: -webkit-transform 300ms ease;
            -o-transition: transform 300ms ease;
            transition: transform 300ms ease;
            transition: transform 300ms ease, -webkit-transform 300ms ease;
            -webkit-transform: translateZ(0) scale(1.02) perspective(1000px);
            transform: translateZ(0) scale(1.02) perspective(1000px);
            float: left;
        }

        .weather-side:hover {
            -webkit-transform: scale(1.1) perspective(1500px) rotateY(10deg);
            transform: scale(1.1) perspective(1500px) rotateY(10deg);
        }

        .weather-gradient {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: var(--gradient);
            border-radius: 25px;
            opacity: 0.8;
        }

        .date-container {
            position: absolute;
            top: 25px;
            left: 25px;
        }

        .date-dayname {
            margin: 0;
        }

        .date-day {
            display: block;
        }

        .location {
            display: inline-block;
            margin-top: 10px;
        }

        .location-icon {
            display: inline-block;
            height: 0.8em;
            width: auto;
            margin-right: 5px;
        }

        .weather-container {
            position: absolute;
            bottom: 25px;
            left: 25px;
        }

        .weather-icon.feather {
            height: 60px;
            width: auto;
        }

        .weather-temp {
            margin: 0;
            font-weight: 700;
            font-size: 4em;
        }

        .weather-desc {
            margin: 0;
        }

        .info-side {
            position: relative;
            float: left;
            height: 100%;
            padding-top: 25px;
        }

        .today-info {
            padding: 15px;
            margin: 0 25px 25px 25px;
            /* 	box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25); */
            border-radius: 10px;
        }

        .today-info>div:not(:last-child) {
            margin: 0 0 10px 0;
        }

        .today-info>div .title {
            float: left;
            font-weight: 700;
        }

        .today-info>div .value {
            float: right;
        }

        .week-list {
            list-style-type: none;
            padding: 0;
            margin: 10px 35px;
            -webkit-box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25);
            box-shadow: 0 0 50px -5px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            /* background: # */
        }

        .week-list>li {
            float: left;
            padding: 15px;
            cursor: pointer;
            -webkit-transition: 200ms ease;
            -o-transition: 200ms ease;
            transition: 200ms ease;
            border-radius: 10px;
        }

        .week-list>li:hover {
            -webkit-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1);
            background: #fff;
            color: #222831;
            -webkit-box-shadow: 0 0 40px -5px rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 40px -5px rgba(0, 0, 0, 0.2)
        }

        .week-list>li.active {
            background: #fff;
            color: #222831;
            border-radius: 10px;
        }

        .week-list>li .day-name {
            display: block;
            margin: 10px 0 0 0;
            text-align: center;
        }

        .week-list>li .day-icon {
            display: block;
            height: 30px;
            width: auto;
            margin: 0 auto;
        }

        .week-list>li .day-temp {
            display: block;
            text-align: center;
            margin: 10px 0 0 0;
            font-weight: 700;
        }

        .location-container {
            padding: 25px 35px;
        }

        .location-button {
            outline: none;
            width: 100%;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            border: none;
            border-radius: 25px;
            padding: 10px;
            font-family: 'Montserrat', sans-serif;
            background-image: var(--gradient);
            color: #ffffff;
            font-weight: 700;
            -webkit-box-shadow: 0 0 30px -5px rgba(0, 0, 0, 0.25);
            box-shadow: 0 0 30px -5px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            -webkit-transition: -webkit-transform 200ms ease;
            transition: -webkit-transform 200ms ease;
            -o-transition: transform 200ms ease;
            transition: transform 200ms ease;
            transition: transform 200ms ease, -webkit-transform 200ms ease;
        }

        .location-button:hover {
            -webkit-transform: scale(0.95);
            -ms-transform: scale(0.95);
            transform: scale(0.95);
        }

        .location-button .feather {
            height: 1em;
            width: auto;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <script>
        var imgbase = 'https://source.unsplash.com/300x400/?';
        var season;

        function changeLocation() {
            let pincode = prompt("Please enter your pincode");
            if (pincode === null) {
                return 0;
            } else {
                $('#changeButton').text('loading...').parent('button').prop('disabled', true);
                var saveData = $.ajax({
                    type: 'POST',
                    url: "weather.php",
                    data: {
                        zip: pincode
                    },
                    dataType: "text",
                    success: function(resultData) {
                        var json = JSON.parse(resultData);
                        var country_code = json.country_code;
                        var country = json.country;
                        var city = json.city;
                        var temp = json.temp;
                        var pressure = json.pressure;
                        var humidity = json.humidity;
                        var nextDay = json.nextDay;
                        var cloud = json.cloud;
                        var wind = json.wind;
                        var day = json.day;
                        var date = json.date;
                        $('#day').text(day);
                        $('#date').text(date);
                        $('#location').text(city + ', ' + country);
                        $('#temp').text(temp + '°C');
                        season = getHot(temp);
                        $('#seasontype').text(season);
                        var imglink = imgbase + season;
                        $(".weather-side").css("background-image", "url(" + imglink + ")");
                        $('#pressure').text(pressure);
                        $('#humidity').text(humidity + '%');
                        $('#wind').text(wind + ' km/hr');
                        for (let i = 0; i <= nextDay.length; i++) {
                            $('#nextDay' + i).text(nextDay[i] + '°C');
                        }
                        $('#changeButton').text('Change Location').parent('button').prop('disabled', false);
                    }
                });
            }
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var myKeyVals = {
                    lat: lat,
                    lng: lng
                };
                var saveData = $.ajax({
                    type: 'POST',
                    url: "weather.php",
                    data: myKeyVals,
                    dataType: "text",
                    success: function(resultData) {
                        var json = JSON.parse(resultData);
                        var country_code = json.country_code;
                        var country = json.country;
                        var city = json.city;
                        var temp = json.temp;
                        var pressure = json.pressure;
                        var humidity = json.humidity;
                        var nextDay = json.nextDay;
                        var cloud = json.cloud;
                        var wind = json.wind;
                        var day = json.day;
                        var date = json.date;
                        $('#day').text(day);
                        $('#date').text(date);
                        $('#location').text(city + ', ' + country);
                        $('#temp').text(temp + '°C');
                        season = getHot(temp);
                        $('#seasontype').text(season);
                        var imglink = imgbase + season;
                        $(".weather-side").css("background-image", "url(" + imglink + ")");
                        $('#pressure').text(pressure);
                        $('#humidity').text(humidity + '%');
                        $('#wind').text(wind + ' km/hr');
                        for (let i = 0; i <= nextDay.length; i++) {
                            $('#nextDay' + i).text(nextDay[i] + '°C');
                        }
                    }
                });
            });
        } else {
            changeLocation();
        }

        function getHot(temp) {
            var result;
            switch (true) {
                case temp > 28:
                    result = "Sunny";
                    break;

                case temp > 15:
                    result = "Cloudy";
                    break;

                default:
                    result = "Cold";
            }
            return result;
        }
    </script>
    <div class="container">
        <div class="weather-side">
            <div class="weather-gradient"></div>
            <div class="date-container">
                <h2 class="date-dayname" id="day"><?php echo $day = date('l'); ?></h2><span id="date" class="date-day"><?php echo  $date = date('d F Y'); ?></span><i class="location-icon" data-feather="map-pin"></i><span id="location" class="location">Loading...</span>
            </div>
            <div class="weather-container"><i class="weather-icon" data-feather="sun"></i>
                <h1 id="temp" class="weather-temp">...</h1>
                <h3 id="seasontype" class="weather-desc"></h3>
            </div>
        </div>
        <div class="info-side">
            <div class="today-info-container">
                <div class="today-info">
                    <div class="precipitation"><span class="title">PRESSURE</span><span id="pressure" class="value">...</span>
                        <div class="clear"></div>
                    </div>
                    <div class="humidity"><span class="title">HUMIDITY</span><span id="humidity" class="value">...</span>
                        <div class="clear"></div>
                    </div>
                    <div class="wind"><span class="title">WIND</span><span id="wind" class="value">...</span>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="week-container">
                <ul class="week-list">
                    <?php
                    for ($x = 0; $x <= 3; $x++) {
                    ?>
                        <li class="<?php if ($x == 0) {
                                        echo 'active';
                                    } ?>"><i class="day-icon" data-feather="sun"></i><span class="day-name"><?php echo date('D', strtotime(date('d F Y') . $x . ' day')) ?></span><span id="nextDay<?php echo $x; ?>" class="day-temp">...</span></li>
                    <?php
                    }
                    ?>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="location-container"><button class="location-button" onclick="changeLocation()"><i data-feather="map-pin"></i><span id="changeButton">Change
                        location</span></button></div>
        </div>
    </div>
</body>

</html>