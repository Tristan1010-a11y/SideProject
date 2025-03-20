<?php
// 設定資料庫連線資訊
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "city_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 執行 SQL 查詢
$sql = "SELECT id, name, country, population FROM cities";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>City</th><th>Country</th><th>Population</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["country"] . "</td><td>" . $row["population"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
