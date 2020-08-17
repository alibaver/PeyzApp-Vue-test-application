<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "iste_library";

// $host = "zy4wtsaw3sjejnud.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
// $user = "yt175solm61xhx2e";
// $pass = "wryysgbmub9ro2sx";
// $dbname = "l0v09yzxdjr8ms7s";
// 3306

$con = mysqli_connect($host, $user, $pass, $dbname);

if (!$con)
    die("Connection failed: " . mysqli_connect_error());
else
    echo mysqli_info($con);
