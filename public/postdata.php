<?php
include "config.php";

// get the incoming POST data
$post = file_get_contents('php://input') ?? $_POST;

// decode the JSON data
$post = json_decode($post, true);

$json = json_encode($post);

$param;

if (isset($_GET['param'])) {
    $param = $_GET['param'];
}

if($param == "saveTeam"){
    $teamName = $post["name"];
    $teamID = $post["_id"];
    $sayi = $post["wCount"];
    $yevmiye = $post["tYevmiye"];
    $agac = $post["agacSayi"];
    $q = "INSERT INTO `ekipler`(`ekip_ID`, `ekip`, `calisan_sayisi`, `toplam_yevmiye`, `toplam_kesilen_agac`) VALUES ('$teamID','$teamName','$sayi','$yevmiye','$agac')";
    $res = mysqli_query($con, $q);
}
if($param == "saveWorker"){
    foreach ($post as $item) {
        $_id = $item["_teamID"];
        $ad = $item["ad"];
        $soyad = $item["soyad"];
        $yevmiye = $item["yevmiye"];
        $gun = $item["gun"];
        $q = "INSERT INTO `calisanlar`(`ekip_ID`, `ad`, `soyad`, `yevmiye`, `gun`) VALUES ('$_id','$ad','$soyad','$yevmiye','$gun')";
        $res = mysqli_query($con, $q);
    }    
}


exit;
 