<?php
// 天氣查詢功能
function getWeatherData($city) {
    $apiKey = "CWA-38BCA7D9-D96E-4130-BC3F-2C186295725B";
    $apiUrl = "https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=$apiKey&locationName=$city";

    // 使用 cURL 發送 API 請求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return "API請求錯誤：" . curl_error($ch);
    }
    curl_close($ch);

    // 將回應解碼為 JSON 格式
    $data = json_decode($response, true);
    if (isset($data['records']['location'][0])) {
        $location = $data['records']['location'][0];
        $weatherDesc = $location['weatherElement'][0]['time'][0]['parameter']['parameterName'];
        $minTemp = $location['weatherElement'][2]['time'][0]['parameter']['parameterName'];
        $maxTemp = $location['weatherElement'][4]['time'][0]['parameter']['parameterName'];
        $comfort = $location['weatherElement'][3]['time'][0]['parameter']['parameterName'];

        return [
            'locationName' => $location['locationName'],
            'weatherDesc' => $weatherDesc,
            'minTemp' => $minTemp,
            'maxTemp' => $maxTemp,
            'comfort' => $comfort
        ];
    } else {
        return "查詢失敗，請稍後再試！";
    }
}

$city = isset($_POST['citySelect']) ? $_POST['citySelect'] : "臺北市";
$weatherData = getWeatherData($city);
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>台灣天氣查詢</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        h2 {
            color: #00796b;
            font-size: 1.5em;
            transition: transform 0.5s ease;
        }

        select,
        button {
            padding: 10px;
            margin: 10px;
            font-size: 16px;
            border: 1px solid #00796b;
            border-radius: 5px;
        }

        button {
            background-color: #00796b;
            color: white;
            cursor: pointer;
            transition: background 0.5s;
        }

        button:hover {
            background-color: #004d40;
        }

        #weatherResult {
            margin-top: 20px;
            font-size: 18px;
            background: #b2dfdb;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>台灣天氣查詢</h2>
        <form method="POST" action="">
            <select name="citySelect" id="citySelect">
                <option value="臺北市" <?php if ($city == "臺北市") echo "selected"; ?>>臺北市</option>
                <option value="新北市" <?php if ($city == "新北市") echo "selected"; ?>>新北市</option>
                <option value="桃園市" <?php if ($city == "桃園市") echo "selected"; ?>>桃園市</option>
                <option value="臺中市" <?php if ($city == "臺中市") echo "selected"; ?>>臺中市</option>
                <option value="臺南市" <?php if ($city == "臺南市") echo "selected"; ?>>臺南市</option>
                <option value="高雄市" <?php if ($city == "高雄市") echo "selected"; ?>>高雄市</option>
            </select>
            <button type="submit">查詢</button>
        </form>

        <div id="weatherResult">
            <?php
            if (is_array($weatherData)) {
                echo "<h3>{$weatherData['locationName']} 天氣</h3>";
                echo "<p>天氣概況：{$weatherData['weatherDesc']}</p>";
                echo "<p>氣溫範圍：{$weatherData['minTemp']}°C ~ {$weatherData['maxTemp']}°C</p>";
                echo "<p>舒適度：{$weatherData['comfort']}</p>";
            } else {
                echo "<p>{$weatherData}</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>
