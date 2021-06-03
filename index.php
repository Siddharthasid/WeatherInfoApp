<?php

    $city="";
    $msg = "";
    $result = "";
    $status = "";

    if(isset($_POST["search"])){
        $city = $_POST["city"];
        $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=faf9d778970d216acfed437c3ffabdc3";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if($result["cod"] == 200){
            $status = "yes";
        }else{
            $msg = $result['message'];
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeatherInfoApp</title>
    <!--Bootstrap CDN link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!--My stylesheet link-->
    <link rel="stylesheet" href="mystyle.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--@This WeatherInfoApp is developed and designed by Siddhartha Sarkar.-->
</head>
<body>
    <div class="searchbox">
        <form method="POST">
            <input type="text" class="city" name="city" placeholder="Enter your city" value="<?php echo $city; ?>"/>
            <input type="submit" value="Search" class="submit" name="search"/>
            <?php echo "<h1 style='color:white; text-transform: uppercase;'><b>$msg<b></h1>"; ?>
        </form>
    </div>
    <?php if($status == 'yes'){ ?>
    <div class="weather_box">
        <div class="weather_icon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon']; ?>.png" alt="Weather icon">
        </div>

        <div class="weather_info">
            <div class="temparature">
                <span><?php echo round($result['main']['temp']-273.15)."°C"; ?></span>
                <span class="minmax">Min: <?php echo round($result['main']['temp_min']-273.15)."°C"; ?> | Max: <?php echo round($result['main']['temp_max']-273.15)."°C"; ?></span>
            </div>
            <div class="description">
                <div class="weather_condition"><?php echo $result['weather'][0]['main']; ?></div>
                <div class="place"><?php echo $result['name']; ?></div>
            </div>
            <div class="description1">
                <div class="weather_condition">Wind</div>
                <div class="place"><?php echo $result['wind']['speed']." m/sec"; ?></div>
            </div>
        </div>
        <div class="date">
            <?php echo date('d M',$result['dt']); ?>
        </div>
    </div>
    <?php } ?>
</body>
</html>