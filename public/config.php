<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "peyzApp";


// $host = "dz8959rne9lumkkw.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
// $user = "sky4002ntsblu6e3";
// $pass = "lambqpie5g9xry9l";
// $dbname = "sfluov3c4h0w2e95";

$con = mysqli_connect($host, $user, $pass, $dbname, 3306);

if (!$con)
    die("Connection failed: " . mysqli_connect_error());
else
    echo mysqli_info($con);
