<?php
include "config.php";

$choose;
$param;

if (isset($_GET['choose'])) {
    $choose = $_GET['choose'];
}
isset($_GET['param']) ? $param = $_GET['param'] : $param = "";

// isset($_GET['param']) ? $param = $_GET['param'] : $param = "";
// isset($_GET['param2']) ? $param2 = $_GET['param2'] : $param2 = "";

if ($choose == "teams") {
    $query = "select * from ekipler";
    $userData = mysqli_query($con, $query);
}
if ($choose == "teamDetails") {
    $query = "select * from ekipler where ekip_ID = '$param'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "workerDetails") {
    $query = "select * from calisanlar where ekip_ID = '$param'";
    $userData = mysqli_query($con, $query);
}
// if ($choose == "trial_database") {
//     $query = "select * from trial_databases ORDER BY trial_databases.date DESC";
//     $userData = mysqli_query($con, $query);
// }
// if ($choose == "monthly_award") {
//     $query = "select * from monthly_award where date >= '$param' and date < '$param2'";
//     $userData = mysqli_query($con, $query);
// }




$response = array();
while ($row = mysqli_fetch_assoc($userData)) {
    $response[] = $row;
}
echo json_encode($response);
exit;
