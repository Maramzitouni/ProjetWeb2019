<?php session_start();
include('Mobile_Detect.php');
include('BrowserDetection.php');
require ( "../../connexionDB.php"); 
    require("../../functions.php");
$connect = connectDB();
$browser=new Wolfcast\BrowserDetection;

$browser_name=$browser->getName();
$browser_version=$browser->getVersion();

$detect=new Mobile_Detect();

if($detect->isMobile()){
	$type='Mobile';
}elseif($detect->isTablet()){
	$type='Tablet';
}else{
	$type='PC';
}

if($detect->isiOS()){
	$os='IOS';
}elseif($detect->isAndroidOS()){
	$os='Android';
}else{
	$os='Window';
}

$url=(isset($_SERVER['HTTPS'])) ? "https":"http";
$url.="//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$ref='';
if(isset($_SERVER['HTTP_REFERER'])){
	$ref=$_SERVER['HTTP_REFERER'];
}
$id=$_SESSION['id'];
$sql= $connect->query("insert into visitor (id_user ,browser_name,browser_version,type,os,url,ref) values($id,'$browser_name','$browser_version','$type','$os','$url','$ref')");
?>
<a href="about.php">About</a>