<?php
// $host = "127.0.0.1";
// $user = "root";
// $pass = "";
// $dbname = "iste_library";

$host = "us-cdbr-east-02.cleardb.com";
$user = "b8bf893063c886";
$pass = "6a99d6b0";
$dbname = "heroku_6983fb8671c8295";

$con = mysqli_connect($host, $user, $pass, $dbname);

!$con ? die("Connection failed: " . mysqli_connect_error()) : "";
