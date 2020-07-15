<?php
// $host = "127.0.0.1";
// $user = "root";
// $pass = "";
// $dbname = "iste_library";

$host = "us-cdbr-east-02.cleardb.com";
$user = "bfa4921c800495";
$pass = "49ed7390";
$dbname = "heroku_6983fb8671c8294";

$con = mysqli_connect($host, $user, $pass, $dbname);

if (!$con)
    die("Connection failed: " . mysqli_connect_error());
else
    echo mysqli_info($con);
