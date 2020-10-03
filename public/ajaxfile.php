<?php
include "config.php";

$choose;
$param;
$param2;
$param3;

if (isset($_GET['choose'])) {
    $choose = $_GET['choose'];
}
isset($_GET['param']) ? $param = $_GET['param'] : $param = "";
isset($_GET['param2']) ? $param2 = $_GET['param2'] : $param2 = "";
isset($_GET['param3']) ? $param3 = $_GET['param3'] : $param3 = "";

if ($choose == "teams") {
    $query = "SELECT * FROM `tb_ekip` ORDER BY id DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "trees") {
    $query = "SELECT * FROM `tb_agac`";
    $userData = mysqli_query($con, $query);
}
if ($choose == "teamDetails") {
    $query = "SELECT * FROM `tb_ekip` WHERE ekip_ID = '$param'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "workerDetails") {
    $query = "SELECT * FROM tb_calisan WHERE ekip_ID = '$param' ORDER BY id DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "allWorkers") {
    $query = "SELECT * FROM tb_calisan";
    $userData = mysqli_query($con, $query);
}
if ($choose == "allBackups") {
    $query = "SELECT * FROM tb_workerBackup WHERE `calculated` = '0'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "pruningDetails") {
    $query = "SELECT * FROM `tb_budama` WHERE ekip_ID = '$param'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getCalendars") {
    $query = "SELECT * FROM `tb_calendar`";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getBackups") {
    $query = "SELECT * FROM `tb_workerBackup` WHERE `ekip_ID` = '$param' AND `calculated` = '0'";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getAllBackups") {
    $query = "SELECT * FROM `tb_workerBackup`";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getFilteredBackups") {
    $query = "SELECT * FROM `tb_workerBackup`  WHERE `ayrilis_tarihi` >= '$param' and `ayrilis_tarihi` <= '$param2' ORDER BY `ayrilis_tarihi` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getExpense") {
    $query = "SELECT * FROM `tb_gider` WHERE `ekip_ID` = '$param' AND `calculated` = '0' ORDER BY `tarih` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getAllExpense") {
    $query = "SELECT * FROM `tb_gider` WHERE `calculated` = '0' AND `calculated` = '0' ORDER BY `tarih` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getFilteredExpense") {
    $query = "SELECT * FROM `tb_gider` WHERE `tarih` >= '$param' and `tarih` <= '$param2' AND `calculated` = '0' ORDER BY `tarih` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getPruning") {
    $query = "SELECT * FROM `tb_budama` WHERE `ekip_ID` = '$param' AND `calculated` = '0' ORDER BY `budama_tarihi` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getAllPruning") {
    $query = "SELECT * FROM `tb_budama` WHERE `calculated` = '0' ORDER BY `budama_tarihi` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getFilteredPruning") {
    $query = "SELECT * FROM `tb_budama` WHERE `budama_tarihi` >= '$param' AND `budama_tarihi` <= '$param2'AND `calculated` = '0' ORDER BY `budama_tarihi` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getPayment") {
    $query = "SELECT * FROM `tb_hakedis` WHERE `ekip_ID` = '$param' ORDER BY `tarih` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getAllPayment") {
    $query = "SELECT * FROM `tb_hakedis` ORDER BY `tarih` DESC";
    $userData = mysqli_query($con, $query);
}
if ($choose == "getFilteredPayment") {
    $query = "SELECT * FROM `tb_hakedis` WHERE `tarih` >= '$param' AND `tarih` <= '$param2' ORDER BY `tarih` DESC";
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
