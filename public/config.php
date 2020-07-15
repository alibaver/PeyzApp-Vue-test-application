<?php
// $host = "127.0.0.1";
// $user = "root";
// $pass = "";
// $dbname = "iste_library";

$host = "kf3k4aywsrp0d2is.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$user = "axgpobkipsdb9d8f";
$pass = "skdh5e9tmw5i5tq6";
$dbname = "kgy3usjhd28sm4gh";

$con = mysqli_connect($host, $user, $pass, $dbname);

!$con ? die("Connection failed: " . mysqli_connect_error()) : "";
