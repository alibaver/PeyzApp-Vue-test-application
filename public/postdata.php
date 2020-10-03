<?php
include "config.php";

// get the incoming POST data
$post = file_get_contents('php://input') ?? $_POST;

// decode the JSON data
$post = json_decode($post, true);

$json = json_encode($post);

$param;
$param2;
$param3;

if (isset($_GET['param'])) {
    $param = $_GET['param'];
}
isset($_GET['param2']) ? $param2 = $_GET['param2'] : $param2 = "";
isset($_GET['param3']) ? $param3 = $_GET['param3'] : $param3 = "";

if($param == "saveTeam"){
    $teamName = $post["name"];
    $teamID = $post["_id"];
    $sayi = $post["wCount"];
    $yevmiye = $post["tYevmiye"];
    $agac = $post["agacSayi"];
    $q = "INSERT INTO `tb_ekip`(`ekip_ID`, `ekip_adi`, `calisan_sayisi`, `toplam_yevmiye`, `toplam_kesilen_agac`) VALUES ('$teamID','$teamName','$sayi','$yevmiye','$agac')";
    $res = mysqli_query($con, $q);
}
if($param == "saveWorker"){
    foreach ($post as $item) {
        $_id = $item["_teamID"];
        $ad = $item["ad"];
        $soyad = $item["soyad"];
        $yevmiye = $item["yevmiye"];
        $kTarihi = $item["ktarihi"];
        $tGun = $item["tam_gun"];
        $yGun = $item["yarim_gun"];
        $q = "INSERT INTO `tb_calisan`(`ekip_ID`, `ad`, `soyad`, `yevmiye`, `kayit_tarihi`,`tam_gun`, `yarim_gun`, `guncelleme_tarihi`) VALUES ('$_id','$ad','$soyad','$yevmiye','$kTarihi','$tGun','$yGun',0000-00-00)";
        $res = mysqli_query($con, $q);
    }    
}
if ($param == "updatedTotalPrice") {
    $_id = $post["id"];
    $total = $post["total"];
    $q= "UPDATE `tb_ekip` SET `toplam_yevmiye`='$total' WHERE `ekip_ID`= '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "updatedWorkers") {
    $_id = $post[0]["_id"];
    $date = $post[0]["uDate"];
    $ygun = $post[0]["yGun"];
    $tgun = $post[0]["tGun"];
    $q= "UPDATE `tb_calisan` SET `tam_gun`='$tgun',`yarim_gun`='$ygun',`guncelleme_tarihi`='$date' WHERE `id`= '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "setCalendar") {
    $_ekip_id = $post[0]["ekip_id"];
    $_ekip_adi = $post[0]["ekip_adi"];
    $_date = $post[0]["date"];
    $_workers = $post[0]["workers"];
    $q = "INSERT INTO `tb_calendar`(`ekip_ID`, `ekip_adi`, `tarih`, `workers`) VALUES ('$_ekip_id', '$_ekip_adi','$_date','$_workers')";
    $res = mysqli_query($con, $q);
}
if ($param == "updateYevmiye") {
    $_id = $post["ekip_ID"];
    $yevmiye = $post["toplam_yevmiye"];
    $q= "UPDATE `tb_ekip` SET `toplam_yevmiye`= '$yevmiye' WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "updateTeamTree") {
    $_id = $post["ekipId"];
    $agacSayi = $post["agacSayisi"];
    $q= "UPDATE `tb_ekip` SET `toplam_kesilen_agac`= toplam_kesilen_agac + '$agacSayi' WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if($param == "pruning"){
    $id = $post["id"];
    $budamatarihi = $post["tarih"];
    $ekipid = $post["ekipId"];
    $ekipadi = $post["ekipAdi"];
    $agacid = $post["budamaTuru"];
    $agacadi = $post["budamaAdi"];
    $adet = $post["agacSayisi"];
    $total = $post["total"];
    $q = "INSERT INTO `tb_budama`(`budama_id`,`budama_tarihi`, `ekip_ID`, `ekip_adi`, `agac_ID`, `agac_adi`, `adet`, `total`) VALUES ('$id','$budamatarihi','$ekipid','$ekipadi','$agacid','$agacadi','$adet','$total')";
    $res = mysqli_query($con, $q);
}
if($param == "updatePruning"){
    $ekipid = $post["ekip_ID"];
    $q = "UPDATE `tb_budama` SET `calculated`= '1' WHERE `ekip_ID` = '$ekipid'";
    $res = mysqli_query($con, $q);
}
if($param == "expense"){
    $ekipid = $post["ekipId"];
    $ekipadi = $post["ekipAdi"];
    $tarih = $post["tarih"];
    $aciklama = $post["aciklama"];
    $total = $post["total"];
    $q = "INSERT INTO `tb_gider`(`ekip_ID`, `ekip_adi`, `tarih`, `aciklama`, `total`) VALUES ('$ekipid','$ekipadi','$tarih','$aciklama','$total')";
    $res = mysqli_query($con, $q);
}
if($param == "updateExpense"){
    $ekipid = $post["ekip_ID"];
    $q = "UPDATE `tb_gider` SET `calculated`= '1' WHERE `ekip_ID` = '$ekipid'";
    $res = mysqli_query($con, $q);
}
if ($param == "uwCount") {
    $_id = $post["id"];
    $_num = $post["num"];
    $q= "UPDATE `tb_ekip` SET `calisan_sayisi` = calisan_sayisi + '$_num' WHERE `ekip_ID`= '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "removeWorker") {
    $_id = $post["id"];
    $q= "DELETE FROM `tb_calisan` WHERE `id` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "workerDataBackup") {
    $ekipid = $post["ekip_ID"];
    $ekipadi = $post["ekip_adi"];
    $id = $post["id"];
    $ad = $post["ad"];
    $soyad = $post["soyad"];
    $yevmiye = $post["yevmiye"];
    $kayit_tarihi = $post["kayit_tarihi"];
    $ayrilis_tarihi = $post["ayrilis_tarihi"];
    $tam_gun = $post["tam_gun"];
    $yarim_gun = $post["yarim_gun"];
    $hakedis = $post["hakedis"];
    $q= "INSERT INTO `tb_workerBackup`( `ekip_ID`,`ekip_adi`, `calisan_id`, `ad`, `soyad`, `yevmiye`, `kayit_tarihi`, `ayrilis_tarihi`, `tam_gun`, `yarim_gun`, `hakedis`) VALUES ('$ekipid','$ekipadi','$id','$ad','$soyad','$yevmiye','$kayit_tarihi','$ayrilis_tarihi','$tam_gun','$yarim_gun','$hakedis')";
    $res = mysqli_query($con, $q);
}
if ($param == "progressPayment") {
    $tarih = $post["tarih"];
    $ekipid = $post["ekip_ID"];
    $ekip_adi = $post["ekip_adi"];
    $calisan_sayisi = $post["calisan_sayisi"];
    $toplam_yevmiye = $post["toplam_yevmiye"];
    $toplam_gider = $post["toplam_gider"];
    $toplam_kesilen_agac = $post["toplam_kesilen_agac"];
    $agac_gelir = $post["agac_gelir"];
    $calisanlar = $post["calisanlar"];
    $ayrilanlar = $post["ayrilan_calisanlar"];    
    $q= "INSERT INTO `tb_hakedis`(`tarih`, `ekip_ID`, `ekip_adi`, `calisan_sayisi`, `toplam_yevmiye`,`toplam_gider`,`toplam_kesilen_agac`,`agac_gelir`, `calisanlar`,`ayrilan_calisanlar`) VALUES ('$tarih','$ekipid','$ekip_adi','$calisan_sayisi','$toplam_yevmiye','$toplam_gider','$toplam_kesilen_agac','$agac_gelir','$calisanlar','$ayrilanlar')";
    $res = mysqli_query($con, $q);
}
if ($param == "deleteTeam") {
    $_id = $post["ekip_ID"];
    $q= "DELETE FROM `tb_ekip` WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "deleteTeamWorker") {
    $_id = $post["ekip_ID"];
    $q= "DELETE FROM `tb_calisan` WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "resetPayment") {
    $_id = $post["ekip_ID"];
    $q= "UPDATE `tb_calisan` SET `tam_gun`= '0',`yarim_gun`= '0',`guncelleme_tarihi`='0000-00-00' WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "resetTeamPayment") {
    $_id = $post["ekip_ID"];
    $q= "UPDATE `tb_ekip` SET `toplam_yevmiye`='0,00',`toplam_kesilen_agac`='0' WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
if ($param == "updateBackupPayment") {
    $_id = $post["ekip_ID"];
    $q= "UPDATE `tb_workerBackup` SET `calculated`= '1' WHERE `ekip_ID` = '$_id'";
    $res = mysqli_query($con, $q);
}
exit;
 