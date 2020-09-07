<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "peyzApp";

$con = mysqli_connect($host, $user, $pass, $dbname, 3306);

if (!$con)
    die("Connection failed: " . mysqli_connect_error());
else
    echo mysqli_info($con);
