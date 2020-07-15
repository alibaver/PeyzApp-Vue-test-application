<?php
include "config.php";

$choose;
$param;
$param2;

if (isset($_GET['choose'])) {
    $choose = $_GET['choose'];
}
isset($_GET['param']) ? $param = $_GET['param'] : $param = "";
isset($_GET['param2']) ? $param2 = $_GET['param2'] : $param2 = "";

if ($choose == "menu") {
    $query = "select jsonContent from menus where MenuName = '$param'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "notice") {
    $query = "select * from notice ORDER BY notice.noticeDate DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "trial_database") {
    $query = "select * from trial_databases ORDER BY trial_databases.date DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "monthly_award") {
    $query = "select * from monthly_award where date >= '$param' and date < '$param2'";
    $userData = mysqli_query($con, $query);
}


$response = array();
while ($row = mysqli_fetch_assoc($userData)) {
    $response[] = $row;
}
echo json_encode($response);
exit;
